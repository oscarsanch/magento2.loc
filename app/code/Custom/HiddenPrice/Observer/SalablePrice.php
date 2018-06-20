<?php

namespace Custom\HiddenPrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Custom\HiddenPrice\Helper\HidePrice as SalableHelper;

class SalablePrice implements ObserverInterface
{
    protected $_helper;

    public function __construct(
        SalableHelper $helper
    ) {
        $this->_helper = $helper;
    }
    
    public function execute(Observer $observer)
    {
        if (!$this->_helper->isAvailablePrice()) {
            $salable = $observer->getEvent()->getSalable();
            $salable->setIsSalable(false);
        }
    }
}