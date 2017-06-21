<?php
/**
 * File: ActionAbstract.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Controller\Adminhtml\Catalogue;

use Magento\Backend\App\Action;

/**
 * Class ActionAbstract
 *
 * @package MSlwk\ICatalogue\Controller\Adminhtml\Catalogue
 */
abstract class ActionAbstract extends Action
{
    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MSlwk_ICatalogue::catalogue_manage');
    }
}
