<?php
				if (($this->item->params->get('show_section') && $this->item->sectionid) || ($this->item->params->get('show_category') && $this->item->catid))
					{
						echo '<div><div>';
								if ($this->item->params->get('show_section') && $this->item->sectionid && isset($this->section->title))
								{
									echo '<span>';
										if ($this->item->params->get('link_section'))
											{
												echo '<a href="'.JRoute::_(ContentHelperRoute::getSectionRoute($this->item->sectionid)).'">';
											}
												echo $this->escape($this->section->title); 
											if ($this->item->params->get('link_section'))
											{ echo '</a>';}
										if ($this->item->params->get('show_category')){	echo ' - '; }
									echo '</span>';							
								}
								if ($this->item->params->get('show_category') && $this->item->catid)
								{
									echo '<span>';
										if ($this->item->params->get('link_category'))
											{
												echo '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catslug, $this->item->sectionid)).'">';
											}
												echo $this->escape($this->item->category);
										if ($this->item->params->get('link_category'))
										{	echo '</a>'; }
									echo '</span>';	
								}
						echo '</div></div>';
					}