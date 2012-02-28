<?php
/**
 * @version
 * @package	F5OSS
 * @subpackage	module
 * @copyright	Copyright (C) 2010 YOS.,JSC. All rights reserved.
 * @license	GNU/GPL 3, see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modSPA_contentHelper extends JObject {
	/**
	 * Get all available departments
	 *
	 * @return array of department objects, else return false
	 */
	var $_dataE	=	array();
	var $_dataS	=	array();
	
	var $_limit	=	0;
	var $_catid =	0;
	var $_secid =	0;
	
	function __construct($limit, $catid, $secid)
	{
		$this->_limit	=	$limit;
		$this->_catid	=	$catid;
		$this->_secid	=	$secid;
	}
	function getMenus($moduleId, $limit){
		
		if(!class_exists('ContentHelperRoute')) require_once (JPATH_SITE . '/components/com_content/helpers/route.php');  
		
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$aid		= $user->get('aid', 0);		
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )';

		// Ordering
		$ordering		= 'a.premium DESC,a.ordering, a.cdate';

		// Content Items only
		$query = 'SELECT a.*'.
				' FROM #__spa_content AS a '.	
						' WHERE '. $where .
						' AND a.type = 1' .
						' AND a.module = ' . $moduleId.
//						' AND a.menu = ' . $menuId.
				' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $limit);
		$datas = $db->loadObjectList();
		
		return $datas;
//		echo $db->getQuery();
	}
	
	function getContentsE()
	{	
		return $this->_dataE;
	}
	function getContentsS()
	{
		return $this->_dataS;
	}
	
	function getContentsEditor($moduleId, $enablePremium, $orderBy){
		
		if(!class_exists('ContentHelperRoute')) require_once (JPATH_SITE . '/components/com_content/helpers/route.php');  
		
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$aid		= $user->get('aid', 0);		
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )';
		
		// Ordering
		$ordering	=	'';
		if ($enablePremium)
			$ordering		.= 'a.premium DESC,';
			
		if ($orderBy == 'ordering')
			$ordering		.= 'a.ordering, a.cdate DESC';
		else if ($orderBy == 'cdate')
			$ordering		.= 'a.cdate DESC, p.cdat DEeSC, a.ordering';

		// Content Items only
		$query = 'SELECT a.*, cc.title as cat_title, cc.section as sectionid, ' .
						' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as slug, '.
						' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug, '.
						' CASE WHEN CHAR_LENGTH(cs.alias) THEN CONCAT_WS(":", cs.id, cs.alias) ELSE cs.id END as secslug'.
				' FROM #__spa_content AS a '.
						' LEFT JOIN #__spa_product AS p ON a.cid = p.id'.
						' LEFT JOIN #__categories AS cc ON cc.id = p.catid' .
						' LEFT JOIN #__sections AS cs ON cs.id = cc.section' .						
						' WHERE '. $where .
//						($access ? ' AND cc.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid : '').
						' AND (p.published  = 1 or a.cid = 0)' .
						' AND a.type = 0' .
						' AND a.module = ' . $moduleId.
				' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $this->_limit);		
		
		$datas = $db->loadObjectList();
