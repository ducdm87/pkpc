<?php
defined('_JEXEC') or die('Restricted access');
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_spa_content/assets/css/quangcao.css');
?>
<div class="spacontent_quangcao">
<!--BEGIN HEADER-->
<?php if ($header) {
	echo '<h3 class="head"><span><strong>'.$header.'</strong></span></h3>';
}

?>
<!--END HEADER-->
<!--BEGIN CONTENT-->
<span class="clear"></span>
	<div class="quangcao">		
		<div class="inner">
			<?php
			for ($i=0; $i< count($contents); $i++)
			{
				$row	=	$contents[$i];
				  if (strpos($row->link,'http://')!==false){
					$row->link	=	JRoute::_($row->link);
					}
				?>
					<a href="<?php echo $row->link; ?>" title="<?php echo $row->title; ?>">
						<img  src="<?php echo $row->thumb; ?>" />
					</a>
				<?php
			}			
			?>
			
		</div>		
	</div>
<!--END CONTENT-->


<!--BEGIN FOOTER-->
<?php if ($footer) {
	echo '<div class="ckmsection">'.$footer.'</div>';
	}
?>
<!--END FOOTER-->
<div class="clr"></div>
</div>
