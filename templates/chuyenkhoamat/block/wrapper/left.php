<?php if ($this->countModules('column_left')) {?>
<div id="column_left">
	<div class="<?php echo $this->params->get('column_left'); ?>">
		<jdoc:include type="modules" name="column_left" style="soft" />
	</div>
</div>	
<?php }?>
<span class="clear">&nbsp;</span>