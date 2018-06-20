<?php

namespace Custom\HiddenPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Custom\HiddenPrice\Helper\HidePrice as CollectionHelper;

class CollectionPrice implements ObserverInterface
{
    protected $_helper;

    public function __construct(
        CollectionHelper $helper
    ) {
        $this->_helper = $helper;
    }
    
    public function execute(Observer $observer)
    {
        if (!$this->_helper->isAvailablePrice()) {
            $collection = $observer->getEvent()->getCollection();
            foreach ($collection as $product) {
                $product->setCanShowPrice(false);
            }
        }
    }
}