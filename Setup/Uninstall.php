<?php
/**
 * File: Uninstall.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue;

/**
 * Class Uninstall
 *
 * @package MSlwk\ICatalogue\Setup
 */
class Uninstall implements UninstallInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function uninstall(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

        $setup->getConnection()->dropTable(Catalogue::CATALOGUE_STORE_TABLE);
        $setup->getConnection()->dropTable(Catalogue::CATALOGUE_IMAGE_TABLE);
        $setup->getConnection()->dropTable(Catalogue::CATALOGUE_TABLE);

        $setup->endSetup();
    }
}