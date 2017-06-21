<?php
/**
 * File: Delete.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Controller\Adminhtml\Catalogue;

use Magento\Backend\Model\View\Result\Redirect;
use MSlwk\ICatalogue\Model\CatalogueFactory;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;

/**
 * Class Delete
 *
 * @package MSlwk\ICatalogue\Controller\Adminhtml\Catalogue
 */
class Delete extends ActionAbstract
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
     * Delete constructor.
     *
     * @param CatalogueFactory $catalogueFactory
     * @param CatalogueResource $catalogueResource
     * @param Context $context
     */
    public function __construct(
        CatalogueFactory $catalogueFactory,
        CatalogueResource $catalogueResource,
        Context $context
    ) {
        $this->catalogueFactory = $catalogueFactory;
        $this->catalogueResource = $catalogueResource;
        parent::__construct($context);
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                /** @var Catalogue $catalogue */
                $catalogue = $this->catalogueFactory->create();
                $this->catalogueResource->load($catalogue, $id);
                $this->catalogueResource->delete($catalogue);
                $this->messageManager->addSuccessMessage(__('The catalogue was deleted successfully'));
                return $resultRedirect->setPath('*/*/grid');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(
                    $e->getMessage(),
                    __('An error ocurred while deleting the catalogue')
                );
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('The requested catalogue doesn\'t exist'));
        return $resultRedirect->setPath('*/*/grid');
    }
}
