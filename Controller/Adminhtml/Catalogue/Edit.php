<?php
/**
 * File: Edit.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Controller\Adminhtml\Catalogue;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Page as ResultPage;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Model\CatalogueFactory;
use Magento\Backend\Model\View\Result\Redirect;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;

/**
 * Class Edit
 *
 * @package MSlwk\ICatalogue\Controller\Adminhtml\Catalogue
 */
class Edit extends ActionAbstract
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var CatalogueFactory
     */
    protected $catalogueFactory;

    /**
     * @var CatalogueResource
     */
    protected $catalogueResource;

    /**
     * Edit constructor.
     *
     * @param CatalogueFactory $catalogueFactory
     * @param CatalogueResource $catalogueResource
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     */
    public function __construct(
        CatalogueFactory $catalogueFactory,
        CatalogueResource $catalogueResource,
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {
        $this->catalogueFactory = $catalogueFactory;
        $this->catalogueResource = $catalogueResource;
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    protected function _initAction()
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Catalogue $catalogue */
        $catalogue = $this->catalogueFactory->create();

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $this->catalogueResource->load($catalogue, $id);
            if (!$catalogue->getId()) {
                $this->messageManager->addErrorMessage(__('The requested catalogue doesn\'t exist'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $catalogue->setData($data);
        }

        $this->coreRegistry->register('mslwk_icatalogue_catalogue', $catalogue);

        /** @var ResultPage $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Catalogues'));
        $resultPage->getConfig()->getTitle()
            ->prepend($catalogue->getId() ? $catalogue->getTitle() : __('New Catalogue'));

        return $resultPage;
    }
}
