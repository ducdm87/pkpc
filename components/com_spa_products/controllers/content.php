<?php
/**
 * Translate Controller for yos_translator Component
 * @package		yos_translator
 * @subpackage	Controllers
 * @link		http://yopensource.com
 * @author		ducdm
 * @copyright 	ducdm (ducdm@f5vietnam.com)
 * @license		Commercial
 */
defined( 'JPATH_BASE' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.controller');

class FAQControllercontent extends FAQController   {

	/** @var string		current used task */
	var $task=null;

	/** @var string		action within the task */
	var $act=null;

	/** @var array		int or array with the choosen list id */
	var $cid=null;

	/** @var string		file code */
	var $fileCode = null;

	/**
	 * @var object	reference to the Joom!Fish manager
	 * @access private
	 */
	var $myClass=null;

	/**
	 * PHP 4 constructor for the tasker
	 *
	 * @return joomfishTasker
	 */
	function __construct( ){	
		parent::__construct();
		$this->registerTask('new', 'edit');
		$this->registerTask('apply', 'save');
	}
	
	function save()
	{	
		global $mainframe,$option;
		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'href.php';
		$href	=	new href();
		JTable::addIncludePath(JPATH_COMPONENT_SITE.DS.'tables');
		
		$db		 		= &JFactory::getDBO();
		$user			= &JFactory::getUser();
		$post			= JRequest::get( 'post' );
		$row =& JTable::getInstance('FAQ_content','Table');
		
		$id	=	JRequest::getVar('id',0);
		
		require_once(JPATH_COMPONENT_SITE.DS.'assets'.DS.'captcha'.DS.'lib'.DS.'recaptchalib.php');
		$cparams 	= 	&JComponentHelper::getParams( 'com_spa_faq' );
		$privatekey		=	$cparams->get('privatekey');
		$enablecaptchar	=	$cparams->get('captchar');
		
		if ($enablecaptchar) {
			$post['error']	=	0;
			$mess	=	'';
			$recaptcha_challenge_field=JRequest::getVar('recaptcha_challenge_field',"");
			$recaptcha_response_field=JRequest::getVar('recaptcha_response_field',"");
			$post['error']	=	1;
			if (!$recaptcha_response_field) {				
				$mess	= 'Bạn hãy nhập mã bảo vệ.';				
			}else {
				$resp = recaptcha_check_answer ($privatekey,
				                                $_SERVER["REMOTE_ADDR"],
				                               	$recaptcha_challenge_field,
				                              	$recaptcha_response_field);
				if (!$resp->is_valid) {
					$post['error']	=	2;
					$mess	= 'Mã bảo vệ không đúng.';				  
				}
			}
			
			$post['message']	=	$mess;						
		}		
		if ($post['error'] == 0)
		{
			$addNew	=	TRUE;
			if ($id)
			{
				$row->load($id);
			}
			$category	=	JRequest::getVar('catid');
			$cat	=	explode('/',$category);
			
			$row->bind($post);
	//		$row->question	=	'Chào bác sĩ, <br /><br />'.JRequest::getVar( 'question', '', 'post', 'string', JREQUEST_ALLOWRAW );
			$row->question	=	JRequest::getVar( 'question', '', 'post', 'string', JREQUEST_ALLOWRAW );
	//		$row->question	=	str_replace("\n\n\n",'<p></p>',$row->question);
	//		$row->question	=	str_replace("\n\n",'<p></p>',$row->question);
			$row->question	=	str_replace("\n",'<br />',$row->question);
			
			$row->answer	=	'<h3 style="color: rgb(134, 181, 37);">BS trả lời bạn:</h3><br />';
			
			$row->secid	=	$cat[0];
			$row->catid	=	$cat[1];
			$date	=	JFactory::getDate();
			$row->cdate	=	$date->toMySQL();
			$row->mdate	=	$date->toMySQL();
			$row->uid	=	$user->get('id');
			$row->state	=	0;
			$row->alias	=	$href->convertalias($row->title);
			$params	=	'';
			
			$xetnghiem	=	JRequest::getVar('xetnghiem');
			$thuocdadung	=	JRequest::getVar('thuocdadung');
			$trieuchung	=	JRequest::getVar('trieuchung');
			$tiensu	=	JRequest::getVar('tiensu');
			
			$params	=	"drug_used=$thuocdadung"."\n";
			$params	.=	"result=$xetnghiem"."\n";
			$params	.=	"medical_history=$tiensu"."\n";
			$params	.=	"symptoms=$trieuchung"."\n";
			$row->params	=	$params;
			$row->store();
		
			$mess = 'Cảm ơn bạn đã gửi câu hỏi cho bác sỹ của chúng tôi. Bác sỹ sẽ trả lời trong thời gian sớm nhất';
			$mainframe->redirect( "index.php", $mess);
		}else {
				$document 	= &JFactory::getDocument();
				$vType		= $document->getType();
				
				$vLayout 	= 'post';			
				// Get/Create the view
				$view = &$this->getView( 'postcontent', $vType);
				
				// Set the layout
				$view->postdata = $post;
				$view->setLayout($vLayout);
				$view->display();
		}
		
	}
	
	function check_module_menu($module, $menu, $id)
	{
		$db	=	JFactory::getDBO();
		
		
	}
	
	function resethits()
	{
		echo 'resehit here';
	}
}
