<?php
/*
# Copyright (C) 2009 YOS Team. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: HongChuyen
# Websites:  http://yopensource.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');

if ( ! defined('modYOSMenuXMLCallbackDefined') )
{
function modYOSMenuXMLCallback(&$node, $args)
{
	$yosmenu  	= &modYOSMenuHelper::getInstance();
	$params   	= $yosmenu->getParams();
	$user		= &JFactory::getUser();
	$menu		= &JSite::getMenu();
	$active		= $menu->getActive();	
	$path		= isset($active) ? array_reverse($active->tree) : null;

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
		
		// set order/first/last for li
		$count = count($node->children());
		foreach ($node->children() as $i => $child) {
			if ($i == 0) $child->addAttribute('first', 1);
			if ($i == $count - 1) $child->addAttribute('last', 1);
			$child->addAttribute('order', $i + 1);
		}
		
		// set ul level
		if (isset($node->_children[0])) {
			$level 	= $node->_children[0]->attributes('level') - $params->get('startLevel');
			$css 	= 'lvl' . $level;
			if ($node->attributes('first')) $css .= ' first-ul';
			if ($node->attributes('last')) $css .= ' last-ul';
			$node->attributes('class') ? $node->addAttribute('class', $node->attributes('class') . ' ' . $css) : $node->addAttribute('class', $css);
		}
	}

	// set item styling
	if ($node->name() == 'li') {

		$item        = $menu->getItem($node->attributes('id'));
		$item_params = new JParameter($item->params);
		$sfx_params  = new YOSTmplParams($params->get('class_sfx'));	
		$page_params = new YOSTmplParams($item_params->get('pageclass_sfx'));		
		$level       = $node->attributes('level') - $params->get('startLevel');
		$images      = $sfx_params->get('images') != 'off';
		$color       = $page_params->get('itemcolor', '');
		$columns     = (int) $page_params->get('columns', 1);
		$width       = (int) $page_params->get('columnwidth');
//		$css         = 'lvl' . $level . ' item' . $node->attributes('order');
		$css         = 'lvl' . $level . ' item' . $node->attributes('id');
		$span_css    = '';

		if ($color) $css .= ' '.$color;
		if ($node->attributes('first')) $css .= ' first-li';
		if ($node->attributes('last')) $css .= ' last-li';
		if (isset($node->ul) && ($args['end'] == 0 || $node->attributes('level') < $args['end'])) $css .= ' parent';
		if (isset($path) && in_array($node->attributes('id'), $path)) $css .= ' active';
		if (isset($path) && $node->attributes('id') == $path[0]) $css .= ' current';
		if ($item->type == 'separator') $css .= ' separator';

		// add a/span css classes
		if (isset($node->_children[0])) {
			$node->_children[0]->attributes('class') ? $node->_children[0]->addAttribute('class', $node->_children[0]->attributes('class') . ' ' . $css) : $node->_children[0]->addAttribute('class', $css);
		}

		// add item css classes
		$node->attributes('class') ? $node->addAttribute('class', $node->attributes('class') . ' ' . $css) : $node->addAttribute('class', $css);

		// add item background image
		if ($item_params->get('menu_image') && $item_params->get('menu_image') != -1) {
			if (isset($node->_children[0])) {
				if ($images && isset($node->_children[0]->span[0])) {
					$img = 'images'.DS.'stories'.DS.$item_params->get('menu_image');
					$alt = dirname($img).DS.JFile::stripExt(basename($img)).'_alt.'.JFile::getExt($img);

					// check for alternate image
					if (JFile::exists(JPATH_ROOT.DS.$alt)) {
						$img = $alt;
					}
					
					$node->_children[0]->span[0]->addAttribute('style', 'background-image: url('.JURI::base().$img.');');
					$span_css .= 'icon';
				}
				if ($img = $node->_children[0]->getElementByPath('img')) {
					$node->_children[0]->removeChild($img); // remove old item image
				}
			}
		}

		// add span css and subtitle span
		if (isset($node->_children[0]) && isset($node->_children[0]->span[0])) {
			$node->_children[0]->span[0]->addAttribute('class', 'bg '.$span_css);
			$title = $node->_children[0]->span[0];
			$split = explode('::', $title->data(), 2);
			if (count($split) == 2) {
				$span =& $node->_children[0]->span[0]->addChild('span', array('class' => 'menutitle'));
				$span->setData(trim($split[0]));
				$span =& $node->_children[0]->span[0]->addChild('span', array('class' => 'submenutitle'));
				$span->setData(trim($split[1]));
			}
		}
	}

	if (!(isset($path) && in_array($node->attributes('id'), $path))) {
		if (isset($args['children']) && !$args['children'])	{
			$children = $node->children();
			foreach ($node->children() as $child) {
				if ($child->name() == 'ul') {
					$node->removeChild($child);
				}
			}
		}
	}

	$node->removeAttribute('id');
	$node->removeAttribute('rel');
	$node->removeAttribute('level');
	$node->removeAttribute('access');
	$node->removeAttribute('order');
	$node->removeAttribute('first');
	$node->removeAttribute('last');
	
	//Parse title and remove the options & description which configure for mega menu.
	$title = $node->data();
	$title = str_replace (array('\\[','\\]'), array('%open%', '%close%'), $title);
	$regex = '/([^\[]*)\[([^\]]*)\](.*)$/';
	if (preg_match ($regex, $title, $matches)) {
		$title = $matches[1];
	} else {
		$title = $title;
	}
	$title = str_replace (array('%open%', '%close%'), array('[',']'), $title);
	$node->setData ($title);
}
	define('modYOSMenuXMLCallbackDefined', true);
}