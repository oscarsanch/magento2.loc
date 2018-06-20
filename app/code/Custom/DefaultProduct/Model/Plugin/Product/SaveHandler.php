<?php

namespace Custom\DefaultProduct\Model\Plugin\Product;

use Magento\ConfigurableProduct\Model\Product\SaveHandler as ParentSaveHandler;
use Magento\Framework\App\RequestInterface;
use Custom\DefaultProduct\Model\ProductFactory;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;
use Magento\Framework\Json\DecoderInterface;

class SaveHandler
{
    protected $request;
    protected $_customProduct;
    protected $_jsonDecoder;
    
    public function __construct(
        RequestInterface $request, 
        ProductFactory $customProduct, 
        DecoderInterface $jsonDecoder
    ) {
        $this->request = $request;
        $this->_customProduct = $customProduct;
        $this->_jsonDecoder = $jsonDecoder;
    }

    public function afterExecute(ParentSaveHandler $subject, $entity)
    {
        if ($entity->getTypeId() !== Configurable::TYPE_CODE) {
            return $entity;
        }

        $extensionAttributes = $entity->getExtensionAttributes();
        if ($extensionAttributes === null) {
            return $entity;
        }

        $configurableLinks = $extensionAttributes->getConfigurableProductLinks();
        if ($configurableLinks !== null) {
            $configurableLinks = (array)$configurableLinks;
            $default = $this->request->getParam('default');
            $default = $this->_jsonDecoder->decode($default);
            $id = $entity->getId();

            if(!empty($default)){
                $modelDefault = $this->_customProduct->create();
                if ($default['newProduct']){
                    $defaultId = $default['id'];
                    $defaultId = $configurableLinks[$defaultId];
                } else {
                    $defaultId = $default['id'];
                }
                $modelDefault->setDefaultId($defaultId)->setEntityId($id)->save();
            }
        }

        return $entity;
    }
}