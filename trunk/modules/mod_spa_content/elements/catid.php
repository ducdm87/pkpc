<?php
defined('JPATH_BASE') or die();

jimport('joomla.filesystem.file'); 
jimport('joomla.filesystem.folder'); 

class JElementCatid extends JElement
{ 
	
	
	function fetchElement($name, $value, &$node, $control_name)
	{ 
		$db=JFactory::getDBO();
		$section = 'com_spa_products';
		$query = 'SELECT c.id id, c.title AS title' .
			' FROM #__categories AS c' .
			' LEFT JOIN #__sections AS s ON s.id=c.section' .
			' WHERE c.published = 1' .
			' AND s.scope = '.$db->Quote($node->attributes('scope')).
			' ORDER BY s.ordering, c.ordering';	
		$db->setQuery($query);
		$options = $db->loadObjectList();
		ob_start();				
		?>			
			<select style="margin:0 0 0 3px;" size="1" name="sectcat" id="cattegories">
				<option value="0">- Select Category -</option>
				<?php for ($i=0;$i<count($options);$i++)
				{
					$row=$options[$i];
					?>
						<option value="<?php echo $row->id; ?>"><?php echo '('.$row->id.') '.$row->title; ?></option>
					<?php
				}
				?>				
			</select>			
			<input type="hidden" style="" id="<?php echo $control_name.$name; ?>" value="<?php echo $value; ?>" name="<?php echo $control_name.'['.$name.']'; ?>" name="params[catid]"
		<?php 
		$str	=	ob_get_contents();
		ob_end_clean();
		return $str;
	}
}
