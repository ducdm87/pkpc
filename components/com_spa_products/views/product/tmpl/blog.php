<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php

// Initialize variables
$db		=& JFactory::getDBO();
$user	=& JFactory::getUser();
$config	=& JFactory::getConfig();
$now	=& JFactory::getDate();
$row	=	$this->row;
//Ordering allowed ?

$config 		= &JComponentHelper::getParams('com_spa_product');
$data_type 		= $config->get('data_type');
JHTML::_('behavior.tooltip');

$document=JFactory::getDocument();
$document->addStyleSheet('components/com_spa_product/assets/css/content.css');
$document->setTitle($row->title);

if ($row->metadesc) {
	$document->setDescription( $row->metadesc );
}
if ($row->metakey) {
	$document->setMetadata('keywords', $row->metakey);
}

$catlink	=	JRoute::_(SPAContentHelperRoute::getCategoryRoute("$row->catslug", "$row->secslug"));
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
</div>
<span class="article_separator">&nbsp;</span>
<?php echo $row->event->afterDisplaySPA; ?>


