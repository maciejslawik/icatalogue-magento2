<?php
/**
 * File: ModuleConfigTest.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Test\Integration;

use Magento\Framework\Component\ComponentRegistrar;
use Magento\Framework\Module\ModuleList;
use Magento\TestFramework\Helper\Bootstrap;

/**
 * Class ModuleConfigTest
 *
 * @package MSlwk\ICatalogue\Test\Integration
 */
class ModuleConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $moduleName = 'MSlwk_ICatalogue';

    /**
     * @test
     */
    public function testTheModuleIsRegistered()
    {
        $registrar = new ComponentRegistrar();
        $this->assertArrayHasKey($this->moduleName, $registrar->getPaths(ComponentRegistrar::MODULE));
    }

    /**
     * @test
     */
    public function testTheModuleIsConfiguredAndEnabled()
    {
        $objectManager = Bootstrap::getObjectManager();
        $moduleList = $objectManager->create(ModuleList::class);
        $this->assertTrue($moduleList->has($this->moduleName));
    }
}
