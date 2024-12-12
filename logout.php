<?php
	include_once './cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	session_start();
	
	if (isset($_SESSION['LojaId'])){$_SESSION = array();}

	session_destroy();
	header('Location: /landingpage/index.php');
