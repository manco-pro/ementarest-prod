<?php
	header("Content-Type: text/html; charset=utf-8");

	session_start();
	require_once getLocal('COMMONS').'func.html.inc.php';
	noCache();

	if (!isset($_SESSION['_EmpId'])){
		$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
		redireccionar(getWeb('PED').'index.php');
	}
