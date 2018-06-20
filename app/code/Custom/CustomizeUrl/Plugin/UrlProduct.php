<?php

namespace Custom\CustomizeUrl\Plugin;

class UrlProduct
{
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    public function aftergetUrlPathWithSuffix(\Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject, $result)
    {
        $product = $this->_scopeConfig
            ->getValue(
                'custom_url/general/url_product',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        $product = trim($product,'/');

        return $product . '/'. $result;
    }
}