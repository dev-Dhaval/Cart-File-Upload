<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Observer;
use Magento\Framework\Event\ObserverInterface;
class AfterPlaceOrderObserver implements ObserverInterface
{
    protected $_logger;
    protected $order;
    protected $_productCollectionFactory;
    protected $_objectManager;
    public function __construct(\Magento\Sales\Model\Order $order,\Eggwhite\Upload\Model\ResourceModel\Upload\CollectionFactory $uploadCollectionFactory,\Magento\Framework\ObjectManagerInterface $objectManager,
    \Psr\Log\LoggerInterface $logger, //log injection
    array $data = []
    ) {
	$this->_objectManager = $objectManager;
	$this->_uploadCollectionFactory = $uploadCollectionFactory;
        $this->_logger = $logger;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
	if($this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/enabled'))
	{
	$fileLimit = $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/maxfile');
	$checkoutSession = $this->_objectManager->get('Magento\Checkout\Model\Session');//checkout session
        $QuoteId = $checkoutSession->getQuoteId();
	$data = array();
	$order = $observer->getEvent()->getOrder();
        $order_id = $order->getIncrementId();
	$collection = $this->_uploadCollectionFactory->create();
        $collection->addFieldToFilter('quote_id',$QuoteId);
	$question = $this->_objectManager->create('Eggwhite\Upload\Model\Order');
	$cnt = 0;
	foreach($collection as $item)
	{
	    if($cnt == $fileLimit) { break;}
	    $data = array('order_id'=>$order_id,'filename'=>$item->getFilename(),'type'=>$item->getType(),'comments'=>$item->getComments());
	    $question->setData($data)->save();
	    $cnt++;
	}
	}
    }
}
