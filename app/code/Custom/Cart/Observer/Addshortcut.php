<?php

namespace Custom\Cart\Observer;

class Addshortcut implements \Magento\Framework\Event\ObserverInterface 
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($container = $observer->getEvent()->getContainer()){

            if($container->getRequest()->isAjax()){
                $block = $container->getLayout()->createBlock('\Custom\Cart\Block\Shortcut')
                    ->setTemplate('Custom_Cart::shortcut.phtml');
                $container->addShortcut($block);
            }
        }
    }
}