<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('SUS') . 'class.suscripcion.inc.php';
require_once getLocal('COMMONS') . 'func.upload.images.php';

$oMySqliDB  = new clsMySqliDB();
$oLoja      = new clsLojas();
$oSuscripcion = new clsSuscripciones();
$oCatalogo = new clsCatalogos();
$stMENSAJE  = false;

if ($_SESSION['_admId'] != 1) {
    $oSmarty->assign('stTITLE', 'Crear lojas');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stID           = 0;
$stNOMBRE       = '';
$stTELEFONO     = '';
$stNIF          = '';
$stEMPRESA      = '';
$stCPASSWORD    = '';
$stENABLED      = '';
$stEMAIL        = '';
$stMORADA       = '';
$stLOGO         = '';
$stFACEBOOK     = '';
$stINSTAGRAM    = '';
$stGOOGLEMAPS   = '';
$stTRIPADVISOR  = '';
$stFREGUESIA    = 0;
$stMESAS        = 0;
$stRUTA_EMENTA  = '';
$stPLANTILLA    = 1;

//var suscripciones
$stINICIO       = '';
$stFIN          = '';
$stTYPE         = '';
$stPLANO        = '';

$stERROR        = '';
$stFREGUESIAS = $oLoja->GetAllFreguesias();
if (isset($_POST['Criar'])) {

    $stNOMBRE       = obtenerValorPOST('nombre');
    $stTELEFONO     = obtenerValorPOST('telefono');
    $stNIF          = obtenerValorPOST('nif');
    $stEMPRESA      = obtenerValorPOST('empresa');
    $stPASSWORD     = obtenerValorPOST('password');
    $stCPASSWORD    = obtenerValorPOST('confirmarPassword');
    $stEMAIL        = obtenerValorPOST('email');
    $stMORADA       = obtenerValorPOST('morada');
    $stMESAS        = obtenerValorPOST('mesas');
    $stFREGUESIA    = obtenerValorPOST('freguesia');
    $stFACEBOOK     = obtenerValorPOST('facebook');
    $stINSTAGRAM    = obtenerValorPOST('instagram');
    $stGOOGLEMAPS   = obtenerValorPOST('googlemaps');
    $stTRIPADVISOR  = obtenerValorPOST('tripadvisor');
    $stLOGO         = obtenerValorPOST('logo');
    $stRUTA_EMENTA  = obtenerValorPOST('ruta_ementa');
    $stPLANTILLA    = obtenerValorPOST('plantilla');
    //suscripciones
    $stINICIO   = obtenerValorPOST('inicio');
    $stFIN      = obtenerValorPOST('fin');
    $stTYPE     = obtenerValorPOST('typeSelect');
    $stPLANO    = obtenerValorPOST('planosSelect');

    if (obtenerValorPOST('enabled') != null) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }


    $oLoja->clearLojas();
    $oLoja->clearErrors();

    $oLoja->setNombre($stNOMBRE);
    $oLoja->setTelefono($stTELEFONO);
    $oLoja->setNIF($stNIF);
    $oLoja->setEmpresa($stEMPRESA);
    $oLoja->setEnabled($stENABLED);
    $oLoja->setEmail($stEMAIL);
    $oLoja->setMorada($stMORADA);
    $oLoja->setMesas($stMESAS);
    $oLoja->setFreguesia($stFREGUESIA);
    $oLoja->setFacebook($stFACEBOOK);
    $oLoja->setInstagram($stINSTAGRAM);
    $oLoja->setGoogleMaps($stGOOGLEMAPS);
    $oLoja->setTripAdvisor($stTRIPADVISOR);
    $oLoja->setRuta_Ementa($stRUTA_EMENTA);
    $oLoja->setPlantilla($stPLANTILLA);
    
    //tratar imagen
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $file_name = $stLOGO;
        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid();

        if (!UploadImagesLoja($_FILES['logo'], 'logos', $file_name, $extension)) {
            $oLoja->Errors['upload'] = 'Erro ao subir a imagem';
        }
        $oLoja->setLogo($file_name . '.' . $extension);
    } else {
        $oLoja->Errors['Imagen'] = 'Carregue uma imagem para sua empresa.';
    }

    if (!$oLoja->hasErrors() && $oLoja->Registrar()) {

        $oCatalogo->clearCatalogos();
        $oCatalogo->nombre_pt = 'Comidas';
        $oCatalogo->nivel = 0;
        $oCatalogo->imagen = 'Comidas.jpg';
        $oCatalogo->template = 1;
        $oCatalogo->loja_id = $oLoja->getId();
        $oCatalogo->hora_desde = '';
        $oCatalogo->hora_hasta = '';
        $oCatalogo->enabled = 'N';

        if (!$oCatalogo->Registrar()) {
            $stERROR = $oCatalogo->getErrors();
        }
        $oCatalogo->clearCatalogos();
        $oCatalogo->nombre_pt = 'Bebidas';
        $oCatalogo->nivel = 0;
        $oCatalogo->imagen = 'Bebidas.jpg';
        $oCatalogo->template = 2;
        $oCatalogo->loja_id = $oLoja->getId();
        $oCatalogo->hora_desde = '';
        $oCatalogo->hora_hasta = '';
        $oCatalogo->enabled = 'N';

        if (!$oCatalogo->Registrar()) {
            $stERROR = $oCatalogo->getErrors();
        }


        $oSuscripcion->clearSuscripciones();
        $oSuscripcion->setInicio($stINICIO);
        $oSuscripcion->setFin($stFIN);
        $oSuscripcion->setType($stTYPE);
        $oSuscripcion->setPlano($stPLANO);
        $oSuscripcion->setLoja_Id($oLoja->getId());

        $fecha_inicio_obj = new DateTime($stINICIO);
        $fecha_fin_obj = new DateTime($stFIN);
        $fecha_verificar_obj = new DateTime();
        if ($fecha_verificar_obj >= $stINICIO && $fecha_verificar_obj <= $stFIN) {
            $oSuscripcion->setActive('S');
        } else {
            $oSuscripcion->setActive('N');
        }

        if (!$oSuscripcion->Registrar()) {
            $stERROR = $oSuscripcion->getErrors();
        }

        $oLoja->AltaMesas($oLoja->getMesas());
    }
    $stERROR = $oLoja->getErrors() . '' . $oSuscripcion->getErrors() . '' . $oCatalogo->getErrors();

    if ($stERROR == '') {
        redireccionar(getWeb('LOJ') . 'loj.modificar.php?id=' . $oLoja->getId() . '&cre=ok');
    }
}
$oSuscripcion->clearSuscripciones();
$stPLANOS = $oSuscripcion->getPlanos();
$stTIPOS = $oSuscripcion->getTipos();
$stPLANTILLAS = $oLoja->GetPlantillas();

