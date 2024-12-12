<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('QR') . 'GenerateQR.php';
$oLojas = new clsLojas();

$stLOJA_ID = 0;
$arrayLojas = array();
$aValues = array();

if ($_SESSION['_admLojaId'] == 0) { //caso admin

	$arrayLojas = $oLojas->GetAllLojas();
	$stLOJA_ID = obtenerValorPOST('loja_id', FILTER_UNSAFE_RAW);
	if ($stLOJA_ID != null) {
		$oLojas->findId($stLOJA_ID);
		$mesas = $oLojas->getAllMesas();
		$aValues = GetAllQRLoja($oLojas,$mesas);
	} else {
		$stLOJA_ID = -1;
		$stTITLE = "Selecione uma loja para listar seus QR's";
	}
} else { //caso usuario
	$oLojas->findId($_SESSION['_admLojaId']);
	$mesas = $oLojas->getAllMesas();
	$aValues = GetAllQRLoja($oLojas,$mesas);
}


if (isset($_GET['pdf'])) {
	if ($_SESSION['_admLojaId'] == 0) { //caso admin
		
		$stLOJA_ID = obtenerValor('pdf', FILTER_UNSAFE_RAW);
		if ($stLOJA_ID != null) {
			$oLojas->findId($stLOJA_ID);
			$mesas = $oLojas->getAllMesas();
			$aValues = GetAllQRLoja($oLojas,$mesas);
		} 
	} else { //caso usuario
		$oLojas->findId($_SESSION['_admLojaId']);
		$mesas = $oLojas->getAllMesas();
		$aValues = GetAllQRLoja($oLojas,$mesas);
		$stLOJA_ID = $oLojas->getId();
	}
	
	GeneratePdf($aValues, $stLOJA_ID );


}


if ($stLOJA_ID != -1) {

	$stTITLE = "lista de QR's do : " . $oLojas->getNombre();
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
$oSmarty->display('QR/_qr.listar.tpl');
