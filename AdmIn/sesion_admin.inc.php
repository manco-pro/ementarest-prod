<?php
	header("Content-Type: text/html; charset=ISO-8859-1");

	session_start();
	require_once getLocal('COMMONS').'func.html.inc.php';
	noCache();

	if (!isset($_SESSION['_admId'])){
		
		redireccionar(getWeb('ADMIN').'index.php');
	}
