<?php

namespace Custom\AuthUser\Block\Adminhtml\Customer\Edit;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Login extends GenericButton implements ButtonProviderInterface
{
    protected $_authorization;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context, $registry);
        $this->_authorization = $context->getAuthorization();
    }

    public function getButtonData()
    {
        $customerId = $this->getCustomerId();
        $data = [];
        $canModify = $customerId && $this->_authorization->isAllowed('Custom_AuthUser::login_button');
        if ($canModify) {
            $data = [
                'label' => __('Login As Customer'),
                'class' => 'login login-button',
                'on_click' => 'window.open( \'' . $this->getInvalidateTokenUrl() .
                    '\')',
                'sort_order' => 70,
            ];
        }
        return $data;
    }

    public function getInvalidateTokenUrl()
    {
        return $this->getUrl('loginascustomer/login/login/', ['customer_id' => $this->getCustomerId()]);
    }
}