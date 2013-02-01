<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.1
	* Creation date: Juillet 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

// No direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class ContactMapsViewContactMap extends JView
{
	protected $item;

	public function display()
	{
		// Get model data.
        $model      = &$this->getModel(); 
        $item       = $model->getContactMapList();
		$item		= $item[0];

		$doc = JFactory::getDocument();
		$doc->setMetaData('Content-Type','text/directory"', true);

		// Compute lastname, firstname and middlename
		$item->name = trim($item->name);

		// "Lastname, Firstname Midlename" format support
		// e.g. "de Gaulle, Charles"
		$namearray = explode(',', $item->name);
		if (count($namearray) > 1 ) {
			$lastname = $namearray[0];
			$card_name = $lastname;
			$name_and_midname = trim($namearray[1]);

			$firstname = '';
			if (!empty($name_and_midname)) {
				$namearray = explode(' ', $name_and_midname);

				$firstname = $namearray[0];
				$middlename = (count($namearray) > 1) ? $namearray[1] : '';
				$card_name = $firstname . ' ' . ($middlename ? $middlename . ' ' : '') .  $card_name;
			}
		}
		// "Firstname Middlename Lastname" format support
		else {
			$namearray = explode(' ', $item->name);

			$middlename = (count($namearray) > 2) ? $namearray[1] : '';
			$firstname = array_shift($namearray);
			$lastname = count($namearray) ? end($namearray) : '';
			$card_name = $firstname . ($middlename ? ' ' . $middlename : '') . ($lastname ? ' ' . $lastname : '');
		}

		$rev = date('c',strtotime($item->modified));

		JResponse::setHeader('Content-disposition','attachment; filename="'.$card_name.'.vcf"', true);
		
		$search = array("\r\n", "\n", "\r");
		$message = str_replace($search, '', $item->misc);
		$search = array('</p>', '<br />');
		$message = str_replace($search, '=0D=0A', $message);
		$message = strip_tags($message);

		$vcard = array();
		$temps = array();
		$temps[].= 'BEGIN:VCARD';
		$temps[].= 'VERSION:3.0';
		$temps[] = 'N:'.$lastname.';'.$firstname.';'.$middlename;
		$temps[] = 'FN:'.$item->name;
		$temps[] = 'TITLE:'.$item->con_position;
		$temps[] = 'TEL;TYPE=WORK,VOICE:'.$item->telephone;
		$temps[] = 'TEL;TYPE=WORK,FAX:'.$item->fax;
		$temps[] = 'TEL;TYPE=WORK,MOBILE:'.$item->mobile;
		$temps[] = 'ADR;TYPE=WORK:;;'.$item->address.';'.$item->suburb.';'.$item->state.';'.$item->postcode.';'.$item->country;
		$temps[] = 'LABEL;TYPE=WORK:'.$item->address."\n".$item->suburb."\n".$item->state."\n".$item->postcode."\n".$item->country;
		$temps[] = 'EMAIL;TYPE=PREF,INTERNET:'.$item->email_to;
		$temps[] = 'URL:'.$item->webpage;
		$temps[] = 'NOTE;ENCODING=QUOTED-PRINTABLE:'.$message;
		if ($item->image) $temps[] = 'PHOTO;VALUE=uri:'.JURI::base().'images/contactmap/'.$item->image;
		$temps[] = 'GEO:'.$item->glat.';'.$item->glng;
		$temps[] = 'REV:'.$rev.'Z';
		$temps[] = 'END:VCARD';
		
		foreach ($temps as $data)
		{
			$vcard[] = html_entity_decode(htmlentities($data, ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES, 'ISO-8859-1');
		}

		echo implode("\n",$vcard);
		return true;
	}
}

