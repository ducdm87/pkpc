<?php
/**
 * @version		$Id: manager.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @subpackage	Content
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

jimport('joomla.application.component.model');

// Set the table directory
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

/**
 * Weblinks Component Weblink Model
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 1.5
 */
class TranslatorModelConfig extends JModel
{
	/**
	 * amMap data array
	 *
	 * @var array
	 */
	var $_data = null;	

	/**
	 * uri total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;
	/**
	 * list element from joomfish
	 *
	 * @var object list
	 */
	var $elementsDetails=null;
	var $elementsList=array();
	var $details=null;
	var $arraySection=array();
	var $arrayCategory=null;
	/**
	 * list elements block
	 *
	 * @var array
	 */
	var $elementsBlock=null;

	/**
	 * Constructor
	 *
	 * @since 0.9
	 */
	function __construct()
	{		
		parent::__construct();
	}	
	
	function getData(){		
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );			
		}

		return $this->_data;
	}
	
	function _buildQuery(){	

		//Get Events from Database
		$query = 'SELECT id, name, active as published, code, shortcode FROM #__languages ';				
		return $query;
	}
	
	function getScript(){
		$data 	=	$this->getData();
		$var 	=	"";
		$addoption =	"";
		for ($i =0 ; $i< count($data); $i++){
			$var		.= "var ".$data[$i]->shortcode." = document.getElementById('".$data[$i]->shortcode."');";			
			$addoption	.= $data[$i]->shortcode.".options.add(new Option(lng, lngCode));";
		}
		$script=
		"
			google.load(\"language\", \"1\");
			google.setOnLoadCallback(init);
			
			function init() 
			{				
				".$var."
				for (l in google.language.Languages) 
				{
					var lng = l.toLowerCase();
					lng 		= lng.substring(0,1).toUpperCase()+lng.substring(1,lng.length);
					var lngCode = google.language.Languages[l];
					if (google.language.isTranslatable(lngCode)) 
					{
						".$addoption."
					}
				}
			}";
		
		return $script;
	}
	
	function getCurrentTranslator(){
		$db		=	&JFactory::getDBO();
		
		$data	=	$this->getData();
		$current	=	array();
		for ($i = 0; $i<count($data); $i++){
			$query	=	"SELECT code_translator FROM #__yos_translator WHERE code_language = '".$data[$i]->code."'";
			$db->setQuery($query);
			$current[]	=	$db->loadResult();
		}
		
		return $current;
	}
	
	// for elements	
	function getElements()
	{
		$this->getElementsJoomfish();
		$this->getElementsBlock();
		
		$elementsList=$this->elementsList;
		$elementsDetails=$this->elementsDetails;
		$elementsBlock=$this->elementsBlock;
		
		for ($i=0;$i<count($elementsBlock);$i++)
		{
			$ename=$elementsBlock[$i]->name;
			if (in_array($ename,$elementsList)) {
				$elementsDetails[$ename]->block=1;
				$elementsDetails[$ename]->details=$elementsBlock[$i]->details;
			}
		}
	/*	$buff=array();
		$i=0;
		foreach ($elementsDetails as $key=>$value)
		{
			$buff[$i]=$value;
			$i++;
		}*/		
		return 	$elementsDetails;
	}
	function getElementsJoomfish()
	{
		global $mainframe, $option;
		jimport('joomla.filesystem.file');
		$linkElements= JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers' .DS. 'defines.php';
		if (!JFile::exists($linkElements)) {
			return false;
		}		
		require_once( JPATH_SITE .DS. 'components' .DS. 'com_joomfish' .DS. 'helpers' .DS. 'defines.php' );
		JLoader::register('JoomFishManager', JOOMFISH_ADMINPATH.DS.'classes'.DS.'JoomfishManager.class.php');
		
		$JFManager = new JoomFishManager();
		$content_elements = $JFManager->getContentElements(true);
		$elementsDetails=array();
		$elementList=array();
		foreach( $content_elements as $key => $element )
		{
			$elementList[]=$key;
			
			$_element=new stdClass();
			$_element->name =$key;
			$_element->block=0;
			$_element->details='';
			$elementsDetails[$key]=$_element;
			
		}
		$this->elementsDetails=$elementsDetails;
		$this->elementsList=$elementList;		
	}
	function getElementsBlock()
	{
		$db=JFactory::getDBO();
		$query='SELECT *
			FROM `#__yos_translator_elements`';
		$db->setQuery($query);
		$data=$db->loadObjectList();
		$this->elementsBlock=$data;
	}
	function checkElement($ename)
	{
		$db=JFactory::getDBO();
		$query='SELECT id
			FROM `#__yos_translator_elements`
			WHERE name='.$db->quote($ename);
		$db->setQuery($query);		
		$id=$db->loadResult();		
		return $id;
	}
	function Translate($bool)
	{		
		$cids=JRequest::getVar('cid');
		$db=JFactory::getDBO();
		$this->getElementsJoomfish();	
		$elementsList=$this->elementsList;				
		for ($i=0;$i<count($cids);$i++)
		{				
			$id=$this->checkElement($cids[$i]);
			$query='';
			if ($bool) {
				
				$query='DELETE FROM `#__yos_translator_elements` 
							WHERE id='.$db->quote($id);
			}
			else {
				if (in_array($cids[$i],$elementsList)) 
				{
					$query='REPLACE INTO `#__yos_translator_elements` 
							SET id='.$db->quote($id).',
							name='.$db->quote($cids[$i]);
					
				}
							
			}
			$db->setQuery($query);			
			$db->query();
		}			
	}
	function oneBlock($bool)
	{
		$cids=JRequest::getVar('cid');		
		$cid=$cids[0];
		$db=JFactory::getDBO();
		if ($bool) {
			$query='INSERT into `#__yos_translator_elements` (`name`) VALUES('.$db->quote($cid).') ';			
		}
		else {
			$query='DELETE FROM `#__yos_translator_elements` 
					WHERE name=('.$db->quote($cid).') ';	
		}
		$db->setQuery($query);		
		$db->query();
	}
	
	
	function getSectionContent()
	{
		$db=JFactory::getDBO();
		$query='SELECT id,title 
				FROM `#__sections`
				WHERE scope='.$db->quote('content');
		$db->setQuery($query);
		$data=$db->loadObjectList();
		return $data;
	}
	function getCategoryContent()
	{
		$db=JFactory::getDBO();
		$query='SELECT C.id,C.title 
				FROM `#__categories` as C,`#__sections` as S
				WHERE S.id=C.section
						AND S.scope='.$db->quote('content');
		$db->setQuery($query);
		$data=$db->loadObjectList();
		$cat=new stdClass();
		$cat->id=0;
		$cat->title='Uncategorised';
		$data1[]=$cat;
		$data=array_merge($data1,$data);
		return $data;
	}
	function getContentDetail()
	{
		$this->getContent();
		$this->getArrayCategory();
		$this->getArraySection();
		$arraySection=$this->arraySection;
		$arrayCategory=$this->arrayCategory;
		$data=array();
		$data['sections']=$arraySection;
		$data['categories']=$arrayCategory;
		return $data;
		
	}
	function getArraySection()
	{
		$data=$this->details;
		$data=explode('_',$data);
		$data=$data[0];
		$data=explode(',',$data);
		$this->arraySection=$data;		
	}	
	function getArrayCategory()
	{
		$data=$this->details;
		$data=explode('_',$data);
		if (count($data)==2) {
			$data=$data[1];	
			$data=$this->checkData($data);	
			$data=explode(',',$data);
			if (count($data)==1 and $data[0]=="") {
				$data=null;				
			}
			$this->arrayCategory=$data;
		}
	}
	function getContent()
	{
		$db=JFactory::getDBO();
		$query='SELECT 	details 
				FROM `#__yos_translator_elements`
				WHERE name='.$db->quote('content');
		$db->setQuery($query);
		$data=$db->loadResult();
		$this->details=$data;		
	}
	function contentTranslate($bool)
	{			
		$type=JRequest::getVar('type');	
		$db=JFactory::getDBO();
		$query='SELECT id 
				FROM `#__yos_translator_elements` 
				WHERE name='.$db->quote('content');
		$db->setQuery($query);
		$eid=$db->loadResult();
		$this->getContent();
		$this->getArrayCategory();
		$this->getArraySection();
		$arraySection=$this->arraySection;
		$arrayCategory=$this->arrayCategory;
		$data='';
		if ($type=='category') {
			$catID=JRequest::getVar('catid');
			//$catID=$catID[0];
			$section=implode(',',$arraySection);			
			$category=array();
			if ($bool) {
//				$category=$this->getCategoryContent();
				$_catids=array();
				for ($i=0;$i<count($arrayCategory);$i++)
				{
					$id=$arrayCategory[$i];
					if (!in_array($id,$catID)) {
						$_catids[]=$id;
					}
				}				
				$category=$_catids;
			}
			else 
			{			
				$_catids=array();
				if (is_array($arrayCategory) and is_array($catID)) {
					$category=array_merge($arrayCategory,$catID);
				}
				else {
					$category=$catID;
				}
				
				for ($i=0;$i<count($category);$i++)
				{
					if (!in_array($category[$i],$_catids)) {
						$_catids[]=$category[$i];
					}
				}
				$category=$_catids;				
					
			}			
			$category=implode(',',$category);
			
			$section=$this->checkData($section);			
			$category=$this->checkData($category);	
			
			$data=$section.'_'.$category;			
		}
		elseif ($type=='section') {
			$secID=JRequest::getVar('secid');					
			$category=implode(',',$arrayCategory);
			$section=array();
			if ($bool) {				
				$_secids=array();
				for ($i=0;$i<count($arraySection);$i++)
				{
					$id=$arraySection[$i];
					if (!in_array($id,$secID)) {
						$_secids[]=$id;
					}
				}				
				$section=$_secids;
			}
			else {				
				$_secids=array();
				$section=array_merge($arraySection,$secID);
				for ($i=0;$i<count($section);$i++)
				{
					if (!in_array($section[$i],$_secids)) {
						$_secids[]=$section[$i];
					}
				}
				$section=$_secids;				
									
			}
			$section=implode(',',$section);	
			$section=$this->checkData($section);			
			$category=$this->checkData($category);			
			$data=$section.'_'.$category;
		}
		//die();
		if ($data=='_') {
			$query='DELETE FROM `#__yos_translator_elements` 
							WHERE name='.$db->quote('content');
		}
		else {
			if ($eid) {
				$query='update `#__yos_translator_elements` set details='.$db->quote($data).'
						where id='.$eid;
			}
			else {
				$query='insert into `#__yos_translator_elements` (`name`,`details`) values ('.$db->quote('content').','.$db->quote($data).')';			
			}
			
		}		
		$db->setQuery($query);
//		var_dump($db->getQuery());
		$db->query();
		
	}
	function oneContentBlock($bool)
	{
		$type=JRequest::getVar('type');
		$db=JFactory::getDBO();
		$query='SELECT id 
				FROM `#__yos_translator_elements` 
				WHERE name='.$db->quote('content');
		$db->setQuery($query);
		$eid=$db->loadResult();
		$this->getContent();
		$this->getArrayCategory();
		$this->getArraySection();
		$arraySection=$this->arraySection;
		$arrayCategory=$this->arrayCategory;
		//var_dump($arrayCategory);
		$data='';
		if ($type=='category') {
			$catID=JRequest::getVar('catid');			
			$catID=$catID[0];
			$section=implode(',',$arraySection);
			$category=array();
			if ($bool) {
				$arrayCategory[]=$catID;
				$category=$arrayCategory;
			}
			else {				
				$pos=array_search($catID,$arrayCategory);
				unset($arrayCategory[$pos]);
				$category=$arrayCategory;		
			}
			$category=implode(',',$category);			
			$section=$this->checkData($section);			
			$category=$this->checkData($category);
			
			$data=$section.'_'.$category;			
		}
		elseif ($type=='section') {
			$secID=JRequest::getVar('secid');
			$secID=$secID[0];
			$category=implode(',',$arrayCategory);
			$section=array();
			if ($bool) {
				$arraySection[]=$secID;
				$section=$arraySection;
			}
			else {				
				$pos=array_search($secID,$arraySection);				
				unset($arraySection[$pos]);				
				$section=$arraySection;		
			}
			$section=implode(',',$section);	
			
			$section=$this->checkData($section);			
			$category=$this->checkData($category);	
			
			$data=$section.'_'.$category;
		}		
		if ($data=='_') {
			$query='DELETE FROM `#__yos_translator_elements` 
							WHERE name='.$db->quote('content');
		}
		else {
			if ($eid) {
			$query='update `#__yos_translator_elements` set details='.$db->quote($data).'
					where id='.$eid;
			}
			else {
				$query='insert into `#__yos_translator_elements` (`name`,`details`) values ('.$db->quote('content').','.$db->quote($data).')';					
			}
		}
		
		$db->setQuery($query);
//		var_dump($db->getQuery());
		$db->query();
	}
	/**
	 * check data. remove value=0; value="";
	 *
	 * @param string $data
	 * @return aray
	 */
	function checkData($data)
	{
		
		$data=explode(',',$data);		
		$data1=array();
		for ($i=0;$i<count($data);$i++)
		{
			if ($data[$i]!="") {
				$data1[]=$data[$i];
			}
		}
		$data1=implode(',',$data1);	
		return $data1;
	}
	function checkContent()
	{
		
	}
}