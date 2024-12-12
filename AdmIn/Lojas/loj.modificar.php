<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('COMMONS') . 'func.upload.images.php';
require_once getLocal('SUS') . 'class.suscripcion.inc.php';
require_once getLocal('QR') . 'GenerateQR.php';

/* ------------------------------------------------------------ */
// if ($_SESSION['_admId'] != 1) {
//     $oSmarty->assign('stTITLE', 'Modificar Lojas');
//     $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
//     $oSmarty->display('_informacion.tpl');
//     exit();
// }
/* ------------------------------------------------------------ */
$oMySqliDB = new clsMySqliDB();
$oSuscripcion = new clsSuscripciones();
$oLoja = new clsLojas();

$stID = 0;
$stNOMBRE = '';
$stTELEFONO = '';
$stNIF = '';
$stEMPRESA = '';
$stCPASSWORD = '';
$stENABLED = '';
$stEMAIL = '';
$stMORADA = '';
$stMESAS = '';
$stFACEBOOK = '';
$stINSTAGRAM = '';
$stGOOGLEMAPS = '';
$stTRIPADVISOR = '';
$stLOGO = '';
$stRUTA_EMENTA = '';
$stPLANTILLA = '';
$stFREGUESIA = 0;
$stVALUES = '';
$stERROR = '';

//var suscripciones
$stINICIO       = '';
$stFIN          = '';
$stTYPE         = '';
$stPLANO        = '';

