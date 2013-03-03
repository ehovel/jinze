<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_media
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php?option=com_easybookreloaded'); ?>" method="post" name="adminForm" id="adminForm">
    <div id="editcell">
        <table class="adminlist">
            <thead>
                <tr>
                    <th width="20">
                        <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                    </th>
                    <th width="6%">
                        <?php echo JText::_('标题'); ?>
                    </th>
                    <th width="12%">
                        <?php echo JText::_('文件'); ?>
                    </th>
                    <th>
                        <?php echo JText::_('时间'); ?>
                    </th>
                </tr>
            </thead>
            <?php
            $k = 0;
            $n = count($this->images);

            for($i = 0; $i < $n; $i++)
            {
                $row = $this->images[$i];
                $checked = JHTML::_('grid.id', $i, $row->id);
                $link = JRoute::_('index.php?option=com_easybookreloaded&controller=entry&task=edit&cid[]='.$row->id);
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td>
                        <?php echo $checked; ?>
                    </td>
                    <td>
                        <?php echo $row->name; ?>
                    </td>
                    <td>
                        <span class="hasTip" title="<?php echo $row->name ?>">
                            <image width="150" src="<?php echo is_int($row->attach_id)?'/attachment/view/'.$row->attach_id:$row->attach_id;?>" />
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <?php echo $row->date_upd;?>
                    </td>
                </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="8">
<<<<<<< HEAD
                        <?php //echo $this->pagination->getListFooter(); ?>
=======
                        <?php echo $this->pagination->getListFooter(); ?>
>>>>>>> ac367e4d9fe39b2192081c2634da77d1a41e8588
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <input type="hidden" name="option" value="com_easybookreloaded" />
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="controller" value="entry" />
    <?php echo JHTML::_('form.token'); ?>
</form>

