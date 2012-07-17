<?php

	/**
	 *  Project: SIMPLE PHP - Framework 
	 * @author Rafael Franco <rafaelfranco@me.com>
	 */

	require SIMPLEPHP_PATH . 'app/code/modules/util.php';
	require SIMPLEPHP_PATH . 'app/code/modules/simplePHP.php';

	#load Simple php
	$simplePHP = new simplePHP();

	#load the page
	$simplePHP->loadPage();

	#apply keys
	$content = $simplePHP->applyKeys($template,$keys);

    echo $content;
?>