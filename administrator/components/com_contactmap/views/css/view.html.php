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

jimport( 'joomla.application.component.view' );

class ContactMapsViewCSS extends JView
{
    function display($tpl = null)
    {
        JToolBarHelper::title(   JText::_( 'GMAPFP_CSS_MANAGER' ).': <small><small>[CSS]</small></small>', 'themes.png' );
        JToolBarHelper :: custom( 'saveCss', 'save.png', 'save.png', 'Save', false, false );


        parent::display($tpl);
    }
}
