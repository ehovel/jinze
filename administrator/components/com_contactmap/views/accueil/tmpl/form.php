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
JHTML::_( 'behavior .modal' );               

$mainframe = &JFactory::getApplication(); 
$lang		=& JFactory::getLanguage();
$template	= $mainframe->getTemplate();

$langue		=substr((@$lang->getTag()),0,2);
if ($langue!='fr') $langue!='en';

?>

<table class="admintable">
    <tr>
        <td width="55%" valign="top" colspan="2">
            <div id="cpanel">
                <?php if ($this->canDo->get('core.admin')) {?>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a class="modal" href="index.php?option=com_config&view=component&component=com_contactmap&path=&tmpl=component" rel="{handler: 'iframe', size: {x: 875, y: 620}, onClose: function() {}}">
                            <?php echo JHTML::_('image.site',  'icon-48-config.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_PARAMETRES'); ?></span>
                        </a>
                    </div>
                </div>
                <?php };?>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_contactmap&controller=contactmap&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-user.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_LIEUX'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_categories&section=com_contact_details">
                            <?php echo JHTML::_('image.site',  'icon-48-category.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_CATEGORIES'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_contactmap&controller=marqueurs&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-checkin.png', '/templates/'. $template .'/images/header/'); ?>
                            <span><?php echo JText::_('GMAPFP_MARQUEURS'); ?></span>
                        </a>
                    </div>
                </div>
                <div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
                    <div class="icon">
                        <a href="index.php?option=com_contactmap&controller=css&task=view">
                            <?php echo JHTML::_('image.site',  'icon-48-themes.png', '/templates/'. $template .'/images/header/'); ?>
                            <span>CSS</span>
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>
<div class="clr"></div>

