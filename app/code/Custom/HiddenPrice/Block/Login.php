<?php

namespace Custom\HiddenPrice\Block;

use Custom\HiddenPrice\Helper\HidePrice as CollectionHelper;
use Magento\Framework\View\Element\Template;

class Login extends Template
{
    protected $_helper;

    public function __construct(
        Template\Context $context,
        CollectionHelper $helper,
        array $data
    ){
        $this->_helper = $helper;
        parent::__construct($context, $data);
    }

    public function getPreviuosUrl()
    {
        $url  = $this->getUrl('*/*/*', ['_current' => true, '_use_rewrite' => true]);
        return $url;
    }
    
    public function canShowButton()
    {
        if ($this->_helper->isAvailablePrice()){
            return false;
        }
        
        return true;
    }
}