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
<?php if ($this->params->def('num_leading_articles', 1)) { ?>
	<div class="article_leading">
		<div class="header">
			<?php echo JText::_('Featured Software');?>
		</div>
		<div class="content">
			<?php 
			for ($i = $this->pagination->limitstart; $i < ($this->pagination->limitstart + $this->params->get('num_leading_articles')); $i++) 
			{
				if ($i >= $this->total) 
				{ 
					break;
				} ?>
				<div>
					<?php
						$this->item =& $this->getItem($i, $this->params);
						echo $this->loadTemplate('item');
					?>
				</div>
			<?php 
			}
			?>
		</div>
	</div>
<?php }else { $i = $this->pagination->limitstart; } 

$startIndivoArticles = $this->pagination->limitstart + $this->params->get('num_leading_articles');
$numIndivoArticles = $startIndivoArticles + $this->params->get('num_intro_articles', 4);
if (($numIndivoArticles != $startIndivoArticles) && ($i < $this->total)){ ?>
	<div class="space"></div>
	<div class="article_column">
		<div class="header">
			<div class="title">
				<h2 class="inline">
					<?php echo $this->escape($this->params->get('page_title')) .' '. JText::_('Software');?> 
				</h2>
			</div>
		</div>
		<span class="clear"> </span>
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
								<div valign="top" width="<?php echo intval(100 / $this->params->get('num_columns')) ?>%" class="article_column<?php echo $divider ?>">
								<?php 
								for ($y = 0; $y < ($this->params->get('num_intro_articles', 4) / $this->params->get('num_columns')); $y ++)
								{
									if ($i < $this->total && $i < ($numIndivoArticles))
									{
										$this->item =& $this->getItem($i, $this->params);
										echo '<div class="box_item"'.$this->loadTemplate('item').'</div>';
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
	if ($this->params->def('show_pagination', 2))
	{ ?>
		<div>
			<div valign="top" align="center">
				<?php echo $this->pagination->getPagesLinks(); ?>
				<br /><br />
			</div>
		</div>
		<?php 
	}
	if ($this->params->def('show_pagination_results', 1))
	{ ?>
		<div>
			<div valign="top" align="center">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</div>
		</div>
	<?php 
	}?>
</div>
