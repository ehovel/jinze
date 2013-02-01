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

class ContactMapsControllerAccueil extends ContactMapsController
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
        JRequest::setVar( 'view', 'accueil' );
        JRequest::setVar( 'layout', 'form'  );
        JRequest::setVar('hidemainmenu', 0);

        parent::display();
    }

}
?>
