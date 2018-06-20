<?php

namespace Custom\DefaultProduct\Ui\DataProvider\Product\Form\Modifier;

use Magento\ConfigurableProduct\Ui\DataProvider\Product\Form\Modifier\Composite as CompositeParent;

use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;
use Magento\Catalog\Model\Product\Type;
use Magento\Framework\ObjectManagerInterface;
use Magento\ConfigurableProduct\Ui\DataProvider\Product\Form\Modifier\Data\AssociatedProducts;
use Magento\Catalog\Ui\AllowedProductTypes;
use Custom\DefaultProduct\Model\ProductFactory;

class Composite extends CompositeParent
{
    private $locator;

    protected $_customProduct;

    public function __construct(
        LocatorInterface $locator, 
        ObjectManagerInterface $objectManager, 
        AssociatedProducts $associatedProducts, 
        AllowedProductTypes $allowedProductTypes,
        ProductFactory $customProduct,
        array $modifiers = []
    ) {
        $this->_customProduct = $customProduct;

        parent::__construct(
            $this->locator = $locator,
            $objectManager, 
            $associatedProducts, 
            $allowedProductTypes, 
            $modifiers
        );
    }

    public function modifyData(array $data)
    {
        $data = parent::modifyData($data);

        /** @var \Magento\Catalog\Api\Data\ProductInterface $model */
        $model = $this->locator->getProduct();
        $productTypeId = $model->getTypeId();
        if ($this->allowedProductTypes->isAllowedProductType($this->locator->getProduct())) {
            $productId = $model->getId();
            if ($productTypeId === ConfigurableType::TYPE_CODE) {
                $modelDefault = $this->_customProduct->create();
                $defaultId = $modelDefault->load($productId)->getData('default_id');

                if(!empty($defaultId)){
                    $data[$productId]['default-checked-product'] = $defaultId;
                } else {
                    $data[$productId]['default-checked-product'] = '';
                }
            }
        }

        return $data;
    }
}