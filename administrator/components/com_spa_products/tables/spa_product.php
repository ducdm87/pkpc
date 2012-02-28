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
class TableSPA_product extends JTable
{
	/** @var int Primary key */
	var $id 				= 	null;
	/** @var string */
	var $title				=	'';
	/** @var string */
	var $alias				=	'';
	/** @var int*/
	var $intro				=	'';
	/** @var int*/
	var $fulltext			=	'';
	var $secid				=	'';
	var $catid				=	'';
	var	$published			=	'';
	var	$price				=	'';
	var	$thumb				=	'';
	var	$smallThumb			=	'';
	var	$timeWarranty		=	'';
	var	$warrantyType		=	'';
	var	$quanlity			=	'';
	var	$book				=	'';
	var	$fac_id				=	'';
	var	$cdate				=	'';			
	var $mdate				=	'';
	/** @var int, user id */
	var $ordering			=	'';
	/** @var int suporter id */
	var $metakey			=	'';
	var $metadesc			=	'';
	var $hits				=	'';
	/** @var datetime */
	var $params				=	'';
	
	/**
	* @param database A database connector object
	*/
	function TableSPA_product(&$db)
	{
		parent::__construct( '#__spa_product', 'id', $db );
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
