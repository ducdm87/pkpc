<?php
/**
 * @version		$Id: contact.php 10094 2008-03-02 04:35:10Z instance $
 * @package		Joomla
 * @subpackage	Test
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );


/**
 * @package		Joomla
 * @subpackage	Test
 */
class TableSPA_factory extends JTable
{
	/** @var int Primary key */
	var $id 				= 	null;
	/** @var string */
	var $title				=	'';
	/** @var string */
	var $alias				=	null;
	/** @var string cid or link */
	var $thumb				=	'';
	/** @var int. module id */
	var $smallThumb			=	'';
	/** @var int*/
	var $intro				=	'';
	/** @var int*/
	var $fulltext 			=	'';
	/** @var int*/
	var $homepageUrl 		=	'';
	/** @var string. link to thumb images */
	var $published			=	'';
	/** @var int. max width for thumb. Unit: px */
	var $ordering			=	'';
	/** @var string. menu or content */
	var $metakey			=	'';		//menu or content
	/** @var string */
	var $metadesc			=	'';
	var $cdate				=	'';
	var $mdate				=	'';
	/** @var string */
	var $hits			=	'';
	/** @var int */
	var $params			=	'';
	
	/**
	* @param database A database connector object
	*/
	function TableSPA_factory(&$db)
	{
		parent::__construct( '#__spa_factory', 'id', $db );
	}

	/**
	 * Overloaded check function
	 *
	 * @access public
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check()
	{
		return true;
	}	
}