//echo count($datas);
//			if($datas[$key]->access <= $aid)
//			{
//				$datas[$key]->link = JRoute::_(ContentHelperRoute::getArticleRoute($datas[$key]->slug, $datas[$key]->catslug, $datas[$key]->sectionid));
//			} else {
//				$datas[$key]->link = JRoute::_('index.php?option=com_user&view=login');
//			}
		$this->_dataE	=	array_merge($this->_dataE, $datas);
	}
	
	function getContentsCat($orderBy)
	{
		if(!class_exists('ContentHelperRoute')) require_once (JPATH_SITE . '/components/com_content/helpers/route.php');  
		
		$limit	=	$this->_limit - count($this->_dataE) - count($this->_dataS);
		if ($limit < 1)
			return ;
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$aid		= $user->get('aid', 0);		
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where		= 'p.published = 1 ';
		
		// Ordering
		$ordering	=	'';
		
		if ($orderBy == 'ordering')
			$ordering		.= 'p.ordering, p.cdate DESC';
		if ($orderBy == 'cdate')
			$ordering		.= 'p.cdate DESC, p.ordering';
		
		// Content Items only
		$query = 'SELECT a.*, cc.title as cat_title, cc.section as sectionid,'.
						' "0" as thumb_width, "" as thumb,"" as link,  ' .
						' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as slug,'.
						' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
						' CASE WHEN CHAR_LENGTH(cs.alias) THEN CONCAT_WS(":", cs.id, cs.alias) ELSE cs.id END as secslug'.
				' FROM #__spa_product AS p'.
						' LEFT JOIN #__categories AS cc ON cc.id = p.catid' .
						' LEFT JOIN #__sections AS cs ON cs.id = cc.section' .
						' WHERE '. $where .						
						' AND p.catid = ' . $this->_catid.
						' AND cs.scope = ' . $db->quote('spa_product').
				' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $limit);
		$datas = $db->loadObjectList();

		$this->_dataS	=	array_merge($this->_dataS, $datas);
		return $datas;
	}

	function getContentsSec($orderBy)
	{
		if(!class_exists('ContentHelperRoute')) require_once (JPATH_SITE . '/components/com_content/helpers/route.php');  
		
		$limit	=	$this->_limit - count($this->_dataE) - count($this->_dataS);
		if ($limit < 1)
			return ;
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$aid		= $user->get('aid', 0);		
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where		= 'a.published = 1 ';
		
		// Ordering
		$ordering	=	'';
		
		if ($orderBy == 'ordering')
			$ordering		.= 'p.ordering, p.cdate DESC';
		if ($orderBy == 'cdate')
			$ordering		.= 'p.cdate DESC, p.ordering';
		
		// Content Items only
		$query = 'SELECT a.*, cc.title as cat_title, cc.section as sectionid, ' .
						' "0" as thumb_width, "" as thumb,"" as link,  ' .
						' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
						' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
						' CASE WHEN CHAR_LENGTH(cs.alias) THEN CONCAT_WS(":", cs.id, cs.alias) ELSE cs.id END as secslug'.
				' FROM #__spa_product AS p'.
						' LEFT JOIN #__categories AS cc ON cc.id = p.catid' .
						' LEFT JOIN #__sections AS cs ON cs.id = cc.section' .
						' WHERE '. $where .						
						' AND p.catid <> ' . $this->_catid.
						' AND p.secid = ' . $this->_secid.
						' AND cs.scope = ' . $db->quote('spa_product').
				' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $limit);		
		$datas = $db->loadObjectList();
		if (is_array($datas))
			$this->_dataS	=	array_merge($this->_dataS, $datas);
	}
	function getContentsSys($orderBy)
	{	
		if(!class_exists('ContentHelperRoute')) require_once (JPATH_SITE . '/components/com_content/helpers/route.php');  
		
		$limit	=	$this->_limit - count($this->_dataE) - count($this->_dataS);
		
		if ($limit < 1)
			return ;
		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$aid		= $user->get('aid', 0);		
		
		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('show_noauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now = $date->toMySQL();

		$where		= 'p.published = 1 ';
		
		// Ordering
		$ordering	=	'';
		
		if ($orderBy == 'ordering')
			$ordering		.= 'p.ordering, p.cdate DESC';
		if ($orderBy == 'cdate')
			$ordering		.= 'p.cdate DESC, p.ordering';
		
		// Content Items only
		$query = 'SELECT p.*, cc.title as cat_title, cc.section as sectionid, ' .
						' "0" as thumb_width, "" as thumb,"" as link,  ' .
						' CASE WHEN CHAR_LENGTH(p.alias) THEN CONCAT_WS(":", p.id, p.alias) ELSE p.id END as slug,'.
						' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug,'.
						' CASE WHEN CHAR_LENGTH(cs.alias) THEN CONCAT_WS(":", cs.id, cs.alias) ELSE cs.id END as secslug'.
				' FROM #__spa_product AS p'.
						' LEFT JOIN #__categories AS cc ON cc.id = p.catid' .
						' LEFT JOIN #__sections AS cs ON cs.id = cc.section' .
						' WHERE '. $where .						
						' AND p.catid <> ' . $this->_catid.
						' AND p.secid <> ' . $this->_secid.
						' AND cs.scope = ' . $db->quote('spa_product').
				' ORDER BY '. $ordering;
		$db->setQuery($query, 0, $limit);		
		$datas = $db->loadObjectList();
		if (is_array($datas))
			$this->_dataS	=	array_merge($this->_dataS, $datas);
	}
}