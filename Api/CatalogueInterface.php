<?php
/**
 * File: CatalogueInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Api;

/**
 * Interface CatalogueInterface
 *
 * @package MSlwk\ICatalogue\Api
 */
interface CatalogueInterface
{
    const CATALOGUE_ID = 'catalogue_id';
    const TITLE = 'title';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle() : string;

    /**
     * @return string
     */
    public function getCreatedAt() : string;

    /**
     * @return string
     */
    public function getUpdatedAt() : string;

    /**
     * @param int $id
     * @return CatalogueInterface
     */
    public function setId($id);

    /**
     * @param string $title
     * @return CatalogueInterface
     */
    public function setTitle(string $title) : CatalogueInterface;

    /**
     * @param string $createdAt
     * @return CatalogueInterface
     */
    public function setCreatedAt(string $createdAt) : CatalogueInterface;

    /**
     * @param string $updatedAt
     * @return CatalogueInterface
     */
    public function setUpdatedAt(string $updatedAt) : CatalogueInterface;
}
