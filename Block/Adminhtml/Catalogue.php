<?php
/**
 * File: Location.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Location
 *
 * @package MSlwk\ICatalogue\Block\Adminhtml
 */
class Catalogue extends Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_catalogue';
        $this->_blockGroup = 'MSlwk_ICatalogues';
        $this->_headerText = __('Catalogues');
        $this->_addButtonLabel = __('Add a catalogue');
        parent::_construct();
    }
}
