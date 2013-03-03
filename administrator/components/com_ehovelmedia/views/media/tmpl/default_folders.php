<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_media
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
// print_r($this->imageFolders);exit;
$folders = $this->imageFolders;
$html = '<ul class="adminformlist">';
foreach ($folders as $fol) {
	$html .= '<li class="tree_navitem"><label for="1group_6"><a href="index.php?option=com_ehovelmedia&amp;view=mediaList&amp;tmpl=component&amp;folder='.$fol->value.'" target="folderframe">'.str_replace('-', '<span class="gi">|&mdash;</span>', $fol->text).'</a></label></li>';
}
$html .= '</ul>';
echo $html;
?>
