<?php
/**
 * File: Gallery.php
 *
 * @author      Maciej Sławik <maciekslawik@gmail.com>
 * Github:      https://github.com/maciejslawik
 */

namespace MSlwk\ICatalogue\Form\Element;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Escaper;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\CollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Gallery
 *
 * @package MSlwk\ICatalogue\Form\Element
 */
class Gallery extends AbstractElement
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param Factory $factoryElement
     * @param CollectionFactory $factoryCollection
     * @param Escaper $escaper
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Factory $factoryElement,
        CollectionFactory $factoryCollection,
        Escaper $escaper,
        StoreManagerInterface $storeManager,
        $data = []
    ) {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        $this->setType('file');
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function getElementHtml()
    {
        $name = $this->getName();
        $parentName = parent::getName();
        $widgetButton = $this->getForm()->getParent()->getLayout();
        $buttonHtml = $widgetButton->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData(
            ['label' => __('Add new image'), 'onclick' => 'addNewImg()', 'class' => 'add']
        )->toHtml();

        $html = '<table id="gallery" class="gallery" border="0" cellspacing="3" cellpadding="0">';
        $html .= '<thead id="gallery_thead" class="gallery"><tr>';
        $html .= '<td class="gallery" width="200" valign="middle" align="left">' . __('Image') . '</td>';
        $html .= '<td class="gallery" width="100" valign="middle" align="center">' . __('Sort order') . '</td>';
        $html .= '<td class="gallery" width="100" valign="middle" align="center">' . __('Delete') . '</td>';
        $html .= '</tr></thead>';
        $html .= '<tfoot class="gallery"><tr>';
        $html .= '<td class="gallery" valign="middle" align="left" colspan="3">' . $buttonHtml . '</td>';
        $html .= '</tr></tfoot>';
        $html .= '<tbody class="gallery">';

        if (!is_null($this->getValue())) {
            $i = 0;
            foreach ($this->getValue() as $image) {
                $i++;
                $html .= '<tr>';
                $url = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $image['image_uri'];
                $html .= '<td class="gallery" align="center" style="vertical-align:bottom;">';
                $html .= '<a href="' . $url . '" target="_blank" ';
                $html .= 'onclick="imagePreview(\'' . $this->getHtmlId() . '_image_' . $image['image_id'] . '\');';
                $html .= 'return false;" ' . $this->_getUiId('image-' . $image['image_id']) . '>';
                $html .= '<img id="' . $this->getHtmlId() . '_image_' . $image['image_id'] . '" ';
                $html .= 'src="' . $url . '" height="25" align="absmiddle" class="small-image-preview">';
                $html .= '</a><br/>';
                $html .= '<input type="file" name="' . $name . '[' . $image['image_id'] . ']" ';
                $html .= 'size="1"' . $this->_getUiId('file') . ' ></td>';
                $html .= '<td class="gallery" align="center" style="vertical-align:bottom;">';
                $html .= '<input type="input" name="' . $parentName . '[position][' . $image['image_id'] . ']" ';
                $html .= 'value="' . $image['sort_order'] . '" ';
                $html .= 'id="' . $this->getHtmlId() . '_position_' . $image['image_id'] . '" ';
                $html .= 'size="3" ' . $this->_getUiId('position-' . $image['image_id']) . '/></td>';
                $html .= '<td class="gallery" align="center" style="vertical-align:bottom;">';
                $html .= '<input type="checkbox" name="' . $parentName . '[delete][' . $image['image_id'] . ']" ';
                $html .= 'value="' . $image['image_id'] . '" ';
                $html .= 'id="' . $this->getHtmlId() . '_delete_' . $image['image_id'] . '" ';
                $html .= $this->_getUiId('delete-button-' . $image['image_id']) . '/></td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<script type="text/javascript">';
            $html .= 'document.getElementById(\'gallery_thead\').style.visibility=\'hidden\';';
            $html .= '</script>';
        }
        $html .= '</tbody></table>';
        $html .= '<script language="javascript">';
        $html .= 'id = 0;';
        $html .= 'function addNewImg(){';
        $html .= 'document.getElementById(\'gallery_thead\').style.visibility=\'visible\';';
        $html .= 'id--;';
        $html .= 'new_file_input = \'<input type="file" name="' . $name . '[\'+id+\']" size="1" />\';';
        $html .= 'var new_row_input = document.createElement( \'input\' );';
        $html .= 'new_row_input.type = \'text\';';
        $html .= 'new_row_input.name = \'' . $parentName . '[position][\'+id+\']\';';
        $html .= 'new_row_input.size = \'1\';';
        $html .= 'new_row_input.value = \'0\';';
        $html .= 'var new_row_button = document . createElement(\'input\');';
        $html .= 'new_row_button.type = \'checkbox\';';
        $html .= 'new_row_button.value = \'Delete\';';
        $html .= 'table = document.getElementById(\'gallery\');';
        $html .= 'noOfRows = table.rows.length;';
        $html .= 'noOfCols = table.rows[noOfRows - 2].cells.length;';
        $html .= 'var x = table.insertRow(noOfRows - 1);';
        $html .= 'newCell = x.insertCell(0);';
        $html .= 'newCell.align = \'center\';';
        $html .= 'newCell.valign = \'middle\';';
        $html .= 'newCell.innerHTML = new_file_input;';
        $html .= 'newCell = x.insertCell(1);';
        $html .= 'newCell.align = \'center\';';
        $html .= 'newCell.valign = \'middle\';';
        $html .= 'newCell.appendChild(new_row_input);';
        $html .= 'newCell = x.insertCell(2);';
        $html .= 'newCell.align = \'center\';';
        $html .= 'newCell.valign = \'middle\';';
        $html .= 'newCell.appendChild(new_row_button);';
        $html .= 'new_row_button.onclick = function () {';
        $html .= 'this.parentNode.parentNode.parentNode.removeChild(this.parentNode.parentNode);';
        $html .= 'return false;};}';
        $html .= '</script>';
        $html .= $this->getAfterElementHtml();
        return $html;
    }
}
