<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php

// Initialize variables
$db		=& JFactory::getDBO();
$user	=& JFactory::getUser();
$config	=& JFactory::getConfig();
$now	=& JFactory::getDate();

$lists	=	$this->lists;
$row	=	$this->row;
//Ordering allowed ?
$editor =& JFactory::getEditor();
$config 		= &JComponentHelper::getParams('com_spa_manager');
$module_type 		= $config->get('module_type');

JHTML::_('behavior.tooltip');
JHTML::_('behavior.mootools');

$document=JFactory::getDocument();
$document->addStyleSheet('components/com_spa_manager/assets/css/content.css');
//$document->addScript('components/com_spa_manager/assets/js/job.js');

?>
<form action="index.php?option=<?php echo $option; ?>" method="post" name="adminForm">
	<div class="col width-70 spa_manager">
		<fieldset class="adminform">
			<legend>Details</legend>
				<table cellspacing="1" class="admintable">
					<tr>
						<td valign="top" class="key">Modules:</td>
						<td><?php echo $lists['module']; ?></td>
					</tr>
					<tr>
						<td class="key"><label for="type">Type:</label></td>
						<td>
						<?php
							$arr_type	=	array('content'=>0,'menu'=>1);
							
							foreach ($arr_type as $k=>$v)							
							{	
								?>
								<input  class="shortr"  <?php if ($v == $row->type) echo 'checked="checked"'; ?> type="radio" value="<?php echo $v; ?>" size="80" id="type" name="type" class="text_area">
								<label><?php echo $k; ?></label>
								<?php 
							}
						?>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="title">Title:</label></td>
						<td><input  class="long" type="text" value="<?php echo htmlspecialchars($row->title); ?>" size="80" id="title" name="title" class="text_area"></td>
					</tr>
					<tr>
						<td class="key"><label for="premium">Premium:</label></td>
						<td>
							<input type="radio" <?php if ($row->premium == 1) echo 'checked="checked"';?> name="premium" value="1" >
							<label>Yes</label>
							<input type="radio" <?php if ($row->premium == 0) echo 'checked="checked"';?> name="premium" value="0" >
							<label>No</label>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="state">Published:</label></td>
						<td>
							<input type="radio" <?php if ($row->state == 1) echo 'checked="checked"';?> name="state" value="1" >
							<label>Yes</label>
							<input type="radio" <?php if ($row->state == 0) echo 'checked="checked"';?> name="state" value="0" >
							<label>No</label>
						</td>
						</td>
					</tr>
					<tr>
						<?php if ($row->cid == 0) $row->cid = ''; ?>
						<td class="key"><label for="cid">content id:</label></td>
						<td><input class="short"  type="text" value="<?php echo $row->cid; ?>" size="30" id="cid" name="cid" class="text_area"></td>
					</tr>
					<tr>
						<td class="key"><label for="link">Or link:</label></td>
						<td><input  class="long"  type="text" value="<?php echo $row->link; ?>" size="80" id="link" name="link" class="text_area"></td>
					</tr>
					<tr>
						<td class="key"><label for="thumb">Thumbnail:</label></td>
						<td><input class="long"  type="text" value="<?php echo $row->thumb; ?>" size="80" id="thumb" name="thumb" class="text_area"></td>
					</tr>
					<tr>
						<td class="key"><label for="thumb_width">Thumbnails, width(px):</label></td>
						<td>
						<?php
						
							$row->thumb_width	=	$row->thumb_width?$row->thumb_width:0;
							$arr_thumbw	=	array(70,80,100,120,140,160,180,200,250,300,350,500,0);
							$arr_titlew	=	array(70,80,100,120,140,160,180,200,250,300,350,500,'User default');
							
							for ($i=0; $i<count($arr_thumbw); $i++)
							{
								?>
								<input  class="shortr"  <?php if ($arr_thumbw[$i] == $row->thumb_width) echo 'checked="checked"'; ?> type="radio" value="<?php echo $arr_thumbw[$i]; ?>" size="80" id="thumb_width" name="thumb_width" class="text_area">
								<label><?php echo $arr_titlew[$i]; ?></label>
								<?php 
							}
						?>
							
						</td>
					</tr>
					<tr>
						<td class="key"><label for="introtext">Description:</label></td>
						<td>
							<?php 
									echo $editor->display('introtext',$row->introtext , '100%', '500', '20', '25');
							?>							
						</td>
					</tr>
					<tr>
						<td class="key"><label for="keywords">Keywords:</label></td>
						<td>
							<textarea  class=""  id="keywords" cols="70" rows="3" name="keywords" class="text_area"><?php echo $row->keywords; ?></textarea>
						</td>
					</tr>					
					<tr>
						<td class="key"><label for="cdate">Created Date:</label></td>
						<td>
							<?php echo JHTML::_('calendar', $row->cdate, 'cdate', 'cdate', '%Y-%m-%d %H:%m:%S', array('class' => 'cdate')); ?>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="publish_up">Start Publishing:</label></td>
						<td>
							<?php echo JHTML::_('calendar', $row->publish_up, 'publish_up', 'publish_up', '%Y-%m-%d %H:%m:%S', array('class' => 'publish_up')); ?>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="publish_down">Finish Publishing:</label></td>
						<td>							
							<?php echo JHTML::_('calendar', $row->publish_down, 'publish_down', 'publish_down', '%Y-%m-%d %H:%m:%S', array('class' => 'publish_down')); ?>
						</td>
					</tr>
					<tr>
						<td class="key"><label for="Target">Target:</label></td>
						<td>
							<select class="inputbox" name="target">
								<option value="0"<?php if($row->target == 0) echo 'selected="selected"'; ?>>Parent Window With Browser Navigation</option>
								<option value="1"<?php if($row->target == 1) echo 'selected="selected"'; ?>>New Window With Browser Navigation</option>
								<option value=2"<?php if($row->target == 2) echo 'selected="selected"'; ?>>New Window Without Browser Navigation</option>
							</select>					
						</td>
					</tr>
					<tr>
						<td class="key"><label for="keywords">Last Modified:</label></td>
						<td>
							<label><?php echo $row->mdate; ?></label>							
						</td>
					</tr>
				</table>
			</fieldset>
	</div>
	<div class="col width-30 menu_right">
		<?php echo $lists['category']; ?>
	</div>
	


<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="module" />
<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
