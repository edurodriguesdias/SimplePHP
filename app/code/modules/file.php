<?php
   	/**
	 * Project: SimplePHP Framework
	 * 
	 * @copyright Alphacode  www.alphacode.com.br
	 * @author Rafael Franco <simplephp@alphacode.com.br>
	 */

	/**
	 * file module
	 *
	 * @package file
	 * @author Rafael Franco
	 **/
	class file
	{
		public function __construct() 
		{
			
		}
	
		public function copyFile($source,$to,$name="") {
			$file = file_get_contents($source);
			$ext = explode('.', $source);

			$extension = $ext[(count($ext)-1)];
			if ($name == '') {
				$name = rand(0,1000).time();
			}

			$arq = fopen($to."/".$name.".".$extension,'a');
			fwrite($arq,$file);
			fclose($arq);
			return $name.".".$extension;
		}

		public function save($content,$to) {
			$arq = fopen($to,'w');
			fwrite($arq,$content);
			fclose($arq);
			return $to;
		}
		
		// @return: Caso dê erro no upload retorna false,
		// caso o upload seja feito retorna o nome do arquivo
		public function uploadFile($file,$path,$name="") {
		
			$f = explode('.',$file['name']);
			$ext = $f[count($f)-1];
			 
			if ( $name == "" ) {
				$name = md5(time()).rand(0,1000).'.'.$ext;
			}
			
			$sucesso = move_uploaded_file($file["tmp_name"], $path.$name);
			
			if (!$sucesso) {
				return false;
			} else {
				return $name;
			}
		}
		
		public function remove($file) {
			unlink($file);
		}
		
		public function prepare($path, $filename) {
			header('Content-Type: application/octet-stream');
		   header('Content-Disposition: attachment; filename='.$filename);
		   // header('Charset: ANSI');
		   header('Expires: 0');
		   header('Cache-Control: must-revalidate');
		   header('Pragma: public');
		   readfile($path.$filename);	
		}
	}
?>
