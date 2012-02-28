<?php // no direct access
defined('_JEXEC') or die('Restricted access');

$canEdit	= ($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own'));
// show title
if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title)
{ ?>
	<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
	</div><?php 
}
// show title and button
	if (!$this->params->get('show_intro')){
		echo $this->article->event->afterDisplayTitle;
	}
	// for Summary
	$k = 1;
	
	echo $this->article->event->beforeDisplayContent; ?>
<!--	BEGIN CONTENTPANEOPEN -->
	<div class="page_detail contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<?php
			if ($this->params->get('show_title'))
				{ ?>
					<div class="contentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
						<h1 class="inline red">
							<a href="<?php echo $this->article->readmore_link ; ?>"><?php echo $this->escape($this->article->title); ?></a>
							<?php
							if ($this->params->get('show_create_date')){ ?>
								<span class="createdate"><?php echo JHTML::_('date', $this->article->created, JText::_('DATE_FORMAT_LC2')) ?></span>
							<?php }?>
						</h1>
					</div>
			<?php }
			?>
			<span class="clear"></span>
			<div>
				<div valign="top">
					<?php 
						if (isset ($this->article->toc))
						{
							echo ($this->article->toc);
						}
						echo ($this->article->text);
					?>
				</div>
			</div><?php 
			if ( intval($this->article->modified) !=0 && $this->params->get('show_modify_date'))
			{?>
				<div>
					<div class="modifydate">
						<?php echo JText::sprintf('LAST_UPDATED2', JHTML::_('date', $this->article->modified, JText::_('DATE_FORMAT_LC2'))); ?>
					</div>
				</div><?php 
			} ?>
	</div>
<!--	END CONTENTPANEOPEN -->
	<span class="article_separator">&nbsp;</span>

	<?php echo $this->article->event->afterDisplayContent; ?>
