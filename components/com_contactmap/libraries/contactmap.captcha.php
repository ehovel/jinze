<?php
	/*
	* ContactMap Component Google Map for Joomla! 1.6.x
	* Version 4.0
	* Creation date: Juin 2011
	* Author: Fabrice4821 - www.gmapfp.org
	* Author email: webmaster@gmapfp.org
	* License GNU/GPL
	*/

class ContactMapCaptcha
{
	function image()
	{
		// small hack to allow captcha display even if any notice or warning occurred
		$obLength = ob_get_length();
		if ($obLength !== false || $obLength > 0) {
			while (@ob_end_clean());
			if (function_exists('ob_clean')) {
				@ob_clean();
			}
		}

		@session_start();

		if (!class_exists('KCAPTCHA')) {
			require_once(JPATH_SITE.'/components/com_contactmap/libraries/kcaptcha/kcaptcha.php');
		}

		$captcha = new KCAPTCHA();
		$_SESSION['contactmap-captcha-code'] = $captcha->getKeyString();
		exit;
	}
}
?>