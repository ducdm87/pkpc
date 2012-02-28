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
/**
 * Weblinks Component Weblink Model
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class SPAModelSection extends JModel
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
		
		$menu  = &JSite::getMenu();
		$menuid=JRequest::getVar('Itemid',0);
		$limit		=	10;
		if($menuid!=0)
		{
//			header('location:index.php');
		$item        	=	$menu->getItem($menuid);
		$item_params 	=	new JParameter($item->params);		
		$limit			=	$item_params->get('intro');
		}
		
		//$context			= 'com_content.viewcontent';
		$filter_order		= $mainframe->getUserStateFromRequest( $option.'.SPA_products.filter_order', 		'filter_order', 	'SCONTENT.id',	'cmd' );
		$filter_order_Dir	= $mainframe->getUserStateFromRequest( $option.'.SPA_products.filter_order_Dir',	'filter_order_Dir',	'',				'word' );		
		$search 			= $mainframe->getUserStateFromRequest( $option.'.SPA_products.search', 			'search', 			'',				'string' );
		$search 			= JString::strtolower( $search );		
		
//		$limit				= $mainframe->getUserStateFromRequest($option.'.SPA_products.limit', 'limit', 'limit', 'int');

		$id				= $mainframe->getUserStateFromRequest($option.'.SPA_products.secid', 'id','id', 'int');
				
		$state				= $mainframe->getUserStateFromRequest($option.'.SPA_products.state', 'state', -1, 'int');
		$limitstart			= $mainframe->getUserStateFromRequest($option.'.SPA_products.limitstart', 'limitstart', 0, 'int');

		$this->setState('limit', 		$limit);
		$this->setState('limitstart', 	$limitstart);		
		$this->setState('id', 		$id);
		
		// Get the filter request variables
		$this->setState('filter_order', 	$filter_order);
		$this->setState('filter_order_dir', $filter_order_Dir);
	}
	
	function getTotal($order = '')
	{
		// Lets load the total nr if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery($order); 
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	
	function getPagination($order = '')
	{		
		// Lets load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			if ($order == 'P.cdate')
				$this->_pagination = new JPagination( $this->getTotal($order), $this->getState('limitstart'), $this->getState('limit') );
			else {
				$this->_pagination = new JPagination( $this->getTotal($order), 0, $this->getState('limit') );
			}
			
		}
	
		return $this->_pagination;
	}
	
	
	function getData($order = ''){
		// Lets load the content if it doesn't already exist
		
			$query = $this->_buildQuery($order);
//					echo $query;
			if ($order == 'P.cdate')
			{
				$this->_data = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit') );
			}
			else {
				$this->_data = $this->_getList( $query, 0, $this->getState('limit') );
			}
		return $this->_data;
	}
	
	function _buildQuery($order = ''){
		// Get the WHERE and ORDER BY clauses for the query
		$where		= $this->_buildWhere();
		$orderby	= $this->_buildOrderBy($order);
		
		$config 	= &JComponentHelper::getParams('com_spa_faq');
		$module_type 	= $config->get('module_type');	
		
			//Get Events from Database
		$query = ' SELECT P.*, SEC.title as sec_title, CAT.title as cat_title, '.
					' CASE WHEN CHAR_LENGTH(P.alias) THEN CONCAT_WS(":", P.id, P.alias) ELSE P.id END as slug, '.
						' CASE WHEN CHAR_LENGTH(CAT.alias) THEN CONCAT_WS(":", CAT.id, CAT.alias) ELSE CAT.id END as catslug, '.
						' CASE WHEN CHAR_LENGTH(SEC.alias) THEN CONCAT_WS(":", SEC.id, SEC.alias) ELSE SEC.id END as secslug '.
					'FROM #__spa_product AS P '. 
						'RIGHT JOIN #__categories as CAT on CAT.id = P.catid '.	
						'RIGHT JOIN #__sections as SEC on SEC.id = CAT.section '.	$where. $orderby;

//		$db	=	JFactory::getDBO();
//		$db->setQuery($query);
//		echo $db->getQuery();
//		echo '<hr />';
		return $query;
	}
	
	function _buildWhere( )
	{		
		
		$db					= &JFactory::getDBO();
		$secid				= $this->getState('secid');	
		$nullDate	= $db->getNullDate();
		$date =& JFactory::getDate();
		$now = $date->toMySQL();
		
		$where 				= array();
		$where[]		= 'P.published = 1';
		$where[]	=	'SEC.scope = '. $db->quote('com_spa_products');	
		if ($secid)
			$where[]	=	' SEC.id = '.$secid;
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
					
		return $where;
	}
	
	function _buildOrderBy($order = '')
	{
		$filter_order		=	$this->getState('filter_order');
		$filter_order_Dir	=	$this->getState('filter_order_dir');
		$orderby	=	'';
		if ($order == 'P.hits'){
			$orderby 	= ' ORDER BY P.hits DESC, P.id';
		} else if($order == 'P.cdate'){
			$orderby 	= ' ORDER BY P.cdate DESC, P.id';
		}
		
		return $orderby;
	}
	
/*	*/
}
