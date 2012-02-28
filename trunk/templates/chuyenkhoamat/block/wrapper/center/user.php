<?php 
	echo $pane->startPane( 'user' );				
		if ($this->countModules('user1')) 
		{
			echo $pane->startPanel( JText::_('Mới xuất hiện'), 'user1' ); ?>
				<div class="<?php echo $this->params->get('user1'); ?>">
					<jdoc:include type="modules" name="user1" style="soft" />
				</div>
				<span class="clear">&nbsp;</span>
			<?php echo $pane->endPanel();
		}
		
		if ($this->countModules('user2')) 
		{
			echo $pane->startPanel( JText::_('Giảm giá nhiều'), 'user2' ); ?>
				<div class="<?php echo $this->params->get('user2'); ?>">
					<jdoc:include type="modules" name="user2" style="soft" />
				</div>					
				<span class="clear">&nbsp;</span>
			<?php echo $pane->endPanel();
		}
		
		if ($this->countModules('user3')) 
		{
			echo $pane->startPanel( JText::_('Sản phẩm bán chạy'), 'user3' ); ?>							
				<div class="<?php echo $this->params->get('user3'); ?>">
					<jdoc:include type="modules" name="user3" style="soft" />
				</div>						
				<span class="clear">&nbsp;</span>
			<?php echo $pane->endPanel();
		}
		
		if ($this->countModules('user4')) 
		{
			echo $pane->startPanel( JText::_('Sản phẩm ưa thích'), 'user4' ); ?>							
				<div class="<?php echo $this->params->get('user4'); ?>">
					<jdoc:include type="modules" name="user4" style="soft" />
				</div>						
				<span class="clear">&nbsp;</span>
			<?php echo $pane->endPanel();
		}
		
		if ($this->countModules('user5')) 
		{
			echo $pane->startPanel( JText::_('Sản phẩm khuyến mại'), 'user5' ); ?>							
				<div class="<?php echo $this->params->get('user5'); ?>">
					<jdoc:include type="modules" name="user5" style="soft" />
				</div>						
				<span class="clear">&nbsp;</span>
			<?php echo $pane->endPanel();
		}
	echo $pane->endPane();