<div id="center_inner">
	<!--	FOR MAIN-TOP	-->
	<jdoc:include type="message" />
	
	<div id="main-top">	
			<?php if ($this->countModules('chuyenmuc1')) {?>
			<div id="chuyenmuc1">
				<div class="<?php echo $this->params->get('chuyenmuc1'); ?>">
					<jdoc:include type="modules" name="chuyenmuc1" style="soft" />
				</div>
			</div>
			<span class="clear">&nbsp;</span>			
			<?php }	
			jimport('joomla.html.pane');
			$pane =& JPane::getInstance('tabs',array('startOffset'=>0)); 
			if($this->countModules('user1') || $this->countModules('user2') || $this->countModules('user3') || $this->countModules('user4') || $this->countModules('user5'))
			{
				?>
				<div class="user_module">
					<?php 
						require 'center/user.php';
					?>
				</div>			
			<?php
			}
			if ($this->countModules('chuyenmuc2')) {?>
			<div id="chuyenmuc2">
				<div class="<?php echo $this->params->get('chuyenmuc2'); ?>">
					<jdoc:include type="modules" name="chuyenmuc2" style="soft" />
				</div>
			</div>
			<span class="clear">&nbsp;</span>
			<?php }?>						
	</div>
	<span class="clear">&nbsp;</span>
	<!--	FOR COMPONENT	-->
	<?php if ($isColumn == false) {?>
		<jdoc:include type="component" />
	<?php }else {
	?>									
		<div id="main-bottom">
			<div class="main-bottom <?php echo $this->params->get('main-bottom'); ?>">
				<jdoc:include type="modules" name="main-bottom" style="soft" />
			</div>					
		</div>		
		<span class="clear">&nbsp;</span>									
	<?php }?>
</div>