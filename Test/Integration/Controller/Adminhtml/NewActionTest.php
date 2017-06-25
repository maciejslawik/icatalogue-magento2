<?php
/**
 * File: NewActionTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Test\Integration\Controller\Adminhtml;

use Magento\TestFramework\TestCase\AbstractBackendController;

/**
 * Class NewActionTest
 *
 * @package MSlwk\ICatalogue\Test\Integration\Controller\Adminhtml
 */
class NewActionTest extends AbstractBackendController
{
    /**
     * @var string
     */
    protected $resource = 'MSlwk_ICatalogue::catalogue_manage';

    /**
     * @var string
     */
    protected $uri = 'backend/icatalogue/catalogue/new';
}
