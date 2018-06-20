<?php

namespace Custom\ExtraAddress\Observer;

class AddressCollectionLoad implements \Magento\Framework\Event\ObserverInterface
{
    protected $_joinProcessor;

    public function __construct(\Magento\Framework\Api\ExtensionAttribute\JoinProcessor $joinProcessor)
    {
        $this->_joinProcessor = $joinProcessor;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($collection = $observer->getEvent()->getQuoteAddressCollection()){
            $this->_joinProcessor->process($collection);
        }
    }
}