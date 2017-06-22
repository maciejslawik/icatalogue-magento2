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
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use MSlwk\ICatalogue\Model\CatalogueFactory;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;

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
     */
    public function execute()
    {
        /** @var Catalogue $catalogue */
        $catalogue = $this->catalogueFactory->create();

        $id = $this->getRequest()->getParam('id');
        $this->catalogueResource->load($catalogue, $id);
        if (!$catalogue->getId()) {
            $this->messageManager->addErrorMessage(__('The requested catalogue doesn\'t exist'));
            /** @var Redirect $resultRedirect */
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('/');

        }

        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->set(__($catalogue->getTitle()));
        $resultPage->getConfig()->setDescription(__($catalogue->getTitle() . ' - iCatalogue'));

        return $resultPage;
    }
}
