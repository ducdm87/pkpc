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
class FAQViewCategory extends JView
{
	function display($tpl = null)
	{
		global $mainframe,$option;
		
		// Set the toolbar
		$cache = &JFactory::getCache('com_spa_faq','output');
		$id	=	JRequest::getVar('id');
		if ($data = $cache->get('category_'.$id,'com_spa_faq')) {
			JHTML::_('behavior.mootools');
			jimport('joomla.html.pane');
			$pane=&JPane::getInstance('tabs',array('startOffset'=>0,'startTransition'=>0));			
			$document=JFactory::getDocument();
			$document->addStyleSheet('components/com_spa_faq/assets/css/category.css');
			
			echo $data;
			return true;
		}
		$cache->clean();
		$cache->start('category_'.$id,'com_spa_faq');
		
		$option		= JRequest::getCmd( 'option' );
		
		$model	=	$this->getModel('category');
		$rows_hit		= $model->getData('SCONTENT.hits');		
		
		$rows_cdate		= $model->getData('SCONTENT.cdate');
		$pageNav_cdate	= $model->getPagination('SCONTENT.cdate');
			
		$this->assignRef('rows_hit',	$rows_hit);
		
		$this->assignRef('rows_cdate',	$rows_cdate);
		$this->assignRef('pageNav_cdate',	$pageNav_cdate);
		
		parent::display($tpl);
		
		$cache->end();	
	}
}
