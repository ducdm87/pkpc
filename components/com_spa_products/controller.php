<?php
/**
 * Translator default controller
 *
 * @package		yos_translator
 * @subpackage	Components
 * @link		http://yopensource.com
 * @author		Minh Nguyen
 * @copyright 	Minh Nguyen (minhna@gmail.com)
 * @license		Commercial
 */

jimport('joomla.application.component.controller');
if(!class_exists('SPAContentHelperRoute')) require_once (JPATH_BASE . '/components/com_spa_products/helpers/route.php');
/**
 * Translator Component Controller
 *
 * @package		yos_translator
 */
class SPAController extends JController
{
	function __construct(){
		
		//set default view to about
		if (!JRequest::getVar('task') && !JRequest::getVar('view')) {
//			JRequest::setVar('task', 'contents');
		}
		parent::__construct();
		
	}
	
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display()
	{
		$view	=	JRequest::getVar('view','product');
		$document 	= &JFactory::getDocument();
		$vType		= $document->getType();
		$vLayout 	= JRequest::getVar('layout','blog');
		$mName		= $view;

		// Get/Create the view
		$view = &$this->getView( $view, $vType);
		
		// Get/Create the model	
	
		if ($model = &$this->getModel($mName)) {
			// Push the model into the view (as default)			
			$view->setModel($model, true);
		}		
		// Set the layout
		$view->setLayout($vLayout);
		
		//display view
		$view->display();
	}
	function save()
	{
			global $mainframe,$option;
			
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('spa_faq');
		
		require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'href.php';
		$href	=	new href();
		JTable::addIncludePath(JPATH_COMPONENT_SITE.DS.'tables');
		
		$db		 		= &JFactory::getDBO();
		$user			= &JFactory::getUser();
		$post			= JRequest::get( 'post' );
		$row =& JTable::getInstance('SPA_content','Table');
		
		$id	=	JRequest::getVar('id',0);
		
		require_once(JPATH_COMPONENT_SITE.DS.'assets'.DS.'captcha'.DS.'lib'.DS.'recaptchalib.php');
		$cparams 	= 	&JComponentHelper::getParams( 'com_spa_faq' );
		$privatekey		=	$cparams->get('privatekey');
		$enablecaptchar	=	$cparams->get('captchar');
		$post['error']	=	0;
		if ($enablecaptchar) {
			$mess	=	'';
			$recaptcha_challenge_field=JRequest::getVar('recaptcha_challenge_field',"");
			$recaptcha_response_field=JRequest::getVar('recaptcha_response_field',"");
			
			if (!$recaptcha_response_field) {
				$mess	= 'Bạn hãy nhập mã bảo vệ.';
				$post['error']	=	1;				
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
//		var_dump($post['error']);
//		die;		
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
			$row->alias	=	$href->take_file_name($row->title);
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

			$results = $dispatcher->trigger('onBeforeSaveSPA', array (& $row));
		
			$row->store();
			
			$results = $dispatcher->trigger('onAfterSaveSPA', array (& $row));
		
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
}
?>
