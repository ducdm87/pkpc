<?php
/**
 * SPA manager
 *
 * @package		spa_manager
 * @subpackage	manager
 * @author		DAM MANH DUC
 * @copyright 	ducdm87@gmail.com
 * @license		Commercial
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

// Set the table directory
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

/**
 * HTML View class for the YOS News Crawler views
 *
 * @static
 * @package		YOS
 * @subpackage	YOS_News_Crawler
 * @since 1.0
 */
class SPAViewProduct extends JView
{
	function display($tpl = null)
	{
		global $mainframe,$option;
		$option		= JRequest::getCmd( 'option' );
		$dispatcher	=& JDispatcher::getInstance();

		$model		=	$this->getModel('product');

		$row		= 	$model->getData();
		if (!$row)
		{
			JError::raiseNotice('c','Bài viết này không tồn tại');
			$mainframe->redirect( JURI::root() );
		}
		$model->incremenHit($row->id);
		$this->assignRef('row',	$row);
		$this->assign('option',		$option);
		
		JPluginHelper::importPlugin('spa_product');
		$results = $dispatcher->trigger('onPrepareSPA', array (& $row));
		/*
		 * Handle display events
		 */
		$row->event = new stdClass();
		$results = $dispatcher->trigger('onAfterDisplaySPA', array (&$row));
		$row->event->afterDisplaySPA = trim(implode("\n", $results));
		parent::display($tpl);
		
	}
}
