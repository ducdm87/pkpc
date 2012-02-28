<?php
/**
* @version		$Id: helper.php 14401 2010-01-26 14:10:00Z louis $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.base.tree');
jimport('joomla.utilities.simplexml');

/**
 * mod_mainmenu Helper class
 *
 * @static
 * @package		Joomla
 * @subpackage	Menus
 * @since		1.5
 */
class SOFT_modMainMenuHelper
{
	function getParams() {
		return $this->params;
	}

	function setParams(&$val) {
		return $this->params = $val;
	}
	
	function buildXML($params)
	{
		$menu = new JMenuTree($params);
		$items = &JSite::getMenu();

		// Get Menu Items
		$rows = $items->getItems('menutype', $params->get('menutype'));
		$maxdepth = $params->get('maxdepth',10);

		// Build Menu Tree root down (orphan proof - child might have lower id than parent)
		$user =& JFactory::getUser();
		$ids = array();
		$ids[0] = true;
		$last = null;
		$unresolved = array();
		// pop the first item until the array is empty if there is any item
		if ( is_array($rows)) {
			while (count($rows) && !is_null($row = array_shift($rows)))
			{
				if (array_key_exists($row->parent, $ids)) {
					$row->ionly = $params->get('menu_images_link');
					$menu->addNode($params, $row);

					// record loaded parents
					$ids[$row->id] = true;
				} else {
					// no parent yet so push item to back of list
					// SAM: But if the key isn't in the list and we dont _add_ this is infinite, so check the unresolved queue
					if(!array_key_exists($row->id, $unresolved) || $unresolved[$row->id] < $maxdepth) {
						array_push($rows, $row);
						// so let us do max $maxdepth passes
						// TODO: Put a time check in this loop in case we get too close to the PHP timeout
						if(!isset($unresolved[$row->id])) $unresolved[$row->id] = 1;
						else $unresolved[$row->id]++;
					}
				}
			}
		}
		return $menu->toXML();
	}

	function &getXML($type, &$params, $decorator)
	{
		static $xmls;

		if (!isset($xmls[$type])) {
			$cache =& JFactory::getCache('mod_mainmenu');
			$string = $cache->call(array('modMainMenuHelper', 'buildXML'), $params);
			$xmls[$type] = $string;
		}

		// Get document
		$xml = JFactory::getXMLParser('Simple');
		$xml->loadString($xmls[$type]);
		$doc = &$xml->document;

		$menu	= &JSite::getMenu();
		$active	= $menu->getActive();
		$start	= $params->get('startLevel');
		$end	= $params->get('endLevel');
		$sChild	= $params->get('showAllChildren');
		$path	= array();

		// Get subtree
		if ($start)
		{
			$found = false;
			$root = true;
			if(!isset($active)){
				$doc = false;
			}
			else{
				$path = $active->tree;
				for ($i=0,$n=count($path);$i<$n;$i++)
				{
					foreach ($doc->children() as $child)
					{
						if ($child->attributes('id') == $path[$i]) {
							$doc = &$child->ul[0];
							$root = false;
							break;
						}
					}

					if ($i == $start-1) {
						$found = true;
						break;
					}
				}
				if ((!is_a($doc, 'JSimpleXMLElement')) || (!$found) || ($root)) {
					$doc = false;
				}
			}
		}

		if ($doc && is_callable($decorator)) {
			$doc->map($decorator, array('end'=>$end, 'children'=>$sChild));
		}
		return $doc;
	}

	function render(&$params, $callback)
	{
		switch ( $params->get( 'menu_style', 'list' ) )
		{
			case 'list_flat' :
				// Include the legacy library file
				require_once(dirname(__FILE__).DS.'legacy.php');
				mosShowHFMenu($params, 1);
				break;

			case 'horiz_flat' :
				// Include the legacy library file
				require_once(dirname(__FILE__).DS.'legacy.php');
				mosShowHFMenu($params, 0);
				break;

			case 'vert_indent' :
				// Include the legacy library file
				require_once(dirname(__FILE__).DS.'legacy.php');
				mosShowVIMenu($params);
				break;

			default :
				// Include the new menu class			
				$xml = modMainMenuHelper::getXML($params->get('menutype'), $params, $callback);
				if ($xml) {
					$class = $params->get('class_sfx');					
					$xml->addAttribute('class', 'menu'.$class);
					if ($tagId = $params->get('tag_id')) {
						$xml->addAttribute('id', $tagId);
					}

					$result = JFilterOutput::ampReplace($xml->toString((bool)$params->get('show_whitespace')));
					$result = str_replace(array('<ul/>', '<ul />'), '', $result);
					echo $result;
				}
				break;
		}
	}
}
