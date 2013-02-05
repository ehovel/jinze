<?php
/**

 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class EhovelmediaModelImages extends JModel
{
    var $_entry;
    var $_total;
    var $_pagination;
    var $_version;

    function __construct()
    {
        parent::__construct();
        $mainframe = JFactory::getApplication();

        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
        $limitstart = $mainframe->getUserStateFromRequest('easybookreloaded.limitstart', 'limitstart', 0, 'int');
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }

    function _buildQuery()
    {
        $query = "SELECT * FROM ".$this->_db->nameQuote('#__easybook')." ORDER BY ".$this->_db->nameQuote('gbdate')." DESC";

        return $query;
    }

    function getData()
    {
        if(empty($this->_data))
        {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
        }

        return $this->_data;
    }

    function getPagination()
    {
        if(empty($this->_pagination))
        {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit'));
        }

        return $this->_pagination;
    }

    function getTotal()
    {
        if(empty($this->_total))
        {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);
        }

        return $this->_total;
    }

    function getVersion()
    {
        require_once(JPATH_COMPONENT.DS.'helpers'.DS.'version.php');

        if(empty($this->_version))
        {
            $this->_version = new EasybookReloadedHelperVersion();
        }

        return $this->_version;
    }
}
