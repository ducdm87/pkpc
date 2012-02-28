<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * components/com_hello/hello.php
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
*/
 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
//overwrite JF database, back to the normal Joomla database
$db =& JFactory::getDBO();
$yos_conf =& JFactory::getConfig();
$yos_host 		= $yos_conf->getValue('config.host');
$yos_user 		= $yos_conf->getValue('config.user');
$yos_password 	= $yos_conf->getValue('config.password');
$yos_db   		= $yos_conf->getValue('config.db');
$yos_dbprefix 	= $yos_conf->getValue('config.dbprefix');
$yos_dbtype 	= $yos_conf->getValue('config.dbtype');
$yos_debug 		= $yos_conf->getValue('config.debug');
$yos_driver 	= $yos_conf->getValue('config.dbtype');
$yos_options = array("driver"=>$yos_driver, "host"=>$yos_host, "user"=>$yos_user, "password"=>$yos_password, "database"=>$yos_db, "prefix"=>$yos_dbprefix,"select"=>true);
//$db =& JDatabase::getInstance( $yos_options );
$yos_driver = preg_replace('/[^A-Z0-9_\.-]/i', '', $yos_driver);
$path	= JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'database'.DS.'database'.DS.$yos_driver.'.php';
if (file_exists($path)) {
	require_once($path);
} else {
	JError::setErrorHandling(E_ERROR, 'die'); //force error type to die
	$error = JError::raiseError( 500, JTEXT::_('Unable to load Database Driver:') .$yos_driver);
	die($error);
}
$yos_adapter	= 'JDatabase'.$yos_driver;
$db	= new $yos_adapter($yos_options);

// Require the base controller 
require_once( JPATH_COMPONENT.DS.'controller.php' );
 
// Require specific controller if requested
if($controller = JRequest::getWord('controller')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}
$task=JRequest::getVar( 'task','' );
if ($task=='' or (!$task=='cron' and $task=='remoteTranslator')) {
	echo 'task incorrect';
	die();
}
// Create the controller
$classname    = 'TranslatorController'.$controller;
$controller   = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar( 'task' ) );

// Redirect if set by the controller
$controller->redirect();
