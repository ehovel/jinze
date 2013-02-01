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
	$splparams = $vars['splparams'];
	$datas = $vars['datas'];
	$cols = $vars['cols'];
	$rowcls = isset($vars['row-fluid']) && $vars['row-fluid'] ? 'row-fluid':'row';
	?>
	<!-- SPOTLIGHT -->
	<div class="ja-spotlight ja-<?php echo $name ?> <?php echo $rowcls ?>">
		<?php
		foreach ($splparams as $i => $splparam):
			$param = (object)$splparam;
		?>
			<div class="<?php echo $splparam->default ?> <?php echo ($i == 0) ? 'item-first' : (($i == $cols - 1) ? 'item-last' : '') ?>"<?php echo $datas[$i] ?>>
				<?php if ($this->countModules($param->position)) : ?>
				<jdoc:include type="modules" name="<?php echo $param->position ?>" style="<?php echo $style ?>"/>
				<?php else: ?>
				&nbsp;
				<?php endif ?>
			</div>
		<?php endforeach ?>
	</div>
<!-- SPOTLIGHT -->