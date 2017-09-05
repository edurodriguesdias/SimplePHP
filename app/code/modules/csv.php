<?php
   	/**
	 * Project: SimplePHP Framework
	 * 
	 * @author Rafael Franco <www.alphacode.com.br>
	 */

	/**
	 * csv module
	 *
	 * @package csv
	 * @author Rafael Franco
	 **/
	class csv
	{
		public function __construct() 
		{
			
		}

		public function export($data, $filename = 'arquivo.csv', $ucwords='') 
		{
			#headers
			$this->prepare($filename);
			foreach ($data[0] as $key => $value) {
				if ( $ucwords == '' ) {
					echo utf8_decode($key) .";";
				} else {
					echo utf8_decode(ucwords($key)) .";";
				}
			}
			echo "\n";
	   	foreach ($data as $item) {
	   		foreach ($item as $key => $value) {
	   			echo utf8_decode($value) .';';
	   		}
	   		echo "\n";
	   	}
		}

		private function prepare($filename) {
			    header("Pragma: public");
			    header("Expires: 0");
			    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			    header("Content-Type: application/force-download");
			    header("Content-Type: application/octet-stream");
			    header("Content-Type: application/download");
			    header("Content-Disposition: attachment;filename={$filename}");
			    header("Content-Transfer-Encoding: binary");
		}

	}
?>
