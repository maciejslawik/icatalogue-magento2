<?php
/**
 * File: View.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Controller\Catalogue;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NotFoundException;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use MSlwk\ICatalogue\Model\CatalogueFactory;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;

/**
 * Class View
 *
 * @package MSlwk\ICatalogue\Controller\Catalogue
 */
class View extends Action
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
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * View constructor.
     *
     * @param CatalogueFactory $catalogueFactory
     * @param CatalogueResource $catalogueResource
     * @param PageFactory $pageFactory
     * @param Context $context
     */
    public function __construct(
        CatalogueFactory $catalogueFactory,
        CatalogueResource $catalogueResource,
        PageFactory $pageFactory,
        Context $context
    ) {
        $this->catalogueFactory = $catalogueFactory;
        $this->catalogueResource = $catalogueResource;
        $this->resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    /**
     * @return Page
     * @throws NotFoundException
     */
    public function execute()
    {
        /** @var Catalogue $catalogue */
        $catalogue = $this->catalogueFactory->create();

        $id = $this->getRequest()->getParam('id');
        $this->catalogueResource->load($catalogue, $id);
        if (!$catalogue->getId()) {
            throw new NotFoundException(__('The requested catalogue doesn\'t exist'));
        }

        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->set(__($catalogue->getTitle()));
        $resultPage->getConfig()->setDescription(__($catalogue->getTitle() . ' - iCatalogue'));

        return $resultPage;
    }
}
