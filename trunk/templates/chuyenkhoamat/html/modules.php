<?php
/**
 * @version		$Id: modules.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Similar to default xhtml, with one additional div to facilitate separate padding for the header and the content.
 */

function modChrome_ckm($module, &$params, &$attribs)
{
	if (!empty ($module->content)) {?>	
		<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">		
		<?php if ($module->showtitle != 0) { ?>
			<h3><span><strong><?php echo $module->title; ?></strong></span></h3>
		<?php } ?>
			<div class="content">
				<?php echo $module->content; ?>
			</div>
		<?php if($params->get('moduleclass_sfx')){?>
			<div class="bottom_section"></div>	
		<?php } ?>
		
		</div>
	<?php }
}
function modChrome_chuyenmuc($module, &$params, &$attribs)
{
	if (!empty ($module->content)) {?>	
		<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">		
		<?php if ($module->showtitle != 0) { ?>
			<h3 class="head"><span><strong><?php echo $module->title; ?></strong></span></h3>
		<?php } ?>
			<div class="content">
				<?php echo $module->content; ?>
			</div>
		<?php if($params->get('moduleclass_sfx')){?>
			<div class="bottom_section"></div>	
		<?php } ?>
		
		</div>
	<?php }
}
function modChrome_ckm_kbol($module, &$params, &$attribs)
{
	if (!empty ($module->content)) {?>	
		<div class="module<?php echo $params->get('moduleclass_sfx'); ?>">		
		<?php if ($module->showtitle != 0) { ?>
			<h3 class="head"><span><strong><?php echo $module->title; ?></strong></span></h3>
		<?php } ?>
			<div class="content">
				<?php echo $module->content; ?>
			</div>
		<?php if($params->get('moduleclass_sfx')){?>
			<div class="bottom_section"></div>	
		<?php } ?>
		
		</div>
		<span class="clr"> </span>
	<?php }
}