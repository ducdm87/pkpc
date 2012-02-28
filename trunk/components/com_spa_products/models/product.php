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
class SPAModelProduct extends JModel
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
		
	}
	
	
	function getData(){
		
		$db		= &JFactory::getDBO();
		$nullDate	= $db->getNullDate();
		$date 	=& JFactory::getDate();
		$now 	= $date->toMySQL();
		$cid	=	JRequest::getInt('id');

		$where	=	array();
		$where[]	=	' P.id = '.$cid;
		
		$where 		= ( count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '' );
		
		$query = ' SELECT P.*, SEC.title as sec_title, CAT.title as cat_title, '.
						' CASE WHEN CHAR_LENGTH(P.alias) THEN CONCAT_WS(":", P.id, P.alias) ELSE P.id END as slug, '.
						' CASE WHEN CHAR_LENGTH(CAT.alias) THEN CONCAT_WS(":", CAT.id, CAT.alias) ELSE CAT.id END as catslug, '.
						' CASE WHEN CHAR_LENGTH(SEC.alias) THEN CONCAT_WS(":", SEC.id, SEC.alias) ELSE SEC.id END as secslug '.
			'FROM #__spa_product AS P '. 
				'LEFT JOIN #__sections as SEC on P.secid = SEC.id '. 
				'LEFT JOIN #__categories as CAT on P.catid = CAT.id '.	$where;
		$db->setQuery($query);
		$data	=	$db->loadObject();
//		echo $db->getQuery();
		return $data;
	}
	function incremenHit($cid)
	{
		
		JTable::addIncludePath(JPATH_COMPONENT_SITE.DS.'tables');
		$row =& JTable::getInstance('SPA_product','Table');
		
		$row->load($cid);					
		$row->hits = $row->hits + 1;		
		$row->store();
		
	}
	
}
