<?php
/**
 * File: Catalogue.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use MSlwk\ICatalogue\Api\Catalogue\ImageInterface;
use MSlwk\ICatalogue\Api\Catalogue\StoreInterface;
use MSlwk\ICatalogue\Api\CatalogueInterface;

/**
 * Class Location
 *
 * @package MSlwk\ICatalogue\Model\ResourceModel
 */
class Catalogue extends AbstractDb
{
    const CATALOGUE_TABLE = 'mslwk_icatalogue_catalogue';
    const CATALOGUE_STORE_TABLE = 'mslwk_icatalogue_catalogue_store';
    const CATALOGUE_IMAGE_TABLE = 'mslwk_icatalogue_catalogue_image';

    /**
     * @var ImageInterface
     */
    protected $imageRelation;

    /**
     * @var StoreInterface
     */
    protected $storeRelation;

    /**
     * Location constructor.
     *
     * @param ImageInterface $imageRelation
     * @param StoreInterface $storeRelation
     * @param Context $context
     * @param null $connectionName
     */
    public function __construct(
        ImageInterface $imageRelation,
        StoreInterface $storeRelation,
        Context $context,
        $connectionName = null
    ) {
        $this->imageRelation = $imageRelation;
        $this->storeRelation = $storeRelation;
        parent::__construct($context, $connectionName);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(self::CATALOGUE_TABLE, CatalogueInterface::CATALOGUE_ID);
    }

    /**
     * @inheritdoc
     */
    protected function _afterLoad(AbstractModel $object)
    {
        $this->loadStoreRelation($object);
        $this->loadImages($object);
        return parent::_afterLoad($object);
    }

    /**
     * @inheritdoc
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->saveStoreRelation($object);
        $this->saveImages($object);
        return parent::_afterSave($object);
    }

    /**
     * @param AbstractModel $object
     * @return void
     */
    protected function loadStoreRelation(AbstractModel $object)
    {
        $this->storeRelation->loadStores($object);
    }

    /**
     * @param AbstractModel $object
     * @return void
     */
    protected function saveStoreRelation(AbstractModel $object)
    {
        $this->storeRelation->saveStores($object);
    }

    /**
     * @param AbstractModel $object
     * @return void
     */
    protected function loadImages(AbstractModel $object)
    {
        $this->imageRelation->loadImages($object);
    }

    /**
     * @param AbstractModel $object
     * @return void
     */
    protected function saveImages(AbstractModel $object)
    {
        $this->imageRelation->saveImages($object);
    }
}
