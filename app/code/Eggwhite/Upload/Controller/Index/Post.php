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
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Checkout\Model\Session;

class Post extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;
    protected $_storeManager;
    protected $_filesystem;
    protected $_fileUploaderFactory;
    protected $_uploadCollectionFactory;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager, StoreManagerInterface $storeManager,\Magento\Framework\Filesystem $filesystem,\Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,\Eggwhite\Upload\Model\ResourceModel\Upload\CollectionFactory $uploadCollectionFactory,Session $session,\Magento\Checkout\Model\Session $checkoutSession) 
    {
        $this->_objectManager = $objectManager;
        $this->_storeManager = $storeManager;
        $this->_filesystem = $filesystem;
	$this->checkoutSession = $checkoutSession;
	$this->_session = $session;
        $this->_fileUploaderFactory = $fileUploaderFactory;
	$this->_uploadCollectionFactory = $uploadCollectionFactory;
        parent::__construct($context);    
    }

    public function execute()
    {
	try{
	$_flag = 0;
	$items = $this->_session->getQuote()->getAllVisibleItems();
	if(count($items) == 0)
	{
		 $_flag = 5;
                 throw new \Exception();
	}
        $post = $this->getRequest()->getPostValue();
        $pathurl = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'upload/';
        $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        $mediapath = $this->_mediaBaseDirectory = rtrim($mediaDir, '/');
	$uploader = $this->_fileUploaderFactory->create(['fileId' => 'file_upload']);
	$uploader->setAllowedExtensions($this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isAllowExtension());
        $uploader->setAllowRenameFiles(true);
	$path = $mediapath . '/upload/';
	$required_size = $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/size');
	$required_count = $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->isConfig('catrupload/active_display/maxfile');
	
	$file_name = $_FILES['file_upload']['name'];
        $file_size =$_FILES['file_upload']['size'];
        $file_tmp =$_FILES['file_upload']['tmp_name'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
	$file_type = $this->_objectManager->create('Eggwhite\Upload\Helper\Data')->checkFileType($file_type);

	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();//instance of object manager
	$checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');//checkout session
	$QuoteId = $checkoutSession->getQuoteId();

	$collectionCount = $this->_uploadCollectionFactory->create();
	$collectionCount->addFieldToFilter('quote_id',$QuoteId);
	$count = count($collectionCount);
	if ($count >= $required_count) 
	{
                            $_flag = 3;
                            throw new \Exception();
        }
	if ($file_size > (1024 * 1024 * $required_size)) 
	{
                            $_flag = 1;
                            throw new \Exception();
        }
	if($file_type == 'Unknown')
	{	
		$_flag = 2;
		throw new \Exception();
	}
        $result = $uploader->save($path);
	$uploderName = $uploader->getUploadedFileName(true);
        $currenttime = date('Y-m-d H:i:s');
	if($result)
	{
		$this->checkoutSession->setQuoteValue($QuoteId);
		$this->messageManager->addSuccess(__('Selected file(s) have been uploaded successfully.'));    
	}
	else
	{
		$_flag = 4;
		throw new \Exception();
	}
        $question = $this->_objectManager->create('Eggwhite\Upload\Model\Upload');
	$question->setQuoteId($QuoteId);
	$question->setfilename($uploderName);
	$question->setType($file_type);
	$question->save();	
	$this->_redirect('checkout/cart');
       }
	catch (\Exception $e) {
			if($_flag == '1')
			{
				$this->messageManager->addError(__('Selected file(s) size is very large!'));
			} 
			if($_flag == '2')
			{
				$this->messageManager->addError(__('Selected file(s) is not supported!.'));
			} 
			if($_flag == '3')
			{
				$this->messageManager->addError(__('Upload file limit is over!.'));
			} 
			if($_flag == '4')
			{
				$this->messageManager->addError(__('Some error occure!.'));
			} 
			if($_flag == '5')
			{
				$this->messageManager->addError(__('Cart is empty. Please add item to cart.'));
			} 
	$this->_redirect('checkout/cart');	
	}
    }
	
}
