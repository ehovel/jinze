<?php
/**
 * ------------------------------------------------------------------------
 * JA T3v3 System Plugin
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - GNU/GPL, http://www.gnu.org/licenses/gpl.html
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites: http://www.joomlart.com - http://www.joomlancers.com
 * ------------------------------------------------------------------------
*/

// No direct access
defined('_JEXEC') or die;
?>
<?php
	$style = 'JAxhtml';
	$name = $vars['name'];
	$poss = $vars['poss'];
	$spldata = $vars['spldata'];
	$default = $vars['default'];
	$rowcls = isset($vars['row-fluid']) && $vars['row-fluid'] ? 'row-fluid':'row';
?>
	<!-- SPOTLIGHT -->
	<div class="<?php echo $rowcls ?> ja-spotlight ja-<?php echo $name ?>"<?php echo $spldata ?>>
		<?php foreach ($poss as $i => $pos): ?>
		<div class="span<?php echo $default[$i] ?>">
			<?php if ($this->countModules($pos)) : ?>
				<jdoc:include type="modules" name="<?php $this->_p($pos) ?>" style="<?php echo $style ?>" />
				<?php else: ?>
				&nbsp;
			<?php endif ?>
		</div>
		<?php endforeach ?>
	</div>
	<!-- SPOTLIGHT -->