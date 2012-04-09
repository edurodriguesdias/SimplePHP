<?php

	/**
	 * Project: SIMPLE PHP - Framework 
	 * 
	 * @copyright RFTI  www.rfti.com.br
	 * @author Rafael Franco <rafael@rfti.com.br>
	 */
        
	#define constants
	define('DEVEVOPMENT_URL','simplephp.local');
	define('TEST_URL','shopply.com.br.trunk');
	define('PRODUCTION_URL','shopply.com.br');

	#master access
	define('MASTER_LOGIN','admin');
	define('MASTER_PASSWD','979899');

	#start the session
	session_start();

	#load php libraries 
	#this is optional, use only if this server dont have the MDB2 installed
	include_once '../libs/MDB2.php';
	
	#load SimplePHP modules 
	require '../modules/util.php';
	require '../modules/simplePHP.php';
        
	#instance modules 
	$simplePHP = new simplePHP();
	
	#define global vars
	$template = '';
	$keys = array();
	
	#include configuration files
	require	'db.php';
	require	'template.php';
	
?>