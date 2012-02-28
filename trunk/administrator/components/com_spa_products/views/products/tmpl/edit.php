<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php

// Initialize variables
$db		=& JFactory::getDBO();
$user	=& JFactory::getUser();
$config	=& JFactory::getConfig();
$now	=& JFactory::getDate();
$date	=	JFactory::getDate();
$lists	=	$this->lists;
$row	=	$this->row;
$editor =& JFactory::getEditor();

//Ordering allowed ?
JHTML::_('behavior.mootools');
jimport('joomla.html.pane');
$pane=&JPane::getInstance('sliders',array('startOffset'=>0,'startTransition'=>0));

$document=JFactory::getDocument();
$document->addStyleSheet('components/com_spa_products/assets/css/content.css');

//$document->addScript('components/com_spa_manager/assets/js/job.js');

?>
<!--BEGIN INFO-->
<form action="index.php?option=<?php echo $option; ?>" method="post" name="adminForm">
	<fieldset class="adminform">
		<legend>Info</legend>
		<div class="col width-60">
			<table cellspacing="1" class="admintable">
				<tr>
					<td class="key"><label for="title">title:</label></td>
					<td><input  class="long" type="text" value="<?php echo htmlspecialchars($row->title); ?>" size="120" id="title" name="title" class="text_area"></td>
				</tr>
				<tr>
					<td class="key"><label for="title">Alias:</label></td>
					<td><input  class="long" type="text" value="<?php echo htmlspecialchars($row->alias); ?>" size="120" id="alias" name="alias" class="text_area"></td>
				</tr>
				<tr>
					<td colspan="2">
						<table>
							<tr>
								<td class="key"><label for="title">Category:</label></td>
								<td><?php echo ($lists['category']); ?></td>
								<td class="key"><label for="title">Factory:</label></td>
								<td><?php echo ($lists['factory']); ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
		<div class="col width-40">
			<table cellspacing="1" class="admintable">
				<tr>
					<td class="key"><label for="state">Published:</label></td>
					<td>
						<input type="radio" <?php if ($row->published == 1) echo 'checked="checked"';?> name="published" value="1" >
						<label>Yes</label>
						<input type="radio" <?php if ($row->published == 0) echo 'checked="checked"';?> name="published" value="0" >
						<label>No</label>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="state">Number:</label></td>
					<td>
						<input type="text" name="quanlity" value="<?php echo $row->quanlity; ?>" >
						waiting:<label><?php echo $row->book; ?></label>
					</td>
				</tr>
				<tr>
					<td class="key"><label for="state">Price:</label></td>
					<td>
						<input type="text" name="price" value="<?php echo $row->price; ?>" > VND
					</td>
				</tr>
				<tr>
					<td class="key"><label for="state">time Warranty:</label></td>
					<td>
						<input type="text" name="timeWarranty" value="<?php echo $row->timeWarranty; ?>" >
					</td>
				</tr>
				<tr>
					<td class="key"><label for="state">Unit Warranty:</label></td>
					<td>
						<select name="warrantyType" value="<?php echo $row->warrantyType; ?>" >
							<option value="1" <?php if($row->warrantyType == 1) echo 'selected="selected"'?>>Giờ</option>
							<option value="2" <?php if($row->warrantyType == 2) echo 'selected="selected"'?>>ngày</option>
							<option value="3" <?php if($row->warrantyType == 3) echo 'selected="selected"'?>>tuần</option>
							<option value="4" <?php if($row->warrantyType == 4) echo 'selected="selected"'?>>tháng</option>
							<option value="5" <?php if($row->warrantyType == 5) echo 'selected="selected"'?>>năm</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</fieldset>
