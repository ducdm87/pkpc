<?php
/**
 * Translator default controller
 *
 * @package		yos_translator
 * @subpackage	Components
 * @link		http://yopensource.com
 * @author		Minh Nguyen
 * @copyright 	Minh Nguyen (minhna@gmail.com)
 * @license		Commercial
 */

jimport('joomla.application.component.controller');

/**
 * Translator Component Controller
 *
 * @package		yos_translator
 */
class TranslatorController extends JController
{

	function cron(){
		global $mainframe;		
		$model = &$this->getModel('Cron');
		
		$model->cron();
//		var_dump($model);
	}
	
}
?>
