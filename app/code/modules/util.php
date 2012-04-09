<?php
   	/**
	 * Project: SIMPLE PHP - Framework 
	 * 
	 * @copyright RFTI  www.rfti.com.br
	 * @author Rafael Franco <rafael@rfti.com.br>
	 */

	/**
	 * util module
	 *
	 * @package util
	 * @author Rafael Franco
	 **/
	class util 
	{
		public function __construct() 
		{

		} 
		
		public function cutEnd($txt,$qtd) {
			return substr($txt,0,strlen($txt)-$qtd);
		}
		
		public function days($days = 31) {
			for($x=1;$x<=$days;$x++) {
				$return[$x] = $x;
			}
			return $return;
		}
		
		public function mounths() {
			for($x=1;$x<=12;$x++) {
				$return[$x] = $x;
			}
			return $return;
		}
		
		public function years($start,$end) {
			while($start <= $end) {
				$return[$start] = $start;
				$start++;
			}
			return $return;
		}

		public function getCurrentUrl() {
			return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		}
		
		public function getAppUrl() {
			return 'http://'.$_SERVER['HTTP_HOST'].'/';
		}
	}
	
	#developer functions
	function pr($data) 
	{
		echo '<pre>';
		print_r($data);
	} 
	function pre($data) 
	{
		pr($data);
		exit;
	}
?>
