<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Model\ResourceModel\Upload;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Eggwhite\Upload\Model\Upload', 'Eggwhite\Upload\Model\ResourceModel\Upload');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>