/* ------------------------------------------------------------------ */

$oSmarty->assign('stNOMBRE',    $stNOMBRE);
$oSmarty->assign('stTELEFONO',  $stTELEFONO);
$oSmarty->assign('stNIF',       $stNIF);
$oSmarty->assign('stEMPRESA',   $stEMPRESA);
$oSmarty->assign('stENABLED',   $stENABLED);
$oSmarty->assign('stEMAIL',     $stEMAIL);
$oSmarty->assign('stMORADA',    $stMORADA);
$oSmarty->assign('stMESAS',     $stMESAS);
$oSmarty->assign('stFACEBOOK',  $stFACEBOOK);
$oSmarty->assign('stINSTAGRAM', $stINSTAGRAM);
$oSmarty->assign('stLOGO',      $stLOGO);
$oSmarty->assign('stRUTA_EMENTA', $stRUTA_EMENTA);
$oSmarty->assign('stGOOGLEMAPS', $stGOOGLEMAPS);
$oSmarty->assign('stTRIPADVISOR', $stTRIPADVISOR);
$oSmarty->assign('stERROR',     $stERROR);
$oSmarty->assign('stMENSAJE',   $stMENSAJE);
$oSmarty->assign('stFREGUESIAS', HandlerSelect($stFREGUESIAS, '', 'Freguesias'));
$oSmarty->assign('stPLANTILLAS', HandlerSelect($stPLANTILLAS, $stPLANTILLA, 'Plantillas'));
$oSmarty->assign('stPLANTILLA', $stPLANTILLA);
//suscripciones
$oSmarty->assign('stNAV_SUS_OR_LIST', 'sus');
$oSmarty->assign('stNAV_SUSCRIPCION', 'Alta da subscri&ccedil;&atilde;o');

$oSmarty->assign('stPLANOS',    HandlerSelect($stPLANOS, $stPLANO, 'Plano'));
$oSmarty->assign('stTIPOS',     HandlerSelect($stTIPOS, $stTYPE, 'Tipo'));
$oSmarty->assign('stINICIO',    $stINICIO);
$oSmarty->assign('stFIN',       $stFIN);


/* ------------------------------------------------------------------ */


$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Criar loja');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de registro de loja');
$oSmarty->assign('stBTN_ACTION', 'Criar');
/* ------------------------------------------------------------------ */
$oSmarty->display('lojas/_loj.crear.tpl');
