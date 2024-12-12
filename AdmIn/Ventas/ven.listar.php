<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('VEN') . 'class.facturacion.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
$oLojas = new clsLojas();
$oStock = new clsStock();
$oPedidos = new clsPedidos();
$oFacturas = new clsfacturas();
$stLOJA_ID = 0;
$arrayLojas = array();
$result = array();
$aValues = array();
$stSTOCK_FALTANTE = array();

$stMESES6 = json_encode(array());
$stTOTALES6 = json_encode(array());
$stNOMBRES12 = json_encode(array());
$stCANTIDAD12 = json_encode(array()); 
$stMESES12 = json_encode(array());
$stTOTALES12 = json_encode(array());
$st12PRODUCTOS_3MESES = json_encode(array());
$stNOMBRES12_3MESES = json_encode(array());
$stCANTIDAD12_3MESES = json_encode(array());



$stPORCENTAJE_BEBIDAS = 0;
$stPORCENTAJE_COMIDAS = 0;



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
		$aValues = $oFacturas->GetAllFacturasByLoja($stLOJA_ID);
	} else {
		$stLOJA_ID = -1;
		$stTITLE = 'Selecione uma loja para listar seus vendas';
	}
} else { //caso usuario
	$aValues = $oFacturas->GetAllFacturasByLoja($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {

	if ($_SESSION['_admLojaId'] == 0) {
		$oLojas->findId($stLOJA_ID);
	} else {
		$oLojas->findId($_SESSION['_admLojaId']);
	}

	$stTITLE = 'lista de Vendas do : ' . $oLojas->getNombre();
	$stLOJA_ID = $oLojas->getId();
}

//graficos-----------------------------------------------------
$stULTIMOS_12_MESES = $oFacturas->GetReportXmeses($stLOJA_ID);
if ($stULTIMOS_12_MESES != false) {
	$stMESES12 = json_encode($stULTIMOS_12_MESES['mes']);
	$stTOTALES12 = json_encode($stULTIMOS_12_MESES['total']);
}
$stULTIMOS_6_MESES = $oFacturas->GetReportXmeses($stLOJA_ID,6);
if ($stULTIMOS_6_MESES != false) {
	$stMESES6 = json_encode($stULTIMOS_6_MESES['mes']);
	$stTOTALES6 = json_encode($stULTIMOS_6_MESES['total']);
}
$stVENTASMES = $oFacturas->GetVentasMes($stLOJA_ID);
$stVENTASCANT = $oFacturas->GetVentasCantidadMes($stLOJA_ID);
$stSTOCK_FALTANTE = $oStock->GetStockMinimo($stLOJA_ID);
$stTIEMPO_PROMEDIO = $oPedidos->GetTiempoPromedioPedido($stLOJA_ID);
$ventas = $oFacturas->GetPromedioVentasMes($stLOJA_ID);


if ($ventas['total_ventas_mes']>0){
	$stPORCENTAJE_BEBIDAS = round(($ventas['total_ventas_bebidas_mes']/$ventas['total_ventas_mes'])*100,2);
	$stPORCENTAJE_COMIDAS = round(($ventas['total_ventas_comida_mes']/$ventas['total_ventas_mes'])*100,2);
}

$st12PRODUCTOS = $oFacturas->GetTop7ProductosMasVendidos($stLOJA_ID);
if ($st12PRODUCTOS != false) {
	$stNOMBRES12 = json_encode($st12PRODUCTOS['nombre']);
	$stCANTIDAD12 = json_encode($st12PRODUCTOS['cantidad']);
}
$st12PRODUCTOS_3MESES = $oFacturas->GetTop7ProductosMasVendidos($stLOJA_ID,3);
if ($st12PRODUCTOS_3MESES != false) {
	$stNOMBRES12_3MESES = json_encode($st12PRODUCTOS_3MESES['nombre']);
	$stCANTIDAD12_3MESES = json_encode($st12PRODUCTOS_3MESES['cantidad']);
}



//fin graficos-------------------------------------------------

/*---------------------------------------------------------------------*/
$oSmarty->assign('stSUPER_ADMIN', $_SESSION['_admin']);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stLOJAS_SELECT', HandlerSelect($arrayLojas, $stLOJA_ID, 'Lojas'));
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stTITLE', $stTITLE);

$oSmarty->assign('stSTOCK_FALTANTE', $stSTOCK_FALTANTE);
$oSmarty->assign('stMESES6', $stMESES6);
$oSmarty->assign('stTOTALES6', $stTOTALES6);
$oSmarty->assign('stVENTASMES', $stVENTASMES);
$oSmarty->assign('stVENTASCANT', $stVENTASCANT);
$oSmarty->assign('stTIEMPO_PROMEDIO', $stTIEMPO_PROMEDIO);
$oSmarty->assign('stPORCENTAJE_BEBIDAS', $stPORCENTAJE_BEBIDAS);
$oSmarty->assign('stPORCENTAJE_COMIDAS', $stPORCENTAJE_COMIDAS);
$oSmarty->assign('st12PRODUCTOS', $st12PRODUCTOS);
$oSmarty->assign('stNOMBRES12', $stNOMBRES12);
$oSmarty->assign('stCANTIDAD12', $stCANTIDAD12);
$oSmarty->assign('st12PRODUCTOS_3MESES', $st12PRODUCTOS_3MESES);
$oSmarty->assign('stNOMBRES12_3MESES', $stNOMBRES12_3MESES);
$oSmarty->assign('stCANTIDAD12_3MESES', $stCANTIDAD12_3MESES);





$oSmarty->assign('stMESES12', $stMESES12);
$oSmarty->assign('stTOTALES12', $stTOTALES12);

/*---------------------------------------------------------------------*/
$oSmarty->display('ventas/_ven.listar.tpl');
