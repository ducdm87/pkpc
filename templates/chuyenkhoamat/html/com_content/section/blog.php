<?php
defined('_JEXEC') or die('Resdivicted access');
$cparams =& JComponentHelper::getParams('com_media');

?>
<?php 
	if ($this->params->get('show_page_title')){ 
?>
		<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
			<?php echo $this->escape($this->params->get('page_title')); ?>
		</div>
<?php 
	} 
?>
<div class="blog<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>" cellpadding="0" cellspacing="0">
<?php 
 $i = $this->pagination->limitstart; 

$startIndivoArticles = $this->pagination->limitstart + $this->params->get('num_leading_articles');
$numIndivoArticles = $startIndivoArticles + $this->params->get('num_intro_articles', 4);
if (($numIndivoArticles != $startIndivoArticles) && ($i < $this->total)){ ?>
	<div class="space"></div>
	<div class="article_column">
		<!--<div class="header">
			<div class="title">
				<h2 class="inline">
					<?php echo $this->escape($this->params->get('page_title'));?> 
				</h2>
			</div>
		</div>
		--><span class="clear"> </span>
		<div>
			<div width="100%">
				<div>
				<?php
					$divider = '';
					if ($this->params->def('multi_column_order', 0))
					{ // order across, like front page
						for ($z = 0; $z < $this->params->def('num_columns', 2); $z ++)
						{
							if ($z > 0) : $divider = " column_separator"; endif; ?>
							<?php
							$rows = (int) ($this->params->get('num_intro_articles', 4) / $this->params->get('num_columns'));
							$cols = ($this->params->get('num_intro_articles', 4) % $this->params->get('num_columns'));
							?>
								<div valign="top"
									width="<?php echo intval(100 / $this->params->get('num_columns')) ?>%"
									class="article_column<?php echo $divider ?>">
									<?php
									$loop = (($z < $cols)?1:0) + $rows;
			
									for ($y = 0; $y < $loop; $y ++) 
									{
										$target = $i + ($y * $this->params->get('num_columns')) + $z;
										if ($target < $this->total && $target < ($numIndivoArticles))
										{
											$this->item =& $this->getItem($target, $this->params);
											echo '<div class="box_item"'.$this->loadTemplate('item').'</div>';
										}
									}
									?></div>
					<?php }; 
						$i = $i + $this->params->get('num_intro_articles', 4) ; 
					}else 
					{ // otherwise, order down, same as before (default behaviour)
						for ($z = 0; $z < $this->params->get('num_columns'); $z ++)
						{
							if ($z > 0){$divider = " column_separator";} ?>
								<div valign="top" width="<?php echo intval(100 / $this->params->get('num_columns')) ?>%" class="_article_column<?php echo $divider ?>">
								<?php 
								for ($y = 0; $y < ($this->params->get('num_intro_articles', 4) / $this->params->get('num_columns')); $y ++)
								{
									if ($i < $this->total && $i < ($numIndivoArticles))
									{
										$this->item =& $this->getItem($i, $this->params);
										echo '<div class="box_item">'.$this->loadTemplate('item').'</div>';
										$i ++;
									}
								} ?>
								</div>
					<?php }
					} ?> 
				</div>
			</div>
		</div>
	</div>
	<span class="clear"> </span>
<?php } 
			$pageNav		=	$this->pagination;
			$limitstart		=	$pageNav->limitstart;
			$limit			=	$pageNav->limit;
			$total			=	$pageNav->total;
			$pages_current	=	$pageNav->get('pages.current');						
			$pages_total	=	$pageNav->get('pages.total');
	if ($this->params->def('show_pagination', 2))
	{ 
		?>
		<div class="paging">
				<ul>
				<?php
					if ($pages_current!=1) {
						$_limitstartjm	=	$limit*($pages_current-2);
							?>
								<li class="pagenav-inactive">
									<a href="<?php echo JRoute::_("&limitstart=$_limitstartjm"); ?>">
										<?php echo  JText::_('<'); ?>
									</a
								</li>
							<?php
						}
				for ($j=1;$j<=$pages_total;$j++)
				{
					if ($pages_total <= 1) {
						break;
					}
					if ($j > 1 && ($j < $pages_current - 3 || $j > $pages_current + 3)) {
						continue;
					}
					
					$_limitstart=$limit*($j-1);
					if($j==$pages_current)
					{
						?>
						<li class="pagenav-active"'>
								<span><?php echo  $j; ?></span>							
						</li>
						<?php
					}
					else {
						?>
						<li class="pagenav-inactive">
							<a href="<?php echo JRoute::_("&limitstart=$_limitstart"); ?>">
								<?php echo  $j; ?>
							</a>
						</li>							
						<?php
					}
					
				}
				// next button
				if ($pages_current < $pages_total) {
					$_limitstart	=	$limit*($pages_current);
					?>
						<li class="pagenav-inactive">
							<a href="<?php echo JRoute::_("&limitstart=$_limitstart"); ?>">
								<?php echo JText::_('>'); ?>
							</a>
						</li>
					<?php
				}
				
				?>
		</div>
		<?php 
	}
	if ($this->params->def('show_pagination_results', 1))
	{ ?>
		<div>
			<div valign="top" align="center">
				<?php //echo $this->pagination->getPagesCounter(); ?>
			</div>
		</div>
	<?php 
	}?>
</div>
