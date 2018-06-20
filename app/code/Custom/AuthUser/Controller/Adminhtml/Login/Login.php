<?php

namespace Custom\AuthUser\Controller\Adminhtml\Login;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Auth\Session;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Url;
use Custom\AuthUser\Model\LoginFactory;

class Login extends Action
{
    protected $_login;
    protected $_session;
    protected $_storeManager;
    protected $_url;

    public function __construct(
        Context $context,
        Session $session,
        StoreManagerInterface $storeManager,
        Url $url, 
        LoginFactory $login
    ){
        parent::__construct($context);
        $this->_login = $login;
        $this->_session = $session;
        $this->_storeManager = $storeManager;
        $this->_url = $url;
    }

    public function execute()
    {
        $customerId = (int) $this->getRequest()->getParam('customer_id');

        $login = $this->_login->create();
        $login->setCustomerId($customerId);

        $customer = $login->getCustomer();
        if (!$customer->getId()) {
            $this->_redirect('customer/index/index');
            return;
        }

        $user = $this->_objectManager->get('Magento\Backend\Model\Auth\Session')->getUser();
        $login->generate($user->getId(), $user->getUserName());
        $customerStoreId = $customer->getData('store_id');
        $store = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore($customerStoreId);
        $url = $this->_objectManager->get('Magento\Framework\Url')
            ->setScope($store);
        
        $redirectUrl = $url->getUrl('loginascustomer/login/index', ['secret' => $login->getSecret(),'_nosid' => true]);
        $this->getResponse()->setRedirect($redirectUrl);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Custom_AuthUser::login_button');
    }

}