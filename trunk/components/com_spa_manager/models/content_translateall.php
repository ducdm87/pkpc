<?php
/**
 * Translateall Model for yos_translator Component
 * @package		yos_translator
 * @subpackage	Models
 * @link		http://yopensource.com
 * @author		ducdm
 * @copyright 	ducdm (ducdm@f5vietnam.com)
 * @license		Commercial
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

require_once( JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers' .DS. 'defines.php' );
JLoader::register('JoomFishManager', JOOMFISH_ADMINPATH.DS.'classes'.DS.'JoomfishManager.class.php');

JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

/**
 * Extensions Model
 *
 * @package		yos_translator
 * @subpackage	Components
 */
class TranslatorModelContent_translateall extends JModel
{
	var $_notran	=	array();
	
	/**
	 * id of content
	 *
	 * @var int
	 */
	var $reference_id = 0;
	var $language_id = 0;
	var $reference_table = 'content';
	
	var $publish = 0;
	
	var $translated = 0;
	
	var $_data = null;
	
	var $data=null;
	
	/**
	 * table name
	 *
	 * @var string
	 */
	var $tblName=null;
	
	/**
	 * list field of table will translate
	 *
	 * @var array
	 */
	var $tableField=array();
	
	var $contentElement;
	
	/**
	 * joomfishManager
	 *
	 * @var object
	 */
	
	var $_joomfishManager=null;
	
	// detail table. all fields.  full infomation about table, value and style
	var $_tableTranslate;	

		
	/**
	 * Constructor
	 *
	 * @since 0.9
	 */
	function __construct()
	{
		parent::__construct();
	}
	/**
	 * initialize
	 *
	 * @param int $reference_id id of content
	 * @param int $language_id
	 * @param string $catid
	 */
	function initialize($reference_id, $language_id,$catid='content'){

		global $mainframe;		
		
		$this->reference_id = $reference_id;
		$this->language_id = $language_id;
				
		$db = $this->_db;
		
		$this->tblName=$catid;
		
		$this->_joomfishManager =& JoomFishManager::getInstance();		
		
		$this->tableField=$this->getFieldTranslate($catid);

		$this->contentElement=$this->getContentElement($catid);		
		
		$this->_tableTranslate=$this->getTableTranslate($catid);		// full infomation about table, value and style
	
		//get original table content		
		if (!$this->contentElement){
			$mainframe->redirect('index.php?option=com_yos_translator&view=translate');
			return ;
		}
		// set original data and translate data
	  	$this->setOrg($this->reference_id);
	  	$this->setTsl();
//						$org=$this->getData('org_');
//						$tsl=$this->getData('tsl_');
//						var_dump($org,'<br /> <hr /><hr /><hr /><hr /><hr /><hr />'); 
//						var_dump($tsl);
//						die();
	}
	
