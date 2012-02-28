<?php
/**
 * @version		$Id: manager.php 10381 2008-06-01 03:35:53Z yopensource $
 * @package		YOS News Crawler
 * @subpackage	Link Manager
 * @license		commercial
 * @author 		yopensource
 * @email		yopensource@gmail.com
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
// Set the table directory
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

/**
 * Weblinks Component Weblink Model
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class SPAModelcontents extends JModel
{
	/**
	 * amMap data array
	 *
	 * @var array
	 */
	var $_data = null;	

	/**
	 * uri total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;
	
	var $_contentEdit=null;
	
	var $errRemove=null;
	/**
	 * Constructor
	 *
	 * @since 0.9
	 */
	
	function __construct()
	{
		parent::__construct();

		global $mainframe,$option;
		
		//$context			= 'com_content.viewcontent';
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.SPA_manager.filter_order', 		'filter_order', 	'SCONTENT.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.SPA_manager.filter_order_Dir',	'filter_order_Dir',	'',				'word' );		
		$search 			= $mainframe->getUserStateFromRequest( $option.'.SPA_manager.search', 			'search', 			'',				'string' );
		$search 			= JString::strtolower( $search );		
		
		$limit				= $mainframe->getUserStateFromRequest($option.'.SPA_manager.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$module				= $mainframe->getUserStateFromRequest($option.'.SPA_manager.module', 'module', 0, 'int');
		$secid				= $mainframe->getUserStateFromRequest($option.'.SPA_manager.secid', 'secid', 0, 'int');
		$catid				= $mainframe->getUserStateFromRequest($option.'.SPA_manager.catid', 'catid', 0, 'int');
		$state				= $mainframe->getUserStateFromRequest($option.'.SPA_manager.state', 'state', -1, 'int');
		$limitstart			= $mainframe->getUserStateFromRequest($option.'.SPA_manager.limitstart', 'limitstart', 0, 'int');

		$this->setState('limit', 		$limit);
		$this->setState('limitstart', 	$limitstart);
		$this->setState('module', 		$module);
		$this->setState('secid', 		$secid);
		$this->setState('state', 		$state);
		$this->setState('catid', 		$catid);
		$this->setState('search', 		$search);
		// Get the filter request variables
		$this->setState('filter_order', 	$filter_order);
		$this->setState('filter_order_dir', $filter_order_Dir);
	}
	
	function getTotal()
	{
		// Lets load the total nr if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery(); 
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	function getPagination()
	{		
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
	
		return $this->_pagination;
	}
	
	
	function getData(){
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
//					echo $query;			
			$this->_data = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit') );
			
		}
	
		return $this->_data;
	}
	
	function _buildQuery(){
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildWhere();
		$orderby	= $this->_buildOrderBy();
		
		$config 	= &JComponentHelper::getParams('com_spa_manager');
		$module_type 	= $config->get('module_type');	
		
			//Get Events from Database
		$query = ' SELECT SCONTENT.*,SCONTENT.state published, SEC.title as sec_title, CAT.title as cat_title, MODULE.title as module_title '.
					'FROM #__spa_content AS SCONTENT '. 
						'LEFT JOIN #__sections as SEC on SCONTENT.secid = SEC.id '. 
						'LEFT JOIN #__categories as CAT on SCONTENT.catid = CAT.id '. 
						'LEFT JOIN #__modules MODULE on SCONTENT.module = MODULE.id'.	$where. $orderby;

//		$db	=	JFactory::getDBO();
//		$db->setQuery($query);
//		echo $db->getQuery();
		return $query;
	}
	
	function _buildWhere( )
	{		
		
		$db					= &JFactory::getDBO();		
		$search				= $this->getState('search');	
		$module				= $this->getState('module');	
		$secid				= $this->getState('secid');	
		$catid				= $this->getState('catid');	
		$state				= $this->getState('state');	
		$where 				= array();
		
		if ( $search ) {
			$w	=	'(';
			$w .= 'SCONTENT.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR SEC.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR CAT.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR MODULE.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w	.=	')';
			$where[]	=	$w;
		}	
		if ($module)
			$where[]	=	' MODULE.id = '.$module;
		if ($secid)
			$where[]	=	' SEC.id = '.$secid;
		if ($catid)
			$where[]	=	' CAT.id = '.$catid;
		if ($state != -1)
			$where[]	=	' SCONTENT.state = '.$state;
			
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
					
		return $where;
	}
	
	function _buildOrderBy()
	{
		$filter_order		=	$this->getState('filter_order');
		$filter_order_Dir	=	$this->getState('filter_order_dir');
		
		if ($filter_order == 'SCONTENT.id'){
			$orderby 	= ' ORDER BY SCONTENT.id '. $filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', SCONTENT.id';
		}
		
		return $orderby;
	}
	
	function getLists(){
		$db	=	JFactory::getDBO();
		
		// state filter
		$lists['state'] = JHTML::_('grid.state', $this->getState('filter_state'), 'Published', 'Unpublished');
		
		// table ordering
		$lists['order_Dir']	= $this->getState('filter_order_dir');
		$lists['order']		= $this->getState('filter_order');
		
		// search filter
		$lists['search']= $this->getState('search');
		
		$config 	= &JComponentHelper::getParams('com_spa_manager');
		$module_type 	= $config->get('module_type');

		$query = 'SELECT id as value, title AS text FROM #__sections';
		$db->setQuery($query);
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Sections').' -');
		$active		= 	$this->getState('secid');		
		$items = array_merge($items, $db->loadObjectList());
		$lists['section'] = JHTML::_('select.genericlist',  $items, 'secid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);
		
		$query = 'SELECT id as value, title AS text FROM #__categories WHERE section = '. $active;
		$db->setQuery($query);
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -');
		$active		= 	$this->getState('catid');		
		$items = array_merge($items, $db->loadObjectList());
		$lists['category'] = JHTML::_('select.genericlist',  $items, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);
				
		$query = 'SELECT id as value, CONCAT_WS( " #",title, id ) AS text FROM #__modules WHERE module = '.$db->quote($module_type);
		$db->setQuery($query);		
		$modules	=	array();
		$modules[] = JHTML::_('select.option', '0', '- '.JText::_('Select Module').' -');
		$active		= 	$this->getState('module');		
		$modules = array_merge($modules, $db->loadObjectList());
		$module = JHTML::_('select.genericlist',  $modules, 'module', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);
		$lists['module']	=	$module;

		$items	=	array();
		$items[] = JHTML::_('select.option', '-1', '- '.JText::_('Select State').' -');
		$items[] = JHTML::_('select.option', '1', JText::_('Publish'));
		$items[] = JHTML::_('select.option', '0', JText::_('UnPublish'));
		$active		= 	$this->getState('state');
		
		$lists['state'] = JHTML::_('select.genericlist',  $items, 'state', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);
		
		return $lists;
	}		

	// FOR EDIT
/*	*/
	function getcontentEdit(){		
		if ($this->_contentEdit) {
			return $this->_contentEdit;			
		}
		global $mainframe;
		// Initialize variables
		$doTask 	= JRequest::getCmd('task',null);
		$db			=& JFactory::getDBO();
		$user 		=& JFactory::getUser();
		$uid		= $user->get('id');
		$option		= JRequest::getCmd( 'option' );
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );

		JArrayHelper::toInteger($cid, array(0));
		
		$edit		=	(strtolower($doTask) == 'content.edit') || ($cid[0]);
	
		$row =& JTable::getInstance('SPA_content','Table');
	
		// load the row from the db table
		if ($edit)
			$row->load( $cid[0] );		
	
//	die;
		$this->_contentEdit=$row;		
		return $this->_contentEdit;
	}	
	function getListsEdit(){
		
		$db			=	&JFactory::getDBO();
		
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
	
		JArrayHelper::toInteger($cid, array(0));
		$doTask 	= JRequest::getCmd('task',null);
		$edit		=	strtolower($doTask) == 'content.edit';
		$sectionid	=	0;

		$row =$this->getcontentEdit();
		
		// load the row from the db table
		if ($edit)
			$row->load( $cid[0] );
		
		$config 	= &JComponentHelper::getParams('com_spa_manager');
		$module_type 	= $config->get('module_type');
			
		// Select plug-in for chart
		
		$query = 'SELECT id, CONCAT_WS( " #",title, id ) AS title FROM #__modules WHERE module = '.$db->quote($module_type).' AND published = 1';
		$db->setQuery($query);
				
		$module = $db->loadObjectList();
		$html	= '<select name="module" id="module">';
		$html	.='<option value="0">------------------</option>';
		$html	.= JHTML::_('select.options', $module, 'id', 'title', $row->module );
		$html	.= '</select>';
		$lists['module']			= $html;

		$query = 'SELECT CONCAT_WS( "/",S.id, C.id ) AS value, CONCAT_WS( "/",S.title, C.title ) AS text '.
					'FROM #__categories as C '.
						'LEFT JOIN #__sections as S ON S.id = C.section'.
					' WHERE S.scope = '. $db->quote('com_spa_products');
						
		$db->setQuery($query);
		
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -');
		$active		= 	$row->secid.'/'.$row->catid;
		$items = array_merge($items, $db->loadObjectList());
		$size	=	count($items)>25?25:count($items);
		$lists['category'] = JHTML::_('select.genericlist',  $items, 'category', 'class="inputbox" size="'.$size.'', 'value', 'text', $active);

		return $lists;
	}
	function remove()
	{		
		// Initialize variables
		$db 	=& JFactory::getDBO();
		$cids 	= JRequest::getVar('cid', array(0), 'post', 'array');
		JArrayHelper::toInteger($cid);

		if (count( $cids ) < 1) {
			JError::raiseError(500, JText::_( 'Select a Link to delete', true ));
		}
		$arr_err=array();
		foreach ($cids as $cid)
		{
			$jobs_title=$this->getJobs($cid);
			if (count($jobs_title)) {
				$arr_err[$cid]=implode(',',$jobs_title);
				continue;
			}
			$query = 'DELETE FROM #__yos_news_crawler'
			. ' WHERE id = ( '.$cid.' )'
			;
			$db->setQuery( $query );
			if (!$db->query()) {
				JError::raiseError( 500, $db->stderr() );
				return false;
			}
			
		}
		$this->errRemove=$arr_err;
		if (count($arr_err)) {
			$this->errRemove=$arr_err;
		}
		return;
	}
	function save()
	{
		
	}
		
/*	*/
}
