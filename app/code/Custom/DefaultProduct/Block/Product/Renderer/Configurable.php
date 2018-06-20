<?php

namespace Custom\DefaultProduct\Block\Product\Renderer;

use Magento\Swatches\Block\Product\Renderer\Configurable as SwatchesConfigurable;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Product as CatalogProduct;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Helper\Data;
use Magento\ConfigurableProduct\Model\ConfigurableAttributeData;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Swatches\Helper\Data as SwatchData;
use Magento\Swatches\Helper\Media;
use Magento\Framework\App\ObjectManager;
use Magento\Swatches\Model\SwatchAttributesProvider;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Json\DecoderInterface;
use Custom\DefaultProduct\Model\ProductFactory;

class Configurable extends SwatchesConfigurable
{
    const DEFAULT_SWATCH_RENDERER_TEMPLATE = 'Custom_DefaultProduct::product/view/renderer.phtml';
    const DEFAULT_CONFIGURABLE_RENDERER_TEMPLATE = 'Custom_DefaultProduct::product/view/type/options/configurable.phtml';
    
    protected $jsonDecoder;
    protected $_defaultModel;

    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        EncoderInterface $jsonEncoder,
        Data $helper,
        CatalogProduct $catalogProduct,
        CurrentCustomer $currentCustomer,
        PriceCurrencyInterface $priceCurrency,
        ConfigurableAttributeData $configurableAttributeData,
        SwatchData $swatchHelper,
        Media $swatchMediaHelper,
        DecoderInterface $jsonDecoder,
        ProductFactory $productFactory,
        array $data = [],
        SwatchAttributesProvider $swatchAttributesProvider = null
    ) {
        $this->jsonDecoder = $jsonDecoder;
        $this->_defaultModel = $productFactory;

        parent::__construct(
            $context,
            $arrayUtils,
            $jsonEncoder,
            $helper,
            $catalogProduct,
            $currentCustomer,
            $priceCurrency,
            $configurableAttributeData,
            $swatchHelper,
            $swatchMediaHelper,
            $data,
            $swatchAttributesProvider);
    }

    public function getDefaultProduct()
    {
        $parentProductId = $this->getProduct()->getId();
        $productDefaultId = $this->getDefaultId($parentProductId);
        $jsConf = parent::getJsonConfig();
        $jsConfDecode = $this->jsonDecoder->decode($jsConf);

        $defaultValues = array();
        foreach ($jsConfDecode['attributes'] as $attributeId => $attribute) {
            foreach ($attribute['options'] as $option) {
                $optionId = $option['id'];
                if(in_array($productDefaultId, $option['products'])) {
                    $defaultValues[$attributeId] = $optionId;
                }
            }
        }
        $result = $this->jsonEncoder->encode($defaultValues);
        
        return $result;
    }

    protected function getDefaultId($entityId)
    {
        $defaultModel = $this->_defaultModel->create();
        $defaultId = $defaultModel->load($entityId)->getData('default_id');

        return $defaultId;
    }

    protected function getRendererTemplate()
    {
        return $this->isProductHasSwatchAttribute() ?
            self::DEFAULT_SWATCH_RENDERER_TEMPLATE : self::DEFAULT_CONFIGURABLE_RENDERER_TEMPLATE;
    }
}