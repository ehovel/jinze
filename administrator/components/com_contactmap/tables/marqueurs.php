<?php
/*
* ContactMap Component Google Map for Joomla! 1.6.x
* Version 4.8
* Creation date: Décembre 2011
* Author: Fabrice4821 - www.gmapfp.org
* Author email: webmaster@gmapfp.org
* License GNU/GPL
*/

defined('_JEXEC') or die('Restricted access');

class ContactMapTableMarqueurs extends JTable
{

	function __construct( &$db ) {
		parent::__construct('#__contactmap_marqueurs', 'id', $db);
	}
}
?>