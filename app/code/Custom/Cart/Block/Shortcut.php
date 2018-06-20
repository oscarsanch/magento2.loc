<?php

namespace Custom\Cart\Block;

class Shortcut extends \Magento\Checkout\Block\Cart\AbstractCart implements \Magento\Catalog\Block\ShortcutInterface
{
    public function getAlias()
    {
        return 'cart_delay';
    }

    protected function _toHtml()
    {
        if($this->_checkoutSession->getShowCart() && $this->getRequest()->getActionName() == 'load'){
            $this->_checkoutSession->setShowCart(false);
            return parent::_toHtml();
        }
        return '';
    }

    public function getDelay()
    {
        return 1000*$this->_scopeConfig->getValue('cartajax/general/cart_add_delay');
    }
}