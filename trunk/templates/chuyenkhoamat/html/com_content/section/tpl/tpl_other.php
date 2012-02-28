<?php
		if ($this->item->params->get('show_create_date'))
					{?>
						<div>
							<div class="createdate">
								<?php echo JHTML::_('date', $this->item->created, JText::_('DATE_FORMAT_LC2')); ?>
							</div>
						</div>
				<?php }
				?>
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
		<?php }