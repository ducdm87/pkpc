<?php
defined('_JEXEC') or die('Restricted access');
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_spa_content/assets/css/chuyenmuc1.css');
?>
<div class="spacontent_chuyenmuc">
<!--BEGIN HEADER-->
<?php if ($header) {
	echo '<h3 class="head"><span><strong>'.$header.'</strong></span></h3>';
}
?>
<!--END HEADER-->
<!--PROCESS LIST TITLE CATEGORIES-->
<!--BEGIN TITLE CATEGORY-->
				<div class="pkpc_chuyenmuc1">
					<div class="inner">
						<?php 
							$row	=	$menus[0];
//							if (!$row->link)
//									$row->link	=	JRoute::_(ContentHelperRoute::getCategoryRoute($row->catid, $row->sectionid));
						?>
	                    <a class="header" href="<?php echo $row->link; ?>"><?php echo htmlspecialchars($row->title)?></a>
	                    <div class="image"> <a href="<?php echo $row->link; ?>"><img height="97" width="97" src="<?php echo $row->thumb; ?>" alt="product"> </a> </div>				
	                   	<?php
							for ($i=1;$i<count($menus);$i++)
							{
								$row	=	$menus[$i];
								if (!$row->link)
									$row->link	=	JRoute::_(ContentHelperRoute::getCategoryRoute($row->catid, $row->sectionid));
								$link	=	$row->link;
								?>
									<?php if ($i>=2):?>
									<div class="spacer"></div>
									<?php endif; ?>
										 <div class="dw1"><a href="<?php echo  $row->link; ?>"><?php echo htmlspecialchars($row->title); ?></a></div>
								<?php
							}
						?>
					</div>
				</div>
<span class="clear">&nbsp;</span>
<!--END TITLE CATEGORY-->

<span class="clear">&nbsp;</span>
<!--BEGIN FOOTER-->
<?php if ($footer) {
	echo '<div class="ckmsection">'.$footer.'</div>';
	}
?>
<!--END FOOTER-->
<div class="clr"></div>
</div>
