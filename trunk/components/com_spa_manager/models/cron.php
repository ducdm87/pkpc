<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');
JLoader::register('TranslatorModelTranslate', JPATH_SITE .DS.'components'.DS.'com_yos_translator'.DS.'models'.DS.'translate.php');
JLoader::register('TranslatorModelContent_translateall', JPATH_SITE .DS.'components'.DS.'com_yos_translator'.DS.'models'.DS.'content_translateall.php');

class TranslatorModelCron extends JModel
{
	var $_notran	=	array();
	
	var $details=null;
	var $blockSession=array();
	var $blockCategory=array();
	
	function __construct()
	{
		parent::__construct();		
	}
	function cron(){                 
		global $mainframe, $option;
		
		$db	=& JFactory::getDBO();
		
		$croncode = JRequest::getVar('croncode', '' );

		$param = JComponentHelper::getParams($option);
		
		$published=$param->get( 'published');
		$number=$param->get( 'number',10);

		if ($param->get( 'croncode') <> $croncode){
			echo 'incorrect croncode';
			die();
		}
		$default_language = &$this->getDefault();
		$from_lang=$this->getLanguage_id($default_language);
		
		$translate=new TranslatorModelTranslate();
		$clist=$translate->getListCron();
		
		$languages_id=$clist['languages'];
		$elements=$clist['elements'];
		$m=0;
		if (count($elements)==0) {
			echo 'No elements is setup';
			die();
		}
		if (count($languages_id)<=1) {
			echo 'require larger second language';
			die();
		}
		
		$elementsBlock=$this->getElementsBlock();
		$this->getContentBlockDetails();
				
		$errs=array();
		$num_err=0;
		
		// 
		for ($i=0;$i<count($elements);$i++)
		{			
			if (in_array($elements[$i],$elementsBlock) and $elements[$i]!='content') {
				continue;				
			}	
			
			for ($j=0;$j<count($languages_id);$j++)
			{					
				if ($from_lang==$languages_id[$j]) {
					continue;
				}
			// load block list reference_id of element			
				$referenceBlock=$this->getBlockListReferences($elements[$i],$languages_id[$j]);
			// get Models
				$translate=new TranslatorModelTranslate();
			// initialize
				$translate->initialize($languages_id[$j],$elements[$i]);				
				$rows=$translate->getData();
			
				$reference_id=array();
				$reference_state=array();
				// filter element state=0 || state==-1
				foreach ($rows as $row ) {
					if ($row->state<1) {
						$reference_id[]=$row->id;
						$reference_state[]=$row->state;
					}					
				}	
					
				for ($k=0;$k<count($reference_id);$k++)
				{	
					if ($elements[$i]=='content' and in_array($elements[$i],$elementsBlock)) {
						if ($this->details==null){								
							continue;
						}						
						$db=JFactory::getDBO();
						$query='SELECT 	sectionid,catid
								FROM `#__content`
								WHERE id='.$reference_id[$k];
						$db->setQuery($query);																	
						$content=$db->loadRow();
						
						$sec=in_array($content[0],$this->blockSession);							
						$cat=in_array($content[1],$this->blockCategory);
						if ($sec==true or $cat==true){
							continue;
						}
					}
						// check element and reference_id in block list
					if (in_array($reference_id[$k],$referenceBlock)) {
						continue;
					}
					if ($m<$number) {
						$translate_all=new TranslatorModelContent_translateall();
						
						$translate_all->initialize($reference_id[$k],$languages_id[$j],$elements[$i]);
						
						$err=$translate_all->translate($default_language,$languages_id[$j],$published, & $message);						
						if ($err==false) {
							$this->process($m,$num_err,$errs,$number,true);
							echo $message.'<br />'."\n";
							die();
						}
						if (is_array($err)) {							
							$this->addData($reference_id[$k],$languages_id[$j],$elements[$i]);
							$num_err++;
							for ($e=0;$e<count($err);$e++){
								$errs[]=$err[$e];
							}
						}					
						$m++;
					}
					else {
						$k=count($reference_id);
						$j=count($languages_id);
						$i=count($elements);
					}
				}
			}
		}
		$this->process($m,$num_err,$errs,$number,false);
		die();
	}
	function process($m,$num_err,$errs,$number,$isTime=false)
	{
		$numberTranslate=$m-$num_err;
		if($num_err<$m or $m==0)
		{
			if($m)
				echo $numberTranslate.' elements have been translated successfully <br />'."\n";
			if (!$isTime) {
				if($m<$number){
					echo 'All elements are translated successfully!'."\n";				
				}
			}			
			if($num_err){
				echo '<br /> ==================================================== <br />'."\n";
			}
		}
		if (count($errs)) {			
			?>			
			
			<br />
			<br />
				<?php echo 'There are few problems with fields during the translation:  <br />'."\n"; ?>
				(<?php echo $num_err.' Element - '. count($errs).' Fields'; ?>)<br>
						<?php
						echo '<br /> ==================================================== <br />'."\n";
						for ($i=0;$i<count($errs);$i++)
						{
							$row=$errs[$i];
							 echo 'Element: &nbsp;'.$row->catid."\n"; 				
							 echo '<br /> Element ID:&nbsp; '.$row->id."\n"; 
							 echo '<br /> Field name: &nbsp;'.$row->field."\n";								
							 echo '<br /> Language Translate: &nbsp;'.$row->langto."\n";
							 echo '<br /> ====================================================<br />'."\n";
						}
						?>				
			<br />
			<br /> 
			<?php
		}		
	}
	function getLanguage_id($short_code)
	{
		$db=JFactory::getDBO();
		$query = "SELECT `id` FROM #__languages
			WHERE `shortcode` = '$short_code'";
		$db->setQuery($query);
		
		return  $db->loadResult();
	}
	function getDefault() {
		global $mainframe;
		$db	=	&JFactory::getDBO();
		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));		
		$params	=	&JComponentHelper::getParams('com_languages');
		$default_language	=	$params->get($client->name, 'en-GB');
		$query				=	"SELECT code_translator FROM #__yos_translator WHERE code_language = '$default_language'";
		$db->setQuery($query);
		$code_translator	=	$db->loadResult();
		if (!$code_translator) {
			echo 'Not config code translator';
			die();			
		}
		
		return $code_translator;
	}
	function getElementsBlock()
	{
		$db=JFactory::getDBO();
		$query='SELECT name
			FROM `#__yos_translator_elements`';
		$db->setQuery($query);		
		$data=$db->loadResultArray();
		
		return $data;
	}
	function getContentBlockDetails()
	{
		$db=JFactory::getDBO();
		$query='SELECT details
			FROM `#__yos_translator_elements`
			where name='.$db->quote('content ');
		$db->setQuery($query);
		$data=$db->loadResult();
		
		$this->details=$data;	
				
		if ($data) {
			$data=explode('_',$data);
			$session=$data[0];
			$session=explode(',',$session);	
			
			$category=$data[1];
			$category=explode(',',$category);
			
			if(is_array($session))
				$this->blockSession=$session;			
				
			if(is_array($category))
				$this->blockCategory=$category;
		}
	}
	function getBlockListReferences($elements,$languege_id)
	{
		$language_name=$this->getLangugeName($languege_id);		
		$this->checkTable();
		$db=JFactory::getDBO();
		$query='SELECT reference_id 
				FROM `#__yos_translator_black_list` 
				WHERE elements='.$db->quote($elements).'
					AND languages_name ='.$db->quote($language_name);
		$db->setQuery($query);
		
		$data=$db->loadResultArray();
		return $data;		
	}
	function checkTable()
	{
		$db=JFactory::getDBO();
		$query='CREATE TABLE IF NOT EXISTS `#__yos_translator_black_list` (
  					`id` int(11) NOT NULL auto_increment,
 				 	`elements` varchar(20) NOT NULL,
 				 	`languages_name` varchar(100) NOT NULL,
 				 	`reference_id` int(11) NOT NULL,
 					 PRIMARY KEY  (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;';
		$db->setQuery($query);
		$db->query();
	}
	function addData($reference_id,$languages_id,$elements)
	{
		$db=JFactory::getDBO();
		$languages_name=$this->getLangugeName($languages_id);
		$query='INSERT INTO `#__yos_translator_black_list`(elements,languages_name,reference_id) 
					VALUES('.$db->quote($elements).','.$db->quote($languages_name).','.$reference_id.')';
		$db->setQuery($query);		
		$db->query();	
	}
	function getLangugeName($languageID)
	{
		$db = $this->_db;
		$query = "SELECT `name` FROM `#__languages`
				WHERE `id` = '$languageID'";
		$db->setQuery($query);		
		$LanguseName= $db->loadResult();
		return $LanguseName;
	}
}
?>