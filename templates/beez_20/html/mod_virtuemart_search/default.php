<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!--BEGIN Search Box -->
<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
<div class="search<?php echo $params->get('moduleclass_sfx'); ?>">
<?php $output = '<input name="keyword" id="mod_virtuemart_search" class="input_text act_clear" type="text" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
 $image = JURI::base().'components/com_virtuemart/assets/images/vmgeneral/search.png' ;

			if ($button) :
			    if ($imagebutton) :
			        $button = '<button type="submit" class="btn">search</button>';
			    else :
			        $button = '<button type="submit" class="btn">search</button>';
			    endif;
		

			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;

			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output.$button;
				    break;

			    case 'right' :
				    $output = $output.$button;
				    break;

			    case 'left' :
			    default :
				    $output = $button.$output;
				    break;
			endswitch;
			endif;
			
			echo $output;
?>
</div>
		<input type="hidden" name="limitstart" value="0" />
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="category" />
	  </form>

<!-- End Search Box -->
