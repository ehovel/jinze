<?php

/**
* Default template
* @package Gavick News Show Pro GK4
* @Copyright (C) 2009-2011 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.3.0.0 $
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

$news_amount = $this->parent->config['news_portal_mode_4_amount'];
?>

<?php if($news_amount > 0) : ?>
<ul class="catelist clearfix">
	<?php for($i = 0; $i < count($news_image_tab); $i++) : ?>
	<li>
		<div class="pic">
			<?php echo $news_image_tab[$i];?>
		</div>
		<div class="info">
			<?php echo $news_title_tab[$i];?>
		</div>
	</li>
	<?php endfor; ?>
</ul>
<?php else : ?>
<p><?php echo JText::_('MOD_NEWS_PRO_GK4_NSP_ERROR'); ?></p>
<?php endif; ?>