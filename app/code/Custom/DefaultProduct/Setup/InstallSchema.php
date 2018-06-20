<?php

namespace Custom\DefaultProduct\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mgcustom_default_product')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mgcustom_default_product')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'default_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Default ID'
                )
                ->setComment('Default Product Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}