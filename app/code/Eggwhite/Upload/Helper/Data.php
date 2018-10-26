<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function isConfig($config_path)
    {
            return $this->scopeConfig->getValue(
                $config_path,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
    }
    public function checkFileType($ext)
    {
        switch ($ext) {
            case 'jpeg':return 'Image';
                break;
            case 'jpg':return 'Image';
                break;
            case 'gif':return 'Image';
                break;
            case 'png':return 'Image';
                break;
	    case 'pdf':return 'PDF';
                break;
            case 'ico':return 'Image';
                break;
            case 'doc':return 'Document';
                break;
            case 'docx':return 'Document';
                break;
            case 'odt':return 'Document';
                break;
            case 'odt2':return 'Document';
                break;
            case 'txt':return 'Text';
                break;
            case 'xls':return 'Excel';
                break;
            case 'xlsx':return 'Excel';
                break;
            case 'ppt':return 'Powerpoint';
                break;
            case 'pptx':return 'Powerpoint';
                break;
            case 'csv':return 'CSV';
                break;
            case 'ods':return 'Document';
                break;
            case 'xml':return 'XML';
                break;  
            case 'mp3':return 'Audio';
                break;
            case 'amr':return 'Audio';
                break;
            case 'wma':return 'Audio';
                break;
            case 'mp4':return 'Video';
                break;
            case 'webm':return 'Video';
                break;
            case '3gp':return 'Video';
                break;
            case 'flv':return 'Video';
                break;
            case 'avi':return 'Video';
                break;
            default:return 'Unknown';
                break;
        }
    }
    public function isAllowExtension()
    {
        return ['jpg', 'jpeg', 'gif', 'png','pdf','3gp','doc','docx','xls','ppt','pdf','pptx','xml','txt','avi','amr','odt2','mp3','mp4','wma','webm','csv','ico','xlsx'];
    }
    
    
}
