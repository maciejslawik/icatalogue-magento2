<?php
/**
 * File: InstallSchema.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue;
use MSlwk\ICatalogue\Api\CatalogueInterface;
use MSlwk\ICatalogue\Api\Catalogue\ImageInterface;
use MSlwk\ICatalogue\Api\Catalogue\StoreInterface;

/**
 * Class InstallSchema
 *
 * @package MSlwk\ICatalogue\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /**
         * Create catalogue table
         */
        $catalogueTable = $setup
            ->getConnection()
            ->newTable($setup->getTable(Catalogue::CATALOGUE_TABLE))
            ->addColumn(
                CatalogueInterface::CATALOGUE_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Catalogue ID'
            )->addColumn(
                CatalogueInterface::TITLE,
                Table::TYPE_TEXT,
                255,
                [],
                'Title'
            )->addColumn(
                CatalogueInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                CatalogueInterface::UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )->setComment(
                'Table for storing data about interactive catalogues'
            );
        $setup->getConnection()->createTable($catalogueTable);

        /**
         * Create store table
         */
        $catalogueStoreTable = $setup
            ->getConnection()
            ->newTable($setup->getTable(Catalogue::CATALOGUE_STORE_TABLE))
            ->addColumn(
                CatalogueInterface::CATALOGUE_ID,
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Catalogue ID'
            )->addColumn(
                StoreInterface::STORE_ID,
                Table::TYPE_SMALLINT,
                5,
                ['unsigned' => true, 'nullable' => false],
                'Store ID'
            )->addForeignKey(
                $setup->getFkName(
                    Catalogue::CATALOGUE_STORE_TABLE,
                    CatalogueInterface::CATALOGUE_ID,
                    Catalogue::CATALOGUE_TABLE,
                    CatalogueInterface::CATALOGUE_ID
                ),
                CatalogueInterface::CATALOGUE_ID,
                Catalogue::CATALOGUE_TABLE,
                CatalogueInterface::CATALOGUE_ID,
                Table::ACTION_CASCADE,
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName(
                    Catalogue::CATALOGUE_STORE_TABLE,
                    StoreInterface::STORE_ID,
                    'store',
                    'store_id'
                ),
                StoreInterface::STORE_ID,
                'store',
                'store_id',
                Table::ACTION_CASCADE,
                Table::ACTION_CASCADE
            )->setComment(
                'Table for assigning catalogues to website stores'
            );
        $setup->getConnection()->createTable($catalogueStoreTable);

        /**
         * Create image table
         */
        $catalogueImageTable = $setup
            ->getConnection()
            ->newTable($setup->getTable(Catalogue::CATALOGUE_IMAGE_TABLE))
            ->addColumn(
                ImageInterface::IMAGE_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Image ID'
            )->addColumn(
                CatalogueInterface::CATALOGUE_ID,
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Catalogue ID'
            )->addColumn(
                ImageInterface::IMAGE_URI,
                Table::TYPE_TEXT,
                0,
                [],
                'Image URI'
            )->addColumn(
                ImageInterface::SORT_ORDER,
                Table::TYPE_INTEGER,
                null,
                ['default' => 0, 'unsigned' => true, 'nullable' => false],
                'Sort order'
            )->addColumn(
                ImageInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            )->addForeignKey(
                $setup->getFkName(
                    Catalogue::CATALOGUE_IMAGE_TABLE,
                    CatalogueInterface::CATALOGUE_ID,
                    Catalogue::CATALOGUE_TABLE,
                    CatalogueInterface::CATALOGUE_ID
                ),
                CatalogueInterface::CATALOGUE_ID,
                Catalogue::CATALOGUE_TABLE,
                CatalogueInterface::CATALOGUE_ID,
                Table::ACTION_CASCADE,
                Table::ACTION_CASCADE
            )->setComment(
                'Table for storing images assigned to catalogues'
            );
        $setup->getConnection()->createTable($catalogueImageTable);

        $setup->endSetup();
    }
}
