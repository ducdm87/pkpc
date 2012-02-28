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
	function edit(){
		$document 	= &JFactory::getDocument();
		$vType		= $document->getType();

		$vLayout 	= 'edit';
		$mName		= 'contents';
		// Get/Create the view
		$view = &$this->getView( 'contents', $vType);
		// Get/Create the model

		if ($model = &$this->getModel($mName)) {
			// Push the model into the view (as default)

			$view->setModel($model, true);
		}
		// Set the layout
		$view->setLayout($vLayout);
		$view->edit();
	}
	function publish()
	{
		global $mainframe, $option;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('FAQ_content','Table');
		$cids 	= JRequest::getVar('cid', array(0), 'post', 'array');
		$err=0;
		$user=JFactory::getUser();
		$task=JRequest::getVar('task');
		foreach ($cids as $cid)
		{
			$row->load($cid);					
			$row->state = ($task=='content.publish')?1:0;		
			$row->store();
		}
		
		$task=explode('.',$task);		
		$mess.=$sucses.' '.JText::_('Content(s) successfully '.$task[1]).". &nbsp; ";
		$mainframe->redirect( "index.php?option=$option&task=contents" ,$mess);
	}
	function saveorder()
	{
		global $mainframe, $option;
		// Initialize variables
		$db			= & JFactory::getDBO();

		$cid		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array (0), 'post', 'array' );
		$total		= count($cid);
		$conditions	= array ();

		JArrayHelper::toInteger($cid, array(0));
		JArrayHelper::toInteger($order, array(0));

		// Instantiate an article table object
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('FAQ_content','Table');

		// Update the ordering for items in the cid array
		for ($i = 0; $i < $total; $i ++)
		{
			$row->load( (int) $cid[$i] );
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					JError::raiseError( 500, $db->getErrorMsg() );
					return false;
				}
				// remember to updateOrder this group
				$condition = 'catid = '.(int) $row->catid.' AND state >= 0';
				$found = false;
				foreach ($conditions as $cond)
					if ($cond[1] == $condition) {
						$found = true;
						break;
					}
				if (!$found)
					$conditions[] = array ($row->id, $condition);
			}
		}

		// execute updateOrder for each group
		foreach ($conditions as $cond)
		{
			$row->load($cond[0]);
			$row->reorder($cond[1]);
		}

//		$cache = & JFactory::getCache('com_content');
//		$cache->clean();

		$msg = JText::_('New ordering saved');
		$mainframe->redirect("index.php?option=$option", $msg);
		
		
	}
	
	function orderup()
	{
		$this->orderContent(-1);
	}
	
	function orderdown()
	{
		$this->orderContent(1);
	}
	
	function orderContent($direction)
	{
			global $mainframe,$option;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db		= & JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		
		if (isset( $cid[0] ))
		{	
			$row =& JTable::getInstance('FAQ_content','Table');
			$row->load( (int) $cid[0] );
			$row->move($direction, 'catid = ' . (int) $row->catid . ' AND state >= 0' );
		}

		$mainframe->redirect("index.php?option=$option");
	}
	
	function toggle_premium()
	{
		global $mainframe, $option;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('FAQ_content','Table');
		$cids 	= JRequest::getVar('cid', array(0), 'post', 'array');
		$row->load($cids[0]);					
		$row->premium = $row->premium?0:1;		
		$row->store();
		$mess.=$sucses.' '.JText::_('Content(s) successfully change premium &nbsp;');
		$mainframe->redirect( "index.php?option=$option&task=contents" ,$mess);
	}
	
	function remove()
	{
		global $mainframe, $option;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('FAQ_content','Table');
		$cids 	= JRequest::getVar('cid', array(0), 'post', 'array');
		$err=0;
		$user=JFactory::getUser();
		$task=JRequest::getVar('task');
		foreach ($cids as $cid)
		{
			$row->delete($cid);
		}
		
		$task=explode('.',$task);		
		$mess.=$sucses.' '.JText::_('Content(s) successfully '.$task[1]).". &nbsp; ";
		$mainframe->redirect( "index.php?option=$option&task=contents" ,$mess);
	}
	
	function cancel()
	{
		global $mainframe,$option;
		// Set the table directory
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
//		$row =& JTable::getInstance('YOS_News_Crawler','Table');
//		$row->bind( JRequest::get( 'post' ));
//		$row->checkin();
		$mainframe->redirect( "index.php?option=$option" );
		
	}
	
	function save()
	{
		global $mainframe,$option;
		
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('spa_faq');
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		
		$db		 		= &JFactory::getDBO();
		$user			= &JFactory::getUser();
		$post			= JRequest::get( 'post' );
		$row =& JTable::getInstance('FAQ_content','Table');
		
		$id	=	JRequest::getVar('id',0);
		
		$addNew	=	TRUE;
		if ($id)
		{	
			$row->load($id);
		}
		$old_answer	=	$row->answer;
		
		$category	=	$post['category'];
		
		$cat	=	explode('/',$category);
		$row->bind($post);
		
		$question	=	JRequest::getVar('question');

		$row->question	=	JRequest::getVar( 'question', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->answer	=	JRequest::getVar( 'answer', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		if (!$row->alias)
		{
			require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'href.php';
			$href	=	new href();	
			$row->alias	=	strtolower($href->take_file_name($row->title));
		
		}
		
		$row->secid	=	$cat[0];
		$row->catid	=	$cat[1];
		$date	=	JFactory::getDate();
		$row->cdate	=	$row->cdate != '0000-00-00 00:00:00'?$row->cdate:$date->toMySQL();
		$row->mdate	=	$date->toMySQL();
		$row->sid	=	$user->get('id');
		$is_change	=	true;
		if($row->answer	== $old_answer)
		{
			$is_change == false;
		}
		$results = $dispatcher->trigger('onBeforeSaveFAQ', array (& $row, $is_change));

		$row->store();

		$results = $dispatcher->trigger('onAfterSaveFAQ', array (& $row,$is_change ));
		
		$task	=	JRequest::getVar('task');
//		die;
		if ($task == 'content.save')
		{
			JError::raiseNotice('c','Successfully saved changes to content: '. $row->title);
			$mainframe->redirect( "index.php?option=$option&task=contents");
		}
		else {
			JError::raiseNotice('c','Successfully apply changes to content: '. $row->title);
			$mainframe->redirect( "index.php?option=$option&task=content.edit&cid=$row->id" );	
			}
	}
	
	function resethits()
	{
		global $mainframe, $option;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('FAQ_content','Table');
		$cid 	= JRequest::getVar('cid', 0, 'post', 'array');
		
		$row->load($cid);					
		$row->hits = 0;		
		$row->store();
		
		JError::raiseNotice('c','Successfully reset hits: '. $row->title);
		$mainframe->redirect( "index.php?option=$option&task=content.edit&cid=$row->id" );
	}
}
