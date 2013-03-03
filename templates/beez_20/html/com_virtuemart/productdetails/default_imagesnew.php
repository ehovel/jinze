<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
vmJsApi::css('jquery.fancybox-1.3.4');
vmJsApi::js( 'jquery.min');
vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
$document = JFactory::getDocument ();


if (!empty($this->product->images)) {
	$imageJS = '
	jQuery(document).ready(function() {
	jQuery("a[rel=vm-additional-images]").fancybox({
	"titlePosition" 	: "inside",
	"transitionIn"	:	"elastic",
	"transitionOut"	:	"elastic"
	});
	var galleries = jQuery(".ad-gallery").adGallery({loader_image: "/images/loader.gif",width:600,height:500});
	galleries[0].settings.effect = "slide-hori";
	galleries[0].slideshow.disable();
	galleries[0].settings.description_wrapper = jQuery("#descriptions");
	});
	';
	$document->addScriptDeclaration ($imageJS);
	$app= JFactory::getApplication();
	$document->addScript('/templates/'.$app->getTemplate(true)->template.'/javascript/adslide/jquery.ad-gallery.min.js');
	$document->addStyleSheet('/templates/'.$app->getTemplate(true)->template.'/javascript/adslide/jquery.ad-gallery.css', $type = 'text/css', $media = 'screen,projection');
}?>
<div id="gallery" class="ad-gallery">
      <div class="ad-image-wrapper">
      </div>
      <div class="ad-controls">
      </div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
          <?php
			$count_images = count ($this->product->images);
			if ($count_images > 1) {
				?>
				<?php
				for ($i = 0; $i < $count_images; $i++) {
					$image = $this->product->images[$i];
					?>
		            <li>
			            <?php $thumbImg = $image->createThumb(100,80);?>
		            	<a href="<?php echo $image->file_url;?>">
			                <img src="<?php echo $thumbImg;?>" class="image<?php echo $i;?>">
			            </a>
		            </li>
					<?php
				}
				?>
			<?php }?>
          </ul>
        </div>
      </div>
</div>