<?php
	/**
 	*  Project: SIMPLE PHP - Framework 
 	* @author Rafael Franco <rafaelfranco@me.com>
 	*/

	/**
	 * default controller
	 *
	 * @package core
	 * @author Rafael Franco
	 **/
	class start
	{
		public function __construct() {
			print('__construct');
		}
		/**
		 * default function
		 *
		 * @return void
		 * @author Rafael Franco
		 **/
		public function main()
		{
			print('default');
		}
	} // END class core
	
?>