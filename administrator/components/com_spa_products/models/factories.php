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
class SPAModelFactories extends JModel
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
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.SPA_factories.filter_order', 		'filter_order', 	'F.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.SPA_factories.filter_order_Dir',	'filter_order_Dir',	'',				'word' );		
		$search 			= $mainframe->getUserStateFromRequest( $option.'.SPA_factories.search', 			'search', 			'',				'string' );
		$search 			= JString::strtolower( $search );		
		
		$limit				= $mainframe->getUserStateFromRequest($option.'.SPA_factories.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart			= $mainframe->getUserStateFromRequest($option.'.SPA_factories.limitstart', 'limitstart', 0, 'int');

		$this->setState('limit', 		$limit);
		$this->setState('limitstart', 	$limitstart);

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
		
		$config 	= &JComponentHelper::getParams('com_spa_products');
			//Get Events from Database
		$query = ' SELECT F.* '.
					'FROM #__spa_factory AS F '.	$where. $orderby;

//		$db	=	JFactory::getDBO();
//		$db->setQuery($query);
//		echo $db->getQuery();
		return $query;
	}
	
	function _buildWhere( )
	{		
		
		$db					= &JFactory::getDBO();		
		$search				= $this->getState('search');
		$where 				= array();
		
		if ( $search ) {
			$w	=	'(';
			$w .= 'F.title LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
			$w .= ' OR F.id LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );	
			$w .= ' OR F.intro LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );	
			$w .= ' OR F.fulltext LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );	
			$w .= ' OR F.homepageUrl LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );	
			$w .= ' OR F.metakey LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );	
			$w .= ' OR F.metadesc LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );	
			$w	.=	')';
			$where[]	=	$w;
		}
			
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
					
		return $where;
	}
	
	function _buildOrderBy()
	{
		$filter_order		=	$this->getState('filter_order');
		$filter_order_Dir	=	$this->getState('filter_order_dir');
		
		if ($filter_order == 'F.id'){
			$orderby 	= ' ORDER BY F.id '. $filter_order_Dir;
		} else {
			$orderby 	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir .', F.id';
		}
		
		return $orderby;
	}
	
	function getLists(){
		$db	=	JFactory::getDBO();
		// table ordering
		$lists				=	array();
		$lists['order_Dir']	= 	$this->getState('filter_order_dir');
		$lists['order']		= 	$this->getState('filter_order');
		
		// search filter
		$lists['search']= $this->getState('search');		
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
		
		$edit		=	(strtolower($doTask) == 'factory.edit') || ($cid[0]);
	
		$row =& JTable::getInstance('spa_factory','Table');
	
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
		
		$cid		= 	JRequest::getVar( 'cid', array(0), '', 'array' );
		$lists		=	array();
		JArrayHelper::toInteger($cid, array(0));
		$doTask 	= 	JRequest::getCmd('task',null);
		$edit		=	strtolower($doTask) == 'factory.edit';
		$sectionid	=	0;

		$row =$this->getcontentEdit();
		
		// load the row from the db table
		if ($edit)
			$row->load( $cid[0] );	
		// Select plug-in for chart
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