	/**
 * return list field of element(catid) to translate
 *
 * @param $catid name of element
 * @return list fieldTable
 */
	function getFieldTranslate($catid)
	{	
		if (count($this->tableField)) {
			return $this->tableField;
		}
		// get tablefield
		$JFManager = new JoomFishManager();		
		$contentElement = $JFManager->getContentElement( $catid );			
			if (!$contentElement){
				$catid = "content";
				$contentElement = $JFManager->getContentElement( $catid );
			}
			$contentTable = $contentElement->getTable();
			foreach( $contentTable->Fields as $table ) {
				if($table->Translate==1)        ////////////   note
					$tableField[] = $table->Name;
			}
			$this->tableField=$tableField;
		return $this->tableField;
	}
	/**
	 * returl all data of table, detail of tablefield
	 *
	 * @param unknown_type $catid name of element
	 * @return unknown
	 */
	function getTableTranslate($catid)
	{
		$JFManager = new JoomFishManager();
		//$myClass =$JFManager;
		$contentElement = $JFManager->getContentElement( $catid );			
			if (!$contentElement){
				$catid = "content";
				$contentElement = $JFManager->getContentElement( $catid );
			}
			$contentTable = $contentElement->getTable();
			foreach( $contentTable->Fields as $tableField ) {
				if($tableField->Translate==1)
				$tableTranslate[] = $tableField;
			}
		$this->_tableTranslate=$tableTranslate;
		return $this->_tableTranslate; 
	}
	function setOrg($reference_id)
	{
		$db=JFactory::getDBO();
		$catid=$this->tblName;
		//list field will translate
		$tableField=$this->tableField;
		$table=$this->_tableTranslate;
			$field='';
			for ($i=0;$i<count($tableField);$i++)
			{
				if($i==count($tableField)-1)
					$field.=$db->NameQuote($tableField[$i]);
				else $field.=$db->NameQuote($tableField[$i]).',';
			}
			
			$contentElement=$this->contentElement;
			$key=$contentElement->getReferenceId();
			$query='SELECT '.$field.
					' FROM #__'.$this->tblName.
					' WHERE '.$key.'='.$reference_id;
			$db->setQuery($query);			
			$data=$db->loadObject();
//			var_dump($data,'<br />vvvvvvvvv <hr />');	
			$data=$this->readFromRow($data);
//			var_dump($data); die();
		for ($i=0;$i<count($tableField);$i++)
		{	
			$org='org_'.$tableField[$i];				
			$oreg_field=$data->$tableField[$i];
			$this->set($org, $oreg_field);

		}
	}
	function getData($t)
	{
		$tableField=$this->tableField;
		$data=array();
		for ($i=0;$i<count($tableField);$i++)
		{	
			$org=$t.$tableField[$i];			
			$data[$tableField[$i]]=$this->get($org);
		}return $data;
	}
	function setTsl($data=null)
	{
		$catid=$this->tblName;
		$tableField=$this->tableField;
		$table=$this->_tableTranslate;

		for ($i=0;$i<count($tableField);$i++)
		{
			$tsl='tsl_'.$tableField[$i];
			$id='tslid_'.$tableField[$i];
		 	if($data) 
		 		$tsl_field=$data[$i];
		 	else
		 	{		 	
		 		$tsl_field=$this->_selectTranslatedValue($this->reference_id, $this->language_id, $tableField[$i]);
		 		$tsl_id=$this->_selectTranslatedId($this->reference_id, $this->language_id, $tableField[$i]);		 		
		 	}		 		
			$this->set($tsl, $tsl_field);
			$this->set($id, $tsl_id);
			//var_dump($this->get($id));
		} 
		$this->chekTsl();
	}
	function chekTsl()
	{
		$elementTable =& $this->_tableTranslate;
		for( $i=0; $i<count($elementTable); $i++ ) {
			$field =& $elementTable[$i];
			$fieldName = 'tsl_'.$field->Name;  // introtext			
			if( isset($this->$fieldName) ) {
				if ($field->prehandleroriginal!=""){ 
					
					if (JString::strlen($this->get('tsl_fulltext')) > 1) {
						$introtext=  $this->get($fieldName) . "<hr id=\"system-readmore\" />" . $this->get('tsl_fulltext');
					} else {
						$introtext  =$this->get($fieldName);
					}
					$this->set($fieldName,$introtext);
				}
				
			}
		}
	}
	function readFromRow( $row ) {		
		// Go thru all the fields of the element and try to copy the content values
		$elementTable =& $this->_tableTranslate;
		for( $i=0; $i<count($elementTable); $i++ ) {
			$field =& $elementTable[$i];
			$fieldName = $field->Name;  // introtext
			if( isset($row->$fieldName) ) {
				$field->originalValue = $row->$fieldName;				
				if ($field->prehandleroriginal!=""){
					if (method_exists($this,$field->prehandleroriginal)){
						$handler = $field->prehandleroriginal;
						$field->originalValue = $this->$handler($row);
						$row->$fieldName=$this->$handler($row);
//						var_dump(htmlspecialchars($row->introtext)); die();
					}
				}
			}
		}
		return $row;
	}
	function fetchArticleText($row){
			// ghep intro va full sau do gan cho intro	
		/*
		 * We need to unify the introtext and fulltext fields and have the
		 * fields separated by the {readmore} tag, so lets do that now.
		 */
		if (JString::strlen($row->fulltext) > 1) {
			return  $row->introtext . "<hr id=\"system-readmore\" />" . $row->fulltext;
		} else {
			return  $row->introtext;
		}

	}
	function _selectTranslatedValue($reference_id, $language_id, $field)
	{
		$db = $this->_db;		
		$query = 'SELECT value FROM #__jf_content
					WHERE reference_id ='. $db->Quote($reference_id).' 
					 AND language_id = '.$db->Quote($language_id).'
					 AND reference_field = '.$db->Quote($field).'
					 AND reference_table ='.$db->Quote($this->tblName);
		$db->setQuery($query);	
		return $db->loadResult();		
	}
	function _selectTranslatedId($reference_id, $language_id, $field)
	{
		$db = $this->_db;		
		$query = 'SELECT id FROM #__jf_content
					WHERE reference_id ='. $db->Quote($reference_id).' 
					 AND language_id = '.$db->Quote($language_id).'
					 AND reference_field = '.$db->Quote($field).'
					 AND reference_table ='.$db->Quote($this->tblName);
		$db->setQuery($query);	
		return $db->loadResult();		
	}
	function getContentElement($catid)
	{
		if ($this->contentElement) {
			return $this->contentElement;
		}
		JLoader::import( 'helpers.controllerHelper',JOOMFISH_ADMINPATH);		
		$JFManager = new JoomFishManager();
		//$myClass =$JFManager;
		$contentElement = $JFManager->getContentElement( $catid );
		$this->contentElement=$contentElement;
		return $this->contentElement;
	}
	function getTableKey($catid)
	{
		$JFManager = new JoomFishManager();
		//$myClass =$JFManager;
		$contentElement = $JFManager->getContentElement( $catid );			
		if (!$contentElement){
			$catid = "content";
			$contentElement = $JFManager->getContentElement( $catid );
		}
		$contentTable = $contentElement->getTable();
		foreach( $contentTable->Fields as $tableField ) {
			if($tableField->Type=='referenceid' )
			return $tableField->Name;
		}
		return 'id';
	}
	function getTableTitle($catid)
	{
		$JFManager = new JoomFishManager();
		//$myClass =$JFManager;
		$contentElement = $JFManager->getContentElement( $catid );			
		if (!$contentElement){
			$catid = "content";
			$contentElement = $JFManager->getContentElement( $catid );
		}
		$contentTable = $contentElement->getTable();
		foreach( $contentTable->Fields as $tableField ) {
			if($tableField->Type=='titletext' )
			return $tableField->Name;
		}
		return 'title';
	}
	
