<?php

namespace Custom\ImageCategory\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;
use Magento\Framework\Registry;

class ImageView extends Template
{
    protected $_registry;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        array $data
    ){
        $this->_registry = $registry;
        parent::__construct($context, $data);
    }

    public function getUrlImage()
    {
        $url = false;
        $category = $this->_registry->registry('current_category');
        $image = $category->getCustomImage();
        if ($image) {
            if (is_string($image)) {
                $url = $this->_storeManager->getStore()->getBaseUrl(
                        UrlInterface::URL_TYPE_MEDIA
                    ) . 'catalog/category/' . $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }

        return $url;
    }
}