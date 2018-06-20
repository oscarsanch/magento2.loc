<?php

namespace Custom\ExtraAddress\Observer\Order;

class AddressCollectionLoad implements \Magento\Framework\Event\ObserverInterface
{
    protected $_joinProcessor;

    public function __construct(\Magento\Framework\Api\ExtensionAttribute\JoinProcessor $joinProcessor)
    {
        $this->_joinProcessor = $joinProcessor;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($collection = $observer->getEvent()->getOrderAddressCollection()){
            $this->_joinProcessor->process($collection);
        }
    }
}