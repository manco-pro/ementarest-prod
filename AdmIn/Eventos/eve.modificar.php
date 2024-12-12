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

/* ------------------------------------------------------------ */
$stID = obtenerValor('id', FILTER_UNSAFE_RAW);

if (!isset($_SESSION['_admin'])  || $stID == null || !$oEvento->findId($stID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
$stLOJA_ID = $oEvento->getLoja_Id();
if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
    $oSmarty->assign('stTITLE', 'Modificar Produto');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
/* ------------------------------------------------------------ */

$stID = 0;
$stNOMBRE = '';
$stIMAGEN = '';
$stENABLED = '';
$stINICIO = '';
$stFIN = '';

$stERROR = '';


if (isset($_POST['Modificar'])) {
    $stID = obtenerValorPOST('id');
    $stLOJA =  obtenerValorPOST('loja');
    $stNOMBRE = obtenerValorPOST('nombre');
    $stINICIO = obtenerValorPOST('inicio');
    $stFIN = obtenerValorPOST('fin');

    $oEvento->clearErrors();


    if (isset($_POST['enabled'])) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }




    $stIMAGEN_B = obtenerValorPOST('imageB');

    if ($stIMAGEN_B != false) {
        $file_name = microtime(true);
        $stIMAGEN = $file_name . '.webp';

        $stIMAGENB = UploadImages($stIMAGEN_B, 'eventos', $file_name, 'webp');
        if (!$stIMAGENB) {
            $oEvento->Errors['Imagen'] = 'Tente enviar a imagem novamente.';
        }
    }

    if ($oEvento->findId($stID)) {
        $oEvento->setNombre($stNOMBRE);
        $oEvento->setInicio($stINICIO);
        $oEvento->setFin($stFIN);
        $oEvento->setEnabled($stENABLED);
        $oEvento->setLoja_Id($stLOJA_ID);
        if ($stIMAGEN != '') {
            $borrado1 = DeleteIMG($oEvento->getImagen(), getLocal('images_eve'));
            $oEvento->setImagen($stIMAGEN);
        }
        if (!$oEvento->hasErrors() && $oEvento->Modificar()) {
            redireccionar('eve.listar.php?loja_id=' . $stLOJA_ID . '&mod=ok');
        } else {
            $stERROR = $oEvento->getErrors();
        }
    }
    $stERROR = $oEvento->getErrors();
} elseif (isset($_GET['id'])) {
    $stID = $_GET['id'];
    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = 'As novas senhas s&atilde;o diferentes';
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'Evento criado com sucesso';
        }
    }


    $oEvento->clearErrors();

    if (!$oEvento->findId($stID) || ($oEvento->getLoja_Id() != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S')) {
        $oSmarty->assign('stTITLE', 'Modificar Evento');
        $oSmarty->assign('stMESSAGE', $oEvento->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
    }
} else {
    $oSmarty->assign('stTITLE', 'Modificar Evento');
    $oSmarty->assign('stMESSAGE', 'Acceso denegados.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


/* --------------------------------------------------------------------- */
$oSmarty->assign('stID', $stID);
$oSmarty->assign('stNOMBRE', $oEvento->getNombre());
$oSmarty->assign('stIMAGEN', $oEvento->getImagen());
$oSmarty->assign('stENABLED', $oEvento->getEnabled($stENABLED));
$oSmarty->assign('stLOJA_ID', $oEvento->getLoja_Id());
$oSmarty->assign('stINICIO', $oEvento->getInicio());
$oSmarty->assign('stFIN', $oEvento->getFin());


$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar evento ');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de modifica&ccedil;&atilde;o do evento');
$oSmarty->assign('stBTN_ACTION', 'Modificar');

$oSmarty->assign('stBTN_ACTION_D', 'deletar');
/* --------------------------------------------------------------------- */

$oSmarty->display('eventos/_eve.crear.tpl');
