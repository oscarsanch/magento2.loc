<?php

namespace Custom\Cart\Observer;

class Addproduct implements \Magento\Framework\Event\ObserverInterface
{
    protected $_checkoutSession;

    public function __construct(\Magento\Checkout\Model\Session $session)
    {
        $this->_checkoutSession = $session;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->_checkoutSession->setShowCart(true);
    }
}