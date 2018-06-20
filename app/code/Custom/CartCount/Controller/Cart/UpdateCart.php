<?php

namespace Custom\CartCount\Controller\Cart;

use Magento\Framework\Json\Helper\Data;
use Psr\Log\LoggerInterface;

class UpdateCart extends \Magento\Checkout\Controller\Cart\UpdatePost
{
    protected $jsonHelper;
    protected $logger;
    protected $helperCart;

    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Checkout\Helper\Cart $helperCart,
        \Magento\Checkout\Helper\Data $helperData,

        Data $jsonHelper,
        LoggerInterface $logger
    ) {
        parent::__construct($context,$scopeConfig,$checkoutSession,$storeManager,$formKeyValidator,$cart);
        $this->jsonHelper = $jsonHelper;
        $this->logger = $logger;
        $this->helperCart = $helperCart;
        $this->helperCart = $helperData;
    }

    public function execute()
    {
        $updateAction  = (string)$this->getRequest()->getParam('update_cart_action');
        $cartIds  = (array)$this->getRequest()->getParam('cart');
        foreach ($cartIds as $index => $data) {
            $cartId = $index;
        }
        try {
            if ($updateAction == 'update_qty') {
                $this->_updateShoppingCart();
                $cartS = $this->cart->getQuote()->getItemsCollection();
                $data = [];
                foreach($cartS as $item) {
                    $qtyId = $item->getItemId();
                    $qty = $item->getQty();
                    $price = $item->getPrice();
                    $totalPrice =  $qty * $price;
                    if ($cartId == $qtyId){
                        $data = $this->helperCart->formatPrice($totalPrice);
                    }
                }
            }
            return $this->getResponse()->representJson($this->jsonHelper->jsonEncode($data));
        } catch (LocalizedException $e) {
            return $this->jsonResponse($e->getMessage());
        } catch (\Exception $e) {
            $this->logger->critical($e);
            return $this->jsonResponse($e->getMessage());
        }
    }

    protected function jsonResponse($error = '')
    {
        return $this->getResponse()->representJson(
            $this->jsonHelper->jsonEncode()
        );
    }
}