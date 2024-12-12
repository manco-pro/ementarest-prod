<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oMySqliDB      = new clsMySqliDB();
$oPedidos       = new clsPedidos();
$oColecciones   = new clsColecciones();
$oLojas         = new clsLojas();

$stMESAS = "";
$stERROR = '';
$stMENSAJE = '';
$arrayPedidos = array();

$loja_id = obtenerValor('loja_id', FILTER_UNSAFE_RAW);



if ((!isset($_SESSION['_admin']) || $loja_id == null || !$oLojas->findId($loja_id))) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


if (isset($_POST['Criar'])) {

    $oPedidos->clearPedidos();
    $Mesa_Selected = obtenerValorPOST('MesasSelect');
    $Pedidos = obtenerValorPOST('idsSeleccionados');
    if ($Pedidos == false) {
        $oPedidos->Errors['Produtos'] = "n&atilde;o selecionou nenhum produto";
    } else {
        $arrayPedidos = explode(',', $Pedidos);
    }

    $oPedidos->setMesa_Id($Mesa_Selected);
    $oPedidos->setEmpleado_Id(0); // 0 prefijo para los administradores
 
    if (!$oPedidos->hasErrors() && $oPedidos->PreRegistrar($arrayPedidos, $loja_id)) {
        redireccionar(getWeb('PED') . 'ped.listar.php?loja_id=' . $loja_id);
        $stERROR = $oPedidos->getErrors();
    }
    $stMENSAJE = 'Ordem Lan&ccedil;ada';
}

/*--------------------------------------------------------------------*/

$stCOLECCIONES  = sobreescribirEntidadesHTML($oColecciones->GetAllColByLoja_Id($loja_id, true));

$stMESAS = $oMySqliDB->Select('SELECT id, identificador as mesa FROM mesas WHERE loja_id = ' . $loja_id . ' ORDER BY id ASC', 'all');

/* ------------------------------------------------------------------ */

$oSmarty->assign('stERROR',     $stERROR);
$oSmarty->assign('stCOLECCIONES', HandlerSelect($stCOLECCIONES, '-1', 'Produtos'));
$oSmarty->assign('stMESAS', HandlerSelect($stMESAS, '', '------- selecione uma tabela -------'));


$oSmarty->assign('stPEDIDO_DETALLE', false);
$oSmarty->assign('stLOJA_ID', $loja_id);
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stTITLE', 'Criar Ordem');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de registro de Ordem');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('pedidos/_ped.crear.tpl');
