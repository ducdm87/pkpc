<?php

	if ($this->item->params->get('show_title') || $this->item->params->get('show_pdf_icon') || $this->item->params->get('show_print_icon') || $this->item->params->get('show_email_icon') || $canEdit)
		{ ?>
			<div class="contentpanecontrol<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">
				<div>
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