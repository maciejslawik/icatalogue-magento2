<?php
/**
 * File: Form.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Block\Adminhtml\Catalogue\Edit;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Cms\Model\Wysiwyg\Config;
use Magento\Framework\Data\Form as DataForm;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\System\Store;
use MSlwk\ICatalogue\Model\Catalogue;
use MSlwk\ICatalogue\Api\CatalogueInterface;

/**
 * Class Form
 *
 * @package MSlwk\ICatalogue\Block\Adminhtml\Catalogue\Edit
 */
class Form extends Generic
{
    /**
     * @var Store
     */
    protected $systemStore;

    /**
     * Form constructor.
     *
     * @param Store $systemStore
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param array $data
     */
    public function __construct(
        Store $systemStore,
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        $this->systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('mslwk_icatalogue_catalogue_form');
        $this->setTitle(__('iCatalogue'));
    }

    /**
     * @inheritdoc
     */
    protected function _prepareForm()
    {
        /** @var Catalogue $catalogue */
        $catalogue = $this->_coreRegistry->registry('mslwk_icatalogue_catalogue');

        /** @var DataForm $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );

        $form->setHtmlIdPrefix('catalogue_');

        /**
         * General fieldset
         */
        $fieldsetGeneral = $form->addFieldset(
            'general_fieldset',
            [
                'legend' => __('General Information'),
                'class' => 'fieldset-wide'
            ]
        );
        $fieldsetGeneral->addField(
            CatalogueInterface::TITLE,
            'text',
            [
                'name' => CatalogueInterface::TITLE,
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true
            ]
        );
        $fieldsetGeneral->addField(
            'stores',
            'multiselect',
            [
                'name' => 'stores[]',
                'label' => __('Store Views'),
                'title' => __('Store Views'),
                'required' => true,
                'values' => $this->systemStore->getStoreValuesForForm(false, true),
            ]
        );

        /**
         * Images fieldset
         */
        $fieldsetImages = $form->addFieldset(
            'images_fieldset',
            [
                'legend' => __('Images'),
                'class' => 'fieldset-wide'
            ]
        );
        $fieldsetImages->addField(
            'images',
            'MSlwk\ICatalogue\Form\Element\Gallery',
            [
                'name' => 'images',
                'label' => __('Image'),
                'title' => __('Image')
            ]
        );

        /** Catalogue ID */
        if ($catalogue->getId()) {
            $fieldsetGeneral->addField(
                CatalogueInterface::CATALOGUE_ID,
                'hidden',
                [
                    'name' => CatalogueInterface::CATALOGUE_ID
                ]
            );
        }

        $form->setValues($catalogue->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
