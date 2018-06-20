<?php

namespace Custom\AuthUser\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $table = $installer->getConnection()->newTable(
            $installer->getTable('mglogin_as_customer')
        )->addColumn(
            'logged_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Logged ID'
        )->addColumn(
            'customer_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Customer ID'
        )->addColumn(
            'customer_email',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Customer Email'
        )->addColumn(
            'admin_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Admin ID'
        )->addColumn(
            'admin_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            40,
            ['nullable' => false],
            'Admin Name'
        )->addColumn(
            'secret',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64',
            ['nullable' => true],
            'Login Secret'
        )->addColumn(
            'logged_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'Logged In'
        )->addIndex(
            $installer->getIdxName('mglogin_as_customer', ['customer_id']),
            ['customer_id']
        )
            ->addIndex(
                $installer->getIdxName('mglogin_as_customer', ['admin_id']),
                ['admin_id']
            )->setComment(
                'Login As Customer Table'
            );
        $installer->getConnection()->createTable($table);
        $installer->endSetup();
    }
}