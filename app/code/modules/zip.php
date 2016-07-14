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

      function zip($files = array(), $destination = 'arquivo.zip',$overwrite = false) {
         if(file_exists($destination) && !$overwrite) { return false; }
         $valid_files = array();
         if(is_array($files)) {
            foreach($files as $file) {
               if(file_exists($file)) {
                  $valid_files[] = $file;
               }
            }
         }
         if(count($valid_files)) {
            $zip = new ZipArchive();
            if($zip->open($path.$destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
               return false;
            }
            foreach($valid_files as $file) {
               $new_filename = substr($file,strrpos($file,'/') + 1);
               $zip->addFile($file,$new_filename);
            }
            $zip->close();
            header("Content-type: application/zip"); 
            header("Content-Disposition: attachment; filename={$destination}"); 
            header("Pragma: no-cache");
            header("Expires: 0");
            readfile($destination);
            ignore_user_abort(true);
            unlink($destination);
            exit;
         }
      }
}
?>
