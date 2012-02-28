<?php // no direct access
defined('_JEXEC') or die('Resdivicted access'); ?>
<?php 
	$canEdit   = ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));
// BEGIN SYSTEM-UNPUBLISHED
	if ($this->item->state == 0){		
		echo '<div class="system-unpublished">';		
	}
		/*	FOR CONTROL*/
		echo '<div class="b1">';
		if ($this->item->params->get('show_title') || $this->item->params->get('show_pdf_icon') || $this->item->params->get('show_print_icon') || $this->item->params->get('show_email_icon') || $canEdit)
		{ ?>
			<div class="contentpanecontrol<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">
				<div><?php 
					if ($this->item->params->get('show_title'))
					{ ?>
						<div class="contentheading<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>" width="100%">
						<?php if ($this->item->params->get('link_titles') && $this->item->readmore_link != ''){ ?>
									<a href="<?php echo $this->item->readmore_link; ?>" class="contentpagetitle<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>"><?php echo $this->escape($this->item->title); ?></a>
						<?php 	}else{
									echo $this->escape($this->item->title);
								} ?>
						</div>
					<?php 
					} ?>
					<div class="control">
						<?php if ($this->item->params->get('show_pdf_icon')){ ?>
							<div class="buttonheading">
								<?php echo JHTML::_('icon.pdf', $this->item, $this->item->params, $this->access); ?>
							</div>
						<?php }
							if ( $this->item->params->get( 'show_print_icon' )){ ?>
								<div  class="buttonheading">
									<?php echo JHTML::_('icon.print_popup', $this->item, $this->item->params, $this->access); ?>
								</div>
						<?php }
							if ($this->item->params->get('show_email_icon')) { ?>
							<div  class="buttonheading">
								<?php echo JHTML::_('icon.email', $this->item, $this->item->params, $this->access); ?>
							</div>
						<?php } 
							if ($canEdit){ ?>
				   			<div  class="buttonheading">
				   				<?php echo JHTML::_('icon.edit', $this->item, $this->item->params, $this->access); ?>
				   			</div>
			   			<?php } ?>
			   		</div>
				</div>
			</div>
			<span class="clear"></span>
	<?php }
		
		if (!$this->item->params->get('show_indivo')){	echo $this->item->event->afterDisplayTitle; }	
		echo $this->item->event->beforeDisplayContent; ?>
			<div class="contentpaneintro<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">
				<?php // show section and category
					
					if (($this->item->params->get('show_section') && $this->item->sectionid) || ($this->item->params->get('show_category') && $this->item->catid))
					{
						echo '<div><div>';
								if ($this->item->params->get('show_section') && $this->item->sectionid && isset($this->section->title))
								{
									echo '<span>';
										if ($this->item->params->get('link_section'))
											{
												echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->item->sectionid)).'">';
											}
												echo $this->escape($this->section->title); 
											if ($this->item->params->get('link_section'))
											{ echo '</a>';}
										if ($this->item->params->get('show_category')){	echo ' - '; }
									echo '</span>';							
								}
								if ($this->item->params->get('show_category') && $this->item->catid)
								{
									echo '<span>';
										if ($this->item->params->get('link_category'))
											{
												echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug, $this->item->sectionid)).'">';
											}
												echo $this->escape($this->item->category);
										if ($this->item->params->get('link_category'))
										{	echo '</a>'; }
									echo '</span>';	
								}
						echo '</div></div>';
					}
				// show auther
					if (($this->item->params->get('show_author')) && ($this->item->author != ""))
					{ ?>
						<div>
							<div>
								<span class="small">
									<?php JText::printf( 'Written by', ($this->escape($this->item->created_by_alias) ? $this->escape($this->item->created_by_alias) : $this->escape($this->item->author)) ); ?>
								</span>
								&nbsp;&nbsp;
							</div>
						</div>
				<?php }
					// show create date
					if ($this->item->params->get('show_create_date'))
					{?>
						<div>
							<div class="createdate">
								<?php echo JHTML::_('date', $this->item->created, JText::_('DATE_FORMAT_LC2')); ?>
							</div>
						</div>
				<?php }
					if ($this->item->params->get('show_url') && $this->item->urls)
					{?>
						<div>
							<div>
								<a href="http://<?php echo $this->escape($this->item->urls) ; ?>" target="_blank"><?php echo $this->escape($this->item->urls); ?></a>
							</div>
						</div>
				<?php }
//
				$link_content	=	'';
				if ($this->item->readmore_link)
					$link_content	=	$this->item->readmore_link;
				if (isset($this->item->thumb)) {
						echo '<div class="thumb"><a href="'.$link_content.'"><img src="'.$this->item->thumb.'" /></a></div>';
					}else {
						echo '<div class="default_image"><a href="'.$link_content.'"> </a></div>'; 
					}
				?>				
				<div class="text">
					<div>
						<?php 
						if (isset ($this->item->toc)) 
						{ echo $this->item->toc;}
						echo strip_tags($this->item->text); ?>
					</div>
				</div>
				<span class="clear"></span>
				<?php 
				if ( intval($this->item->modified) != 0 && $this->item->params->get('show_modify_date'))
				{?>
					<div>
						<div class="modifydate">
							<?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
						</div>
					</div>
		<?php } ?>
				<?php 
				if ($this->item->params->get('show_readmore') && $this->item->readmore)
				{?>
					<div>
						<div  colspan="2">
							<a href="<?php echo $this->item->readmore_link; ?>" class="readon<?php echo $this->escape($this->item->params->get('pageclass_sfx')); ?>">
								<?php if ($this->item->readmore_register){	echo JText::_('Register to read more...'); }
								elseif ($readmore = $this->item->params->get('readmore')) {	echo $readmore; }
								else {	echo JText::sprintf('Read more...'); } ?>
							</a>
						</div>
					</div>
		<?php } ?>
		</div>
	</div>
	<div class="b2">
		<?php
//		$this->item->price	=	'35 usd';
		if (isset ($this->item->price)) 
		{
			echo '<div class="price">'.JText::_('price').': '.$this->item->price.' </div>';
		}
//		$this->item->filesize	=	'13.7 MB';
		if (isset ($this->item->filesize)) 
		{
			echo '<div class="filesize">'.JText::_('File Size').': '.$this->item->filesize.' </div>';
		}
		if ($this->item->readmore_link)
		{
			echo '<div class="download"><a href="'.$this->item->readmore_link.'">'.JText::_('Download').' </a></div>';	
		}
		
		?>
	</div>
	<div class="b3">&nbsp;</div>
<!--	abc-->
<?php if ($this->item->state == 0) { echo '</div>'; } ?>
<span class="article_separator"> </span>
<?php echo $this->item->event->afterDisplayContent; ?>
