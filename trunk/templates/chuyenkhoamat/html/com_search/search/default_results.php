<?php defined('_JEXEC') or die('Restricted access'); ?>

<div class="contentpaneopen<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">	
	<div class="page_body">
		<?php		
		$this->results	=	JArrayHelper::sortObjects($this->results,'thumb', -1);
		
		foreach( $this->results as $result )
		{ 
//			$result->text	=	str_replace($this->searchword,'<span class="searchword">'.$this->searchword.'</span>',$result->text);
			?>
			<div class="row">
					<div class="thumb">
						<?php
						
							if (isset($result->thumb) and $result->thumb != '') {
								?>
									<a href="<?php echo JRoute::_($result->href); ?>">
										<img  alt="" src="<?php echo $result->thumb; ?>" />
									</a>
								<?php
							}
						?>
					</div>
					<div class="title">
						<?php 
						if ($result->href) {
							?>
									<a href="<?php echo JRoute::_($result->href); ?>">
										<?php echo $this->escape($result->title) ?>
									</a>
								<?php
						}
						?>
						<br>
						<span class="section">(<?php echo $this->escape($result->section); ?>)</span>
					</div>
					
					<div class="text">
						<?php echo $result->text; ?>
					</div>
					<div class="date">
						<?php
						if ( $this->params->get( 'show_date' ))
								{?>
									<div class="small<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
										<?php echo $result->created; ?>
									</div>
							<?php 
								}
						?>
					</div>
					<span class="clear">&nbsp;</span>			
			</div>
			
		<?php
		}
		?>			
	</div>	
	
</div>
