<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

class ContactMapHelper
{

	public static function addSubmenu($vName = 'accueil')
	{
		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_ACCUEIL'),
			'index.php?option=com_contactmap&controller=accueil&task=view',
			$vName == 'accueil'
		);

		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_LIEUX'),
			'index.php?option=com_contactmap&controller=gmapfp&task=view',
			$vName == 'gmapfp'
		);

		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_MARQUEURS'),
			'index.php?option=com_contactmap&controller=marqueurs&task=view',
			$vName == 'marqueurs'
		);

		JSubMenuHelper::addEntry(
			JText::_('GMAPFP_CATEGORIES'),
			'index.php?option=com_categories&extension=com_contact',
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title(
				JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE',JText::_('COM_GMAPFP')),
				'contactmap-categories');
		}

		JSubMenuHelper::addEntry(
			JText::_('CSS'),
			'index.php?option=com_contactmap&controller=css&task=view',
			$vName == 'css'
		);
	}

	public static function getActions($categoryId = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($categoryId)) {
			$assetName = 'com_contactmap';
		} else {
			$assetName = 'com_contactmap.category.'.(int) $categoryId;
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
}
