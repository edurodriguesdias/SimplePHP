<?php
	/**
	 *  Project: SIMPLE PHP - Framework 
	 * @author Rafael Franco <rafaelfranco@me.com>
	 */
	
	#include global file
	include '../configs/global.php';
	
	#get the controler
	$url_parameter[1] = $simple->getParameter(1);
	$controler_name = ($url_parameter[1] == '') ? 'start' : $url_parameter[1] ;

	#get the action
	$url_parameter[2] = $simple->getParameter(2);
	$action_name = ($url_parameter[2] == '') ? 'main' : $url_parameter[2] ;
	
	#load the page
	$simple->loadPage($controler_name,$action_name);

?>