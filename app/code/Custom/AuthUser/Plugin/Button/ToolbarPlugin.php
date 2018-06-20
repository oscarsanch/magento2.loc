<?php

namespace Custom\AuthUser\Plugin\Button;

//use Custom\AuthUser\Controller\Adminhtml\Order\Login as LoginController;
use Magento\Backend\Block\Widget\Button\Toolbar\Interceptor;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Backend\Block\Widget\Button\ButtonList;

class ToolbarPlugin
{
    protected $authorization;

    public function __construct(
        \Magento\Framework\AuthorizationInterface $authorization
    ) {
        $this->authorization = $authorization;
    }

    public function beforePushButtons(
        Interceptor $subject,
        AbstractBlock $context,
        ButtonList $buttonList
    ) {
        $order = false;
        $nameInLayout = $context->getNameInLayout();
        if ('sales_order_edit' == $nameInLayout) {
            $order = $context->getOrder();
        } elseif ('sales_invoice_view' == $nameInLayout) {
            $order = $context->getInvoice()->getOrder();
        } elseif ('sales_shipment_view' == $nameInLayout) {
            $order = $context->getShipment()->getOrder();
        } elseif ('sales_creditmemo_view' == $nameInLayout) {
            $order = $context->getCreditmemo()->getOrder();
        }

        if ($order && $this->isAllowed() && $order['customer_id']) {
            $buttonUrl = $context->getUrl('loginascustomer/login/login', [
                'customer_id' => $order['customer_id']
            ]);
            $buttonList->add(
                'login_as_customer',
                ['label' => __('Login As Customer'), 'onclick' => 'window.open(\'' . $buttonUrl . '\')', 'class' => 'reset'],
                -1
            );
        }
    }

    protected function isAllowed()
    {
        return $this->authorization->isAllowed('Custom_AuthUser::login_plugin');
    }
}