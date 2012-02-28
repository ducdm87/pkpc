<?php
defined('_JEXEC') or die('Restricted access');
$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'modules/mod_spa_content/assets/css/chuyenmuc2.css');
?>
<div class="pkpc_chuyenmuc2<?php echo $class_sfx; ?>">
	<!--BEGIN HEADER-->	
		<div class="titlecategory">
                    <div class="center">
                       <div class="left"><a> </a></div>
                       <?php if ($header) {
							?><h3 class="head"><span><strong><b><?php echo $header; ?></b></strong></span></h3> <span>(<?php echo $total; ?>)</span>
						<?php }	?>
                    </div>
                    <div class="right"></div>
                    <div class="right1">
                        <div class=catlist>
		                      <?php
								for ($i=0;$i<count($menus);$i++)
								{
									$row	=	$menus[$i];
									if ($i>=2) echo '<div class="spacer"></div>'; ?>
									<a href="<?php echo  $row->link; ?>"><?php echo htmlspecialchars($row->title); ?></a>
									<?php
								}
								?>
                        </div>
                    </div>
          </div>
          <span class="clear">&nbsp;</span>		
	<!--END HEADER-->	
	<div class="content">
		<?php 
		$k=0;
			for ($i=0;$i<count($contents); $i++)			
			{
				$row	=	$contents[$i];
				$row->price	=	'000';
				$class	=	$i == 0 ?'first':(($i+1)%3? 'breakrow':'');			
				?>
					<div class="row<?php echo $k; ?> <?php echo $class; ?>">
						<div class="image"> <a href="<?php echo $row->link; ?>"><img title="<?php echo $row->title; ?>" src="<?php echo $row->thumb; ?>" alt="product"></a> </div>
                        <div class="t_prmo"> 
                            <a class="til_prmo" href="<?php echo $row->link; ?>"><?php echo $row->title; ?></a>
                            <span><?php echo $row->introtext; ?></span>
                            <div class="left1"> <span class="prices"> <?php echo $row->price; ?> VND</span> </div> 
                            <div class=" right1"> <a class="buy" href="#"></a> </div>
	                    </div>
					</div>
				<?php 
				$k=1-$k;
			}
		?>
	</div>
	<!--BEGIN FOOTER-->
	<?php if ($footer) {
		echo '<div class="ckmsection">'.$footer.'</div>';
		}
	?>
	<!--END FOOTER-->
	<div class="clr"></div>
</div>
