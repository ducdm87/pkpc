	<?php
	
	function getMyPagenation($obj_pagination)
	{
		
			$pageNav		=	$obj_pagination;
			$limitstart		=	$pageNav->limitstart;
			$limit			=	$pageNav->limit;
			$total			=	$pageNav->total;
			$pages_current	=	$pageNav->get('pages.current');						
			$pages_total	=	$pageNav->get('pages.total');
		ob_start();		
			?>
			<div class="paging">
					<ul>
					<?php
						if ($pages_current!=1) {
							$_limitstartjm	=	$limit*($pages_current-2);
								?>
									<li class="pagenav-inactive">
										<a href="<?php echo JRoute::_("&limitstart=$_limitstartjm"); ?>">
											<?php echo  JText::_('<'); ?>
										</a
									</li>
								<?php
							}
					for ($j=1;$j<=$pages_total;$j++)
					{
						if ($pages_total <= 1) {
							break;
						}
						if ($j > 1 && ($j < $pages_current - 3 || $j > $pages_current + 3)) {
							continue;
						}
						
						$_limitstart=$limit*($j-1);
						if($j==$pages_current)
						{
							?>
							<li class="pagenav-active"'>
									<span><?php echo  $j; ?></span>							
							</li>
							<?php
						}
						else {
							?>
							<li class="pagenav-inactive">
								<a href="<?php echo JRoute::_("&limitstart=$_limitstart"); ?>">
									<?php echo  $j; ?>
								</a>
							</li>							
							<?php
						}
						
					}
					// next button
					if ($pages_current < $pages_total) {
						$_limitstart	=	$limit*($pages_current);
						?>
							<li class="pagenav-inactive">
								<a href="<?php echo JRoute::_("&limitstart=$_limitstart"); ?>">
									<?php echo JText::_('>'); ?>
								</a>
							</li>
						<?php
					}
					
					?>
			</div>
			<?php 		
		$str	=	ob_get_contents();
		ob_end_clean();
		return $str;
	}
	
	