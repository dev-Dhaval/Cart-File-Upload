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
class AfterCustomerLoginObserver implements ObserverInterface
{
    protected $_logger;
    protected $order;
    protected $_productCollectionFactory;
    protected $_objectManager;
    public function __construct(\Magento\Sales\Model\Order $order,\Eggwhite\Upload\Model\ResourceModel\Upload\CollectionFactory $productCollectionFactory,\Magento\Framework\ObjectManagerInterface $objectManager,\Magento\Checkout\Model\Session $checkoutSession,
    \Psr\Log\LoggerInterface $logger, //log injection
    array $data = []
    ) {
	$this->_objectManager = $objectManager;
	$this->checkoutSession = $checkoutSession;
	$this->_productCollectionFactory = $productCollectionFactory;
        $this->_logger = $logger;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
	$oldQuote = $this->checkoutSession->getQuoteValue();
	$enable = $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/enabled');
	if($enable)
	{
		$QuoteId = $this->checkoutSession->getQuoteId();
		$data = array();
		$collection = $this->_productCollectionFactory->create();
		$collection->addFieldToFilter('quote_id',$oldQuote);
		foreach($collection as $item){
			$item->setQuoteId($QuoteId);
		}
		$collection->save();
	}	
    }
}
