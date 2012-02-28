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
<!--BEGIN FORM-->	
		<div class="col width-70 spa_manager">
			<fieldset class="adminform">
				<legend>Details</legend>
					<table cellspacing="1" class="admintable">
						<tr>
							<td class="key"><label for="title">Title:</label></td>
							<td><input  class="long" type="text" value="<?php echo htmlspecialchars($row->title); ?>" size="80" id="title" name="title" class="text_area"></td>
						</tr>
						<tr>
							<td class="key"><label for="title">Alias:</label></td>
							<td><input  class="long" type="text" value="<?php echo htmlspecialchars($row->alias); ?>" size="80" id="title" name="alias" class="text_area"></td>
						</tr>
						<tr>
							<td class="key"><label for="state">Published:</label></td>
							<td>
								<input type="radio" <?php if ($row->published == 1) echo 'checked="checked"';?> name="published" value="1" >
								<label>Yes</label>
								<input type="radio" <?php if ($row->published == 0) echo 'checked="checked"';?> name="published" value="0" >
								<label>No</label>
							</td>
							</td>
						</tr>
						
						<tr>
							<td class="key"><label for="thumb">Thumbnail:</label></td>
							<td><input class="long"  type="text" value="<?php echo $row->thumb; ?>" size="80" id="thumb" name="thumb" class="text_area"></td>
						</tr>
						<tr>
							<td class="key"><label for="thumb">Small Thumbnail:</label></td>
							<td><input class="long"  type="text" value="<?php echo $row->smallThumb; ?>" size="80" id="smallThumb" name="smallThumb" class="text_area"></td>
						</tr>
						<tr>
							<td class="key"><label for="thumb">homepageUrl:</label></td>
							<td><input class="long"  type="text" value="<?php echo $row->homepageUrl; ?>" size="80" id="homepageUrl" name="homepageUrl" class="text_area"></td>
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
					<td width="35%"><strong> Factory ID: </strong> </td>
					<td> <?php echo $row->id; ?></td>
				</tr>
				<tr>
					<td><strong> State: </strong> </td>
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
									<input type="button" onclick="submitbutton('factory.resethits');" value="Reset" class="button" name="reset_hits">
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
									<textarea  class=""  id="desc" cols="35" rows="3" name="metadesc" class="text_area"><?php echo $row->metadesc; ?></textarea>
								</td>
							</tr>
							<tr>
								<td><label for="keywords">Keywords:</label></td>
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
	<input type="hidden" name="task" value="module" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
	</form>
<!--END FORM-->