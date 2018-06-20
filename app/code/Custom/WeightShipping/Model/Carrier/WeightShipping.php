<?php

namespace Custom\WeightShipping\Model\Carrier;

use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Psr\Log\LoggerInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Framework\Serialize\SerializerInterface;

class WeightShipping extends AbstractCarrier implements CarrierInterface
{
    protected $_code = 'weightshipping';
    protected $_isFixed = true;
    protected $_rateMethodFactory;
    protected $_rateResultFactory;
    protected $serializer;

    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        SerializerInterface $serializer,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->serializer = $serializer;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function getAllowedMethods()
    {
        return [$this->getCarrierCode() => $this->getConfigData('name')];
    }

    public function collectRates(RateRequest $request)
    {
        $weight = (float)$request->getPackageWeight();
        $configWeight = $this->getConfigData('weightprice');
        $decodedValue = $this->serializer->unserialize($configWeight);

        if (!$this->isActive()) {

            return false;
        }

        if (!empty($decodedValue)) {
            foreach ($decodedValue as $key => $item) {
                if ($key != 'base') {
                    $minWeight = (float) $item['weight'];
                    if($weight >= $minWeight) {
                        $shippingPrice = $item['price'];
                    }    
                } else {
                    $shippingPrice = $item['price'];
                }
            }
        } else {

            return false;
        }

        $result = $this->_rateResultFactory->create();
        $method = $this->_rateMethodFactory->create();

        $method->setCarrier($this->getCarrierCode());
        $method->setCarrierTitle($this->getConfigData('title'));

        $method->setMethod($this->getCarrierCode());
        $method->setMethodTitle($this->getConfigData('name'));

        $method->setPrice($shippingPrice);
        $method->setCost($shippingPrice);

        $result->append($method);
        return $result;
      
    }
}