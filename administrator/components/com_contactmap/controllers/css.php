<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class ContactMapsControllerCSS extends ContactMapsController
{
    /**
     * constructor (registers additional tasks to methods)
     * @return void
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * display the edit form
     * @return void
     */
    function view()
    {
        JRequest::setVar( 'view', 'css' );
        JRequest::setVar( 'layout', 'form'  );
        JRequest::setVar('hidemainmenu', 0);

        parent::display();
    }

    /**
     * save CSS
     */
    function saveCss()
    {   
        $post   = JRequest::get('post');
        $model = $this->getModel('css');
        if ($model->store($post)) {
            $msg = JText::_( 'GMAPFP_SAVED');
        } else {
            $msg = JText::_( 'GMAPFP_SAVED_ERROR');
        }

        $link = 'index.php?option=com_contactmap&controller=css&task=view';
        $this->setRedirect($link, $msg);
    
    }

}
?>
