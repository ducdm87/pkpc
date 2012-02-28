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

// Include the syndicate functions only once

	$type 		=	$params->get('type',0);	
	
	if ($type == 'jhtml')
	{
		$description	=	$params->get('description',0);
		require(JModuleHelper::getLayoutPath('mod_spa_content','jhtml'));
	}
	else {
			if (!class_exists('modSPA_contentHelper'))
				require_once( dirname(__FILE__).DS.'helper.php' );
			$limit_content		=	$params->get('limit_content',10);
			$catid	=	$params->get('catid',0);
			$secid	=	$params->get('secid',0);
			$class_sfx 	=	$params->get('moduleclass_sfx','');
			
			$moduleId	=	$module->id;
			$menuId		=	JRequest::getVar('Itemid',1);
			$helper 		=	new modSPA_contentHelper($limit_content, $catid, $secid);
			
			$header 		=	$params->get('header','');
			$footer 		=	$params->get('footer','');
			
			$limit_menu			=	$params->get('limit_menu',5);
			
			$menus	 	=	$helper->getMenus($moduleId,$limit_menu);
			
			$contents	=	array();
			
			$showEditor	=	$params->get('showEditor',1);

			if ($showEditor)
			{	
				$enablePremium		=	$params->get('enablePremium',1);
				$orderEditor		=	$params->get('orderEditor','cdate');
				$helper->getContentsEditor($moduleId, $enablePremium, $orderEditor);
			}
			
			if ($catid)
			{
				$orderCat		=	$params->get('orderCat','cdate');
				$helper->getContentsCat($orderCat);
			}
			
			if ($secid)
			{
				$orderSec		=	$params->get('orderSec','cdate');
				$helper->getContentsSec($orderSec);
			}
			
			$showSystem	=	$params->get('showSystem',1);
			if ($showSystem)
			{
				$orderSys		=	$params->get('orderSys','cdate');
				$helper->getContentsSys($orderSys);
			}
			
			$contentsE	=	$helper->getContentsE();
			
			$contentsS	=	$helper->getContentsS();
			$contentsS	=	JArrayHelper::sortObjects($contentsS,'created',-1);
			$total		=	10000;
			$contents	=	array_merge($contentsE, $contentsS);
//$debug	=	JRequest::getVar('debug',0);
//if ($debug) {
//	var_dump($helper);
//	die;
//}					 
			if (count($contents) || count($menus)) {
				require(JModuleHelper::getLayoutPath('mod_spa_content',$type));	
			
			}elseif ($type == 'chiase')
			{
				require(JModuleHelper::getLayoutPath('mod_spa_content',$type));
			}
	}
