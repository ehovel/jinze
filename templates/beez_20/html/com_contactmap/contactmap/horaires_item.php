<?php 
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

foreach ($this->rows as $row) { ?>
	<h2>
	<?php echo JText::_('GMAPFP_HORAIRES_PRIX'); ?>
    </h2>
	<?php echo $row->horaires_prix;
};?>
