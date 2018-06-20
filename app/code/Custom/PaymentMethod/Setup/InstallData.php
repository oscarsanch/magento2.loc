<?php

namespace Custom\PaymentMethod\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    protected $_eavConfig;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->_eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'bonuses',
            [
                'type' => 'decimal',
                'label' => 'Bonuses',
                'input' => 'text',
                'source' => '',
                'required' => false,
                'default' => '0',
                'sort_order' => 999,
                'system' => false,
                'position' => 999
            ]
        );
        $bonuses = $this->_eavConfig->getAttribute(Customer::ENTITY, 'bonuses');
        $bonuses->setData(
            'used_in_forms',
            ['adminhtml_customer']
        );
        $bonuses->save();
    }
}