	function getDefault() {
		global $mainframe;
		$db	=	$this->_db;
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));		
		$params	=	&JComponentHelper::getParams('com_languages');
		$default_language	=	$params->get($client->name, 'en-GB');
		$query				=	"SELECT code_translator FROM #__yos_translator WHERE code_language = '$default_language'";
		$db->setQuery($query);
		$code_translator	=	$db->loadResult();
		if (!$code_translator) {
			$mainframe->redirect('index.php?option=com_yos_translator&task=config', JText::_('Please do configure languages'));
		}
		return $code_translator;
	}
	function getScript(){
		$script=
		"
			google.load(\"language\", \"1\");
			google.setOnLoadCallback(init);
			
			function init() 
			{				
				var from_lang = document.getElementById('from_lang');
				for (l in google.language.Languages) 
				{
					var lng = l.toLowerCase();
					lng 		= lng.substring(0,1).toUpperCase()+lng.substring(1,lng.length);
					var lngCode = google.language.Languages[l];
					if (google.language.isTranslatable(lngCode)) 
					{
						from_lang.options.add(new Option(lng, lngCode));
					}
				}
			}";
		
		return $script;
	}
	// for once translate    ///////////////////////////////////////////////////////
	function translate($lang_from='vi',$lang_to=0,$published=true, & $message=null)
	{
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('yos_translator');
		
//		$translate_to = JRequest::getInt('dst', 0);
		$translate_to = $lang_to;
		$tableField=$this->tableField;
		$table=$this->_tableTranslate;
		for ($i=0;$i<count($tableField);$i++)
		{	
			if ($table[$i]->Type!='params' and $table[$i]->Type!='readonlytext') {
				$nameField=$tableField[$i];			
				$org='org_'.$nameField;	
				$oreg_field=$this->get($org);
				$table[$i]->originalValue=$oreg_field;
			}
		}
		$result=$dispatcher->trigger('onBeforeTranslate', array ($this->tblName, & $table,$translate_to, & $message));
		for ($i=0;$i<count($result);$i++)
		{
			if ($result[$i]==false) {
				return false;
			}
		}		
		$pageContent = '';
		for ($i=0;$i<count($tableField);$i++)
		{	
			if ($table[$i]->Type!='params' and $table[$i]->Type!='readonlytext') {			
				$nameField=$tableField[$i];			
				$org='org_'.$nameField;	
//				$oreg_field=$this->get($org);
				$oreg_field=$table[$i]->originalValue;
				$nameFieldHashBegin=md5($nameField.'_BEGIN_AREA');
				
				$nameFieldHashEND=md5($nameField.'_END_AREA');
				$pageContent .= '' . $nameFieldHashBegin . '<div>' .$oreg_field . '</div>' . $nameFieldHashEND . '';
				$pageContent .= "<br />";
			}
		}		
		//No translate
		$pageContent	=	$this->notranslate($pageContent);
		$pageContent	=	$this->personconfig($pageContent);
		//get language pair
		$languagePair = $this->getLanguagePair($translate_to);
		
		$lang_to_Name=$this->getLanguseName($translate_to);		
//		$language_from = JRequest::getString('from_lang', '');
		$language_from = $lang_from;
		
		if ($language_from != '') {
			//get code of language to
			$code_to = $this->_getLanguageCode($translate_to);
			$languagePair = $language_from.'|'.$code_to;
		}
		
		//get translated pageContent from helper
		require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'translator.php');
		$translator = new Yos_translator();
		$tsl_pageContent = $translator->translate($languagePair, $pageContent);
			
		if (stristr($tsl_pageContent,'ERROR_YOS_TRANSLATOR'))
		{
			$tsl_pageContent=explode('|',$tsl_pageContent);
			$message=$tsl_pageContent[1];
			return false;
		}
	
//		var_dump(htmlspecialchars($tsl_pageContent)); die();
		if (preg_match('/^ERROR #/', $tsl_pageContent)) {
			JError::raiseNotice('500', $tsl_pageContent);
		}
		
		//Prepare save content
		if (count($this->_notran)) {
			foreach ($this->_notran as $notran) {
				$tsl_pageContent	=	str_replace($notran['hash'], $notran['value'], $tsl_pageContent);
				$tsl_pageContent	=	str_replace('<div> '.$notran['value'].' </div>', $notran['value'], $tsl_pageContent);
			}
		}
		$pattern = '/class=system-pagebreak/i';
		$replace='class="system-pagebreak"';
		$tsl_pageContent=preg_replace($pattern,$replace,$tsl_pageContent);
		$err=array();	
		for ($i=0;$i<count($tableField);$i++)
		{	
			$nameField=$tableField[$i];		
			$tsl='tsl_'.$nameField;
			$org='org_'.$nameField;
			if ($table[$i]->Type!='params' and $table[$i]->Type!='readonlytext') {	
					
				$nameFieldHashBegin=md5($nameField.'_BEGIN_AREA');
				$nameFieldHashEND=md5($nameField.'_END_AREA');
				
				if (preg_match('/' . $nameFieldHashBegin . '\s*<div>(.*?)<\/div>\s*' . $nameFieldHashEND . '/is', $tsl_pageContent, $match)) {
					$table[$i]->translationValue=trim($match[1]);
				}
				else {
						$note=new stdClass();
						$note->catid=$this->tblName;
						$note->field=$nameField;
						$note->id=$this->reference_id;
						$note->langto=$lang_to_Name;
						$err[]=$note;
//					return '1|No connect to the internet';
				}
			}
			else {
				$org='org_'.$nameField;
				$oreg_field=$this->get($org);
				$table[$i]->translationValue=$oreg_field;				
			}
		}
		if (count($err)) {
			return $err;
		}
		$result=$dispatcher->trigger('onAfterTranslate', array ($this->tblName, & $table,$translate_to, & $message));
		for ($i=0;$i<count($result);$i++)
		{
			if ($result[$i]==false) {
				return false;
			}
		}
		
		for ($i=0;$i<count($tableField);$i++)
		{	
			$nameField=$tableField[$i];		
			$tsl='tsl_'.$nameField;
			$tsl_value=$table[$i]->translationValue;
			$this->set($tsl,$tsl_value);	
		}		
		$result=$this->store($published, & $message);		
		return $result;
				
	}
	function store($published, & $message)
	{
		$reference_id	=	JRequest::getInt('reference_id');
		$lang_id = JRequest::getInt('translate_to');
		$catid=JRequest::getVar('catid');
		$id_fulltext = JRequest::getVar('id_fulltext');		
		$storeOriginalText = ($this->_joomfishManager->getCfg('storageOfOriginal') == 'md5') ? false : true;		
		$actContentObject=null;
		JLoader::import( 'models.ContentObject',JOOMFISH_ADMINPATH);
		$result=$this->bind('', '', true,  $storeOriginalText,$published, & $message);		
		return $result;
	}
	function bind($prefix="", $suffix="", $tryBind=true, $storeOriginalText=false,$published, &$message ) {
	
		$dispatcher	=& JDispatcher::getInstance();
		JPluginHelper::importPlugin('yos_translator');
		
		$table=$this->_tableTranslate;
			
		$db =& JFactory::getDBO();
		
		$published=$published;
		
		if ($published) {
			$published=1;
		}
		else {
			$published=0;
		}		
		// Go thru all the fields of the element and try to copy the content values	
		$elementTable =& $this->contentElement->getTable();
		
		JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');
		$tbl_jf_content =& JTable::getInstance('jf_content', 'Table');
		
		for( $i=0; $i<count($this->_tableTranslate); $i++ ) {
			$field =& $this->_tableTranslate[$i];
			$fieldName=$field->Name;	
			$tslvalue=	null;			
			$name='tsl_'.$fieldName;
//			var_dump($name,$this->get($name));			
			if( isset($this->$name) )
			{
			//	var_dump($prefix . "id_" .$fieldName .$suffix);
				$value = $this->get('tsl_'.$fieldName);				
				$table[$i]->originalValue=$this->get('org_'.$fieldName);
				$table[$i]->translationValue=$value;
			}
		}
//		$dispatcher->trigger('onBeforeSaveTranslate', array ($this->tblName, & $table,$this->language_id));
		$result=$dispatcher->trigger('onBeforeSaveTranslate', array ($this->tblName, & $table,$this->language_id,& $message));
		for ($i=0;$i<count($result);$i++)
		{
			if ($result[$i]==false) {
				return false;
			}
		}	
		for( $i=0; $i<count($table); $i++ )
		{
			$field =&$table[$i];
			$fieldName=$field->Name;
			$translationValue=$table[$i]->translationValue;
			if ($field->posthandler!=""){
				if (method_exists($this,$field->posthandler)){
					$handler = $field->posthandler;	
					$this->$handler($translationValue);  // return introtext.					
				}
			}
			if ($translationValue!="") {
				$this->set('tsl_'.$fieldName,$translationValue);
			}
		}
		$language_id = $this->language_id;
			
		$reference_id = $this->reference_id;
		
		$reference_table= $db->getEscaped( $this->tblName );
		
		$published=$published;
			
		for( $i=0; $i<count($table); $i++ )
		{
			$field =&$table[$i];
			$fieldName=$field->Name;
			
			$id=$this->get('tslid_'.$fieldName);
			
			$reference_field= $db->getEscaped( $fieldName );
			
			// original value will be already md5 encoded - based on that any encoding isn't needed!
			$originalValue=md5($table[$i]->originalValue);
			
			$originalText = ($storeOriginalText) ? $table[$i]->originalValue: "";
			$original_text = !is_null($originalText)?$originalText:"";
			
			$value= $this->get('tsl_'.$fieldName);
			
			$tbl_jf_content->store_jf($id,$language_id, $reference_id,$reference_table , $reference_field, $value, $originalValue, $original_text, $published);
		}
		$result=$dispatcher->trigger('onAfterSaveTranslate', array ($this->tblName,& $table,$this->language_id, & $message));
		for ($i=0;$i<count($result);$i++)
		{
			if ($result[$i]==false) {
				return false;
			}
		}
		return '1|Finish';
	}
