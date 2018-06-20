<?php

namespace Custom\HiddenPrice\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Config\Model\Config\Source\Enabledisable;
use Magento\Framework\App\Http\Context as HttpContext;

class HidePrice extends AbstractHelper
{
    const XML_CONFIG_HIDE_PRICE = 'hiddenprice/general/enabled';

    protected $_customerSession;
    protected $_httpContext;
    
    public function __construct(
        Context $context,
        HttpContext $httpContext
    ) {
        $this->_httpContext = $httpContext;
        parent::__construct(
            $context
        );
    }
    
    public function isAvailablePrice()
    {
        $enabled = $this->_getConfig(self::XML_CONFIG_HIDE_PRICE);

        if ($enabled == Enabledisable::ENABLE_VALUE) {
            $isLoggedIn = $this->_httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
            return $isLoggedIn;
        }

        return true;
    }

    protected function _getConfig($path)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

}