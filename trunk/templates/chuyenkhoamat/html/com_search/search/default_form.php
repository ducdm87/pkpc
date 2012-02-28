<?php defined('_JEXEC') or die('Restricted access'); ?>

<form id="searchForm" action="<?php echo JRoute::_( 'index.php?option=com_search' );?>" method="post" name="searchForm">
	<table class="contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<tr>
			<td nowrap="nowrap">
				<label for="search_searchword">
					<?php echo JText::_( 'Search Keyword' ); ?>:
				</label>
			</td>
			<td nowrap="nowrap">
				<input type="text" name="searchword" id="search_searchword" size="30" maxlength="20" value="<?php echo $this->escape($this->searchword); ?>" class="inputbox" />
			</td>
			<td width="100%" nowrap="nowrap">
				<button name="Search" onclick="this.form.submit()" class="button"><?php echo JText::_( 'Search' );?></button>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">
				<?php echo $this->lists['searchphrase']; ?>
			</td>
		</tr>
<!--		Thứ tự:-->
		<tr>
			<td>
				<label for="ordering">
					<?php echo JText::_( 'Ordering' );?>:
				</label>
			</td>
			<td colspan="2">				
				<?php echo $this->lists['ordering'];?>
			</td>
		</tr>
	</table>
	
<!--	Chỉ tìm kiếm:-->
	<?php if ($this->params->get( 'search_areas', 1 )) : ?>
		<?php echo JText::_( 'Search Only' );?>:
		<?php foreach ($this->searchareas['search'] as $val => $txt) :
			$checked = is_array( $this->searchareas['active'] ) && in_array( $val, $this->searchareas['active'] ) ? 'checked="checked"' : '';
		?>
		<input type="checkbox" name="areas[]" value="<?php echo $val;?>" id="area_<?php echo $val;?>" <?php echo $checked;?> />
			<label for="area_<?php echo $val;?>">
				<?php echo JText::_($txt); ?>
			</label>
		<?php endforeach; ?>
	<?php endif; ?>



	<div class="searchintro<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
		<div class="row">
			<div class="left">
				<?php 
					echo JText::_( 'Search Keyword' );
				?>
			</div>
			<div class="right search1">
				<?php echo ' <b>'. $this->escape($this->searchword) .'</b>'; ?>
			</div>
		</div>
		<span class="clear">&nbsp;</span>
		<div class="row">
			<div class="left <?php if (count($this->results) <= 0) echo 'error'; else echo 'success' ?>">			
				<?php echo $this->result; ?>
			</div>
		</div>
	</div>

<br />
<?php if($this->total > 0) : ?>
<div class="paging"">
	<div style="float: right;">
		<label for="limit">
			<?php echo JText::_( 'Display Num' ); ?>
		</label>
		<?php echo $this->pagination->getLimitBox( ); ?>
	</div>
	<div>
		<?php 
			require_once('mypageing.php');
			//echo $this->pagination->getPagesLinks( );
			echo getMyPagenation($this->pagination);
		?>
	</div>
</div>
<?php endif; ?>

<input type="hidden" name="task"   value="search" />
</form>