/* Begin Post handler	*/
	function filterTitle(&$alias){
		if($alias=="") {
			$alias =$this->get("tsl_title");
		}
		$alias = JFilterOutput::stringURLSafe($alias);
		return $alias;
	}

	function filterName(&$alias){
	
		if($alias=="") {			
			$alias = $this->get('tsl_name');
		}
		$alias = JFilterOutput::stringURLSafe($alias);
		return $alias;
	}
/* end Post handler */

	function saveArticleText(&$introtext) {		
		// Search for the {readmore} tag and split the text up accordingly.
		$pattern = '#<hr\s+id=("|\'|)system-readmore("|\'|)\s*\/*>#i';
		$tagPos	= preg_match($pattern, $introtext);	
		if ( $tagPos > 0 ) {
			list($introtext, $fulltext) = preg_split($pattern, $introtext, 2);			
			$this->set('tsl_fulltext',$fulltext);			
		}
		else {			
			$this->set('tsl_fulltext',"");		//die();
		}
		return $introtext;
		
	}
	function getLanguseName($languageID)
	{
		$db = $this->_db;
		$query = "SELECT `name` FROM #__languages
				WHERE `id` = '$languageID'";
		$db->setQuery($query);
		$LanguseName= $db->loadResult();
		return $LanguseName;
	}
	function getLanguagePair($to_id, $from_id = 0){		
		$db = $this->_db;
		
		if ($from_id == 0) {
			//get default language
			$params = JComponentHelper::getParams('com_languages');
			$default_codeLanguage = $params->get('site');
			//select language id
			$query = "SELECT `id` FROM #__languages
				WHERE `code` = '$default_codeLanguage'";
			$db->setQuery($query);
			$from_id = $db->loadResult();
		}		
		return  $this->_getLanguageCode($from_id) . '|' . $this->_getLanguageCode($to_id);
	}
	function _getLanguageCode($language_id){
		$db = $this->_db;
		
		//get language code
		$query = "SELECT TSL.code_translator 
			FROM #__languages AS JL
			LEFT JOIN #__yos_translator AS TSL ON JL.code = TSL.code_language
			WHERE JL.id = $language_id";
		$db->setQuery($query);
		return $db->loadResult();
	}
		/**
	 * Dump to notranslate data
	 *
	 * @param content data $data
	 * @return content data
	 */
	function notranslate($data){
		
		$regex	=	'/\{notranslate\}(.*?)\{\/notranslate\}/m';
		preg_match_all($regex, $data, $matches);
		$f_number	=	count($matches[0]);
				
		if (!$f_number) {
			return $data;
		}
		
		for ($i =0 ; $i<$f_number; $i++){
			$data	=	str_replace($matches[0][$i], md5($matches[0][$i]),$data);
			$this->_notran[]	=	array('hash'=> md5($matches[0][$i]), 'value'=> $matches[1][$i]);
		}		
		
		return $data;
	}
		/**
	 * Replace personconfig to notranslate and dump it
	 *
	 * @param content data $data
	 * @return content data
	 */
	function personconfig( $data ){
		$config =& JComponentHelper::getParams('com_yos_translator');
		$param_notranslate= $config->get('notranslate');
		$param_notranslate=	preg_replace('/\s/','',$param_notranslate);
		if ($param_notranslate) {
			$arr_tag	=	explode(';',$param_notranslate);
			foreach ($arr_tag as $tag) {
				if ($tag) {
					$arr_sp		=	explode(',', $tag);
					$tagfirst	=	$arr_sp[0];
					$taglast	=	$arr_sp[1];
					if (!($tagfirst && $taglast)) {
						continue;
					}
					
					preg_match_all('/'.str_replace('/','\/',preg_quote($tagfirst)).'(.*?)'.str_replace('/','\/',preg_quote($taglast)).'/', $data, $matches);
					$f_number	=	count($matches[0]);
					if (!$f_number) {
						continue;
					}
					for ($i =0 ; $i<$f_number; $i++){
						$data	=	str_replace($matches[0][$i], md5($matches[0][$i]),$data);
						$this->_notran[]	=	array('hash'=>md5($matches[0][$i]), 'value'=> $matches[0][$i]);
					}
				}
			}
		}
		return $data;
	}
	function checkLanguage()
	{
		$to_id = JRequest::getVar('dst', 0);
		$from_id=0;
		$language_from = JRequest::getString('from_lang', '');
		if ($language_from == '') {
			$db=JFactory::getDBO();
			$params = JComponentHelper::getParams('com_languages');
			$default_codeLanguage = $params->get('site');
			//select language id
			$query = "SELECT `id` FROM #__languages
				WHERE `code` = '$default_codeLanguage'";
			$db->setQuery($query);
			$from_id = $db->loadResult();
			$language_from=$this->_getLanguageCode($from_id);
		}
		$language_to=$this->_getLanguageCode($to_id);
		if($language_from==$language_to | $language_to==null)
			return false;
		return true;
	}
	
}