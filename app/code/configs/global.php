<?php

	/**
	 * Project: SIMPLE PHP - Framework 
	 * 
	 * @copyright RFTI  www.rfti.com.br
	 * @author Rafael Franco <rafaelfranco@me.com>
	 */
        
	#define constants
	define('DEVEVOPMENT_URL','imoov.com.br.local');
	define('TEST_URL','imoov.com.br.trunk');
	define('PRODUCTION_URL','imoov.com.br');

	#master access
	define('MASTER_LOGIN','admin');
	define('MASTER_PASSWD','979899');

	#load php libraries 
	#this is optional, use only if this server dont have the MDB2 installed
	include_once SIMPLEPHP_PATH.'/app/code/libs/MDB2.php';
	
	#load SimplePHP modules 
	require SIMPLEPHP_PATH . '/app/code/modules/util.php';
	require SIMPLEPHP_PATH . '/app/code/modules/simplePHP.php';
        
	#instance modules 
	$simplePHP = new simplePHP();
	
	#define global vars
	$template = '';
	$keys = array();

	
?>