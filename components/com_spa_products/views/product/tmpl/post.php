<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php

// Initialize variables
$db		=& JFactory::getDBO();
$user	=& JFactory::getUser();
$config	=& JFactory::getConfig();
$now	=& JFactory::getDate();
$row	=	$this->row;
//Ordering allowed ?

$config 		= &JComponentHelper::getParams('com_spa_faq');
$data_type 		= $config->get('data_type');
JHTML::_('behavior.tooltip');

$document=JFactory::getDocument();
$document->addStyleSheet('components/com_spa_faq/assets/css/content.css');
$document->setTitle($row->title);

if ($row->desc) {
	$document->setDescription( $row->desc );
}
if ($row->keywords) {
	$document->setMetadata('keywords', $row->keywords);
}


$catlink	=	JRoute::_(FAQContentHelperRoute::getCategoryRoute("$row->catslug", "$row->secslug"));
?>


<div class="spa_content">
	<div class="cat">
		<h3>
			<span class="linkcat">
				<a href="<?php echo $catlink; ?>">
					<?php echo $row->cat_title; ?>
				</a>
			</span>
			<span class="date"><?php echo JHTML::_('date', $row->cdate, JText::_('DATE_FORMAT_LC2'));; ?></span>
		</h3>		
	</div>
	
	<div class="content">
		<h3 style="color: rgb(134, 181, 37);">CÃ¢u há»�i:</h3>
		<h1 class="title"><?php echo $row->title; ?></h1>
		<h4 class="question">
			<?php echo $row->question; ?>	
		</h4>
		<div class="answer">
			<?php echo $row->answer; ?>
		</div>
	</div>
</div>
<span class="article_separator">&nbsp;</span>
<?php echo $row->event->afterDisplayFAQ; ?>