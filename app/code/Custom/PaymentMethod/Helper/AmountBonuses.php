<?php

namespace Custom\PaymentMethod\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

class AmountBonuses extends AbstractHelper
{
    const XML_CONFIG_HIDE_PRICE = 'payment/bonuspay/bonuses';

    public function getValueBonuses()
    {
        $path = self::XML_CONFIG_HIDE_PRICE;
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }
}