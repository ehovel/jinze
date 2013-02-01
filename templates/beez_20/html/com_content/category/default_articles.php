<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.framework');

// Create some shortcuts.
$params		= &$this->item->params;
// print_r($this->state);exit;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$menu_data_info = $this->state->params->toArray();
$title = explode('&', $menu_data_info['page_heading']);
?>
<div class="headline clearfix">
	
	<div class="hd">
		<h3 class="title"><?php echo $title[0];?></h3>
		<?php echo isset($title[1]) ? '<span>'.$title[1].'</span>' : '';?>
	</div>
	<jdoc:include type="modules" name="顶部服务热线" />
	<div class="crumb"><span>您的位置：</span><a href="/" title="">首页</a>|<em><?php echo $title[0];?></em></div>
</div>
<div class="news_list">
<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles', 1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>
	<ul>
	<?php foreach ($this->items as $i => $article) : ?>
		<li>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>">
							<?php echo $this->escape($article->title); ?>
			</a>
			<span class="date">
				<?php if ($this->params->get('list_show_date')) : ?>
					<?php echo JHtml::_('date', $article->displayDate, $this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))); ?>
				<?php endif; ?>
			</span>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<?php endif;?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
	<?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
<?php  endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
	<?php if($this->pagination->get('pages.total') > 1) : ?>
	<div class="pagination">

		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		 	<p class="counter">
				<?php echo $this->pagination->getPagesCounter(); ?>
			</p>
		<?php endif; ?>

		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
</form>
<?php  endif; ?>
