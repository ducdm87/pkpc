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
class SPAViewProducts extends JView
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
		JHTML::stylesheet( 'spa_manager.css', 'administrator/components/com_spa_products/assets/' );		
		JToolBarHelper::title( JText::_( 'Products' ).' <small>[manager]</small>', 'content' );
				
		
		
//		JToolBarHelper::custom( 'content.copy', 'copy.png', 'copy_f2.png', 'Copy', true );
		JToolBarHelper::deleteList('Are you sure?','product.remove');
		JToolBarHelper::editListX('product.edit');		
		JToolBarHelper::addNewX('product.new');	
		JToolBarHelper::preferences('com_spa_products', '400');

	}
	
	// edit link
	function edit()
	{	
		global $mainframe;
		JHTML::stylesheet( 'spa_manager.css', 'administrator/components/com_spa_products/assets/' );	
		$doTask 	= JRequest::getCmd('task',null);
		$edit		=	strtolower($doTask) == 'product.edit';
	//	$document->addScriptDeclaration($this->get('Script'));
		$row	=	$this->get('contentEdit');
		$lists	=	$this->get('ListsEdit');
			
		JRequest::setVar( 'hidemainmenu', 1 );
		$this->assignRef('row',$row);
//		var_dump($row); 
//		var_dump($lists); 
//		die();
		
		$this->assignRef('lists', $lists);
		$this->_setToolBarEdit($edit);
		parent::display();
	}
	
	function _setToolBarEdit($edit){
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$cid = intval($cid[0]);

		$text = ( $edit ? JText::_( 'Edit' ) : JText::_( 'New' ) );
		$bar =& JToolBar::getInstance('toolbar');
		JToolBarHelper::title( JText::_( 'Product' ).': <small><small>[ '. $text.' ]</small></small>', 'addedit.png' );
		
		$step	=	intval(JRequest::getInt('step'));
		
		JToolBarHelper::apply('product.apply');		
		JToolBarHelper::save('product.save');
				
		if ( $edit ) {
			// for existing articles the button is renamed `close`
			JToolBarHelper::cancel( 'product.cancel', 'Close' );
		} else {
			JToolBarHelper::cancel('product.cancel');
		}
	}
	
}
