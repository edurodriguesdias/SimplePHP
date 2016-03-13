<?php
   	/**
	 * Project: SimplePHP Framework
	 * 
	 * @copyright Alphacode  www.alphacode.com.br
	 * @author Rafael Franco <rafael@Alphacode.com.br>
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
	
		public function copyFile($source,$to) {
			$file = file_get_contents($source);
			$ext = explode('.', $source);

			$extension = $ext[(count($ext)-1)];
			$name = rand(0,1000).time();

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
		
		public function uploadFile($file,$path) {
		
			$f = explode('.',$file['name']);
			$ext = $f[count($f)-1];
			 
			$name = md5(time()).rand(0,1000).'.'.$ext;
			move_uploaded_file($file["tmp_name"], $path.$name);
			
			return $name;
		}
		
		public function remove($file) {
			unlink($file);
		}
		
	}
?>
