<?php
/*
# Copyright (C) 2009 YOS Team. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: HongChuyen
# Websites:  http://yopensource.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


if ( ! defined('modMainMenuXMLCallbackDefined') )
{
	function modMainMenuXMLCallbackDefined(&$node, $args)
	{
		$user	= &JFactory::getUser();
		$menu	= &JSite::getMenu();
		$active	= $menu->getActive();	
		$path	= isset($active) ? array_reverse($active->tree) : null;
	
		if (($args['end']) && ($node->attributes('level') >= $args['end']))
		{
			$children = $node->children();
			foreach ($node->children() as $child)
			{
				if ($child->name() == 'ul') {
					$node->removeChild($child);
				}
			}
		}
	
		if ($node->name() == 'ul') {
			foreach ($node->children() as $child)
			{
				if ($child->attributes('access') > $user->get('aid', 0)) {
					$node->removeChild($child);
				}
			}
		}
	
		if (($node->name() == 'li') && isset($node->ul)) {
			$node->addAttribute('class', 'parent');	
		}
		
		// set order/first/last for li
		if ($node->name() == 'ul')
		{
			$count = count($node->children());
			foreach ($node->children() as $i => $child) {
				if ($i == 0) $child->addAttribute('class', 'first');
				if ($i == $count - 1) $child->addAttribute('class', 'last');
			}
			
			if (4<$count and $count<9) {
				$node->addAttribute('class', 'col2');	
			}else if($count>=9) {
				$node->addAttribute('class', 'col3');	
			}
		}
		
		
	
		if (isset($path) && (in_array($node->attributes('id'), $path) || in_array($node->attributes('rel'), $path)))
		{
			if ($node->attributes('class')) {
				$node->addAttribute('class', $node->attributes('class').' active');
			} else {
				$node->addAttribute('class', 'active');
			}
		}
		else
		{
			if (isset($args['children']) && !$args['children'])
			{
				$children = $node->children();
				foreach ($node->children() as $child)
				{
					if ($child->name() == 'ul') {
						$node->removeChild($child);
					}
				}
			}
		}
	
		if (($node->name() == 'li') && ($id = $node->attributes('id'))) {
			if ($node->attributes('class')) {
				$node->addAttribute('class', $node->attributes('class').' item'.$id);
			} else {
				$node->addAttribute('class', 'item'.$id);
			}
		}
	
		if (isset($path) && $node->attributes('id') == $path[0]) {
			$node->addAttribute('id', 'current');
		} else {
			$node->removeAttribute('id');
		}
		$node->removeAttribute('rel');
		$node->removeAttribute('level');
		$node->removeAttribute('access');
	
	}
	define('modMainMenuXMLCallbackDefined', true);
}

require_once (dirname(__FILE__).DS.'helper.php');

$mod = new SOFT_modMainMenuHelper();
$mod->setParams($params);
$mod->render($params, 'modMainMenuXMLCallbackDefined');