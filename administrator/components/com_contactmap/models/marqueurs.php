<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.8
	* Creation date: D�cembre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class ContactMapsModelMarqueurs extends JModel
{
    var $_data;
    var $_list;
    var $_total;
    
    function __construct()
    {
        parent::__construct();

		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
        $controller = JRequest::getWord('controller');

        $array = JRequest::getVar('cid',  0, '', 'array');
        $this->setId((int)$array[0]);
            
        $limit      = $mainframe->getUserStateFromRequest( $option.$controller.'limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest( $option.$controller.'limitstart', 'limitstart', 0, 'int' );

        // In case limit has been changed, adjust limitstart accordingly
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

    
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function _buildQuery()
    {
        $query = ' SELECT * '
            . ' FROM #__contactmap_marqueurs '
        ;

        return $query;
    }

    function setId($id)
    {
        // Set id and wipe data
        $this->_id      = $id;
        $this->_data    = null;
    }

    function getList()
    {
        // Lets load the data if it doesn't already exist
        if (empty( $this->_list ))
        {
            $query = $this->_buildQuery();
            $this->_list = $this->_getList( $query, $this->getState('limitstart'), $this->getState('limit'));
        }
        // tri par ordre alphab�tic
        if (!empty($this->_list))
            {usort($this->_list, array($this,'sortArray'));};
        
        return $this->_list;
    }
    
    function getData()
    {
        // Lets load the data if it doesn't already exist
        if (empty( $this->_data )) {
            $query = ' SELECT * FROM #__contactmap_marqueurs '.
                    '  WHERE id = '.$this->_id;
            $this->_db->setQuery( $query );
            $this->_data = $this->_db->loadObject();
        }
        if (!$this->_data) {
            $this->_data = new stdClass();
            $this->_data->id = 0;
            $this->_data->nom = null;
            $this->_data->url = null;
            $this->_data->published = null;
        }

        return $this->_data;
    }
    
    function sortArray($a, $b) {
		$mainframe = &JFactory::getApplication(); 
		$option    = JRequest::getCMD('option'); 
        $controller = JRequest::getWord('controller');
        
        $filter_order       = $mainframe->getUserStateFromRequest( $option.$controller.'filter_order', 'filter_order', 'nom', 'cmd' );
        $filter_order_Dir   = $mainframe->getUserStateFromRequest( $option.$controller.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
        if (!$filter_order) {$filter_order='nom';}
        
        if ($filter_order_Dir != 'asc') {
            $element1 = 'a';
            $element2 = 'b';
        } else {
            $element1 = 'b';
            $element2 = 'a';
        }
        
        return @strcasecmp(${$element1}->{$filter_order}, ${$element2}->{$filter_order});
    }

    function limitArray($array,$start,$limit) {
        $return = Array();
        for ($i=0;$i<count($array);$i++) {
            if ($i >= $start && $i < ($start+$limit)) {
                $return[] = $array[$i];
            }
        }
        return $return;
        }

    function getPagination()
    {
        // Lets load the content if it doesn't already exist
        if (empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }

        return $this->_pagination;
    }       
    
    function getTotal()
    {
        // Lets load the content if it doesn't already exist
        if (empty($this->_total))
        {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }

        return $this->_total;
    }

    function store()
    {
        $row =& $this->getTable('Marqueurs', 'ContactMapTable');

        $data = JRequest::get( 'post' );

        // Bind the form fields to the hello table
        if (!$row->bind($data)) {
            $this->setError($this->_db->getErrorMsg());
            return 0;
        }

        // Make sure the hello record is valid
        if (!$row->check()) {
            $this->setError($this->_db->getErrorMsg());
            return 0;
        }
        
        // Store the web link table to the database
        if (!$row->store()) {
            $this->setError($this->_db->getErrorMsg() );
            return 0;
        }

        return $row->id;
    }

    function delete()
    {
        $cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

        $row =& $this->getTable('Marqueurs', 'ContactMapTable');

        if (count( $cids ))
        {
            foreach($cids as $cid) {
                if (!$row->delete( $cid )) {
                    $this->setError( $row->getErrorMsg() );
                    return false;
                }
            }                       
        }
        return true;
    }
            

}
