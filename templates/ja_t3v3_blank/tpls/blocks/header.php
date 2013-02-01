<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$sitename = $this->params->get('sitename') ? $this->params->get('sitename') : JFactory::getConfig()->get('sitename');
$slogan = $this->params->get('slogan');
$logotype = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', '') : '';
if ($logoimage) {
  $logoimage = ' style="background-image:url('.JURI::base(true).'/'.$logoimage.');"';
}
?>
<div id="header">
	<div class="layout header_inner"> 
		<div class="header_top clearfix">
			<div class="unit"><a class="red" title="" href="#">网站首页</a>|<a title="" href="#">网站地图</a>|<a title="" href="#">English</a></div>
			<div class="top_nav"><a title="" href="#">液压机</a>|<a class="red" title="" href="#">卷板机</a>|<a title="" href="#">剪板机</a>|<a title="" href="#">折弯机</a></div>
		</div>
		
		<!--logo-->
		<h1 id="logo" class="logo logo-<?php echo $logotype ?>"><a title="<?php echo strip_tags($sitename) ?>" href=""<?php echo $logoimage ?>><span><?php echo $sitename ?></span></a></h1>

		<!--nav-->
		<?php //$this->loadBlock ('mainnav') ?>
		<jdoc:include type="modules" name="<?php $this->_p('mainnav') ?>" style="raw" />
	</div>
</div>