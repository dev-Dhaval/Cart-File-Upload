<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Block\Adminhtml\Order\View;
class Upload extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Template
     *
     * @var string
     */
    //protected $_template = 'order/view/upload.phtml';
    protected $_activeTab = null;

    protected $_template = 'upload_index_index.phtml';
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,\Eggwhite\Upload\Model\ResourceModel\Order\CollectionFactory $uploadCollectionFactory,\Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
	
        array $data = []
    ) {
	$this->_uploadCollectionFactory = $uploadCollectionFactory;
	$this->_objectManager = $objectManager;
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    public function getUploadCollection($orderId)
    {
	$collection = $this->_uploadCollectionFactory->create();
	$collection->addFieldToFilter('order_id',$orderId);
	return $collection;
    }
    public function isEnable()
    {
	return $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/enabled');
    }
    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }
    public function getTabLabel()
    {
        return __('Order Attachment');
    }
    public function getTabTitle()
    {
        return __('Order Attachment');
    }
    public function canShowTab()
    {
        return true;
    }

    public function getClass()
    {
        return $this->getTabClass();
    }
    public function getTabClass()
    {
        return 'ajax only';
    }
    public function isHidden()
    {
	return false;
    }
    public function getRealOrderId()
    {
		$orderId = $this->getRequest()->getParam("order_id");
		$orderLoad = $this->_objectManager->create('Magento\Sales\Model\Order');
		$orderLoad->load($orderId);
		return $orderLoad->getRealOrderId();
    }
    public function getUploadpath()
    {
		return $this->getBaseUrl().'pub/media/upload/';
    }
   
	
}
