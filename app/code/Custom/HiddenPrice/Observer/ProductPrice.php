<?php

namespace Custom\HiddenPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Custom\HiddenPrice\Helper\HidePrice as ProductHelper;

class ProductPrice implements ObserverInterface
{
    protected $_helper;

    public function __construct(
        ProductHelper $helper
    ) {
        $this->_helper = $helper;
    }
    
    public function execute(Observer $observer)
    {
        if (!$this->_helper->isAvailablePrice()) {
            $product = $observer->getEvent()->getProduct();
            $product->setCanShowPrice(false);
        }
    }
}