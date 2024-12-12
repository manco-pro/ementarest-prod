<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('MES') . 'class.mesas.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('QR') . 'GenerateQR.php';

$oLojas = new clsLojas();
$oMesas = new clsMesas();
$stLOJA_ID = 0;
$QRValues = array();
$arrayLojas = array();
$result = array();

if (!isset($_SESSION['_admId'])) {
	$oSmarty->assign('stTITLE', 'Listar Mesas');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}
$Cid = obtenerValor('Cid');
$Cvalue = obtenerValor('Cvalue');
if ($Cid != false && $Cvalue != false) {
    $oMesas->findId($Cid);
    $oMesas->setEnabled($Cvalue);
    if (!$oMesas->UpdateEstado()){
        $stMESSAGE = $oMesas->getErrors();
        echo 'bad';
        exit();
    
    }else{
        echo 'ok';
        exit();
    }
}

if ($_SESSION['_admLojaId'] == 0) { //caso admin

	$arrayLojas = $oLojas->GetAllLojas();
	$stLOJA_ID = obtenerValorPOST('loja_id', FILTER_UNSAFE_RAW);
	if ($stLOJA_ID != null) {
		$result = $oMesas->GetAllMesasInLoja($stLOJA_ID);
		//-------------QR---------
		$oLojas->findId($stLOJA_ID);
		$mesas = $oLojas->getAllMesas();
		$QRValues = GetAllQRLoja($oLojas,$mesas);
		//------------------------
	} else {
		$stLOJA_ID = -1;
		$stTITLE = 'Selecione uma loja para listar seus Mesas';
	}
} else { //caso usuario
	$result = $oMesas->GetAllMesasInLoja($_SESSION['_admLojaId']);
	$oLojas->findId($_SESSION['_admLojaId']);
	$mesas = $oLojas->getAllMesas();
	$QRValues = GetAllQRLoja($oLojas,$mesas);
}

if (isset($_GET['pdf'])) {
	if ($_SESSION['_admLojaId'] == 0) { //caso admin
		
		$stLOJA_ID = obtenerValor('pdf', FILTER_UNSAFE_RAW);
		if ($stLOJA_ID != null) {
			$oLojas->findId($stLOJA_ID);
			$mesas = $oLojas->getAllMesas();
			$QRValues = GetAllQRLoja($oLojas,$mesas);
		} 
	} else { //caso usuario
		$oLojas->findId($_SESSION['_admLojaId']);
		$mesas = $oLojas->getAllMesas();
		$QRValues = GetAllQRLoja($oLojas,$mesas);
		$stLOJA_ID = $oLojas->getId();
	}
	
	GeneratePdf($QRValues, $stLOJA_ID );
}



if ($stLOJA_ID != -1) {

	if ($_SESSION['_admLojaId'] == 0) {
		$oLojas->findId($stLOJA_ID);
	} else {
		$oLojas->findId($_SESSION['_admLojaId']);
	}

	$stTITLE = 'lista de Mesas do : ' . $oLojas->getNombre();
	$stLOJA_ID = $oLojas->getId();
}


if ($result != false) {
	foreach ($result as $value) {
		$Id = $value['id'];
		$aValues[$Id]['id'] = $Id;
		$aValues[$Id]['identificador']   = $value['identificador'];
		$aValues[$Id]['loja_id']   = $value['loja_id'];

		$aValues[$Id]['enabled']  = $value['enabled'];
	}           
	                   
} else {
	$aValues = array();
}











// resultados

/*---------------------------------------------------------------------*/
$oSmarty->assign('stSUPER_ADMIN', $_SESSION['_admin']);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stLOJAS_SELECT', HandlerSelect($arrayLojas, $stLOJA_ID, 'Lojas'));
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stQR_VALUES', $QRValues);
$oSmarty->assign('stTITLE', $stTITLE);
/*---------------------------------------------------------------------*/
$oSmarty->display('mesas/_mes.listar.tpl');