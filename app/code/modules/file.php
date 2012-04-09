<?php
   	/**
	 * Project: SIMPLE PHP - Framework 
	 * 
	 * @copyright RFTI  www.rfti.com.br
	 * @author Rafael Franco <rafael@rfti.com.br>
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
	
		public function copyFile($source) {
			$file = file_get_contents($source);
			$ext = explode('.', $source);

			$extension = $ext[(count($ext)-1)];
			$name = rand(0,1000).time();
			$arq = fopen("../public/upload_files/original/".$name.".".$extension,'a');
			fwrite($arq,$file);
			fclose($arq);
			return 'http://'.$_SERVER['HTTP_HOST']."/upload_files/original/".$name.".".$extension;
		}
		
		public function uploadFile($file,$path) {
		
			$f = explode('.',$file['name']);
			$ext = $f[count($f)-1];
			 
			$name = md5(time()).'.'.$ext;
			move_uploaded_file($file["tmp_name"], $path.$name);
			
			return $path.$name;
		}
		
		public function remove($file) {
			unlink($file);
		}
		
	}
?>
