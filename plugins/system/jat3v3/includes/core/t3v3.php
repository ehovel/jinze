<?php

/**
 * Import T3 Library
 *
 * @param string $package    Object path that seperate by dot (.)
 *
 * @return void
 */
function t3v3import($package)
{
	$path = T3V3_ADMIN_PATH . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . strtolower($package) . '.php';
	if (file_exists($path)) {
		include_once $path;
	} else {
		trigger_error('t3v3import not found object: ' . $package, E_USER_ERROR);
	}
}

/**
 * T3v3 Class
 * Singleton class for T3v3
 */
class T3V3 {
	
	protected static $t3app = null;

	public static function getApp($tpl = null){
		if(empty(self::$t3app)){	
			$japp = JFactory::getApplication();
			self::$t3app = $japp->isAdmin() ? self::getAdmin() : self::getSite($tpl); 
		}
		
		return self::$t3app;
	}

	/**
	 * Initialize T3v3
	 */
	public static function init () {
		// load core library
		t3v3import ('core/path');
		
		$app = JFactory::getApplication();
		if (!$app->isAdmin()) {
			$jversion  = new JVersion;
			if($jversion->isCompatible('3.0')){
				// override core joomla class
				// JViewLegacy
				if (!class_exists('JViewLegacy', false)) t3v3import ('joomla30/viewlegacy');
				// JModuleHelper
				if (!class_exists('JModuleHelper', false)) t3v3import ('joomla30/modulehelper');
				// JPagination
				if (!class_exists('JPagination', false)) t3v3import ('joomla30/pagination');
			} else {
				// override core joomla class
				// JViewLegacy
				if (!class_exists('JViewLegacy', false)) t3v3import ('joomla25/view');
				// JModuleHelper
				if (!class_exists('JModuleHelper', false)) t3v3import ('joomla25/modulehelper');
				// JPagination
				if (!class_exists('JPagination', false)) t3v3import ('joomla25/pagination');
			}
		} else {
		}
	}

	public static function getAdmin(){
		t3v3import ('core/admin');
		return new T3v3Admin();
	}

	public static function getSite($tpl){
		//when on site, the JDocumentHTML parameter must be pass
		if(empty($tpl)){
			return false;
		}

		$type = 'Template'. JFactory::getApplication()->input->getCmd ('t3tp', '');
		t3v3import ('core/'.$type);

		// create global t3v3 template object 
		$class = 'T3v3'.$type;
		return new $class($tpl);
	}

	public static function cleanPath ($path) {
		$pattern = '/\w+\/\.\.\//';
		while(preg_match($pattern,$path)){
		    $path = preg_replace($pattern, '', $path);
		}
		return $path;		
	}

	public static function relativePath($path1, $path2='') {
		// absolute path
		if ($path2[0] == '/') return $path2;
		if ($path2 == '') {
		    $path2 = $path1;
		    $path1 = getcwd();
		}

		//Remove starting, ending, and double / in paths
		$path1 = trim($path1,'/');
		$path2 = trim($path2,'/');
		while (substr_count($path1, '//')) $path1 = str_replace('//', '/', $path1);
		while (substr_count($path2, '//')) $path2 = str_replace('//', '/', $path2);

		//create arrays
		$arr1 = explode('/', $path1);
		if ($arr1 == array('')) $arr1 = array();
		$arr2 = explode('/', $path2);
		if ($arr2 == array('')) $arr2 = array();
		$size1 = count($arr1);
		$size2 = count($arr2);

		//now the hard part :-p
		$path='';
		for($i=0; $i<min($size1,$size2); $i++)
		{
		    if ($arr1[$i] == $arr2[$i]) continue;
		    else $path = '../'.$path.$arr2[$i].'/';
		}
		if ($size1 > $size2)
		    for ($i = $size2; $i < $size1; $i++)
		        $path = '../'.$path;
		else if ($size2 > $size1)
		    for ($i = $size1; $i < $size2; $i++)
		        $path .= $arr2[$i].'/';

		return rtrim ($path, '/');
	}
}

T3V3::init();
?>