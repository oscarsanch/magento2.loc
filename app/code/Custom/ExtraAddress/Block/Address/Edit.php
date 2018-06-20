<?php

namespace Custom\ExtraAddress\Block\Address;

use Custom\ExtraAddress\Model\Address\Type;
use Magento\Customer\Model\AttributeChecker;
use Magento\Framework\App\ObjectManager;

class Edit extends \Magento\Customer\Block\Address\Edit
{
    protected $_typeAddress;

    private $attributeChecker;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\App\Cache\Type\Config $configCacheType,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory,
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $countryCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
        \Magento\Customer\Api\Data\AddressInterfaceFactory $addressDataFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        $data = [],
        AttributeChecker $attributeChecker = null,
        Type $type
    ) {
        parent::__construct(
            $context,
            $directoryHelper,
            $jsonEncoder,
            $configCacheType,
            $regionCollectionFactory,
            $countryCollectionFactory,
            $customerSession,
            $addressRepository,
            $addressDataFactory,
            $currentCustomer,
            $dataObjectHelper,
            $data = []
        );
        $this->attributeChecker = $attributeChecker ?: ObjectManager::getInstance()->get(AttributeChecker::class);
        $this->_typeAddress = $type;
    }

    public function getAddressType()
    {
        return $this->_typeAddress->getAttributeArray();
    }

    public function getType()
    {
        $addressId = $this->getRequest()->getParam('id');
        if ($addressId){
            $this->_address = $this->_addressRepository->getById($addressId);
            $typeValue = $this->_address->getCustomAttribute('type')->getValue();
            return $typeValue;
        }
        return false;
    }
}
