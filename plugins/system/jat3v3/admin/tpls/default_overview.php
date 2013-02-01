<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_templates
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.updater.update');

$telem = T3V3_TEMPLATE;
$felem = T3V3_ADMIN;

$thasnew = false;
$ctversion = $ntversion = $xml->version;
$fhasnew = false;
$cfversion = $nfversion = $fxml->version;

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
  ->select('*')
  ->from('#__updates')
  ->where('(element = ' . $db->q($telem) . ') OR (element = ' . $db->q($felem) . ')');
$db->setQuery($query);
$results = $db->loadObjectList('element');

if(count($results)){
  if(isset($results[$telem])){
    $thasnew = true;
    $ntversion = $results[$telem]->version;
  }
  
  if(isset($results[$felem])){
    $fhasnew = true;
    $nfversion = $results[$felem]->version;
  }
}

$hasperm = JFactory::getUser()->authorise('core.manage', 'com_installer');

?>
<div class="t3-overview">

  <legend class="t3-form-legend"><?php echo JText::_('T3V3_OVERVIEW_TPL_INFO')?></legend>
  <div id="template-home" class="section">
  	<div class="row-fluid">

  		<div class="span8">
  			<?php if (is_file (T3V3_TEMPLATE_PATH.'/templateInfo.php')): ?>
  			<div class="template-info row-fluid">
  				<?php include T3V3_TEMPLATE_PATH.'/templateInfo.php' ?>
  			</div>
  			<?php endif ?>
  		</div>

      <div class="span4">
        <div id="tpl-info" class="admin-block clearfix">
          <h3><?php echo JText::_('T3V3_OVERVIEW_TPL_INFO')?></h3>
          <dl class="info">
            <dt><?php echo JText::_('T3V3_OVERVIEW_NAME')?></dt>
            <dd><?php echo $xml->name ?></dd>
            <dt><?php echo JText::_('T3V3_OVERVIEW_VERSION')?></dt>
            <dd><?php echo $xml->version ?></dd>
            <dt><?php echo JText::_('T3V3_OVERVIEW_CREATE_DATE')?></dt>
            <dd><?php echo $xml->creationDate ?></dd>
            <dt><?php echo JText::_('T3V3_OVERVIEW_AUTHOR')?></dt>
            <dd><a href="<?php echo $xml->authorUrl ?>" title="<?php echo $xml->author ?>"><?php echo $xml->author ?></a></dd>
          </dl>
        </div>
        <div class="admin-block updater<?php echo $thasnew ? ' outdated' : '' ?> clearfix">
          <h3><?php echo empty($xml->updateservers) ? JText::sprintf('T3V3_OVERVIEW_TPL_VERSION', $xml->name, $xml->version) : JText::sprintf($thasnew ? 'T3V3_OVERVIEW_TPL_NEW' : 'T3V3_OVERVIEW_TPL_SAME', $xml->name) ?></h3>
          <p><?php echo empty($xml->updateservers) ? JText::_('T3V3_OVERVIEW_TPL_VERSION_MSG') : ($thasnew ? JText::sprintf('T3V3_OVERVIEW_TPL_NEW_MSG', $ctversion, $xml->name, $ntversion) : JText::sprintf('T3V3_OVERVIEW_TPL_SAME_MSG', $ctversion)) ?></p>
          <?php if($hasperm) :
            if(empty($xml->updateservers)): ?>
            <a class="btn" href="http://www.joomlart.com/forums/downloads.php" class="t3check-framework" title="<?php echo JText::_('T3V3_OVERVIEW_TPL_DL_CENTER') ?>"><?php echo JText::_('T3V3_OVERVIEW_TPL_DL_CENTER') ?></a>&nbsp;
            <a class="btn" href="http://update.joomlart.com" class="t3check-framework" title="<?php echo JText::_('T3V3_OVERVIEW_TPL_UPDATE_CENTER') ?>"><?php echo JText::_('T3V3_OVERVIEW_TPL_UPDATE_CENTER') ?></a>
            <?php else : ?> 
            <a class="btn" href="<?php JURI::base() ?>index.php?option=com_installer&view=update" class="t3check-framework" title="<?php echo JText::_( $thasnew ? 'T3V3_OVERVIEW_GO_DOWNLOAD' : 'T3V3_OVERVIEW_CHECK_UPDATE') ?>"><?php echo JText::_( $thasnew ? 'T3V3_OVERVIEW_GO_DOWNLOAD' : 'T3V3_OVERVIEW_CHECK_UPDATE') ?></a>
            <?php endif ?>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

  <legend class="t3-form-legend"><?php echo JText::_('T3V3_OVERVIEW_FRMWRK_INFO')?></legend>
  <div id="framework-home" class="section">

    <div class="row-fluid">

      <div class="span8">
        <?php if (is_file (T3V3_ADMIN_PATH.'/admin/frameworkInfo.php')): ?>
        <div class="template-info row-fluid">
          <?php include T3V3_ADMIN_PATH.'/admin/frameworkInfo.php' ?>
        </div>
        <?php endif ?>
      </div>

      <div class="span4">
        <div id="frmk-info" class="admin-block clearfix">
          <h3><?php echo JText::_('T3V3_OVERVIEW_FRMWRK_INFO')?></h3>
          <dl class="info">
            <dt><?php echo JText::_('T3V3_OVERVIEW_NAME')?></dt>
            <dd><?php echo $fxml->name ?></dd>
            <dt><?php echo JText::_('T3V3_OVERVIEW_VERSION')?></dt>
            <dd><?php echo $fxml->version ?></dd>
            <dt><?php echo JText::_('T3V3_OVERVIEW_CREATE_DATE')?></dt>
            <dd><?php echo $fxml->creationDate ?></dd>
            <dt><?php echo JText::_('T3V3_OVERVIEW_AUTHOR')?></dt>
            <dd><a href="<?php echo $fxml->authorUrl ?>" title="<?php echo $fxml->author ?>"><?php echo $fxml->author ?></a></dd>
          </dl>
        </div>
        <div class="admin-block updater<?php echo $fhasnew ? ' outdated' : '' ?> clearfix">
          <h3><?php echo JText::sprintf($fhasnew ? 'T3V3_OVERVIEW_FRMWRK_NEW' : 'T3V3_OVERVIEW_FRMWRK_SAME', $fxml->name)?></h3>
          <p><?php echo $fhasnew ? JText::sprintf('T3V3_OVERVIEW_FRMWRK_NEW_MSG', $cfversion, $fxml->name, $nfversion) : JText::sprintf('T3V3_OVERVIEW_FRMWRK_SAME_MSG', $cfversion) ?></p>
          <?php if($hasperm): ?>
          <a class="btn" href="<?php JURI::base() ?>index.php?option=com_installer&view=update" class="t3check-framework" title="<?php echo JText::_( $fhasnew ? 'T3V3_OVERVIEW_GO_DOWNLOAD' : 'T3V3_OVERVIEW_CHECK_UPDATE') ?>"><?php echo JText::_( $fhasnew ? 'T3V3_OVERVIEW_GO_DOWNLOAD' : 'T3V3_OVERVIEW_CHECK_UPDATE') ?></a>
          <?php endif; ?>
        </div>
      </div>

    </div>

	</div>

</div>