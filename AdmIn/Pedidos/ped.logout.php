<?php
	include_once '../../cOmmOns/config.inc.php';
	require_once getLocal('COMMONS').'func.html.inc.php';

	session_start();
	
	if (isset($_SESSION['_EmpId'])){$_SESSION = array();}

	session_destroy();
	redireccionar(getWeb('PED').'ped.sesion.php');
