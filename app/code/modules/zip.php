<?php
   	/**
	 * Project: SimplePHP Framework
	 * 
	 * @author Rafael Franco <www.alphacode.com.br>
	 */

	/**
	 * ZipFile Module
	 *
	 * @package zip
	 * @author Paulo Cézar Lima
	 **/
	class zip
	{
		public function __construct() 
		{
			
		}

		/* creates a compressed zip file */
		function zip($files = array(),$destination = 'arquivo.zip',$overwrite = false) {
			//if the zip file already exists and overwrite is false, return false
			if(file_exists($destination) && !$overwrite) { return false; }
			//vars
			$valid_files = array();
			//if files were passed in...
			if(is_array($files)) {
				//cycle through each file
				foreach($files as $file) {
					//make sure the file exists
					if(file_exists($file)) {
						$valid_files[] = $file;
					}
				}
			}
			//if we have good files...
			if(count($valid_files)) {
				//create the archive
				$zip = new ZipArchive();
				if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
					return false;
				}
				//add the files
				foreach($valid_files as $file) {
					$zip->addFile($file,$file);
				}
				//debug
				//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
				// pre($zip);
				//close the zip -- done!
				$zip->close();
				header("Content-type: application/zip"); 
				header("Content-Disposition: attachment; filename=$destination"); 
				header("Pragma: no-cache");
				header("Expires: 0");
				readfile($destination);
				exit;
			}
		}
}