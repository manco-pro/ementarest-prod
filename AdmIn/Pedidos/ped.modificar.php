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


$stMESA = "";
$stESTADO = '';
$stHORA_INICIO = '';
$stHORA_FIN = '';
$stCOMENTARIOS = '';
$stDETALLE_PEDIDO = array();
$stERROR = '';


/* ------------------------------------------------------------ */

$stID = obtenerValor('id');
 $oPedidos->clearPedidos();


if ((!isset($_SESSION['_admin']) || $stID == null || !$oPedidos->findId($stID))) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
//if ($_SESSION['_admin'] != 'S' && $_SESSION['_admLojaId'] != $oPedidos->getLoja_Id()) {
//    $oSmarty->assign('stTITLE', 'Acceso denegado.');
//    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
//    $oSmarty->display('_informacion.tpl');
//    exit();
//}
/* ------------------------------------------------------------ */

$stMENSAJE = false;


if (isset($_POST['Modificar'])) {
   

    $Mesa_Selected = obtenerValorPOST('MesasSelect');
    $Pedidos = obtenerValorPOST('idsSeleccionados');
    $stLOJA_ID = obtenerValor('loja_id');
    if ($Pedidos == false) {
        $oPedidos->Errors['Produtos'] = "n&atilde;o selecionou nenhum produto";
    } else {
        $arrayPedidos = explode(',', $Pedidos);
    }

    $oPedidos->setMesa_Id($Mesa_Selected);
    $oPedidos->setEmpleado_Id(0); // 0 prefijo para los administradores

    if (!$oPedidos->hasErrors() && $oPedidos->PreRegistrar($arrayPedidos, $stLOJA_ID,true)) {
        redireccionar(getWeb('PED') . 'ped.modificar.php?id=' . $stID . '&mod=ok');
    }
 

    $stERROR = $oPedidos->getErrors();

   
   
} elseif (isset($_GET['id'])) {
    //     echo '<pre>';
    //     print_r($oPedidos);
    //     echo '</pre>';

    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = $oPedidos->getErrors();
        }
    }




    $stMESA = $oPedidos->getMesa_Id();
    $stESTADO = $oPedidos->getEstado();
    $stHORA_INICIO = $oPedidos->getHora_Inicio();
    $stHORA_FIN = $oPedidos->getHora_Fin();
    $stCOMENTARIOS = $oPedidos->GetComentariosArray($oPedidos->comentarios);


    $stDETALLE_PEDIDO = $oPedidos->getDetallePedido();

    $z = 0;
    foreach ($stDETALLE_PEDIDO as $key => $value) {
        for ($i = 0; $i < $value['cantidad']; $i++) {
            $NComentario[$z]['coleccion_id'] = $value['coleccion_id'];
            $NComentario[$z]['nombre_pt'] = $value['nombre_pt'];
            $NComentario[$z]['comentario'] = $oPedidos->buscarYEliminarItem($stCOMENTARIOS, $value['nombre_pt']);
            $z++;
        }
    }

    //obtengo un coleccion id para averiguar cual es el template que esta usando la coleccion
    $template = $oPedidos->GetTemplate($NComentario[0]['coleccion_id']);

    //$stLOJA_ID = $oColecciones->GetLojaIdByColeccion($stID);
    $stLOJA_ID = $oPedidos->getLoja_Id();

    if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
        $oSmarty->assign('stTITLE', 'Modificar Produto');
        $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
        $oSmarty->display('_informacion.tpl');
        exit();
    }
} else {
    $oSmarty->assign('stTITLE', 'Modificar Produto');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


/*--------------------------------------------------------------------*/

$stCOLECCIONES  = sobreescribirEntidadesHTML($oColecciones->GetAllColByLoja_Id($stLOJA_ID, true, $template['template']));

$stMESAS = $oMySqliDB->Select('SELECT id, identificador as mesa FROM mesas WHERE loja_id = ' . $stLOJA_ID . ' ORDER BY id ASC', 'all');

/* ------------------------------------------------------------------ */


$oSmarty->assign('stID', $stID);
$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stCOLECCIONES', HandlerSelect($stCOLECCIONES, '-1', 'Produtos'));
$oSmarty->assign('stMESAS', HandlerSelect($stMESAS, $stMESA, 'Mesas'));
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stPEDIDO_DETALLE', $NComentario);
$oSmarty->assign('stESTADO', $stESTADO);
$oSmarty->assign('stHORA_INICIO', $stHORA_INICIO);
$oSmarty->assign('stHORA_FIN', $stHORA_FIN);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar Pedido');
$oSmarty->assign('stSUBTITLE', 'Formul&aacute;rio de modifica&ccedil;&atilde;o do pedido ');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
$oSmarty->assign('stBTN_ACTION_D', 'deletar');
/* --------------------------------------------------------------------- */

$oSmarty->display('pedidos/_ped.crear.tpl');