<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// addon for joomla modal Box
JHTML::_('behavior.modal');
// JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();
/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
?>
<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
?>
<div class="headline clearfix">
	<div class="hd">
		<h3>产品展示</h3>
		<span>PRODUCTS SHOW</span>
	</div>
	<div class="crumb"><span>您的位置：</span><a title="江苏金泽重型机械有限公司" href="/">首页</a>|<?php if ($categoryName) {?><a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><em><?php echo $categoryName ?></em></a><?php } else {?><em>产品展示</em><?php }?></div>
</div>
<div class="product_details">
	<h2><?php echo $this->product->product_name ?></h2>
	<div class="bd">
		<div class="pic">
		<?php
			echo $this->loadTemplate('imagesnew');
		?>
		</div>
		<div class="des">
		 <?php
		    if (!empty($this->product->product_s_desc)) {
			?>
			    <?php
			    /** @todo Test if content plugins modify the product description */
			    echo nl2br($this->product->product_s_desc);
			    ?>
			<?php
		    }
		    if (!empty($this->product->customfieldsSorted['ontop'])) {
			$this->position = 'ontop';
			echo $this->loadTemplate('customfields');
		    }
		 ?>
		 <?php
			// Product Description
			if (!empty($this->product->product_desc)) {
			   echo $this->product->product_desc; 
		    } // Product Description END
		 ?>
		 </div>
	</div>
</div>
