<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
$oLojas = new clsLojas();
$oPedidos = new clsPedidos();
$stLOJA_ID = 0;
$arrayLojas = array();
$result = array();
$aValues = array();

if (!isset($_SESSION['_admId'])) {
	$oSmarty->assign('stTITLE', 'Listar Pedidos');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}

if ($_SESSION['_admLojaId'] == 0) { //caso admin

	$arrayLojas = $oLojas->GetAllLojas();
	$stLOJA_ID = obtenerValorPOST('loja_id', FILTER_UNSAFE_RAW);
	if ($stLOJA_ID != null) {
		$aValues = $oPedidos->GetAllPedidosActivosByLoja($stLOJA_ID);
	} else {
		$stLOJA_ID = -1;
		$stTITLE = 'Selecione uma loja para listar seus Pedidos';
	}
} else { //caso usuario
	$aValues = $oPedidos->GetAllPedidosActivosByLoja($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {

	if ($_SESSION['_admLojaId'] == 0) {
		$oLojas->findId($stLOJA_ID);
	} else {
		$oLojas->findId($_SESSION['_admLojaId']);
	}

	$stTITLE = 'lista de Pedidos do : ' . $oLojas->getNombre();
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
$oSmarty->display('pedidos/_ped.listaract.tpl');
