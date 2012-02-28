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
class SPAModelProducts extends JModel
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
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.SPA_products.filter_order', 		'filter_order', 	'P.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.SPA_products.filter_order_Dir',	'filter_order_Dir',	'',				'word' );		
		$search 			= $mainframe->getUserStateFromRequest( $option.'.SPA_products.search', 			'search', 			'',				'string' );
		$search 			= JString::strtolower( $search );		

		$limit				= $mainframe->getUserStateFromRequest($option.'.SPA_products.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$secid				= $mainframe->getUserStateFromRequest($option.'.SPA_products.secid', 'secid', 0, 'int');
		$catid				= $mainframe->getUserStateFromRequest($option.'.SPA_products.catid', 'catid', 0, 'int');
		$state				= $mainframe->getUserStateFromRequest($option.'.SPA_products.state', 'state', -1, 'int');
		$limitstart			= $mainframe->getUserStateFromRequest($option.'.SPA_products.limitstart', 'limitstart', 0, 'int');

		$this->setState('limit', 		$limit);
		$this->setState('limitstart', 	$limitstart);
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
		
		$config 	= &JComponentHelper::getParams('com_spa_faq');
		$module_type 	= $config->get('module_type');	
		
			//Get Events from Database
		$query = ' SELECT F.title ftitle, P.*, SEC.title as sec_title, CAT.title as cat_title '.
					'FROM #__spa_factory AS F '. 
						'RIGHT JOIN #__spa_product as P on F.id = P.fac_id '.
						'LEFT JOIN #__sections as SEC on P.secid = SEC.id '. 
						'LEFT JOIN #__categories as CAT on P.catid = CAT.id '. 		
						$where. $orderby;

//		$db	=	JFactory::getDBO();
//		$db->setQuery($query);
//		echo $db->getQuery();
//		die;
		return $query;
	}
	
	function _buildWhere( )
	{		
		
		$db					= &JFactory::getDBO();		
		$search				= $this->getState('search');
		$secid				= $this->getState('secid');	
		$catid				= $this->getState('catid');	
		$state				= $this->getState('state');	
		$where 				= array();
		
		if ( $search ) {
			$w	=	'(';
			$w .= 'F.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR P.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR P.intro LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR P.fulltext LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR P.metadesc LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			
			$w	.=	')';
			$where[]	=	$w;
		}	
		
		if ($secid)
			$where[]	=	' P.secid = '.$secid;
		if ($catid)
			$where[]	=	' P.catid = '.$catid;
		if ($state != -1)
			$where[]	=	' P.published = '.$state;
			
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
					
		return $where;
	}
	
	function _buildOrderBy()
	{
		$filter_order		=	$this->getState('filter_order');
		$filter_order_Dir	=	$this->getState('filter_order_dir');
		
		if ($filter_order == 'P.id'){
			$orderby 	= ' ORDER BY P.id '. $filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', P.id';
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
		
		$config 	= &JComponentHelper::getParams('com_spa_products');
		$module_type 	= $config->get('module_type');

		$query = 'SELECT id as value, title AS text FROM #__sections where scope='. $db->quote('com_spa_products');
		$db->setQuery($query);
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Sections').' -');
		$active		= 	$this->getState('secid');		
		$items = array_merge($items, $db->loadObjectList());
		$lists['section'] = JHTML::_('select.genericlist',  $items, 'secid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);
		if ($active)
			$query = 'SELECT c.id as value, c.title AS text '.
					' FROM #__categories as c '.
					' INNER JOIN #__sections as s ON c.section = s.id'.
					' WHERE c.section = '. $active.
					' AND s.scope='.$db->quote('com_spa_products');
		else
			$query = 'SELECT c.id as value, c.title AS text '.
					' FROM #__categories as c '.
					' INNER JOIN #__sections as s ON c.section = s.id'.
					' WHERE s.scope='.$db->quote('com_spa_products');
		$db->setQuery($query);
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -');
		$active		= 	$this->getState('catid');		
		$items = array_merge($items, $db->loadObjectList());
		$lists['category'] = JHTML::_('select.genericlist',  $items, 'catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);
		
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
		
		$edit		=	(strtolower($doTask) == 'product.edit') || ($cid[0]);
	
		$row =& JTable::getInstance('spa_product','Table');
	
		// load the row from the db table
		if ($edit)
			$row->load( $cid[0] );
		if ($row->intro and $row->fulltext)
			$row->text	=	$row->intro . '<hr id="system-readmore" />'. $row->fulltext;
		else $row->text	=	$row->fulltext;
		$this->_contentEdit=$row;
//		var_dump($row);
		return $this->_contentEdit;
	}	
	function getListsEdit(){
		
		$db			=	&JFactory::getDBO();
		
		$cid		= JRequest::getVar( 'cid', array(0), '', 'array' );
	
		JArrayHelper::toInteger($cid, array(0));
		$doTask 	= JRequest::getCmd('task',null);
		$edit		=	strtolower($doTask) == 'product.edit';
		$sectionid	=	0;

		$row =$this->getcontentEdit();
		
		// load the row from the db table
		if ($edit)
			$row->load( $cid[0] );	
		// Select plug-in for chart
		
		$query = 'SELECT CONCAT_WS( "/",S.id, C.id ) AS value, CONCAT_WS( "/",S.title, C.title ) AS text '.
					'FROM #__categories as C '.
						'LEFT JOIN #__sections as S ON S.id = C.section'.
					' WHERE S.scope = '. $db->quote('com_spa_products');
						
		$db->setQuery($query);
		
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Category').' -');
		$active		= 	$row->secid.'/'.$row->catid;
		$items = array_merge($items, $db->loadObjectList());
		$size	=	count($items)>7?7:count($items);
		$lists['category'] = JHTML::_('select.genericlist',  $items, 'category', 'class="inputbox" size="'.$size.'', 'value', 'text', $active);

		$query = 'SELECT F.id AS value, F.title AS text '.
					'FROM #__spa_factory as F ';
						
		$db->setQuery($query);
		
		$items	=	array();
		$items[] = JHTML::_('select.option', '0', '- '.JText::_('Select Factory').' -');
		$active		= 	$row->secid.'/'.$row->catid;
		$items = array_merge($items, $db->loadObjectList());
		$size	=	count($items)>7?7:count($items);
		$lists['factory'] = JHTML::_('select.genericlist',  $items, 'fac_id', 'class="inputbox" size="'.$size.'', 'value', 'text', $row->fac_id);
			
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
