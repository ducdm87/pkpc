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
				<div class="pkpc_usertab">
					<div class="inner">
						 	<?php
							for ($i=0;$i<count($contents);$i++)
							{
								$row	=	$contents[$i];
//								if (!$row->link)
//									$row->link	=	JRoute::_(ContentHelperRoute::getCategoryRoute($row->catid, $row->sectionid));
								$link	=	$row->link;
								$row->price	=	isset($row->price)?$row->price:'000';
								$class		=	$i==0?'first':($i==count($contents)-1?'last':'');
								?>
									<?php if ($i>=2):?>
									<div class="spacer"></div>
									<?php endif; ?>
								<div class="list_product border <?php echo $class; ?>">
				                   <div class="title_product"><a href="<?php echo $link; ?>"><?php echo $row->title; ?></a></div>
				                   <div class="image_product"><a href="<?php echo $link; ?>"><img height="97" title="<?php echo $row->title; ?>" src="<?php echo $row->thumb; ?>" alt="product"></a></div>
				                   <div class="t_product"> 
				                       <span class="tnds"><?php echo $row->introtext; ?></span>
				                       <span class="price"><?php echo $row->price?$row->price:'000'; ?> VND</span>
				                       <a class="buy" href="#"></a>
				                   </div>
				                 </div>	
									
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
