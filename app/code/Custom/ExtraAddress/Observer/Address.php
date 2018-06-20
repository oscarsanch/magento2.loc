<?php

namespace Custom\ExtraAddress\Observer;

class Address implements \Magento\Framework\Event\ObserverInterface
{
    protected $_objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManagerInterface)
    {
        $this->_objectManager = $objectManagerInterface;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($address = $observer->getEvent()->getQuoteAddress()){
            if($attributes = $address->getExtensionAttributes()){
                $customAddress = $this->_objectManager->create('\Custom\ExtraAddress\Model\Quote\Address');
                $customAddress->setType($attributes->getType())->setAddressId($address->getAddressId())->save();
            }
        }
    }
}