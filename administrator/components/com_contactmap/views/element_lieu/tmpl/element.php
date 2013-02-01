<?php 
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.9
	* Creation date: Mars 2012
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

defined('_JEXEC') or die('Restricted access'); 

?>
<form action="index.php?option=com_contactmap&amp;controller=element&amp;task=element&amp;tmpl=component&amp;object=id"; method="post" name="adminForm">
	<table  class="adminform">
		<tr>
			<td width="100%">
				<?php echo JText::_( 'JSEARCH_FILTER_LABEL' ); ?>:
				<input type="text" name="search_lieu" id="search_lieu" value="<?php echo @$this->lists['search_lieu'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'JSEARCH_FILTER_SUBMIT' ); ?></button>
				<button onclick="document.getElementById('search_lieu').value='';this.form.submit();"><?php echo JText::_( 'JSEARCH_FILTER_CLEAR' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo @$this->lists['ville'];
				echo @$this->lists['departement'];
				?>
			</td>
		</tr>
	</table>
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'JGLOBAL_DISPLAY_NUM' ); ?>
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_NOM', 'name', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_VILLE', 'ville', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th  class="title">
				<?php echo JHTML::_('grid.sort',   'GMAPFP_DEPARTEMENT', 'departement', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
			<th width="1%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort',   'ID', 'id', @$this->lists['order_Dir'], @$this->lists['order'] ); ?>
			</th>
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$row = &$this->items[$i];
		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<a style="cursor: pointer;" onclick="window.parent.jSelectArticle('<?php echo $row->id; ?>', '<?php echo str_replace(array("'", "\""), array("\\'", ""),$row->name); ?>', '<?php echo JRequest::getVar('object'); ?>');"><?php echo $row->name; ?></a>
			</td>
			<td>
				<?php echo $row->suburb; ?>
			</td>
			<td>
				<?php echo $row->state; ?>
			</td>
						</td>
			<td align="center">
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
        <tfoot>
            <tr>
                <td colspan="15">
                    <?php echo $this->pageNav->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo @$this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo @$this->lists['order_Dir']; ?>" />
		</form>
