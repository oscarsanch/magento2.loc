<?php

namespace Custom\ExtraAddress\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;

class InstallData implements InstallDataInterface
{
    private $customerSetupFactory;

    public function __construct(
        CustomerSetupFactory $customerSetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerSetup->addAttribute('customer_address', 'type',
            [
                'type' => 'int',
                'label' => 'Address Type',
                'input' => 'select',
                'source'=> 'Custom\ExtraAddress\Model\Address\Type',
                'global' => true,
                'visible' => true,
                'required' => true,
                'user_defined' => true,
                'system' => 0,
                'group'=>'General',
                'visible_on_front' => true,
                'sort_order' => 1000,
                'position' => 1000,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'type')
            ->addData(['used_in_forms' => [
                'adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address'
            ]]);
        $attribute->save();
    }
}