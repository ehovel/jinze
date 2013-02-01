<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.8
	* Creation date: Décembre 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die();

class ContactMapsControllerContactMap extends ContactMapsController
{
    function __construct()
    {
        parent::__construct();

        // Register Extra tasks
        $this->registerTask( 'add', 'edit' );
        $this->registerTask( 'unpublish',   'publish');
    }

    function edit()
    {
        JRequest::setVar( 'view', 'contactmap' );
        JRequest::setVar( 'layout', 'form'  );
        JRequest::setVar('hidemainmenu', 1);

        parent::display();
    }

    function view()
    {
        JRequest::setVar( 'view', 'contactmaps' );
        JRequest::setVar( 'layout', 'default'  );

        parent::display();
    }

    function save()
    {
        $post   = JRequest::get('post');
        $model = $this->getModel('contactmap');
        $returnid=$model->store($post);
        if ($returnid>0) {
            $msg = JText::_( 'GMAPFP_SAVED' );
        } else {
            $msg = JText::_( 'GMAPFP_SAVED_ERROR' );
        }

        $link = 'index.php?option=com_contactmap&controller=contactmap&task=view';
        // Check the table in so it can be edited.... we are done with it anyway
        $this->setRedirect($link, $msg);
    }

    function apply()
    {
        $post   = JRequest::get('post');
        $model = $this->getModel('contactmap');
        $returnid=$model->store($post);
        if ($returnid>0) {
            $msg = JText::_( 'GMAPFP_SAVED' );
        } else {
            $msg = JText::_( 'GMAPFP_SAVED_ERROR' );
        }

        $link = 'index.php?option=com_contactmap&controller=contactmap&task=edit&cid[]='.(int)$returnid;
        // Check the table in so it can be edited.... we are done with it anyway
        $this->setRedirect($link, $msg);
    }

    function remove()
    {
        $model = $this->getModel('contactmap');
        if(!$model->delete()) {
            $msg = JText::_( 'Error: One or more ContactMaps could not be Deleted' );
        } else {
            $msg = JText::_( 'ContactMap(s) Deleted' );
        }

        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view', $msg );
    }

    function publish()
    {
        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view' );

        // Initialize variables
        $db         =& JFactory::getDBO();
        $user       =& JFactory::getUser();
        $cid        = JRequest::getVar( 'cid', array(), 'post', 'array' );
        $task       = JRequest::getCmd( 'task' );
        $publish    = ($task == 'publish');
        $n          = count( $cid );

        if (empty( $cid )) {
            return JError::raiseWarning( 500, JText::_( 'JERROR_NO_ITEMS_SELECTED' ) );
        }

        JArrayHelper::toInteger( $cid );
        $cids = implode( ',', $cid );

        $query = 'UPDATE #__contact_details'
        . ' SET published = ' . (int) $publish
        . ' WHERE id IN ( '. $cids .' )'
        ;
        $db->setQuery( $query );
        if (!$db->query()) {
            return JError::raiseWarning( 500, JText::_( 'Undefine error on controller published' ) );
        }
        $this->setMessage( JText::sprintf( $publish ? 'Items published' : 'Items unpublished', $n ) );

    }

    function copy()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view' );

        $cid    = JRequest::getVar( 'cid', null, 'post', 'array' );
        $db     = &JFactory::getDBO();
        $model	= $this->getModel('contactmap');
        $table  = $model->getTable('ContactMap', 'ContactMapTable');
        $user   = &JFactory::getUser();
        $n      = count( $cid );

        if ($n > 0)
        {
            foreach ($cid as $id)
            {
                if ($table->load( (int)$id ))
                {
                    $table->id          = 0;
                    $table->name        = '(Copie de - copy of) ' . $table->name;
                    $table->alias       = '';
                    $table->published   = 0;
                    $table->user_id      = $user->get('id');
            
                    if (!$table->store()) {
                        return JError::raiseWarning( 500, $table->getError() );
                    }
                }
                else {
                    return JError::raiseWarning( 500, $table->getError() );
                }
            }
        }
        else {
            return JError::raiseWarning( 500, JText::_( 'JERROR_NO_ITEMS_SELECTED' ) );
        }
        $table->reorder();
        $this->setMessage( JText::sprintf( 'Items copied', $n ) );
    }
    
    function cancel()
    {
        $msg = JText::_( 'Operation Cancelled' );
        $this->setRedirect( 'index.php?option=com_contactmap&controller=contactmap&task=view', $msg );
    }

    function edit_upload()
    {
        JRequest::setVar( 'view', 'contactmap' );
        JRequest::setVar( 'layout', 'upload_form'  );
        JRequest::setVar('hidemainmenu', 1);

        parent::display();
    }

    function upload_image() {
		$mainframe = &JFactory::getApplication(); 
        $config =& JComponentHelper::getParams('com_contactmap');

        $data = JRequest::get( 'post' );
        $type_image = array(".gif",".jpg",".jpeg",".png",".bmp"); 
        $loaderror = false;
        $file = $_FILES['image1'];
        $file_name = $_FILES['image1']['name'];

        $ext = strrchr($file_name,'.');
        $ext = strtolower($ext);
        if (!in_array( $ext, $type_image )) 
        {
            echo "<script> alert('".JText::_( 'GMAPFP_BAD_EXT')."'); window.history.go(-1); </script>";
            exit();
        }

        $file['name'] = str_replace(" ","_",$file['name']);
        
        if (strlen($_FILES['image1']['tmp_name']) > 0 and $_FILES['image1']['name'] != "none"){         
            if(!is_file($mainframe->getCfg('tmp_path').'/../images/contactmap/'.strtolower($file['name'])))
                copy ($file['tmp_name'], $mainframe->getCfg('tmp_path').'/../images/contactmap/'.strtolower($file['name']));
            else $loaderror=true;               
            if($loaderror) {?>
                    <script type="text/javascript" language="javascript">
                        alert('<?php echo JText::_( 'GMAPFP_UPLOAD_NOK');?>');
                        window.history.go(-1);
                    </script> <?php
            } else { ?>
                    <script type="text/javascript" language="javascript">
                        alert('<?php echo JText::_( 'GMAPFP_UPLOAD_OK');?>');
                        window.opener.addphoto("<?php echo strtolower($file['name']);?>", "<?php echo strtolower($file['name']);?>");
                        window.opener.changeDisplayImage("<?php echo JURI::base().'../images/contactmap/';?>");
                        window.close();
                    </script> <?php
            }
        }
    }
            
}
?>
