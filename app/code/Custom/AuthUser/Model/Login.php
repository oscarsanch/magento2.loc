<?php

namespace Custom\AuthUser\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Registry;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Math\Random;

class Login extends AbstractModel
{
    protected $_customer;
    protected $_customerFactory;
    protected $_customerSession;
    protected $_checkoutSession;
    protected $_random;

    public function __construct(
        Context $context,
        Registry $registry,
        CustomerFactory $customerFactory,
        Session $customerSession,
        Random $random,
        \Magento\Checkout\Model\Session $checkoutSession,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_customerFactory = $customerFactory;
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        $this->_random = $random;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }
    
    protected function _construct()
    {
        $this->_init('Custom\AuthUser\Model\ResourceModel\Login');
    }

    public function getCustomer()
    {
        if (is_null($this->_customer)) {
            $this->_customer = $this->_customerFactory->create()
                ->load($this->getCustomerId());
        }
        return $this->_customer;
    }

    public function generate($adminId, $adminName)
    {
        return $this->setData([
            'customer_id' => $this->getCustomerId(),
            'admin_id' => $adminId,
            'customer_email' => $this->getCustomer()->getEmail(),
            'admin_name' => $adminName,
            'secret' => $this->_random->getRandomString(64)
        ])->save();
    }
    
    public function authenticateCustomer()
    {
        if ($this->_customerSession->getId()) {
            $this->_customerSession->logout();
        }

        $customer = $this->getCustomer();
        if (!$customer->getId()) {
            throw new \Exception(__("Customer are no longer exist."), 1);
        }
        if ($this->_customerSession->loginById($customer->getId())) {
            $this->_customerSession->regenerateId();
            $this->_customerSession->setLoggedAsCustomerAdmindId(
                $this->getAdminId()
            );
        }
        $this->_checkoutSession->loadCustomerQuote();

        return $customer;
    }
    
    public function loadFromGenerate($secret){
        return $this->getCollection()
            ->addFieldToFilter('secret', $secret)
            ->getFirstItem();
    }
}