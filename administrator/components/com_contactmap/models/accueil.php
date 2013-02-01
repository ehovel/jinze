<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class ContactMapsModelAccueil extends JModel
{

    /**
     * Gère la list des onglets publiés
     */
    function getPublishedTabs() {
        $tabs = array();

        $onglet = new stdClass();
        $onglet->title = 'Donation';
        $onglet->name = 'Donation';
        $onglet->alert = false;
        $tabs[] = $onglet;

        $onglet = new stdClass();
        $onglet->title = 'News';
        $onglet->name = 'News';
        $onglet->alert = false;
        $tabs[] = $onglet;

        return $tabs;
    }




}
?>