<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Block\Index;

use Magento\Framework\View\Element\Template;

class Index extends \Magento\Framework\View\Element\Template {

    protected $_uploadCollectionFactory; 
    protected $_objectManager;
    public function __construct(\Magento\Catalog\Block\Product\Context $context,\Eggwhite\Upload\Model\ResourceModel\Upload\CollectionFactory $uploadCollectionFactory,\Magento\Framework\ObjectManagerInterface $objectManager,\Magento\Checkout\Model\Cart $cart , array $data = []) {
	$this->_uploadCollectionFactory = $uploadCollectionFactory;
	$this->_objectManager = $objectManager;
	$this->_cart = $cart;  
        parent::__construct($context, $data);
    }
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }
    public function isEnable()
    {
	return $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/enabled');
    }
    public function getUploadCollection()
    {
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();//instance of object manager
	$checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');//checkout session
	$QuoteId = $checkoutSession->getQuoteId();
        $collection = $this->_uploadCollectionFactory->create();
	$collection->addFieldToFilter('quote_id',$QuoteId);
        return $collection;
    }
    public function emptyCart() 
    {
	$productCart = $this->_cart->getQuote()->getAllItems();
	if($productCart){
		return true;
	}
    }
    public function getBaseCommentUrl() 
    {
	return $this->getBaseUrl().'upload/index/comment';
    }
    public function getDeleteUrl($id) 
    {
	return $this->getBaseUrl().'upload/index/delete/id/'.$id;
    }
    public function getUploadpath()
    {
	return $this->getBaseUrl().'pub/media/upload/';
    }
    public function getFileCount($cur)
    {
	$maxLimit = $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/maxfile');
	if($cur > $maxLimit){
		$overLimit = $cur - $maxLimit;
		return $overLimit;
	}
	
    }
}
