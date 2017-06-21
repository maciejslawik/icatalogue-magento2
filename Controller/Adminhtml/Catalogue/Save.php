<?php
/**
 * File: Save.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Controller\Adminhtml\Catalogue;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use MSlwk\ICatalogue\Model\CatalogueFactory;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Model\ResourceModel\Catalogue as CatalogueResource;
use MSlwk\ICatalogue\Api\CatalogueInterface;

/**
 * Class Save
 *
 * @package MSlwk\ICatalogue\Controller\Adminhtml\Catalogue
 */
class Save extends ActionAbstract
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
     * Save constructor.
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

        $data = $this->getRequest()->getPostValue();
        if ($data) {
            /** @var Catalogue $catalogue */
            $catalogue = $this->catalogueFactory->create();

            $id = $this->getRequest()->getParam(CatalogueInterface::CATALOGUE_ID);
            if ($id) {
                $this->catalogueResource->load($catalogue, $id);
            }

            $catalogue->setData($data);

            try {
                $this->catalogueResource->save($catalogue);
                $id = $catalogue->getId();
                $this->messageManager->addSuccessMessage(__('The catalogue was saved successfully'));
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('An error ocurred while saving the catalogue')
                );
            }

            return $this->getRequest()->getParam('back')
                ? $resultRedirect->setPath('*/*/edit', ['id' => $id, '_current' => true])
                : $resultRedirect->setPath('*/*/grid');
        }
        return $resultRedirect->setPath('*/*/grid');
    }
}
