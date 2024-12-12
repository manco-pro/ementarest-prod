<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('PED') . 'sesion_Pedidos.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';
require_once getLocal('ALE') . 'class.alertas.inc.php';
require_once getLocal('MES') . 'class.mesas.inc.php';


$oMySqliDB  = new clsMySqliDB();
$oPedidos      = new clsPedidos();
$oColecciones  = new clsColecciones();

$stMESAS = "";
$stERROR = '';
$idsSeleccionados = '';
$stMENSAJE = '';
$Mesa_Selected = '';
$stPEDIDO_DETALLE = array();

$arrayPedidos = array();

if (!isset($_SESSION['_EmpId'])) {
    $oSmarty->assign('stTITLE', 'Pedidos');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

if (isset($_POST['Criar'])) {
    $oPedidos->clearPedidos();
    $oPedidos->clearErrors();

    $Mesa_Selected = obtenerValorPOST('MesasSelect');
    $Pedidos = obtenerValorPOST('idsSeleccionados');
    $Comentarios = obtenerValorPOST('comentarios') . "";

    if ($Pedidos == false) {
        $oPedidos->Errors['Produtos'] = "n&atilde;o selecionou nenhum produto";
    } else {
        $arrayPedidos = explode(',', $Pedidos);
    }

    /* logica para separa el array y a&ntilde;adir el comentario a nivel de pedido*/


    $oPedidos->setMesa_Id(obtenerValorPOST('MesasSelect'));
    $oPedidos->setEmpleado_Id($_SESSION['_EmpId']); //cambiar lo el ID del empleado

    if (!$oPedidos->hasErrors() && $oPedidos->PreRegistrar($arrayPedidos, $_SESSION['_EmpLojaId'])) {

        $stERROR = $oPedidos->getErrors();
    }
    $stMENSAJE = 'Ordem Lan&ccedil;ada';
} elseif (isset($_GET['idsSeleccionados'])) {
    $idsSeleccionados = obtenerValorGET('idsSeleccionados');
    $aPedidosID = explode(',', $idsSeleccionados);
    $stPEDIDO_DETALLE = $oColecciones->GetColeccionForPedidoQR($aPedidosID);
    $Mesa_Selected = obtenerValor('MesasSelect');
} elseif (isset($_POST['Excluir'])) {


    $Mesa_Selected = obtenerValorPOST('MesasSelect');
    $Pedidos = obtenerValorPOST('idsSeleccionados');

    if ($Pedidos != false) {
        $arrayPedidos = explode(',', $Pedidos);

        /* crear mensaje de notificacion para pedir que se eleminin los productos seleccionados*/
        $oMesas = new clsMesas();
        $oMesas->findId($Mesa_Selected);
        $mesaNombre = $oMesas->getIdentificador();
        $mensaje = 'Mesa: ' . $mesaNombre ;

        $mensaje = $mensaje . ' - Eliminar os produtos selecionados: ';
        foreach ($arrayPedidos as $coleccion) {
            $oColecciones->findId($coleccion);
            $mensaje = $mensaje . $oColecciones->getNombre_pt() . ' ,';
        }
        $mensaje = substr($mensaje, 0, -1);

        $mensaje = $mensaje . '. Por favor, apague os produtos selecionados.';

        

        $oAlertas = new clsAlertas();
        $oAlertas->clearAlertas();
        $oAlertas->setLoja_Id($_SESSION['_EmpLojaId']);
        $oAlertas->setMensaje($mensaje);
        $oAlertas->tipo = 5;
        $oAlertas->Registrar();

        
        $stMENSAJE = 'Pedido exclu&iacute;do solicitado';
    } else
        $stERROR = 'n&atilde;o selecionou nenhum produto';
}

/*--------------------------------------------------------------------*/

$stCOLECCIONES  = sobreescribirEntidadesHTML($oColecciones->GetAllColByLoja_Id($_SESSION['_EmpLojaId'], true));

$stMESAS = $oMySqliDB->Select('SELECT id, identificador as mesa FROM mesas WHERE loja_id = ' . $_SESSION['_EmpLojaId'] . ' ORDER BY identificador ASC', 'all');

/* ------------------------------------------------------------------ */

$oSmarty->assign('stERROR',     $stERROR);
$oSmarty->assign('stPEDIDO_DETALLE',     $stPEDIDO_DETALLE);
$oSmarty->assign('stID_SELECCIONADOS', $idsSeleccionados);
$oSmarty->assign('stCOLECCIONES', HandlerSelect($stCOLECCIONES, '-1', 'Produtos'));
$oSmarty->assign('stMESAS', HandlerSelect($stMESAS, $Mesa_Selected, 'Mesas'));

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stTITLE', 'Criar Ordem');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de registro de Ordem');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_REVERT', 'Excluir');
/* ------------------------------------------------------------------ */
$oSmarty->display('pedidos/_ped.crear_emp.tpl');
