<?php
namespace Custom\PaymentMethod\Model;

use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Framework\DataObject;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Payment\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Payment\Model\Method\Logger;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Payment\Model\InfoInterface;

class PaymentMethodBonus extends AbstractMethod
{
    protected $_code = 'bonuspayment';
    protected $_isOffline = true;
    protected $_canCapture = true;
    protected $_canRefund = true;
    protected $_canRefundInvoicePartial = true;
    
    protected $_customerRepository;

    public function __construct(
        Context $context, 
        Registry $registry, 
        ExtensionAttributesFactory $extensionFactory, 
        AttributeValueFactory $customAttributeFactory, 
        Data $paymentData, 
        ScopeConfigInterface $scopeConfig,
        Logger $logger,
        CustomerRepositoryInterface $customerRepository,
        AbstractResource $resource = null, 
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context, 
            $registry, 
            $extensionFactory, 
            $customAttributeFactory, 
            $paymentData, 
            $scopeConfig, 
            $logger, 
            $resource, 
            $resourceCollection, 
            $data
        );
        $this->_customerRepository = $customerRepository;
    }


    public function isAvailable(CartInterface $quote = null)
    {
        $customer = $quote->getCustomer();
        $bonuses = $this->getBonusesData($customer);
        $grandTotal = $quote->getGrandTotal();

        if ((float)$bonuses < (float)$grandTotal) {
            return false;
        }
        
        $checkResult = new DataObject();
        $checkResult->setData('is_available', true);
        
        return $checkResult->getData('is_available');
        
    }

    public function getConfigPaymentAction()
    {
        return self::ACTION_AUTHORIZE_CAPTURE;
    }

    public function capture(InfoInterface $payment, $amount)
    {
        parent::capture($payment, $amount);

        $order = $payment->getOrder();
        $customer = $this->_customerRepository->getById($order->getCustomerId());
        $grandTotal = $order->getGrandTotal();
        $method = 'capture';
        $this->setBonusesData($customer, $grandTotal, $method);
        
        return $this;
    }

    public function refund(InfoInterface $payment, $amount)
    {
        parent::refund($payment, $amount);

        $order = $payment->getOrder();
        $customer = $this->_customerRepository->getById($order->getCustomerId());
        $method = 'refund';
        $this->setBonusesData($customer, $amount, $method);

        return $this;
    }
    
    protected function getBonusesData($customer)
    {
        return $customer->getCustomAttribute('bonuses')->getValue();
    }

    protected function setBonusesData($customer, $value, $method)
    {
        $bonuses = $this->getBonusesData($customer);

        if ($method == 'capture' && $bonuses >= $value) {
            $newValue = (float)$bonuses - (float)$value;
        }

        if ($method == 'refund') {
            $newValue = (float)$bonuses + (float)$value;
        }

        $customer->setCustomAttribute('bonuses', $newValue);
        $this->_customerRepository->save($customer);
    }
}