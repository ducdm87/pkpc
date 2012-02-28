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

class SPAControllerProduct extends SPAController   {

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
		$mName		= 'products';
		// Get/Create the view
		$view = &$this->getView( 'products', $vType);
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
		$row =& JTable::getInstance('spa_product','Table');
		$cids 	= JRequest::getVar('cid', array(0), 'post', 'array');
		$err=0;
		$user=JFactory::getUser();
		$task=JRequest::getVar('task');
		foreach ($cids as $cid)
		{
			$row->load($cid);					
			$row->published = ($task=='product.publish')?1:0;		
			$row->store();
		}
		
		$task=explode('.',$task);		
		$mess.=$sucses.' '.JText::_('Published(s) successfully '.$task[1]).". &nbsp; ";
		$mainframe->redirect( "index.php?option=$option&task=products" ,$mess);
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
		$row =& JTable::getInstance('spa_product','Table');

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
				$condition = 'catid = '.(int) $row->catid.' AND published >= 0';
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

		$msg = JText::_('Product ordering saved');
		$mainframe->redirect("index.php?option=$option&task=products", $msg);
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
			$row =& JTable::getInstance('spa_product','Table');
			$row->load( (int) $cid[0] );
			$row->move($direction, 'catid = ' . (int) $row->catid . ' AND published >= 0' );
		}

		$mainframe->redirect("index.php?option=$option&task=products");
	}

	function remove()
	{
		global $mainframe, $option;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('spa_product','Table');
		$cids 	= JRequest::getVar('cid', array(0), 'post', 'array');
		$err=0;
		$user=JFactory::getUser();
		$task=JRequest::getVar('task');
		foreach ($cids as $cid)
		{
			$row->delete($cid);
		}
		
		$task=explode('.',$task);		
		$mess.=$sucses.' '.JText::_('Product(s) successfully '.$task[1]).". &nbsp; ";
		$mainframe->redirect( "index.php?option=$option&task=products" ,$mess);
	}
	
	function cancel()
	{
		global $mainframe,$option;
		// Set the table directory
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
//		$row =& JTable::getInstance('YOS_News_Crawler','Table');
//		$row->bind( JRequest::get( 'post' ));
//		$row->checkin();
		$mainframe->redirect( "index.php?option=$option&task=products" );
		
	}
	
	function save()
	{
		global $mainframe,$option;
		
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('spa_products');
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		
		$db		 		= &JFactory::getDBO();
		$user			= &JFactory::getUser();
		$post			= JRequest::get( 'post' );
		$row =& JTable::getInstance('spa_product','Table');

		$id	=	JRequest::getVar('id',0);
		
		$addNew	=	TRUE;
		if ($id)
		{	
			$row->load($id);
		}
		
		$row->bind($post);

		$text	=	JRequest::getVar('text');
		$text	=	JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );
		
		$text	=	explode('<hr id="system-readmore" />',$text);
		if (count($text) == 2)
		{
			$row->intro	=	$text[0];
			$row->fulltext	=	$text[1];
		}
		else {
			$row->intro		=	'';
			$row->fulltext	=	$text[0];
		}

		if (!$row->alias)
		{
			require_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'href.php';
			$href	=	new href();	
			$row->alias	=	strtolower($href->take_file_name($row->title));
		
		}
		$category	=	JRequest::getVar('category');
		$category	=	explode('/',$category);
		if (count($category) == 2)
		{
			$row->secid		=	$category[0];
			$row->catid		=	$category[1];
		}
		else {
			$row->secid		=	0;
			$row->catid		=	0;
		}		
		
		$date	=	JFactory::getDate();
		$row->cdate	=	$row->cdate != '0000-00-00 00:00:00'?$row->cdate:$date->toMySQL();
		$row->mdate	=	$date->toMySQL();
		
		$results = $dispatcher->trigger('onBeforeSaveSPAP', array (& $row));

		$row->store();
		
		$results = $dispatcher->trigger('onAfterSaveSPAP', array (& $row ));
		
		$task	=	JRequest::getVar('task');
//		die;
		if ($task == 'product.save')
		{
			JError::raiseNotice('c','Successfully saved changes to product: '. $row->title);
			$mainframe->redirect( "index.php?option=$option&task=products");
		}
		else {
			JError::raiseNotice('c','Successfully apply changes to product: '. $row->title);
			$mainframe->redirect( "index.php?option=$option&task=product.edit&cid=$row->id" );	
			}
	}
	
	function resethits()
	{
		global $mainframe, $option;
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$row =& JTable::getInstance('spa_product','Table');
		$cid 	= JRequest::getVar('cid', 0, 'post', 'array');
		
		$row->load($cid);					
		$row->hits = 0;		
		$row->store();
		
		JError::raiseNotice('c','Successfully reset hits: '. $row->title);
		$mainframe->redirect( "index.php?option=$option&task=product.edit&cid=$row->id" );
	}
}
