<?php
/**
 * File: SaveTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Test\Integration\Controller\Adminhtml;

use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class SaveTest
 *
 * @package MSlwk\ICatalogue\Test\Integration\Controller\Adminhtml
 */
class SaveTest extends AbstractBackendController
{
    /**
     * @var string
     */
    protected $resource = 'MSlwk_ICatalogue::catalogue_manage';

    /**
     * @var string
     */
    protected $uri = 'backend/icatalogue/catalogue/save';
}
