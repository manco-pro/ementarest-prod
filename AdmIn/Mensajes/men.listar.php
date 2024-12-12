<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('MEN') . 'class.mensajes.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
$oLojas = new clsLojas();
$oMensajes = new clsMensajes();
$stLOJA_ID = 0;
$arrayLojas = array();
$aValues = array();

if ($_SESSION['_admLojaId'] == 0) { //caso admin

	$arrayLojas = $oLojas->GetAllLojas();
	$stLOJA_ID = obtenerValorPOST('loja_id', FILTER_UNSAFE_RAW);
	if ($stLOJA_ID != null) {
		$aValues = $oMensajes->GetAllmensajesInLoja($stLOJA_ID);
	} else {
		$stLOJA_ID = -1;
		$stTITLE = 'Selecione uma loja para listar seus mensagens';
	}
} else { //caso usuario
	$aValues = $oMensajes->GetAllmensajesInLoja($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {

	if ($_SESSION['_admLojaId'] == 0) {
		$oLojas->findId($stLOJA_ID);
	} else {
		$oLojas->findId($_SESSION['_admLojaId']);
	}

	$stTITLE = 'lista de Mensagens do : ' . $oLojas->getNombre();
	$stLOJA_ID = $oLojas->getId();
}

// resultados

/*---------------------------------------------------------------------*/
$oSmarty->assign('stSUPER_ADMIN', $_SESSION['_admin']);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stLOJAS_SELECT', HandlerSelect($arrayLojas, $stLOJA_ID, 'Lojas'));
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stTITLE', $stTITLE);
/*---------------------------------------------------------------------*/
$oSmarty->display('mensajes/_men.listar.tpl');
