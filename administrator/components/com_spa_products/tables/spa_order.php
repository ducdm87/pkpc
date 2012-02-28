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
class TableSPA_order extends JTable
{
	/** @var int Primary key */
	var $id 				= 	null;
	/** @var string */
	var $name				=	'';
	/** @var int */
	var $title				=	'';
	/** @var string cid or link */
	var $state				=	'';
	/** @var int. module id */
	var $alias				=	'';
	/** @var int*/
	var $cdate				=	'';
	/** @var int*/
	var $mdate				=	'';
	/** @var int*/
	var $notice 			=	'';
	/** @var string. link to thumb images */
	var $birthday				=	'';
	/** @var int. max width for thumb. Unit: px */
	var $address1		=	'';
	/** @var string. menu or content */
	var $address2		=	'';		//menu or content
	/** @var string */
	var $phone1			=	'';
	/** @var string */
	var $phone2			=	'';
	/** @var int */
	var $mail1			=	'';
	var $mail2			=	'';
	var $chat1			=	'';
	var $chat2			=	'';
	var $mail1			=	'';
	var $quality		=	'';
	var $params			=	'';
	
	/**
	* @param database A database connector object
	*/
	function TableSPA_order(&$db)
	{
		parent::__construct( '#__spa_order', 'id', $db );
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
