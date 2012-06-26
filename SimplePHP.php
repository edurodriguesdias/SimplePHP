<?php
	/**
	 *  Project: SIMPLE PHP - Framework 
	 * @author Rafael Franco <rafaelfranco@me.com>
	 */

	#include global file
	include SIMPLEPHP_PATH.'app/code/configs/global.php';
        
	#get the controler
	$url_parameter[1] = $simplePHP->getParameter(1);
	$controler_name = ($url_parameter[1] == '') ? 'hotsite' : $url_parameter[1] ;

	#get the action
	$url_parameter[2] = $simplePHP->getParameter(2);
	$action_name = ($url_parameter[2] == '') ? 'start' : $url_parameter[2] ;

	#load the page
	$simplePHP->loadPage($controler_name,$action_name);

	#apply keys
	$content = $simplePHP->applyKeys($template,$keys);

    echo $content;
?>