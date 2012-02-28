<div id="header">
	<div class="inner">
	<!--	BEGIN HEADER_LEFR	-->
		<div id="header_left">
			<div id="logo" style="cursor: pointer;" onclick="location.href='<?php echo JURI::root(); ?>';">
				<h2 class="title"><?php echo $mainframe->getPageTitle(); ?></h2>
			</div>						
		</div>
	<!--		END HEADER_LEFR	-->
	
	<!--		BEGIN HEADER RIGHT-->
		<div id="header_right">
			<?php if ($this->countModules('topbanner')) {?>
				<div id="topbanner">
					<jdoc:include type="modules" name="topbanner" style="ckm" />
				</div>
			<?php }?>							
		</div>
		<span class="clear">&nbsp;</span>
	<!--		END HEADER RIGHT-->
	
	<!--		BEGIN MENU-->
		<div id="menu">	
			<?php
				$option	=	JRequest::getVar('option');
				$view	=	JRequest::getVar('view');
				$isHome	=	false;
				if ($view == 'frontpage' && $option == 'com_content') {
					$isHome	=	true;
				}
			?>													
			<?php if ($this->countModules('menu-nav')) {?>
					<div id="menu-nav">
<!--						<div class="home_menu <?php if ($isHome) { echo 'home-active';	}?>">							-->
<!--							<a class="content" href="<?php echo JURI::root(); ?>"> &nbsp; </a>-->
<!--						</div>-->
						<jdoc:include type="modules" name="menu-nav" style="ckm" />
					</div>
			<?php }?>
				
			<?php if ($this->countModules('submenu-nav')) {?>
				<div id="submenu-nav">
					<jdoc:include type="modules" name="submenu-nav" style="ckm" />
				</div>
			<?php }?>
			
		</div>
	<!-- END MENU-->
	</div>
</div>