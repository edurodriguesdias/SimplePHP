<?php
	/**
	 *  Project: SIMPLE PHP - Framework 
	 * @author Rafael Franco <rafaelfranco@me.com>
	 */

	#include global file
	include SIMPLEPHP_PATH.'app/code/configs/global.php';

	#load the page
	$simplePHP->loadPage();

	#apply keys
	$content = $simplePHP->applyKeys($template,$keys);

    echo $content;
?>