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
class TableSPA_content extends JTable
{
	/** @var int Primary key */
	var $id 				= 	null;
	/** @var string */
	var $title				=	'';
	/** @var int */
	var $cid				=	null;
	/** @var string cid or link */
	var $link				=	'';
	/** @var int. module id */
	var $module				=	0;
	/** @var int*/
	var $secid				=	0;
	/** @var int*/
	var $catid				=	0;
	/** @var int*/
	var $ordering 			=	0;
	/** @var string. link to thumb images */
	var $thumb				=	'';
	/** @var int. max width for thumb. Unit: px */
	var $thumb_width		=	0;
	/** @var string. menu or content */
	var $type				=	'';		//menu or content
	/** @var string */
	var $introtext			=	'';
	/** @var string */
	var $keywords			=	'';
	/** @var int */
	var $premium			=	0;
	/** @var datetime */
	var $state				=	1;
	/** @var datetime */	
	var $cdate				=	'';
	/** @var datetime */
	var $mdate				=	'';
	/** @var datetime */
	var	$publish_up			=	'';
	/** @var datetime */
	var $publish_down		=	'';	
	/** @var string. target windows when the link is clicked  */
	var $target				=	'';
	
	/**
	* @param database A database connector object
	*/
	function TableSPA_content(&$db)
	{
		parent::__construct( '#__spa_content', 'id', $db );
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
