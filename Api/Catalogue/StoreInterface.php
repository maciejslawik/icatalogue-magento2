<?php
/**
 * File: StoreInterface.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Api\Catalogue;

use Magento\Framework\Model\AbstractModel;

/**
 * Interface StoreInterface
 *
 * @package MSlwk\ICatalogue\Api\Catalogue
 */
interface StoreInterface
{
    const STORE_ID = 'store_id';

    /**
     * @param AbstractModel $object
     * @return void
     */
    public function loadStores(AbstractModel $object);

    /**
     * @param AbstractModel $object
     * @return void
     */
    public function saveStores(AbstractModel $object);

}