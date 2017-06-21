<?php
/**
 * File: Store.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Model\ResourceModel\Catalogue\Relation;

use Magento\Framework\Model\AbstractModel;
use MSlwk\ICatalogue\Api\Catalogue\StoreInterface;
use Magento\Framework\App\ResourceConnection;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue;
use MSlwk\ICatalogue\Api\CatalogueInterface;

/**
 * Class Store
 *
 * @package MSlwk\ICatalogue\Model\ResourceModel\Catalogue\Relation
 */
class Store implements StoreInterface
{
    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * Store constructor.
     *
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @inheritdoc
     */
    public function loadStores(AbstractModel $object)
    {
        $connection = $this->resourceConnection->getConnection(ResourceConnection::DEFAULT_CONNECTION);
        $storeIds = $connection->fetchCol(
            'SELECT ' . StoreInterface::STORE_ID .
            ' FROM ' . Catalogue::CATALOGUE_STORE_TABLE .
            ' WHERE ' . CatalogueInterface::CATALOGUE_ID . ' = :catalog_id;',
            [
                ':catalog_id' => $object->getId()
            ]
        );

        $object->setStores($storeIds);
    }

    /**
     * @inheritdoc
     */
    public function saveStores(AbstractModel $object)
    {
        $connection = $this->resourceConnection->getConnection(ResourceConnection::DEFAULT_CONNECTION);

        $connection->delete(
            Catalogue::CATALOGUE_STORE_TABLE,
            [
                CatalogueInterface::CATALOGUE_ID . ' = ' . $object->getId()
            ]
        );

        if (is_array($object->getStores())) {
            foreach ($object->getStores() as $store_id) {
                $connection->insert(
                    Catalogue::CATALOGUE_STORE_TABLE,
                    [
                        StoreInterface::STORE_ID => $store_id,
                        CatalogueInterface::CATALOGUE_ID => $object->getId()
                    ]
                );
            }
        }
    }

}
