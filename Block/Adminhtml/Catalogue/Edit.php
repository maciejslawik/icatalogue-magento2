<?php
/**
 * File: Edit.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Block\Adminhtml\Catalogue;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Phrase;
use Magento\Framework\Registry;

/**
 * Class Edit
 *
 * @package MSlwk\ICatalogue\Block\Adminhtml\Catalogue
 */
class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Department edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'MSlwk_ICatalogue';
        $this->_controller = 'adminhtml_catalogue';

        parent::_construct();

        if ($this->isAllowed()) {
            $this->buttonList->update('save', 'label', __('Save Catalogue'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ]
            );
        } else {
            $this->buttonList->remove('save');
        }
    }

    /**
     * @return Phrase
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry('mslwk_icatalogue_catalogue')->getId()) {
            return __(
                "Edit catalogue '%1'",
                $this->escapeHtml(
                    $this->coreRegistry->registry('mslwk_icatalogue_catalogue')->getName()
                )
            );
        } else {
            return __('New Catalogue');
        }
    }

    /**
     * Check permission for passed action
     *
     * @return bool
     */
    protected function isAllowed()
    {
        return $this->_authorization->isAllowed('MSlwk_ICatalogue::catalogue_manage');
    }

    /**
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('icatalogue/catalogue/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }

    /**
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/grid');
    }
}