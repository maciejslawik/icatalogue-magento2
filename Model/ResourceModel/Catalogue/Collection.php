<?php
/**
 * File: Collection.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Model\ResourceModel\Catalogue;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;
use MSlwk\ICatalogue\Api\CatalogueInterface;
use MSlwk\ICatalogue\Api\Catalogue\StoreInterface;

/**
 * Class Collection
 *
 * @package MSlwk\ICatalogue\Model\ResourceModel\Catalogue
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('MSlwk\ICatalogue\Model\Catalogue', 'MSlwk\ICatalogue\Model\ResourceModel\Catalogue');
    }

    /**
     * @inheritdoc
     */
    protected function _afterLoad()
    {
        $this->loadStoresData(CatalogueResource::CATALOGUE_STORE_TABLE, CatalogueInterface::CATALOGUE_ID);
        return parent::_afterLoad();
    }

    /**
     * @param $tableName
     * @param $linkField
     * @return void
     */
    protected function loadStoresData($tableName, $linkField)
    {
        $connection = $this->getConnection();
        $select = $connection->select()->from($tableName);
        $result = $connection->fetchAll($select);
        if ($result) {
            $storesData = [];
            foreach ($result as $storeData) {
                $storesData[$storeData[$linkField]][] = $storeData[StoreInterface::STORE_ID];
            }

            foreach ($this as $item) {
                $linkedId = $item->getData($linkField);
                if (!isset($storesData[$linkedId])) {
                    continue;
                }
                $item->setStores($storesData[$linkedId]);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($field === 'stores') {
            return $this->addStoreFilter($condition, false);
        }

        return parent::addFieldToFilter($field, $condition);
    }

    /**
     * Add filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        $this->addFilter(StoreInterface::STORE_ID, ['in' => $store]);
        return $this;
    }

    /**
     * @inheritdoc
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter(StoreInterface::STORE_ID)) {
            $this->joinStoreRelationTable();
        }
        return parent::_renderFiltersBefore();
    }

    /**
     * Join store relation table
     *
     * @return void
     */
    protected function joinStoreRelationTable()
    {
        $this->getSelect()->join(
            ['store_table' => CatalogueResource::CATALOGUE_STORE_TABLE],
            'main_table.' . CatalogueInterface::CATALOGUE_ID . ' = store_table.' . CatalogueInterface::CATALOGUE_ID,
            []
        )->group(
            'main_table.' . CatalogueInterface::CATALOGUE_ID
        );
    }
}
