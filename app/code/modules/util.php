<?php
   	/**
	 * Project: SimplePHP Framework
	 * 
	 * @copyright Alphacode  www.alphacode.com.br
	 * @author Rafael Franco <simplephp@alphacode.com.br>
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

		public function hours() {
			for($x=0;$x<=24;$x++) {
				$return[$x.':00'] = $x.':00';
			}
			return $return;
		}
		
		public function mounths() {
			for($x=1;$x<=12;$x++) {
				$return[$x] = $x;
			}
			return $return;
		}

		public function states() {
			 $estado['Acre'] = utf8_decode('Acre');
			 $estado['Alagoas'] = utf8_decode('Alagoas');
			 $estado['Amapa'] = utf8_decode('Amapa');
			 $estado['Amazonas'] = utf8_decode('Amazonas');
			 $estado['Bahia'] = utf8_decode('Bahia');
			 $estado['Ceará'] = utf8_decode('Ceará');
			 $estado['Distrito Federal'] = utf8_decode('Distrito Federal');
			 $estado['Espírito Santo'] = utf8_decode('Espírito Santo');
			 $estado['Goiás'] = utf8_decode('Goiás');
			 $estado['Maranhão'] = utf8_decode('Maranhão');
			 $estado['Mato Grosso'] = utf8_decode('Mato Grosso');
			 $estado['Mato Grosso do Sul'] = utf8_decode('Mato Grosso do Sul');
			 $estado['Minas Gerais'] = utf8_decode('Minas Gerais');
			 $estado['Pará'] = utf8_decode('Pará');
			 $estado['Paraíba'] = utf8_decode('Paraíba');
			 $estado['Paraná'] = utf8_decode('Paraná');
			 $estado['Pernambuco'] = utf8_decode('Pernambuco');
			 $estado['Piauí'] = utf8_decode('Piauí');
			 $estado['Rio de Janeiro'] = utf8_decode('Rio de Janeiro');
			 $estado['Rio Grande do Norte'] = utf8_decode('Rio Grande do Norte');
			 $estado['Rio Grande do Sul'] = utf8_decode('Rio Grande do Sul');
			 $estado['Rondônia'] = utf8_decode('Rondônia');
			 $estado['Roraima'] = utf8_decode('Roraima');
			 $estado['Santa Catarina'] = utf8_decode('Santa Catarina');
			 $estado['São Paulo'] = utf8_decode('São Paulo');
			 $estado['Sergipe'] = utf8_decode('Sergipe');
			 $estado['Tocantins'] = utf8_decode('Tocantins');
			return $estado;
		}
		public function clubs() {
			 $estado['Corinthians'] = utf8_decode('Corinthians');
			 $estado['São Paulo'] = utf8_decode('São Paulo');
			 $estado['Palmeiras'] = utf8_decode('Palmeiras');
			 $estado['Santos'] = utf8_decode('Santos');
			
			return $estado;
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
		
		public function utf8decodeArray($array) {
			foreach($array as $key => $value) {
				$return[$key] = utf8_decode($value);
			}
			return $return;
		} 
		public function utf8encodeArray($array) {
			foreach($array as $key => $value) {
				$return[$key] = utf8_encode($value);
			}
			return $return;
		}
		public function error($msg='') {
			$msg = utf8_decode($msg);
			echo "<script>alert('$msg');history.back(-1);</script>";
			exit;
		}

		public function success($msg='',$url = '') {
			$msg = utf8_decode($msg);
			echo "<script>alert('$msg');
			window.location='$url'</script>";
			exit;
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
	function reais($value) {
		return 'R$ '.number_format($value,2,',','.');
	}
	
	function idade($birthday){
		list($year,$month,$day) = explode("-",$birthday);
		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0)
		$year_diff--;
		return $year_diff;
	}
	
?>
