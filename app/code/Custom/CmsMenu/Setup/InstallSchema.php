<?php

namespace Custom\Cmsmenu\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mgcms_page_link')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mgcms_page_link')
            )
                ->addColumn(
                    'link_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Link ID'
                )
                ->addColumn(
                    'url_key',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false],
                    'Link URL Key'
                )
                ->addColumn(
                    'text',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    '64k',
                    ['nullable' => false],
                    'Text'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    1,
                    ['nullable' => false],
                    'Link Status'
                )
                ->addColumn(
                    'created_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                    'Created At'
                )->addColumn(
                    'updated_at',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    null,
                    ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                    'Updated At')
                ->setComment('Link Table');
            $installer->getConnection()->createTable($table);

        }

        if (!$installer->tableExists('mgcms_page_link_dependence')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mgcms_page_link_dependence')
            )
                ->addColumn(
                    'link_dependence_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Link Dependence ID'
                )
                ->addColumn(
                    'link_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    ['unsigned' => true, 'nullable' => false],
                    'Link ID'
                )
                ->addColumn(
                    'page_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    ['nullable' => false],
                    'Page ID'
                )
                ->addForeignKey(
                    $installer->getFkName('mgcms_page_link_dependence', 'link_id', 'mgcms_page_link', 'link_id'),
                    'link_id',
                    $installer->getTable('mgcms_page_link'),
                    'link_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName('mgcms_page_link_dependence', 'page_id', 'mgcms_page', 'page_id'),
                    'page_id',
                    $installer->getTable('mgcms_page'),
                    'page_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Link Table');
            $installer->getConnection()->createTable($table);

        }
        $installer->endSetup();
    }
}

