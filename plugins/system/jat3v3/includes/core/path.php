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
defined('_JEXEC') or die();

/**
 * T3V3Path class
 *
 * @package T3V3
 */
class T3v3Path extends JObject
{

	/**
	 * Get path in tpls folder. If found in template, use the path, else try in plugin t3v3
	 */
	public static function getPath ($file, $default = '', $relative = false) {
		$return = '';
		if (is_file (T3V3_TEMPLATE_PATH . '/' . $file)) $return = ($relative ? T3V3_TEMPLATE_REL : T3V3_TEMPLATE_PATH) . '/' . $file;
		if (!$return && is_file (T3V3_PATH . '/' . $file)) $return = ($relative ? T3V3_REL : T3V3_PATH) . '/' . $file;
		if (!$return && $default) $return = self::getPath ($default);
		return $return;
	}
 
	/**
	 * Get path in tpls folder. If found in template, use the path, else try in plugin t3v3
	 */
	public static function getUrl ($file, $default = '', $relative = false) {
		$return = '';
		if (is_file (T3V3_TEMPLATE_PATH . '/' . $file)) $return =  ($relative ? T3V3_TEMPLATE_REL : T3V3_TEMPLATE_URL) . '/' . $file;
		if (!$return && is_file (T3V3_PATH . '/' . $file)) $return =  ($relative ? T3V3_REL : T3V3_URL) . '/' . $file;
		if (!$return && $default) $return =  self::getUrl ($default);
		return $return;
	}
}