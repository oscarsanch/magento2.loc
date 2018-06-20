<?php

namespace Custom\CustomizeUrl\Plugin;

class UrlCategory
{
    protected $_scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    public function afterGetUrlPathWithSuffix(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $result)
    {
        $category = $this->_scopeConfig
            ->getValue(
                'custom_url/general/url_category',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        $category = trim($category, '/');

        if (strrpos($result,'/')) {
            $result = substr($result, strrpos($result, '/') + 1);
        }
        return $category . '/' . $result;
    }
}