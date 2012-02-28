<?php
/**
 * Extension Controller for yos_translator Component
 * @package		yos_translator
 * @subpackage	Components
 * @link		http://yopensource.com
 * @author		Minh Nguyen
 * @copyright 	Minh Nguyen (minhna@gmail.com)
 * @license		Commercial
 */


/*ob_start();
			//var_dump($_POST);
			echo '----------------------------------------------------';
			var_dump($content);
			$str=ob_get_contents();
		ob_clean();										
		$file = dirname(__FILE__).DS.'post.php';
		JFile::write($file,$str);*/



// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

/**
 * Translator Customer Controller
 *
 * @package		yos_translator
 * @subpackage	Components
 */
class TranslatorControllerRemote extends TranslatorController
{
	/**
	 * check translator allow sccess.
	 *
	 * @var int. allow if $allow_access=0. Not allow if $allow_access=1
	 */
	var $allow_access		=null;
	/**
	 * check code for security access
	 *
	 * @var unknown_type
	 */
	var $api_code_access	=null;
	
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		$params = &JComponentHelper::getParams( 'com_yos_translator' );
		
       	$allow_access=$params->get('allow_access',1);
       	$api_code_access=$params->get('api_code_access');
       
       	$this->allow_access=$allow_access;
       	$this->api_code_access=$api_code_access;
		parent::__construct();
	}
	
	function remoteTranslator(){
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('yos_translator');
		
		global $mainframe;
		$content=JRequest::getVar('content');		
		$begin=JRequest::getVar('begin_translate');
		$end=JRequest::getVar('end_translate');
		$languagePair=JRequest::getVar('languagePair');
		$api_code_remote=JRequest::getVar('api_code_remote');		
		
		// allow_access=1 =>Not allow
		// allow_access=0 =>Allow
		if ($this->allow_access or $api_code_remote!=$this->api_code_access) {						
				$tsl_pageContent='ERROR_YOS_TRANSLATOR|Unable to translate.';
				$tsl_pageContent.=' REMOTE SITE API: You re not allowed to use this API, please check the API settings.';							
		}else {			
				$pageContent=urldecode((base64_decode($content)));
				require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'translator.php');
				$translator = new Yos_translator();
				
				$result=$dispatcher->trigger('onBeforeTranslate', array (null, null,null, & $message));
				$bool=true;
				for ($i=0;$i<count($result);$i++)
				{
					if ($result[$i]==false) {
						$tsl_pageContent='ERROR_YOS_TRANSLATOR|(SITE API) '.$message;
						$bool=false;
						$i=count($result);
					}
				}		
				if ($bool) {
					$tsl_pageContent = $translator->accessTranslate($languagePair, $pageContent,$api_code_remote);	
				}			
					
		}	
		
		echo $begin.'<div> '.$tsl_pageContent.'</div>'.$end;
		die();
	}
}
?>
