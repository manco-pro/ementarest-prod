<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('EVE') . 'class.eventos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('COMMONS') . 'func.upload.images.php';

$oMySqliDB = new clsMySqliDB();
$oEvento = new clsEventos();
$oLojas = new clsLojas();
$stMENSAJE = false;

$loja_id = obtenerValor('loja_id', FILTER_UNSAFE_RAW);

if (!isset($_SESSION['_admin']) || $loja_id == null || !$oLojas->findId($loja_id)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stID = 0;
$stLOJA_ID = $loja_id;
$stNOMBRE = '';
$stIMAGEN = '';
$stENABLED = '';
$stINICIO = '';
$stFIN = '';

$stERROR = '';

if (isset($_POST['Criar'])) {
    $oEvento->clearEventos();
    $oEvento->clearErrors();
    $stNOMBRE = obtenerValorPOST('nombre');
    $stINICIO = obtenerValorPOST('inicio');
    $stFIN = obtenerValorPOST('fin');

 
   
//------------------------------------------------------------------------------
    //tratar imagen
    $file_name = microtime(true);
    $stIMAGEN = $file_name . '.webp';
    $stIMAGEN_B = $_POST['imageB'];


    if ($stIMAGEN_B != false) {
        $stIMAGENB = UploadImages($stIMAGEN_B, 'eventos', $file_name, 'webp');

        
        if (!$stIMAGENB) {
            $oEvento->Errors['Imagen'] = 'Tente enviar a imagem novamente.';
        }
    } else {
        $oEvento->Errors['Imagen'] = 'Carregue uma imagem para o seu evento.';
    }

//------------------------------------------------------------------------------

  
    $stLOJA_ID = obtenerValorPOST('loja_id');
  
    if (isset($_POST['enabled'])) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }
    $oEvento->setNombre($stNOMBRE);
    $oEvento->setImagen($stIMAGEN);
    $oEvento->setLoja_Id($stLOJA_ID);
    $oEvento->setEnabled($stENABLED);
    $oEvento->setInicio($stINICIO);
    $oEvento->setFin($stFIN);


    if (!$oEvento->hasErrors() && $oEvento->Registrar()) {
        redireccionar(getWeb('EVE') . 'eve.modificar.php?id=' . $oEvento->getId() . '&loja_id='. $loja_id .'&cre=ok');
    }
    $stERROR = $oEvento->getErrors();
}


/* ------------------------------------------------------------------ */

$oSmarty->assign('stNOMBRE', $stNOMBRE);
$oSmarty->assign('stIMAGEN', $stIMAGEN);
$oSmarty->assign('stENABLED', $oEvento->getEnabled($stENABLED));
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stINICIO', $stINICIO);
$oSmarty->assign('stFIN', $stFIN);


$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);

$oSmarty->assign('stTITLE', 'Criar Evento');
$oSmarty->assign('stSUBTITLE', 'Titulo de evento');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('eventos/_eve.crear.tpl');
