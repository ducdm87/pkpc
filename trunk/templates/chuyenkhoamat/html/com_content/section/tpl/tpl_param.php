<?php
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
					if ( intval($this->item->modified) != 0 && $this->item->params->get('show_modify_date'))
					{?>
						<div>
							<div class="modifydate">
								<?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->item->modified, JText::_('DATE_FORMAT_LC2'))); ?>
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
				$link_content	=	'';
				if ($this->item->params->get('link_titles') && $this->item->readmore_link)
					$link_content	=	$this->item->readmore_link;
				if (isset($this->item->src_image) and $this->item->src_image) {
						echo '<div class="thumb"><a href="'.$link_content.'"><img src="'.$this->item->src_image.'" /></a></div>';
					}else {
						echo '<div class="default_image"><a href="'.$link_content.'"> </a></div>'; 
					}				
					
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
				} 