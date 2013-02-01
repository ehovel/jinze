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

class ContactMapsViewContactMaps extends JView
{
	protected $state;

    function display($tpl = null)
    {
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 

		$this->state		= $this->get('State');
		require_once JPATH_COMPONENT.'/helpers/contactmap.php';
		$canDo	= ContactMapHelper::getActions($this->state->get('filter.category_id'));


			JToolBarHelper::title(   JText::_( 'GMAPFP_LIEUX_MANAGER' ), 'user.png' );
		if ($canDo->get('core.create')) {
        	JToolBarHelper::addNewX();
		}
		if (($canDo->get('core.edit')) || ($canDo->get('core.edit.own'))) {
			JToolBarHelper::editListX();
		}
		if ($canDo->get('core.create')) {
			JToolBarHelper::customX( 'copy', 'copy.png', 'copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY' );
		}
 	    JToolBarHelper::divider();
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
		}
		if ($canDo->get('core.delete')) {
 	    	JToolBarHelper::divider();
			JToolBarHelper::deleteList();
		}
		if ($canDo->get('core.admin')) {
 	    	JToolBarHelper::divider();
	       JToolBarHelper::preferences('com_contactmap', '620');
		}


        JHTML::_('behavior.tooltip');

        // Get data from the model
        $items      = & $this->get( 'Data');
        $total      = & $this->get( 'Total');
        $pageNav    = & $this->get( 'Pagination' );

        $filtrevilles = array();
        $filtrevilles[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_VILLE_FILTRE' ).' --' );
                foreach($this->get('listville') as $temp) {
                    $filtrevilles[] = JHTML::_('select.option', $temp->suburb );
                }

        $filtredepartements = array();
        $filtredepartements[] = JHTML::_('select.option', '-- '.JText::_( 'GMAPFP_DEPARTEMENT_FILTRE' ).' --' );
                foreach($this->get('listdepartement') as $temp) {
                    $filtredepartements[] = JHTML::_('select.option', $temp->state );
                }

        $filter_order       = $mainframe->getUserStateFromRequest( $option.'filter_order',      'filter_order',     'a.ordering',   'cmd' );
        $filter_order_Dir   = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',  'filter_order_Dir',     '',                                             'word');
        $search             = $mainframe->getUserStateFromRequest( $option.'search',            'search',               '',                                             'string' );
        $filtreville        = $mainframe->getUserStateFromRequest( $option.'filtreville',       'filtreville',          '-- '.JText::_( 'GMAPFP_VILLE' ).' --',         'string' );
        $filtredepartement  = $mainframe->getUserStateFromRequest( $option.'filtredepartement', 'filtredepartement',    '-- '.JText::_( 'GMAPFP_DEPARTEMENT' ).' --',   'string' );

        $lists['ville']         = JHTML::_('select.genericlist', $filtrevilles, 'filtreville', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtreville );
        $lists['departement']   = JHTML::_('select.genericlist', $filtredepartements, 'filtredepartement', 'size="1" class="inputbox" onchange="form.submit()"', 'value', 'text', $filtredepartement );

        // table ordering
        $lists['order_Dir'] = $filter_order_Dir;
        $lists['order'] = $filter_order;

        // search filter
        $lists['search'] = $search;
        
        $this->assignRef('lists', $lists);
        $this->assignRef('items',   $items);
        $this->assignRef('pageNav', $pageNav);

        parent::display($tpl);

    }
}
