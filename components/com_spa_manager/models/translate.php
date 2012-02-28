<?php
/**
 * Translate Model for yos_translator Component
 * @package		yos_translator
 * @subpackage	Models
 * @link		http://yopensource.com
 * @author		ducdm
 * @copyright 	ducdm (ducdm@f5vietnam.com)
 * @license		Commercial
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

require_once( JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers' .DS. 'defines.php' );
JLoader::register('JoomFishManager', JOOMFISH_ADMINPATH.DS.'classes'.DS.'JoomfishManager.class.php');

/**
 * This is the corresponding module for translation management
 * @package		Joom!Fish
 * @subpackage	Translate
 */
class TranslatorModelTranslate extends JModel 
{
	var $_modelName = 'translate';
	
	var $_lists = array();
	
	var $_listsCron=array();
	
	var $_default_language = '';
	
	var $select_language_id = 0;
	var $select_catid = '';
	var $search = '';
	var $tranFilters;
	
	var $_data = null;
	
	var $_page_nav = null;
	
	var $i=0;
	
	function __construct(){
		global $mainframe, $option;
	
		$db =& JFactory::getDBO();
		
		parent::__construct();
	}
	function initialize($lang_id,$catid='content')
	{
		$this->select_language_id=$lang_id;
		$this->select_catid=$catid;
		$this->_getListFilter();
		$this->_data=null;
	}
	
	function getData(){
		global $mainframe, $option;
		$db =& JFactory::getDBO();
		if ($this->_data) {
			return $this->_data;
		}		
		$rows=null;
		//get data
		if( $this->select_language_id != -1 && $this->select_catid != '' ) {
			$JFManager = new JoomFishManager();
			$contentElement = $JFManager->getContentElement( $this->select_catid );			
			if (!$contentElement){
				$catid = "content";
				$contentElement = $JFManager->getContentElement( $catid );
			}
			
			$pageNav = $this->getPageNav();
			
			$contentTable = $contentElement->getTable();
			foreach( $contentTable->Fields as $table ) {
				if($table->Translate==1 && $table->Type!='params')        ////////////   note
					$tableField[] = $table->Name;
			}

			$db->setQuery( $contentElement->createContentSQL( $this->select_language_id, null, $pageNav->get('limitstart'), $pageNav->get('limit'), $this->tranFilters ) );
			$rows = $db->loadObjectList();
			
			if ($db->getErrorNum()) {
				echo $db->stderr();
				// should not stop the page here otherwise there is no way for the user to recover
				$rows = array();
			}
			
			// Manipulation of result based on further information
			for( $i=0; $i<count($rows); $i++ ) {
				JLoader::import( 'models.ContentObject', JOOMFISH_ADMINPATH);
				$contentObject = new ContentObject( $this->select_language_id, $contentElement );
				$contentObject->readFromRow( $rows[$i] );
				$rows[$i] = $contentObject;
			}
			
		}
		$this->i=$this->i+1;
//		var_dump($this->select_catid,$this->select_language_id,$this->i,count($rows),'<hr />');
		$this->_data = $rows;
		
		return $this->_data;
	}
	
	function getPageNav(){
		global $mainframe, $option;
		
		$db =& JFactory::getDBO();
		
		if ($this->_page_nav) {
			return $this->_page_nav;
		}
		
		$limit		= 0;
		$limitstart = 0;
		$search ='';
		
		$total=0;
		
		if( $this->select_language_id != -1 && $this->select_catid != '' ) {
			$JFManager = new JoomFishManager();
			$contentElement = $JFManager->getContentElement( $this->select_catid );
			
			if (!$contentElement){
				$catid = "content";
				$contentElement = $JFManager->getContentElement( $this->select_catid );
			}
			
			$total = $contentElement->countReferences($this->select_language_id, $this->tranFilters);
		}

		// Create the pagination object
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		
		$this->_page_nav = $pageNav;
		
		return $this->_page_nav;		
	}
	
	function _getListFilter(){
		global $mainframe, $option;
		
		$db =& JFactory::getDBO();
		
		$limit		=0;
		$limitstart = 0;
		$search = '';
		
		$filterHTML=array();
		if( $this->select_language_id != -1 && $this->select_catid != '' ) {
			$JFManager = new JoomFishManager();
			$contentElement = $JFManager->getContentElement( $this->select_catid );			
			if (!$contentElement){
				$this->select_catid = "content";
				$contentElement = $JFManager->getContentElement( $this->select_catid );
			}		
			JLoader::import( 'models.TranslationFilter', JOOMFISH_ADMINPATH);
			$tranFilters = getTranslationFilters($this->select_catid,$contentElement);
			
			$this->tranFilters = $tranFilters;

			foreach ($tranFilters as $tranFilter){
				$afilterHTML=$tranFilter->_createFilterHTML();
				if (isset($afilterHTML)) $filterHTML[$tranFilter->filterType] = $afilterHTML;
			}

		}
		
		return $filterHTML;
	}
	
	/**
	 * returns the default language of the frontend
	 * @return object	instance of the default language
	 */
	function getDefaultLanguage() {
		if ($this->_default_language) {
			return $this->_default_language;
		}
		
		$params = JComponentHelper::getParams('com_languages');
		$this->_default_language = $params->get("site", 'en-GB');
		
		return $this->_default_language;
	}
	
	//////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////  FOR CRON //////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	function getListCron()
	{
		global $mainframe, $option;
		
		if (count($this->_listsCron)) {
			return $this->_listsCron;
		}
		$this->_listsCron['languages'] = $this->_getlistLanguageCron();
		$this->_listsCron['elements'] = $this->_getlistElementCron();
		return $this->_listsCron;
		
	}
	function _getlistLanguageCron()
	{
		global $mainframe, $option;
		
		$JFManager = new JoomFishManager();
		$langActive = $JFManager->getLanguages();		//all languages even non active once
		$defaultLang = $this->getDefaultLanguage();
		$params = JComponentHelper::getParams('com_joomfish');
		$showDefaultLanguageAdmin = $params->get("showDefaultLanguageAdmin", true);		
		$langOptions[] = JHTML::_('select.option',  '-1', JText::_('Select Language') );
		
		if ( count($langActive)>0 ) {
			foreach( $langActive as $language )
			{
				if($language->code != $defaultLang || $showDefaultLanguageAdmin) {
					if($language->active)  // only active
					{
						$langlist[] =$language->id;
					}
				}
			}
		}
		return $langlist;
	}
	function _getlistElementCron()
	{
		global $mainframe, $option;
		
		$JFManager = new JoomFishManager();
		$content_elements = $JFManager->getContentElements(true);
		foreach( $content_elements as $key => $element )
		{
			$elements[] =$key;
		}		
		return $elements;
	}
}