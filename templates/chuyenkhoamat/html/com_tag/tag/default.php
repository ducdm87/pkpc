<?php
/**
 * @package Component Tag for Joomla! 1.5
 * @version $Id: com_tag.php 599 2010-06-06 23:26:33Z you $
 * @author Joomlatags.org
 * @copyright (C) 2010- http://www.joomlatags.org
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');

$tag	= JRequest::getVar('tag', null);
$tagKeyword=JText::_('TAG:').$tag;

$params = JComponentHelper::getParams('com_tag');
$topAds=$params->get('topAds');
$bottomAds=$params->get('bottomAds');
$showTagDescription=$params->get('description');
 $config =& JFactory::getConfig();
?>
<div class="componentheading tags"><?php echo($tag);?></div>

<div class="contentpaneopen tags" width="100%">
	<?php
	if(isset($showTagDescription)&&$showTagDescription){
		echo('<div>'.$this->tagDescription.'</div>');
	}
	if(isset($topAds)&&$topAds){
		echo('<div>'.$topAds.'</div>');
	}

	$count=$this->pagination->limitstart;
	if(isset($this->results)&&!empty($this->results)){
		require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
		$odd=0;
		foreach( $this->results as $result ){ ?>
	<div class="row<?php echo(1-$odd);?>">		
		<div>
			<h3 class="small"><?php echo (++$count).'. ';?> 
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($result->slug, $result->catslug, $result->sectionid)); ?>">
				<?php echo $this->escape($result->title);?> </a>
			</h3>
		</div>		
	</div>
	<?php
	$odd=1-$odd;
		}
	} ?>
	<div>
		<?php 
			require_once('mypageing.php');
			//echo $this->pagination->getPagesLinks( );
			echo getMyPagenation($this->pagination);
		?>
	</div>	
	<?php
	if(isset($bottomAds)&&$bottomAds){
		echo('<div>'.$bottomAds.'</div>');
	}
	?>	
</div>

	<?php
	$document	   =& JFactory::getDocument();
	if($this->tagDescription){
		$document->setDescription( JoomlaTagsHelper::truncate($this->tagDescription) );
	}else{
		$document->setDescription(  JoomlaTagsHelper::truncate($tag) );
	}
	$document->setTitle($tag.' | '.$config->getValue('sitename'));
	$document->setMetadata('keywords', $tag);
	$document->addStyleSheet(JURI::base() . 'components/com_tag/css/tagcloud.css');
	?>

