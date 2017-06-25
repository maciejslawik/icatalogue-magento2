<?php
/**
 * File: CatalogueViewTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Test\Integration\Controller;

use Magento\TestFramework\TestCase\AbstractController;

/**
 * Class CatalogueViewTest
 *
 * @package MSlwk\ICatalogue\Test\Integration\Controller
 */
class CatalogueViewTest extends AbstractController
{
    /**
     * Loads Catalogue Fixtures
     */
    public static function loadFixture()
    {
        require __DIR__ . '/../_files/CatalogueFixture.php';
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     * @magentoDataFixture loadFixture
     */
    public function testCatalogueExistsAndDisplaysTitle()
    {
        $this->dispatch('icatalogue/catalogue/view/id/1');

        $this->assertEquals(200, $this->getResponse()->getHttpResponseCode());
        $this->assertContains('Catalogue 1', $this->getResponse()->getBody());
    }

    /**
     * @magentoDbIsolation enabled
     * @magentoAppIsolation enabled
     */
    public function testCatalogueNotExists()
    {
        $this->dispatch('icatalogue/catalogue/view/id/2');

        $this->assert404NotFound();
    }
}