<!--END INFO-->
<!--BEGIN FORM-->	
		<div class="col width-70 spa_manager">
			<fieldset class="adminform">
				<legend>Details</legend>
					<table cellspacing="1" class="admintable">
						<tr>
							<td class="key"><label for="thumb">Thumbnail:</label></td>
							<td><input class="long"  type="text" value="<?php echo $row->thumb; ?>" size="80" id="thumb" name="thumb" class="text_area"></td>
						</tr>
						<tr>
							<td class="key"><label for="thumb">Small Thumbnail:</label></td>
							<td><input class="long"  type="text" value="<?php echo $row->smallThumb; ?>" size="80" id="smallThumb" name="smallThumb" class="text_area"></td>
						</tr>
						<tr>
							<td class="key"><label for="introtext">Content:</label></td>
							<td>
								<?php 
									echo $editor->display('text',$row->text , '100%', '500', '20', '25');
								?>
							</td>
						</tr>
					</table>
				</fieldset>
		</div>
		<div class="col width-30 menu_right">
			<table width="100%" style=" border: 1px dashed silver; margin-bottom: 10px; padding: 5px;">
				<tr>
					<td width="35%"><strong> Content ID: </strong> </td>
					<td> <?php echo $row->id; ?></td>
				</tr>
				<tr>
					<td><strong> published: </strong> </td>
					<td>
						<?php
							if ($row->published)
								echo 'Published';
							else {
								echo 'Unpublished';
							}
							 
						 ?>
					</td>
				</tr>
				<tr>
					<td><strong> Hits: </strong> </td>
					<td> 
						<?php echo $row->hits; 
						if ($row->hits)
						{
							?>
								<span>
									<input type="button" onclick="submitbutton('content.resethits');" value="Reset" class="button" name="reset_hits">
								</span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td><strong> Created: </strong> </td>
					<td>
						<?php echo JHTML::_('date', $row->cdate, JText::_('DATE_FORMAT_LC2'));; ?>
					</td>
				</tr>
				<tr>
					<td><strong> Modified: </strong> </td>
					<td>
						<?php echo JHTML::_('date', $row->mdate, JText::_('DATE_FORMAT_LC2'));; ?>
					</td>
				</tr>
			</table>
			<?php 
			echo $pane->startPane( 'param' );
				// 	PANEL 1
				echo $pane->startPanel( JText::_('Parameters'), 'parameters' );
					?>
						<table cellspacing="1" class="admintable">
							<tr>
								<td class="key"><label for="cdate">Created Date:</label></td>
								<td>
									<?php 
									if ($row->cdate == '' || $row->cdate == '0000-00-00 00:00:00')
									{
										$row->cdate	=	$date->toMySQL();
									}
									echo JHTML::_('calendar', $row->cdate, 'cdate', 'cdate', '%Y-%m-%d %H:%m:%S', array('class' => 'cdate')); ?>
								</td>
							</tr>	
						</table>
					<?php
				echo $pane->endPanel();
				/*END PANEL 1*/
				// PANEL 2
				echo $pane->startPanel( JText::_('Metadata Infomation'), 'infomation' );
					?>
						<table cellspacing="1" class="admintable">
							<tr>
								<td><label for="keywords">Description:</label></td>
								<td>
									<textarea  class=""  id="metadesc" cols="35" rows="3" name="metadesc" class="text_area"><?php echo $row->metadesc; ?></textarea>
								</td>
							</tr>
							<tr>
								<td><label for="keywords">Key word:</label></td>
								<td>
									<textarea  class=""  id="metakey" cols="35" rows="3" name="metakey" class="text_area"><?php echo $row->metakey; ?></textarea>
								</td>
							</tr>							
						</table>
					<?php
				echo $pane->endPanel();
			echo $pane->endPane();
		if ($row->smallThumb)
			echo '<span>small Thumb: <img style="max-width: 180px; " src="'.$row->smallThumb.'" /></span>';
		if ($row->thumb)
			echo '<hr /><span>Thumb: <img style="max-width: 300px; " src="'.$row->thumb.'" /></span>';
			?>
		</div>	
	
	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="product" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>
<!--END FORM-->