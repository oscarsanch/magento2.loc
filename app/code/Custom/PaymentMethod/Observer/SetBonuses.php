<?php

namespace Custom\PaymentMethod\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Custom\PaymentMethod\Helper\AmountBonuses;
use Magento\Customer\Api\CustomerRepositoryInterface;

class SetBonuses implements ObserverInterface
{
    protected $_amount;
    protected $_customerRepository;

    public function __construct(AmountBonuses $amountBonuses, CustomerRepositoryInterface $customerRepository)
    {
        $this->_amount = $amountBonuses;
        $this->_customerRepository = $customerRepository;
    }

    public function execute(Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $defaultValue = $this->_amount->getValueBonuses();
        $bonuses = $customer->getCustomAttribute('bonuses');
        if (empty($bonuses)){
            try {
                $customer->setCustomAttribute('bonuses',$defaultValue);
                $this->_customerRepository->save($customer);
            }
            catch (\Exception $e) {
                return $e->getMessage();
            }
        }
    }
}