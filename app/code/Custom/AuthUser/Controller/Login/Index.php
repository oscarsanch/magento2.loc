<?php

namespace Custom\AuthUser\Controller\Login;

use Custom\AuthUser\Model\LoginFactory;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_login;

    public function __construct(Context $context, LoginFactory $loginFactory)
    {
        $this->_login = $loginFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $login = $this->initLoginCustomer();
        if (!$login) {
            $this->_redirect('customer/account/');
            $this->messageManager->addError(__('Cannot login to account.'));
        }
        try {
            $login->authenticateCustomer();
            $this->_redirect('customer/account/');
            $this->messageManager->addSuccess(
                __('You are logged in as customer: %1', $login->getCustomer()->getName())
            );
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
    }

    protected function initLoginCustomer()
    {
        $login = $this->_login->create()->loadFromGenerate($this->getRequest()->getParam('secret'));
       
        if ($login->getId()) {
            return $login;
        } else {
            return false;
        }
    }
}