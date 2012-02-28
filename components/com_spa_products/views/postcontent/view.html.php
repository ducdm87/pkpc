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
class FAQViewPostcontent extends JView
{
	var $postdata	=	array();
	function display($tpl = null)
	{
		global $mainframe,$option;
		$option		= JRequest::getCmd( 'option' );

		$list_cat	=	$this->getCategory();

		$this->assignRef('list_cat',	$list_cat);
		JHTML::_('behavior.mootools');
			$document =& JFactory::getDocument();
			$document->addScript(JURI::root().'components/com_spa_faq/assets/js/post.js');
			$document->addStyleSheet(JURI::root().'components/com_spa_faq/assets/css/post.css');
		$this->assignRef('postdata', $this->postdata);
		parent::display($tpl);
	}
	
	function getCategory()
	{
		$db	=	JFactory::getDBO();
		$cparams 	= 	&JComponentHelper::getParams( 'com_spa_faq' );
		$catids		=	$cparams->get('catids');
		$query = 'SELECT CONCAT_WS("/", s.id, c.id) as id, c.title' .
				' FROM #__categories AS c' .
				' LEFT JOIN #__sections AS s ON s.id=c.section' .
				' WHERE c.published = 1' .
				' AND c.id in ( '.$catids.')'.
				' ORDER BY s.title, c.title';
		$db->setQuery($query);
		
		return $db->loadObjectList();	
	}
}
