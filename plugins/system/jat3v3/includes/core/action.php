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
 * T3V3Less class compile less
 *
 * @package T3V3
 */
class T3V3Action extends JObject
{
	static public function run ($action) {
		if (method_exists('T3V3Action', $action)) {
			T3V3Action::$action();
		}
	}

	static public function lessc () {
		$path = JFactory::getApplication()->input->getString ('s');
		t3v3import ('core/less');
		$t3less = new T3V3Less;
		$css = $t3less->getCss($path);

		header("Content-Type: text/css");
		header("Content-length: ".strlen($css));
		echo $css;
		exit;
	}

	public static function lesscall(){
		JFactory::getLanguage()->load(T3V3_PLUGIN, JPATH_ADMINISTRATOR);
		t3v3import ('core/less');
		
		$result = array();
		try{
			T3V3Less::compileAll();
			$result['successful'] = JText::_('T3V3_MSG_COMPILE_SUCCESS');
		}catch(Exception $e){
			$result['error'] = sprintf(JText::_('T3V3_MSG_COMPILE_FAILURE'), $e->getMessage());
		}
		
		die(json_encode($result));
	}

	public static function theme(){
		
		JFactory::getLanguage()->load(T3V3_PLUGIN, JPATH_ADMINISTRATOR);
		JFactory::getLanguage()->load('tpl_' . T3V3_TEMPLATE, JPATH_SITE);

		if(!defined('T3V3')) {
			die(json_encode(array(
				'error' => JText::_('T3V3_MSG_PLUGIN_NOT_READY')
			)));
		}

		$user = JFactory::getUser();
		$action = JFactory::getApplication()->input->getCmd('t3task', '');

		if ($action != 'thememagic' && !$user->authorise('core.manage', 'com_templates')) {
		    die(json_encode(array(
				'error' => JText::_('T3V3_MSG_NO_PERMISSION')
			)));
		}
		
		if(empty($action)){
			die(json_encode(array(
				'error' => JText::_('T3V3_MSG_UNKNOW_ACTION')
			)));
		}

		t3v3import('core/theme');
		
		if(method_exists('ThemeHelper', $action)){
			ThemeHelper::$action(T3V3_TEMPLATE_PATH);	
		} else {
			die(json_encode(array(
				'error' => JText::_('T3V3_MSG_UNKNOW_ACTION')
			)));
		}
	}

	public static function positions(){
		JFactory::getLanguage()->load(T3V3_PLUGIN, JPATH_ADMINISTRATOR);

		$japp = JFactory::getApplication();
		if(!$japp->isAdmin()){
			$tpl = $japp->getTemplate(true);
		} else {

			$tplid = JFactory::getApplication()->input->getCmd('view') == 'style' ? JFactory::getApplication()->input->getCmd('id', 0) : false;
			if(!$tplid){
				die(json_encode(array(
					'error' => JText::_('T3V3_MSG_UNKNOW_ACTION')
					)));
			}

			$cache = JFactory::getCache('com_templates', '');
			if (!$templates = $cache->get('jat3tpl')) {
				// Load styles
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('id, home, template, s.params');
				$query->from('#__template_styles as s');
				$query->where('s.client_id = 0');
				$query->where('e.enabled = 1');
				$query->leftJoin('#__extensions as e ON e.element=s.template AND e.type='.$db->quote('template').' AND e.client_id=s.client_id');

				$db->setQuery($query);
				$templates = $db->loadObjectList('id');
				foreach($templates as &$template) {
					$registry = new JRegistry;
					$registry->loadString($template->params);
					$template->params = $registry;
				}
				$cache->store($templates, 'jat3tpl');
			}

			if (isset($templates[$tplid])) {
				$tpl = $templates[$tplid];
			}
			else {
				$tpl = $templates[0];
			}
		}

		$t3v3 = T3v3::getSite($tpl);
		$layout = $t3v3->getLayout();
		$t3v3->loadLayout($layout);
	}

	public static function layout(){
		JFactory::getLanguage()->load(T3V3_PLUGIN, JPATH_ADMINISTRATOR);
		if(!defined('T3V3')) {
			die(json_encode(array(
				'error' => JText::_('T3V3_MSG_PLUGIN_NOT_READY')
			)));
		}

		$action = JFactory::getApplication()->input->getCmd('t3task', '');
		if(empty($action)){
			die(json_encode(array(
				'error' => JText::_('T3V3_MSG_UNKNOW_ACTION')
			)));
		}

		if($action != 'display'){
			$user = JFactory::getUser();
			if (!$user->authorise('core.manage', 'com_templates')) {
			    die(json_encode(array(
					'error' => JText::_('T3V3_MSG_NO_PERMISSION')
				)));
			}
		}

		t3v3import('core/layout');
		
		if(method_exists('LayoutHelper', $action)){
			LayoutHelper::$action(T3V3_TEMPLATE_PATH);	
		} else {
			die(json_encode(array(
				'error' => JText::_('T3V3_MSG_UNKNOW_ACTION')
			)));
		}
	}

	static public function unittest () {
		$app = JFactory::getApplication();
		$tpl = $app->getTemplate(true);
		$t3v3 = T3V3::getApp($tpl);
		$layout = JFactory::getApplication()->input->getCmd('layout', 'default');
		ob_start();
		$t3v3->loadLayout ($layout);
		ob_clean();
		echo "Positions for layout [$layout]: <br />";
		var_dump ($t3v3->getPositions());
		exit;
	}	
}