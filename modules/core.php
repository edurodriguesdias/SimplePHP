<?php
	/**
 	*  Project: SIMPLE PHP - Framework 
 	* @author Rafael Franco <rafaelfranco@me.com>
 	*/

	/**
	 * core module
	 *
	 * @package core
	 * @author Rafael Franco
	 **/
	class core
	{
		public function __construct() {
			
		}
		
		/**
		 * getParameter get the url parameters
		 *
		 * @return string		
		 **/
		public function getParameter($position)
		{
			#get the url and explode to get positions
			$url = explode('/',urldecode($_SERVER['REQUEST_URI']));
            return  (count($url)>$position) ? $url[$position] :'';
		}
		
		/**
		 * loadPage function
		 *
		 * @return void
		 * @author Rafael Franco
		 **/
		public function loadPage($controler,$action)	
		{
			include '../app/control/'.$controler.'.php';
			$contol = new $controler();
			$contol->$action();
		}
		
	} // END class core
	
	
	#Auxiliar functions to help development
	/**
	 * pre function
	 *
	 * @return string
	 * @author Rafael Franco
	 **/
	function pre($data)
	{
		pr($data);
		exit;
	}
	/**
	 * pr function
	 *
	 * @return string
	 * @author Rafael Franco
	 **/
	function pr($data)
	{
		print '<pre>';
		print_r($data);
		print '</pre>';
	}
	

?>