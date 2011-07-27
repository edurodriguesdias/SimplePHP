<?php
	/**
	 *  Project: SIMPLE PHP - Framework 
	 *  @author Rafael Franco <rafaelfranco@me.com>
	 * 	This is a global file
	 */

	#include configuration files
	require	'db.php';

	#load modules 
	require '../modules/core.php';

	#instance modules 
	$simple = new core();
	
?>