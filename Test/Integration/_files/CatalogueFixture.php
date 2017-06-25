<?php
/**
 * File: CatalogueFixture.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

/** @var $catalogue \MSlwk\ICatalogue\Model\Catalogue */
$catalogue = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create('MSlwk\ICatalogue\Model\Catalogue');

/** @var \MSlwk\ICatalogue\Model\ResourceModel\Catalogue $catalogueResource */
$catalogueResource = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()
    ->create('MSlwk\ICatalogue\Model\ResourceModel\Catalogue');

$catalogue
    ->setTitle('Catalogue 1')
    ->setStores([])
    ->setImages([]);
$catalogueResource->save($catalogue);
