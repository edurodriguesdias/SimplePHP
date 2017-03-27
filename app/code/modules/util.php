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
		
		public function cutEnd($txt,$qtd,$points=false) {
			$return = substr($txt,0,$qtd);
			if($points) {
				if(strlen($txt) > $qtd) {
					$return .= '...';
				}
			}
			return $return;
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

		public function ufs() {
			 $estado['AC'] = utf8_decode('AC');
			 $estado['AL'] = utf8_decode('AL');
			 $estado['AP'] = utf8_decode('AP');
			 $estado['AM'] = utf8_decode('AM');
			 $estado['BA'] = utf8_decode('BA');
			 $estado['CE'] = utf8_decode('CE');
			 $estado['DF'] = utf8_decode('DF');
			 $estado['ES'] = utf8_decode('ES');
			 $estado['GO'] = utf8_decode('GO');
			 $estado['MA'] = utf8_decode('MA');
			 $estado['MT'] = utf8_decode('MT');
			 $estado['MS'] = utf8_decode('MS');
			 $estado['MG'] = utf8_decode('MG');
			 $estado['PA'] = utf8_decode('PA');
			 $estado['PB'] = utf8_decode('PB');
			 $estado['PR'] = utf8_decode('PR');
			 $estado['PE'] = utf8_decode('PE');
			 $estado['PI'] = utf8_decode('PI');
			 $estado['RJ'] = utf8_decode('RJ');
			 $estado['RN'] = utf8_decode('RN');
			 $estado['RS'] = utf8_decode('RS');
			 $estado['RO'] = utf8_decode('RO');
			 $estado['RR'] = utf8_decode('RR');
			 $estado['SC'] = utf8_decode('SC');
			 $estado['SP'] = utf8_decode('SP');
			 $estado['SE'] = utf8_decode('SE');
			 $estado['TO'] = utf8_decode('TO');
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
		public function calculaStartPaginacao($page,$stepper) {
			return ($page == 1) ? 0 : (($page*$stepper)-$stepper);
		}
		         

		/*----
		Contagem de intervalo de dias entre datas
		Parametro 1: Dia inicial em formato datetime
		Parametro 2: Dia final em formato datetime
		Retorno: valor inteiro
		----*/
		public function countDays($initial_date='',$final_date='') {
			/*----
			Caso queira contar a partir da data atual não informar $initial_date (parametro 1)
			Caso queira contar até a data atual não informar $final_date (parametro 2)
			----*/
			if ($final_date == '') {
				$final_date = date_create($final_date);
			} else {
				$final_date = date('d/m/Y', strtotime($final_date));
				$final_date = date_create_from_format('d/m/Y',$final_date);
			}

			if ($initial_date == '') {
				$initial_date = date_create($initial_date);
			} else {
				$initial_date = date('d/m/Y', strtotime($initial_date));
				$initial_date = date_create_from_format('d/m/Y',$initial_date);
			}

			$days = date_diff($initial_date,$final_date);
			
			if ($days->invert) {
				// caso seja negativo:
				$days = '-'.$days->format('%a');
			} else {
				$days = $days->format('%a');
			}

			return $days;
		}
		

		public function calculaDistancia($lat1, $long1, $lat2, $long2) {
			
			$d2r = 0.017453292519943295769236;

			$dlong = ($long2 - $long1) * $d2r;
			$dlat = ($lat2 - $lat1) * $d2r;

			$temp_sin = sin($dlat/2.0);
			$temp_cos = cos($lat1 * $d2r);
			$temp_sin2 = sin($dlong/2.0);

			$a = ($temp_sin * $temp_sin) + ($temp_cos * $temp_cos) * ($temp_sin2 * $temp_sin2);
			$c = 2.0 * atan2(sqrt($a), sqrt(1.0 - $a));

			return 6368.1 * $c;
			
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

	function reais($value, $casas = 2) {
		return 'R$ '.number_format($value,$casas,',','.');
	}

	function p($data) {
		echo '<!--';
		if(is_array($data)) {
			foreach ($data as $key => $value) {
				echo $key .'->'.$value;
			} 
		} else {
			echo $data;
		}
		echo '-->';
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

	function formataValor($data) {

        $data = str_ireplace('R$','',$data);
        $data = str_ireplace('.','',$data);
        $data = str_ireplace(',','.',$data);

        return $data;
    }

    function timestamp($data) {
        //quebrando os valores vindo do datetimepicker e tranformando em um array
        $d = explode('/', $data);
        
        //tranformando a data escolhida em timestamp
        $data = mktime(0,0,0,$d[1],$d[0],$d[2]);
        return $data;
        
    }

    function mil($value) {

	   if($value < 1000) {
	       return $value;
	    } else {
	       return '+'.intval($value/1000).'k';
	    }
	}

	function mask($val, $mask) {
		$value = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++) {
			if($mask[$i] == '#') {
				if(isset($val[$k]))
				$value .= $val[$k++];
			}
			else {
				if(isset($mask[$i])) {
					$value .= $mask[$i];
				}
			}
		}
		return $value;
	}

	#remove todos os caracteres não alfa-numéricos da string 
	function unmask($valor) {
		$retorno = str_replace(array('R$',' ','.','-','_','(',')',','), '', $valor);
		return $retorno;
	}

   // Substitui todos os caracteres especiais pelas suas vogais respectivas
	function removeAcentos($string) {
      $pattern = array("'é'", "'è'", "'ë'", "'ê'", "'É'", "'È'", "'Ë'", "'Ê'", "'Ã'", "'ã'", "'á'", "'à'", "'ä'", "'â'", "'å'", "'Á'", "'À'", "'Ä'", "'Â'", "'Å'", "'ó'", "'ò'", "'ö'", "'ô'", "'Ó'", "'Ò'", "'Ö'", "'Ô'", "'í'", "'ì'", "'ï'", "'î'", "'Í'", "'Ì'", "'Ï'", "'Î'", "'ú'", "'ù'", "'ü'", "'û'", "'Ú'", "'Ù'", "'Ü'", "'Û'", "'ý'", "'ÿ'", "'Ý'", "'ø'", "'Ø'", "'œ'", "'Œ'", "'Æ'", "'ç'", "'Ç'");
		$replace = array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A', 'A', 'o', 'o', 'o', 'o', 'O', 'O', 'O', 'O', 'i', 'i', 'i', 'I', 'I', 'I', 'I', 'I', 'u', 'u', 'u', 'u', 'U', 'U', 'U', 'U', 'y', 'y', 'Y', 'o', 'O', 'a', 'A', 'A', 'c', 'C'); 

		$retorno = preg_replace($pattern, $replace, $string);
		$retorno = str_replace(' ', '_', $retorno);

      return $retorno;
   }
	// Substitui todos os caracteres especiais pelas suas vogais respectivas
	function clean($string) {
	  $retorno = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
	  return $retorno;
	}


?>
