<?php
	header("Content-Type: text/html; charset=UTF-8");

	session_start();
	
	require_once getLocal('COMMONS').'func.html.inc.php';
	noCache();
	if (!isset($_SESSION['LojaId'])){
		if (isset($_COOKIE['loja'])) {
			redireccionar(getWeb('EMENTA').'user_session.php?loja=' . $_COOKIE['loja'] );			
		}else{
			redireccionar(getWeb('EMENTA').'logout.php' );
		}
	}


	$lang = obtenerValorGET('lang');

	if ($lang != false) {
		$_SESSION['idioma'] = $lang;
	}



	if (isset($_SESSION['LojaMesa'])){
	$oSmarty->assign('stMESA', $_SESSION['LojaMesa']);
	}
	$stCARRITOACTIVO = isset($_SESSION['carrito']) ? 'S' : 'N';

	
	$oSmarty->assign('stNOMBRE_RESTO', $_SESSION['LojaNombre']);
	$oSmarty->assign('stLOGO', $_SESSION['LojaLogo']);
	$oSmarty->assign('stFACEBOOK', $_SESSION['LojaFacebook']);
	$oSmarty->assign('stINSTAGRAM', $_SESSION['LojaInstagram']);
	$oSmarty->assign('stGOOGLEMAPS', $_SESSION['LojaGoogleMaps']);
	$oSmarty->assign('stTRIPADVISOR', $_SESSION['LojaTripAdvisor']);
	$oSmarty->assign('stMORADA', $_SESSION['LojaMorada']);
	$oSmarty->assign('stLANG', $_SESSION['idioma']);
	
	$oSmarty->assign('stCARRITOACTIVO', $stCARRITOACTIVO);
	
