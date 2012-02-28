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
class SPAController extends JController
{
	function __construct(){
		
		//set default view to about
		if (!JRequest::getVar('task') && !JRequest::getVar('view')) {
			JRequest::setVar('task', 'modules');
		}		
		parent::__construct();
		
	}
	
	/**
	 * Method to display the view
	 *
	 * @access	public
	 */
	function display()
	{		
		$this->contents();
	}
	
	function modules()
	{		
		$document 	= &JFactory::getDocument();
		$vType		= $document->getType();
		$vLayout 	= 'list';
		$mName		= 'modules';
		
		// Get/Create the view
		$view = &$this->getView( 'modules', $vType);
		
		// Get/Create the model	
	
		if ($model = &$this->getModel($mName)) {
			// Push the model into the view (as default)			
			$view->setModel($model, true);
		}
				
		// Set the layout
		$view->setLayout($vLayout);
		
		//display view
		$view->display();
	}
	
	function contents()
	{		
		$document 	= &JFactory::getDocument();
		$vType		= $document->getType();
		$vLayout 	= 'list';
		$mName		= 'contents';
		
		// Get/Create the view
		$view = &$this->getView( 'contents', $vType);
		
		// Get/Create the model	
	
		if ($model = &$this->getModel($mName)) {
			// Push the model into the view (as default)			
			$view->setModel($model, true);
		}
				
		// Set the layout
		$view->setLayout($vLayout);
		
		//display view
		$view->display();
	}
	
	function about(){
		global $mainframe;
		
		$document 	= &JFactory::getDocument();
		$vType		= $document->getType();
		$vLayout 	= 'about';
		$mName		= 'version';
		
		// Get/Create the view
		$view = &$this->getView( 'about', $vType);
		
		// Get/Create the model	
		$checkversion	=	&Yos_utility::getVersion();
		$version	=	$checkversion['version'];
		$url		=	$checkversion['url'];
		$pc			=	$checkversion['productcode'];
		if ($model = &$this->getModel($mName,'', array('version'=> $version, 'url'=> $url , 'pc'=> $pc ))) {
			// Push the model into the view (as default)
			$model->updateVersion();
			$view->setModel($model, true);
		}
				
		// Set the layout
		$view->setLayout($vLayout);
		
		//display view
		$view->display();
	}
	
}
?>
