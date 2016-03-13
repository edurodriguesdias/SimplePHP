<?php
	/**
	 * Project: SimplePHP Framework
	 * 
	 * @copyright Alphacode  www.alphacode.com.br
	 * @author Rafael Franco <simplephp@alphacode.com.br>
	 */

	/**
	 * session module
	 *
	 * @package session
	 * @author Rafael Franco
	 **/
	class session
	{
		public function __construct() 
		{
			#todo define multi domain session
			session_start();
		}
		/**
		 * Add value to an session
		 * **/
		public static function add($key,$value) {
			$_SESSION[$key] = $value;
		}

		public static function values() {
			return $_SESSION;
		}

	}
?>