$actualizar_Mesas = false;
$stERROR = '';
$stMENSAJE = '';
$stFREGUESIAS = $oLoja->GetAllFreguesias();
if (isset($_POST['Modificar'])) {

    $stID = obtenerValorPOST('id');
    $stNOMBRE = obtenerValor('nombre');
    $stTELEFONO = obtenerValor('telefono');
    $stNIF = obtenerValor('nif');
    $stEMPRESA = obtenerValor('empresa');
    $stEMAIL = obtenerValor('email');
    $stMORADA = obtenerValor('morada');
    $stMESAS = obtenerValor('mesas');
    $stFREGUESIA =  obtenerValor('freguesia');
    $stFACEBOOK = obtenerValor('facebook');
    $stINSTAGRAM = obtenerValorPOST('instagram');
    $stGOOGLEMAPS = obtenerValorPOST('googlemaps');
    $stTRIPADVISOR = obtenerValorPOST('tripadvisor');
    $stRUTA_EMENTA = obtenerValorPOST('ruta_ementa');
    $stPLANTILLA = obtenerValorPOST('plantilla');

    //suscripciones
    $stINICIO   = obtenerValorPOST('inicio');
    $stFIN      = obtenerValorPOST('fin');
    $stTYPE     = obtenerValorPOST('typeSelect');
    $stPLANO    = obtenerValorPOST('planosSelect');


    $oLoja->clearErrors();

    if ($oLoja->findId($stID)) {

        $oLoja->setNombre($stNOMBRE);
        $oLoja->setTelefono($stTELEFONO);
        $oLoja->setNIF($stNIF);
        $oLoja->setEmpresa($stEMPRESA);

        $oLoja->setEmail($stEMAIL);
        $oLoja->setMorada($stMORADA);
        $oLoja->setFreguesia($stFREGUESIA);
        $oLoja->setFacebook($stFACEBOOK);
        $oLoja->setInstagram($stINSTAGRAM);
        $oLoja->setGoogleMaps($stGOOGLEMAPS);
        $oLoja->setTripAdvisor($stTRIPADVISOR);
        $oLoja->setPlantilla($stPLANTILLA);

        if ($_SESSION['_admin'] === 'S') {

            $stENABLED = obtenerValorPOST('enabled');
            if ($stENABLED != null) {
                $stENABLED = 'S';
            } else {
                $stENABLED = 'N';
            }
            $oLoja->setEnabled($stENABLED);
            if ($stMESAS != $oLoja->getMesas()) {
                $actualizar_Mesas = true;
            }
            $oLoja->setMesas($stMESAS);
            $oLoja->setRuta_Ementa($stRUTA_EMENTA);
        }

        //tratar imagen
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
            $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $file_name = uniqid();
            if (strtolower($extension) != 'png') {
                $oLoja->Errors['upload'] = 'A imagem deve ser PNG';
            } else {
                if (!UploadImagesLoja($_FILES['logo'], 'logos', $file_name, $extension)) {
                    $oLoja->Errors['upload'] = 'Erro ao subir a imagem';
                } else {
                    DeleteIMG($oLoja->getLogo(), getLocal('LOGOS'));
                }
                $file_name . '.' . $extension;
                $oLoja->setLogo($file_name . '.' . $extension);
            }
        }

        if ($_SESSION['_admin'] === 'S') {
            if (!$oLoja->hasErrors() && $oLoja->Modificar_ADM()) {

                if ($actualizar_Mesas) {
                    $oLoja->ActualizarMesas($oLoja->getMesas());
                    DeleteAllQrByLojaId($oLoja->getId());
                }
                //suscripciones
                $oSuscripcion->clearSuscripciones();
                $oSuscripcion->GetSuscripcionActiveByLoja($oLoja->getId());
                $oSuscripcion->setInicio($stINICIO);
                $oSuscripcion->setFin($stFIN);
                $oSuscripcion->setType($stTYPE);
                $oSuscripcion->setPlano($stPLANO);
                $oSuscripcion->setLoja_Id($oLoja->getId());

                $fecha_inicio_obj = new DateTime($stINICIO);
                $fecha_fin_obj = new DateTime($stFIN);
                $fecha_verificar_obj = new DateTime();
                if ($fecha_verificar_obj >= $fecha_inicio_obj && $fecha_verificar_obj <= $fecha_fin_obj) {
                    $oSuscripcion->setActive('S');
                } else {
                    $oSuscripcion->setActive('N');
                }

                if (!$oSuscripcion->Modificar()) {
                    $stERROR = $oSuscripcion->getErrors();
                }

                redireccionar(getWeb('LOJ') . 'loj.modificar.php?id=' . $stID . '&mod=ok');
            }
        } else {
            if (!$oLoja->hasErrors() && $oLoja->Modificar()) {
                redireccionar(getWeb('LOJ') . 'loj.modificar.php?id=' . $stID . '&mod=ok');
            }
        }
    }

    $stERROR = $oLoja->getErrors();
} elseif (isset($_GET['id'])) {

    $stID = $_GET['id'];
    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'Dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = 'As novas senhas s&atilde;o diferentes';
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'Loja criada com sucesso';
        } else {
            $stERROR = 'Erro no QR das tabelas';
        }
    }


    $oLoja->clearErrors();

    if ((!$oLoja->findId($stID)) || ($stID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S')) {

        $oSmarty->assign('stTITLE', 'Modificar Loja');
        $oSmarty->assign('stMESSAGE', $oLoja->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
    }
    $oSuscripcion->clearErrors();
    //como el findId no trae la suscripcion, la busco por el id de la loja
    $stSUSCRIPCION = $oSuscripcion->GetSuscripcionByLoja($oLoja->getId());
} else {
    $oSmarty->assign('stTITLE', 'Modificar Loja');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stPLANOS = $oSuscripcion->getPlanos();
$stTIPOS = $oSuscripcion->getTipos();
$stPLANTILLAS = $oLoja->GetPlantillas();

/* --------------------------------------------------------------------- */
$oSmarty->assign('stID', $stID);
$oSmarty->assign('stNOMBRE', $oLoja->getNombre());
$oSmarty->assign('stTELEFONO', $oLoja->getTelefono());
$oSmarty->assign('stNIF', $oLoja->getNIF());
$oSmarty->assign('stEMPRESA', $oLoja->getEmpresa());
$oSmarty->assign('stENABLED', $oLoja->getEnabled());
$oSmarty->assign('stEMAIL', $oLoja->getEmail());
$oSmarty->assign('stMORADA', $oLoja->getMorada());
$oSmarty->assign('stMESAS', $oLoja->getMesas());
$oSmarty->assign('stFACEBOOK',  $oLoja->getFacebook());
$oSmarty->assign('stINSTAGRAM', $oLoja->getInstagram());
$oSmarty->assign('stLOGO', $oLoja->getLogo());
$oSmarty->assign('stRUTA_EMENTA', $oLoja->getRuta_Ementa());
$oSmarty->assign('stGOOGLEMAPS', $oLoja->getGoogleMaps());
$oSmarty->assign('stTRIPADVISOR', $oLoja->getTripAdvisor());
$oSmarty->assign('stPLANTILLAS', HandlerSelect($stPLANTILLAS, $oLoja->getPlantilla(), 'Plantillas'));
$oSmarty->assign('stPLANTILLA', $oLoja->getPlantilla());

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stFREGUESIAS', HandlerSelect($stFREGUESIAS, $oLoja->getFreguesia(), 'Freguesias'));
//suscripciones
$oSmarty->assign('stNAV_SUS_OR_LIST', 'list');
$oSmarty->assign('stSUSCRIPCION', $stSUSCRIPCION);
$oSmarty->assign('stNAV_SUSCRIPCION', 'Informa&ccedil;&otilde;es de  Subscri&ccedil;&atilde;o');



$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar Loja ');
$oSmarty->assign('stSUBTITLE', 'Formul&aacute;rio de modifica&ccedil;&atilde;o do loja');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
/* --------------------------------------------------------------------- */

if ($_SESSION['_admin'] === 'S') {
    $oSmarty->display('lojas/_loj.crear.tpl');
} else {
    $oSmarty->display('lojas/_loj.modificar.tpl');
}
