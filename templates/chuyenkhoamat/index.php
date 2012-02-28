<?php
	$columns = NULL;
	$editmode = NULL;
	$taskmode = JRequest::getCmd('task');
	if ($taskmode == "edit") $editmode = 1;
	if ($this->countModules('left + right') <= 0) $columns="nocolumns";
	elseif ($this->countModules('left') >= 1 || $this->countModules('right') >= 1) $columns="rightcolumn";
	$joomlaJS = $this->params->get('defaultJS');
	if (($joomlaJS == "off") && (!$editmode)) {
		$headerjs = $this->getHeadData();
		$headerjs['scripts'] = array();
		$this->setHeadData($headerjs);
	};
	defined( '_JEXEC' ) or die( 'Restricted access' ); 
	$option = JRequest::getVar('option');
	$view = JRequest::getVar('view');
	$isDetail = false;
	$isColumn = false;
	
	if ($option = 'com_content') {
		switch ($view)
		{
			case 'article':
					$isDetail = true;
					break;
			case 'frontpage':
					$isColumn = true;
					break;
			case 'section':
					$isColumn = FALSE;
					break;
		}		
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

	<head>
		<?php 
			$use_motools = $this->params->get('use_motools');
			if ($use_motools==2) {
					unset($this->_scripts[$this->baseurl . '/media/system/js/mootools.js']);
				?>				
					<script type="text/javascript" language="javascript" src="templates/<?php echo $this->template ?>/assets/js/mootools-1.2-core.js"></script>
					<script type="text/javascript" language="javascript" src="templates/<?php echo $this->template ?>/assets/js/mootools-1.2-more.js"></script>
				<?php
				
			}
			
		?>	
		<script type="text/javascript" language="javascript" src="templates/<?php echo $this->template ?>/assets/js/module.js"></script>
		<jdoc:include type="head" />
		<script type="text/javascript" language="javascript" src="templates/<?php echo $this->template ?>/assets/js/menu.js"></script>
		<link rel="Shortcut Icon" href="templates/<?php echo $this->template ?>/assets/images/icon.png" type="image/x-icon" />		
		<link rel="stylesheet" href="templates/<?php echo $this->template ?>/assets/css/template.css" type="text/css"/>
		<link rel="stylesheet" href="templates/<?php echo $this->template ?>/assets/css/module.css" type="text/css"/>
		<?php if ($editmode) echo '<link rel="stylesheet" href="/templates/system/css/general.css" type="text/css" />'."\n"; ?>
		<!--[if lte IE 6]><script type="text/javascript" language="javascript" src="templates/<?php echo $this->template ?>/assets/js/ie6.js"></script>
		<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->template ?>/assets/css/ie6.css" />
		<![endif]-->
		<!--[if lte IE 7]>
		<link rel="stylesheet" type="text/css" href="templates/<?php echo $this->template ?>/assets/css/ie7.css" />
		<![endif]-->
		
	</head>
	<body>
		<!--BEGIN PAGE-->	
		<div id="page">			
			<!--BEGIN PADDING_BORDER_LEFT -->
			<div class="padding_border_left">
				<!--END PADDING_BORDER_LEFT	-->
				<div class="padding_border_right">
					<!--BEGIN BREAKDUM-->					
					<?php if ($this->countModules('breadcrumb')) {?>
						<div id="breadcrumb">
							<jdoc:include type="modules" name="breadcrumb" style="soft" />
						</div>
					<?php }?>					
					<!--END BREAKDUM-->
					<!--BEGIN ONLIE-->					
					<?php if ($this->countModules('online')) {?>
						<div id="online">
							<jdoc:include type="modules" name="online" style="soft" />
						</div>
					<?php }?>					
					<!--END ONLIE-->
					<!--BEGIN WRAPPER-->
						<?php require_once('block/wrapper.php'); ?>
					<!--END WRAPPER-->
						<span class="clear">&nbsp;</span>
					<!--BEGIN FOOTER-->
						<?php require_once('block/footer.php'); ?>
					<!--END FOOTER	-->
					<!--BEGIN HEADER-->
						<?php require_once('block/header.php'); ?>
					<!--END HEADER-->
				</div>
				<!--END PADDING_BORDER_LEFT-->						
			</div>
			<!--END PADDING_BORDER_RIGHT_RIGHT-->	
		</div>
		<span class="clear">&nbsp;</span>
		<!--END PAGE-->
		<!--BEGIN DEBUG-->
		<div id="debug">		
		</div>
		<!--END DEBUG-->
	</body>
</html>