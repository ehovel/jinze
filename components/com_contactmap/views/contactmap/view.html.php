<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.9
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

jimport( 'joomla.application.component.view');

class ContactMapsViewContactMap extends JView
{
    function display($tpl = null)
    {
		$mainframe = JFactory::getApplication(); 
		$Itemid    = JRequest::getInt('Itemid'); 
		$option    = JRequest::getCMD('option'); 

		$user		= JFactory::getUser();
        $document   = JFactory::getDocument();

        $params = clone($mainframe->getParams('com_contactmap'));

        // Parametres
        $params->def('show_headings',           1);

        $model      = $this->getModel(); 
		//die(print_r($model));
        $rows       = $model->getContactMapList();
		//die(print_r($rows[0]));
       	$map        = $model->getView();
       	
		$contact = $rows[0];
		// check if we have a contact
		if (!is_object( $contact )) {
			JError::raiseError( 404, 'Contact not found' );
			return;
		}
		
		// check if access is registered/special
		$groups	= $user->getAuthorisedViewLevels();

		$return = '';

		if ((!in_array($contact->access, $groups)) || (!in_array($contact->category_access, $groups))) {
			$uri		= JFactory::getURI();
			$return		= (string)$uri;

			JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			return;
		}

		JHTML::_('behavior.formvalidation');
		
        $this->assignRef('map'          , $map );	        
        $this->assignRef('rows'         , $rows);
        $this->assignRef('params'       , $params);

		$this->_prepareDocument();

        parent::display($tpl);
    }   
	
	protected function _prepareDocument()
	{
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$pathway	= $app->getPathway();
		$title 		= null;

		$menu = $menus->getActive();
		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}

		$title = $this->params->get('page_title', '');
		if (empty($title)) {
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		if (empty($title)) {
			$title = $this->item->name;
		}
		$this->document->setTitle($title);
	}
}
?>
