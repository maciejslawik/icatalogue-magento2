<?php
/**
 * File: ImageInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Api\Catalogue;

use Magento\Framework\Model\AbstractModel;

/**
 * Interface ImageInterface
 *
 * @package MSlwk\ICatalogue\Api\Catalogue
 */
interface ImageInterface
{
    const IMAGE_ID = 'image_id';
    const IMAGE_URI = 'image_uri';
    const SORT_ORDER = 'sort_order';
    const CREATED_AT = 'created_at';

    /**
     * @param AbstractModel $object
     * @return void
     */
    public function loadImages(AbstractModel $object);

    /**
     * @param AbstractModel $object
     * @return void
     */
    public function saveImages(AbstractModel $object);
}
