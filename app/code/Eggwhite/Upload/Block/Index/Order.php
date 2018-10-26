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

class Order extends \Magento\Framework\View\Element\Template {

    protected $_uploadCollectionFactory;
    protected $_objectManager;
    public function __construct(\Magento\Catalog\Block\Product\Context $context,\Eggwhite\Upload\Model\ResourceModel\Order\CollectionFactory $uploadCollectionFactory,\Magento\Framework\ObjectManagerInterface $objectManager, array $data = []) {
	$this->_uploadCollectionFactory = $uploadCollectionFactory;
	$this->_objectManager = $objectManager;
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
	
	$orderCollection = $this->_objectManager->create('\Magento\Sales\Model\Order');
	$orderCollection->load($this->getOrderId());
	$orderId = $orderCollection->getRealOrderId();
	$collection = $this->_uploadCollectionFactory->create();
	$collection->addFieldToFilter('order_id',$orderId);
        return $collection;
    }
    public function getOrderId()
    {
		return $this->getRequest()->getParam("order_id");
    }
    public function getUploadpath()
    {
		return $this->getBaseUrl().'pub/media/upload/';
    }

}
