<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php

// Initialize variables
$db		=& JFactory::getDBO();
$user	=& JFactory::getUser();
$config	=& JFactory::getConfig();
$now	=& JFactory::getDate();

//Ordering allowed ?
$ordering = ($this->lists['order'] == 'ordering');

$config 		= &JComponentHelper::getParams('com_yos_news_crawler');
$data_type 		= $config->get('data_type');

JHTML::_('behavior.tooltip');

	$ordering	=	FALSE;
	$arr_order	=	array('SCONTENT.ordering','SEC.title','SCONTENT.id','SCONTENT.type');
	if(in_array($this->lists["order"],$arr_order))
	{
		$ordering	=	TRUE;
	}
	$disabled = $ordering ?  '' : 'disabled="disabled"';
	
?>
<form action="index.php?option=<?php echo $option; ?>" method="post" name="adminForm">
<table>
<tr>
	<td align="left" width="80%">
		<?php echo JText::_( 'Filter' ); ?>:
		<input type="text" name="search" id="search" value="<?php echo $this->lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
		<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
		<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_sectionid').value='-1';this.form.getElementById('catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
	</td>
	<td align="right"><?php echo $this->lists['module']; ?></td>
	<td><?php echo $this->lists['section']; ?></td>
	<td><?php echo $this->lists['category']; ?></td>
	<td><?php echo $this->lists['state']; ?></td>
	
</tr>
</table>
<!--id,title,id or link,module,menu,state,premium,cdate-->
<table class="adminlist">
	<thead>
		<tr>
			<th width="2%">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="2%" class="title">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->rows); ?>);" />
			</th>
			<th width="23%">
				<?php echo JHTML::_('grid.sort', 'Title', 'SCONTENT.title', @$this->lists['order_Dir'], @$this->lists['order']);?>
			</th>			
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'State', 'SCONTENT.state', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Premium', 'SCONTENT.premium', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th style="width:7%;">
				<?php echo JHTML::_('grid.sort',   JText::_( 'Ordering' ), 'SCONTENT.ordering', @$this->lists["order_Dir"], @$this->lists["order"] );
				if($ordering)	echo JHTML::_('grid.order',  $this->rows );				
				 ?>
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Type', 'SCONTENT.type', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>			
			<th width="12%">
				<?php echo JHTML::_('grid.sort',   'Module', 'MODULE.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="12%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Section', 'SEC.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>		
			<th width="12%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'Category', 'CAT.title', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>		
			<th width="10%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'created date', 'SCONTENT.cdate', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="3%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'SCONTENT.id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="12">
				<?php echo $this->pageNav->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	$k = 0;
	$nullDate = $db->getNullDate();
	
	for ($i=0, $n=count($this->rows); $i < $n; $i++) {
		$row = $this->rows[$i];
		$published 	= JHTML::_('grid.published', $row, $i, 'publish_g.png','publish_x.png','content.' );
		$link 		= JRoute::_( 'index.php?option='.$option.'&task=content.edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pageNav->getRowOffset( $i ); ?>
			</td>
			<td>
				<input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $row->id; ?>" onclick="isChecked(this.checked);" />
			</td>
			<td>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Edit Content' );?>::<?php echo $row->title; ?>">
				<a href="<?php echo $link; ?>">
					<?php echo $row->title; ?></a> </span>						
			</td>
			<td align="center"><?php echo $published; ?></td>
			<td align="center">
						<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','content.toggle_premium')" title="<?php echo ( $row->premium ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>">
							<img src="images/<?php echo ( $row->premium ) ? 'tick.png' :'publish_x.png' ;?>" width="16" height="16" border="0" alt="<?php echo ( $row->premium ) ? JText::_( 'Yes' ) : JText::_( 'No' );?>" /></a>
			</td>
			<td align="left" class="order">
					<span><?php echo $this->pageNav->orderUpIcon( $i, ($row->module == @$this->rows[$i-1]->module), 'orderup', 'Move Up', $ordering); ?></span>
					<span><?php echo $this->pageNav->orderDownIcon( $i, $n, ($row->module == @$this->rows[$i+1]->module), 'orderdown', 'Move Down', $ordering ); ?></span>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled; ?> class="text_area" style="text-align: center" />
			</td>			
			<td align="center">
				<?php 
				$str	=	'';
				if ($row->type)
					$str = 'Menu';
				else {
					$str = 'Content';
				}
				
				?>
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Type Content' );?>::<?php echo $str; ?>">
					<?php echo $str; ?></span>	
			</td>
			<td align="center">
				<?php echo JText::_($row->module_title); ?>
			</td>
			<td align="center">
				<?php echo JText::_($row->sec_title); ?>
			</td>
			<td align="center">
				<?php echo JText::_($row->cat_title); ?>
			</td>
			<td align="center">
				<?php echo JHTML::_('date',  $row->cdate, JText::_('DATE_FORMAT_LC4') ); ?>
			</td>
			<td align="center">
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</tbody>
</table>
<input type="hidden" name="option" value="<?php echo $this->option; ?>" />
<input type="hidden" name="task" value="module" />
<input type="hidden" name="controller" value="content" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
