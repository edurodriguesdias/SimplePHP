<?php

/**
 * Project: SIMPLE PHP - Framework 
 * 
 * @copyright RFTI  www.rfti.com.br
 * @author Rafael Franco <rafael@rfti.com.br>
 */

/**
 *  admin class
 *
 * @package admin
 * @author Rafael Franco
 * */
class master extends simplePHP {
        public function __construct() {
         	global $keys;
         	$this->keys['header'] = file_get_contents(SIMPLEPHP_PATH.'/app/code/view/master/header.php');
            
        }
        public function _actionStart() {
         	return $this->keys;
        }
        public function _actionLogin() {
        	pre($_POST);
        }
}
?>
