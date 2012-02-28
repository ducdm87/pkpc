<?php
/**
 * @license		Commercial
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/**
 * Yos Utility class
 * Store many useful functions
 *
 */
class spa_utility
{	
	function getVersion(){
		$xml = & JFactory::getXMLParser('Simple');
		if ($xml->loadFile(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'version.xml'))
		{
			if (!$version = & $xml->document->version) {
				return false;
			}
			if (!$url = & $xml->document->url) {
				return false;
			}
			if (!$productcode = & $xml->document->productcode) {
				return false;
			}
		} else {
			return false;
		}
		
		return array('version' => $version[0]->data(), 'url' => $url[0]->data(), 'productcode'=> $productcode[0]->data() );
		
	}
}
?>

