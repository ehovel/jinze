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
            $this->items = array();
            $k = 0;
            $n = count($this->items);

            for($i = 0; $i < $n; $i++)
            {
                $row = $this->items[$i];
                $checked = JHTML::_('grid.id', $i, $row->id);
                $published = JHTML::_('grid.published', $row, $i);
                $link = JRoute::_('index.php?option=com_easybookreloaded&controller=entry&task=edit&cid[]='.$row->id);
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td>
                        <?php echo $checked; ?>
                    </td>
                    <td>
                        <?php echo $row->gbname; ?>
                    </td>
                    <td>
                        <span class="hasTip" title="<?php echo $row->gbtitle ?>">
                            <a href="<?php echo $link ?>">
                                <?php
                                if(strlen($row->gbtitle) > 45)
                                {
                                    echo substr($row->gbtitle, 0, 45)."...";
                                }
                                else
                                {
                                    echo $row->gbtitle;
                                }
                                ?>
                            </a>
                        </span>
                    </td>
                    <td>
                        <span class="hasTip" title="<?php echo $row->gbtext ?>">
                            <a href="<?php echo $link ?>">
                                <?php
                                if(strlen($row->gbtext) > 165)
                                {
                                    echo substr($row->gbtext, 0, 165)."...";
                                }
                                else
                                {
                                    echo $row->gbtext;
                                }
                                ?>
                            </a>
                        </span>
                    </td>
                    <td>
                        <?php echo JHTML::_('date', $row->gbdate, JText::_('DATE_FORMAT_LC2')); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo $row->gbvote; ?>
                    </td>
                    <td>
                        <?php
                        if($row->gbcomment)
                        {
                            if(strlen($row->gbcomment) > 75)
                            {
                                echo substr($row->gbcomment, 0, 75)."...";
                            }
                            else
                            {
                                echo $row->gbcomment;
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo $published; ?>
                    </td>
                </tr>
                <?php
                $k = 1 - $k;
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <?php echo $this->pagination->getListFooter(); ?>
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

