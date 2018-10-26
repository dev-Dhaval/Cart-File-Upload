<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Controller\Index;

class Comment extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager) 
    {
	$this->_objectManager = $objectManager;
        parent::__construct($context);    
    }

    public function execute()
    {
	$id = $this->getRequest()->getParam("id");
	$comment = $this->getRequest()->getParam("comment");
	$collection = $this->_objectManager->create('Eggwhite\Upload\Model\Upload');
	$collection->load($id);
	$collection->setComments($comment);
	$collection->save();
    }
}
