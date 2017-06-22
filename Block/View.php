<?php
/**
 * File: View.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template\Context;
use MSlwk\ICatalogue\Model\CatalogueFactory;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;

/**
 * Class View
 *
 * @package MSlwk\ICatalogue\Block
 */
class View extends Template
{
    /**
     * @var CatalogueFactory
     */
    protected $catalogueFactory;

    /**
     * @var CatalogueResource
     */
    protected $catalogueResource;

    /**
     * @var Catalogue
     */
    protected $catalogue;

    /**
     * @var Http
     */
    protected $request;

    /**
     * Details constructor.
     *
     * @param Http $request
     * @param CatalogueFactory $catalogueFactory
     * @param CatalogueResource $catalogueResource
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Http $request,
        CatalogueFactory $catalogueFactory,
        CatalogueResource $catalogueResource,
        Context $context,
        array $data = []
    ) {
        $this->request = $request;
        $this->catalogueFactory = $catalogueFactory;
        $this->catalogueResource = $catalogueResource;
        parent::__construct($context, $data);
    }

    /**
     * @return Catalogue
     */
    public function getCatalogue()
    {
        if (!$this->catalogue) {
            $this->catalogue = $this->catalogueFactory->create();
            $this->catalogueResource->load($this->catalogue, $this->request->getParam('id'));
        }
        return $this->catalogue;
    }

    /**
     * @return array
     */
    public function getImages()
    {
        $images = [];
        foreach ($this->getCatalogue()->getImages() as $image) {
            $images[] = [
                'url' => '/media/' . $image['image_uri']
            ];
        }
        return $images;
    }

    /**
     * @return int
     */
    public function getFlipbookWidth()
    {
        return is_numeric($this->_scopeConfig->getValue('mslwk_icatalogue/general/width'))
            ? 2 * intval($this->_scopeConfig->getValue('mslwk_icatalogue/general/width'))
            : 922;
    }

    /**
     * @return int
     */
    public function getFlipbookHeight()
    {
        return is_numeric($this->_scopeConfig->getValue('mslwk_icatalogue/general/height'))
            ? intval($this->_scopeConfig->getValue('mslwk_icatalogue/general/height'))
            : 600;
    }
}
