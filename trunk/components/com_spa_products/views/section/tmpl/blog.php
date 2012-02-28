<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php

// Initialize variables
$now	=& JFactory::getDate();
$date	=	JFactory::getDate();

$pageNav_cdate	=	$this->pageNav_cdate;

$data		=	$this->data;

//Ordering allowed ?
JHTML::_('behavior.mootools');
jimport('joomla.html.pane');
$pane=&JPane::getInstance('tabs',array('startOffset'=>0,'startTransition'=>0));

if(!class_exists('SPAContentHelperRoute')) require_once (JPATH_BASE . '/components/com_spa_products/helpers/route.php');

$document=JFactory::getDocument();
$document->addStyleSheet('components/com_spa_faq/assets/css/section.css');
?>
	<div class="sectionblog_faq">
		<?php 
		echo $pane->startPane( 'blog_faq' );
			// PANEL 1
			echo $pane->startPanel( JText::_('Câu hỏi mới nhất'), 'blog_caumoi' );
				?> 
				<div class="contentnew">
					<ul>
						<?php 
						$k	=	1;
						$ItemId	=	JRequest::getVar('Itemid');
						for ($i=0; $i<count($data); $i++)
						{
							$row	=	$data[$i];					
							
							$row->link	=	JRoute::_(SPAContentHelperRoute::getArticleRoute("$row->slug", "$row->catslug", "$row->secslug"));
							$k	=	1-$k;
							
							$str	=	strip_tags($row->intro);
								
							$question		=	explode(' ',$str,41);							
							$question		=	array_slice($question,0,40);
							$question		=	implode(' ',$question);
							
							if (strlen($question)<strlen($str))
								$question		.=' ... ';
							?>
								<li class="row<?php echo $k; ?>">
								    <a href="<?php echo $row->link; ?>" alt="<?php echo htmlspecialchars($row->title); ?>" title="<?php echo htmlspecialchars($row->title); ?>">
								    	<img class="kb_thumb" border="0" title="<?php echo htmlspecialchars($row->title); ?>"  alt="<?php echo htmlspecialchars($row->title); ?>" src="<?php echo $row->thumb; ?>">
								    </a>
								    <h4><a title="<?php echo htmlspecialchars($row->title); ?>" href="<?php echo $row->link; ?>">
								            <?php echo htmlspecialchars($row->title); ?></a>
								     </h4>
								    <p> <?php echo JHTML::_('date', $row->cdate, JText::_('DATE_FORMAT_LC2'));; ?></p>
								    <h4>
								    	<?php echo $question; ?>
								    </h4>
								</li>
								<span class="clear">&nbsp;</span>
							<?php
						}
						?>
					</ul>
				</div>
					<?php
					$pageNav		=	$this->pageNav_cdate;
					$limitstart		=	$pageNav->limitstart;
					$limit			=	$pageNav->limit;
					$total			=	$pageNav->total;
					$pages_current	=	$pageNav->get('pages.current');						
					$pages_total	=	$pageNav->get('pages.total');
					?>
					<div class="paging">
							<ul>
							<?php
								if ($pages_current!=1) {
									$_limitstartjm	=	$limit*($pages_current-2);
										?>
											<li class="pagenav-inactive">
												<a href="<?php echo JRoute::_("&limitstart=$_limitstartjm"); ?>">
													<?php echo  JText::_(' Back'); ?>
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
											<?php echo JText::_('Next'); ?>
										</a>
									</li>
								<?php
							}
							?>
					</div>
				<?php		
			echo $pane->endPanel();
			/*END PANEL 1*/
			// PANEL 2
			echo $pane->startPanel( JText::_('Nhiều người đọc nhất'), 'blog_docnhieu' );
				?>
				<div class="contentnew">
					<ul>
						<?php 
						$k	=	1;
						$ItemId	=	JRequest::getVar('Itemid');
						for ($i=0; $i<count($rows_hit); $i++)
						{
							$row	=	$rows_hit[$i];
							$row->link	=	JRoute::_(FAQContentHelperRoute::getArticleRoute("$row->slug", "$row->catslug", "$row->secslug"));
							$k	=	1-$k;
							
							$str	=	strip_tags($row->question);

							$question		=	explode(' ',$str,41);							
							$question		=	array_slice($question,0,40);
							$question		=	implode(' ',$question);
							if (strlen($question)<strlen($row->question))
								$question		.=' ... ';
														
							?>
								<li class="row<?php echo $k; ?>">
								    <a href="<?php echo $row->link; ?>" alt="<?php echo htmlspecialchars($row->title); ?>" title="<?php echo htmlspecialchars($row->title); ?>">
								    	<img class="kb_thumb" border="0" title="<?php echo htmlspecialchars($row->title); ?>"  alt="<?php echo htmlspecialchars($row->title); ?>" src="<?php echo $row->thumb; ?>">
								    </a>
								    <h4><a title="<?php echo htmlspecialchars($row->title); ?>" href="<?php echo $row->link; ?>">
								            <?php echo htmlspecialchars($row->title); ?></a>
								     </h4>
								    <p> <?php echo JHTML::_('date', $row->cdate, JText::_('DATE_FORMAT_LC2'));; ?></p>
								    <h4>
								    	<?php echo $question; ?>
								    </h4>
								</li>
								<span class="clear">&nbsp;</span>
								<span class="clear">&nbsp;</span>
							<?php
						}
						?>
					</ul>
				</div>
				<?php 		
			echo $pane->endPanel();
		echo $pane->endPane();
		?>
		
	</div>
