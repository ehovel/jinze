<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

jimport('joomla.application.component.controller');

class ContactMapsController extends JController
{
    function display()
    {
		require_once JPATH_COMPONENT.'/helpers/contactmap.php';
		//GMapFPHelper::updateReset();

		// Load the submenu.
		ContactMapHelper::addSubmenu(JRequest::getCmd('controller', 'accueil'));
		
		parent::display();
		
		return $this;
    }
    
    function orderup()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
        $filter_order       = $mainframe->getUserStateFromRequest( $option.'filter_order',      'filter_order',     'a.ordering',   'cmd' );
        $filter_order_Dir   = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',  'filter_order_Dir',     '',                                             'word');
        $model = $this->getModel('contactmap');
        
        if (($filter_order=='a.ordering')and($filter_order_Dir=='asc')) {
            $model->move(-1);
        };
        if (($filter_order=='a.ordering')and($filter_order_Dir=='desc')) {
            $model->move(1);
        };

        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view');
    }

    function orderdown()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
        $filter_order       = $mainframe->getUserStateFromRequest( $option.'filter_order',      'filter_order',     'a.ordering',   'cmd' );
        $filter_order_Dir   = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir',  'filter_order_Dir',     '',                                             'word');
        $model = $this->getModel('contactmap');
        
        if (($filter_order=='a.ordering')and(($filter_order_Dir=='asc')or($filter_order_Dir==''))) {
            $model->move(1);
        };
        if (($filter_order=='a.ordering')and($filter_order_Dir=='desc')) {
            $model->move(-1);
        };

        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view');
    }

    function saveorder()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $cid    = JRequest::getVar( 'cid', array(), 'post', 'array' );
        $order  = JRequest::getVar( 'order', array(), 'post', 'array' );
        JArrayHelper::toInteger($cid);
        JArrayHelper::toInteger($order);

        $model = $this->getModel('contactmap');
        $model->saveorder($cid, $order);

        $msg = JText::_( 'New ordering saved' );
        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view', $msg );
    }

}
?>
