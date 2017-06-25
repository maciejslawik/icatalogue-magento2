<?php
/**
 * File: DeleteTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Test\Integration\Controller\Adminhtml;

use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class DeleteTest
 *
 * @package MSlwk\ICatalogue\Test\Integration\Controller\Adminhtml
 */
class DeleteTest extends AbstractBackendController
{
    /**
     * @var string
     */
    protected $resource = 'MSlwk_ICatalogue::catalogue_manage';

    /**
     * @var string
     */
    protected $uri = 'backend/icatalogue/catalogue/delete';
}
