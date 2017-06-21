<?php
/**
 * File: Catalogue.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use MSlwk\ICatalogue\Api\CatalogueInterface;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;

/**
 * Class Catalogue
 *
 * @package MSlwk\ICatalogue\Model
 */
class Catalogue extends AbstractExtensibleModel implements CatalogueInterface
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(CatalogueResource::class);
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::CATALOGUE_ID);
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @return string
     */
    public function getCreatedAt() : string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param int $id
     * @return CatalogueInterface
     */
    public function setId($id)
    {
        return $this->setData(self::CATALOGUE_ID, $id);
    }

    /**
     * @param string $title
     * @return CatalogueInterface
     */
    public function setTitle(string $title) : CatalogueInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @param string $createdAt
     * @return CatalogueInterface
     */
    public function setCreatedAt(string $createdAt) : CatalogueInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @param string $updatedAt
     * @return CatalogueInterface
     */
    public function setUpdatedAt(string $updatedAt) : CatalogueInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
