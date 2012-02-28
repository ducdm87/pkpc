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
class SPAViewContents extends JView
{
	function display($tpl = null)
	{
		global $mainframe,$option;
		
		// Set the toolbar
		$this->_setToolBar();
		
		$option		= JRequest::getCmd( 'option' );
		
		$rows		= $this->get('Data');
		$pageNav	= $this->get('Pagination');
		$lists		= $this->get('Lists');
		
		$this->assignRef('lists',	$lists);	
		$this->assignRef('rows',	$rows);
		$this->assignRef('pageNav',	$pageNav);
		$this->assign('option',		$option);
		
		parent::display($tpl);
		
	}	

	function _setToolBar()
	{
		JHTML::stylesheet( 'spa_manager.css', 'administrator/components/com_spa_manager/assets/' );		
		JToolBarHelper::title( JText::_( 'Module Manager' ).' <small>[Content]</small>', 'news' );		
		JToolBarHelper::deleteList('Are you sure?','content.remove');
		JToolBarHelper::editListX('content.edit');
		JToolBarHelper::addNewX('content.new');		
		JToolBarHelper::preferences('com_spa_manager', '300');
		
		JSubMenuHelper::addEntry('Module Manager', 'index.php?option=com_spa_manager&task=modules', FALSE);
		JSubMenuHelper::addEntry('Content Manager', 'index.php?option=com_spa_manager&task=contents', TRUE);
		JSubMenuHelper::addEntry('About', 'index.php?option=com_spa_manager&task=about', false);
	}
	
	// edit link
	function edit()
	{	
		global $mainframe;
		JHTML::stylesheet( 'yos_news_crawler.css', 'administrator/components/com_yos_news_crawler/assets/' );	
		$doTask 	= JRequest::getCmd('task',null);
		$edit		=	strtolower($doTask) == 'link.edit';	
		
	//	$document->addScriptDeclaration($this->get('Script'));
		$row	=	$this->get('LinkEdit');
		$lists	=	$this->get('ListsEdit');
		$this->_setToolBarEdit($edit);	
	
		$this->assignRef('row',$row);	
		$this->assignRef('lists', $lists);
		
		parent::display();
	}
	
	function _setToolBarEdit($edit){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$cid = intval($cid[0]);

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );
		$bar =& JToolBar::getInstance('toolbar');
		JToolBarHelper::title( JText::_( 'Content News' ).': <small><small>[ '. $text.' ]</small></small>', 'addedit.png' );
		
		$step	=	intval(JRequest::getInt('step'));
		
		JToolBarHelper::apply('link.apply');		
		JToolBarHelper::save('link.save');
					
		// Add a back button
		$dhtml = "<a class=\"toolbar\" href=\"#\">
							<span title=\"Next\" class=\"icon-32-back\"><!--span--></span>
							Back
						</a>";
		$bar->appendButton( 'Custom', $dhtml, 'back' );
		
		// Add a next button
		$dhtml = "<a class=\"toolbar\" href=\"#\">
							<span title=\"Next\" class=\"icon-32-next\"><!--span--></span>
							Next
						</a>";
		$bar->appendButton( 'Custom', $dhtml, 'next' );
		
		// Add a preview button
		$dhtml = "<a id=\"toolbar-preview\" href=\"#\">
							<span title=\"Next\" class=\"icon-32-preview\"><!--span--></span>
							Preview
						</a>";
		$bar->appendButton( 'Custom', $dhtml, 'Preview' );
		
		if ( $edit ) {
			// for existing articles the button is renamed `close`
			JToolBarHelper::cancel( 'link.cancel', 'Close' );
		} else {
			JToolBarHelper::cancel('link.cancel');
		}
	}
	
}
