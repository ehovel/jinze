<?php
/**
 * EBR - Easybook Reloaded for Joomla! 2.5
 * License: GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * Author: Viktor Vogel
 * Projectsite: http://joomla-extensions.kubik-rubik.de/ebr-easybook-reloaded
 *
 * @license GNU/GPL
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');
define('_EASYBOOK_VERSION', '2.5-5');

require_once(JPATH_COMPONENT.DS.'controller.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'content.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'smilie.php');
require_once(JPATH_COMPONENT.DS.'acl.php');
//daipengxiang 默认页面更改为表单页,而不是留言列表
if (!$controller = JRequest::getWord('controller')){
	$controller = JRequest::getWord('view');
}
if ($controller=='easybookreloaded') {
	$controller = 'entry';
}
//end 默认页面更改为表单页
if($controller)
{
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

    if(file_exists($path))
    {
        require_once $path;
    }
    else
    {
        $controller = '';
    }
}

$classname = 'EasybookReloadedController'.$controller;
$controller = new $classname();
$controller->execute(JRequest::getVar('task','add'));
$controller->redirect();
