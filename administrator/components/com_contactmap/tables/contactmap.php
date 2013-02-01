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

class ContactMapTableContactMap extends JTable
{
	function __construct( &$db ) {
        parent::__construct('#__contact_details', 'id', $db);
    }

    function check()
    {
        //Remove all HTML tags from the title
        $filter = new JFilterInput(array(), array(), 0, 0);
        $this->name = $filter->clean($this->name);

        if(empty($this->alias)) {
            $this->alias = $this->name;
        }
        $this->alias = JFilterOutput::stringURLSafe($this->alias);
        if(trim(str_replace('-','',$this->alias)) == '') {
            $datenow =& JFactory::getDate();
            $this->alias = $datenow->toFormat("%Y-%m-%d-%H-%M-%S");
        }

        return true;
    }
}
?>
