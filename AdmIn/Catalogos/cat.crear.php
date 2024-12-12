<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('COMMONS') . 'func.upload.images.php';

$oMySqliDB = new clsMySqliDB();
$oCatalogo = new clsCatalogos();
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
$stNOMBRE_PT = '';
$stNOMBRE_FR = '';
$stNOMBRE_EN = '';
$stNOMBRE_ES = '';
$stNOMBRE_DE = '';
$stNIVEL = 0;
$stIMAGEN = '';
$stTEMPLATE = 0;
$stLOJA_ID = $oLojas->getId();
$stHORA_DESDE = '';
$stHORA_HASTA = '';
$stENABLED = '';

$stERROR = '';

if (isset($_POST['Criar'])) {
    $oCatalogo->clearCatalogos();
    $oCatalogo->clearErrors();
    $stNOMBRE_PT = obtenerValorPOST('nombre_pt');
    $stNOMBRE_FR = obtenerValorPOST('nombre_fr');
    $stNOMBRE_EN = obtenerValorPOST('nombre_en');
    $stNOMBRE_ES = obtenerValorPOST('nombre_es');
    $stNOMBRE_DE = obtenerValorPOST('nombre_de');
   
//------------------------------------------------------------------------------
    //tratar imagen
    $file_name = microtime(true);
    $stIMAGEN = $file_name . '.jpeg';
    $stIMAGEN_B = $_POST['imageB'];
    $stIMAGEN_M = $_POST['imageM'];
    $stIMAGEN_S = $_POST['imageS'];

    if ($stIMAGEN_B != false) {
        $stIMAGENB = UploadImages($stIMAGEN_B, 'catalogos', $file_name);
        $stIMAGENM = UploadImages($stIMAGEN_M, 'catalogos', 'M' . $file_name);
        $stIMAGENS = UploadImages($stIMAGEN_S, 'catalogos', 'S' . $file_name);
        if (!$stIMAGENB || !$stIMAGENM || !$stIMAGENS) {
            $oCatalogo->Errors['Imagen'] = 'Tente enviar a imagem novamente.';
        }
    } else {
        $oCatalogo->Errors['Imagen'] = 'Carregue uma imagem para o seu cat&aacute;logo.';
    }

//------------------------------------------------------------------------------

    $stTEMPLATE = obtenerValorPOST('templateSelect');
    $stNIVEL = obtenerValorPOST('nivelSelect');

    if (!$stNIVEL) {
        $stNIVEL = "0";
    }

    $stLOJA_ID = obtenerValorPOST('loja_id');
    $stHORA_DESDE = obtenerValorPOST('hora_desde');
    $stHORA_HASTA = obtenerValorPOST('hora_hasta');

    if (isset($_POST['enabled'])) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }
    $oCatalogo->setNombre_pt($stNOMBRE_PT);
    $oCatalogo->setNombre_fr($stNOMBRE_FR);
    $oCatalogo->setNombre_en($stNOMBRE_EN);
    $oCatalogo->setNombre_es($stNOMBRE_ES);
    $oCatalogo->setNombre_de($stNOMBRE_DE);
    $oCatalogo->setNivel($stNIVEL);
    $oCatalogo->setImagen($stIMAGEN);
    //envio el nivel para que le asigne el template del catalogo pai
    $oCatalogo->setTemplate($stNIVEL);
    $oCatalogo->setLoja_Id($stLOJA_ID);
    $oCatalogo->setHora_Desde($stHORA_DESDE);
    $oCatalogo->setHora_Hasta($stHORA_HASTA);
    $oCatalogo->setEnabled($stENABLED);

    if (!$oCatalogo->hasErrors() && $oCatalogo->Registrar()) {
        redireccionar(getWeb('CAT') . 'cat.modificar.php?id=' . $oCatalogo->getId() . '&loja_id='. $loja_id .'&cre=ok');
    }
    $stERROR = $oCatalogo->getErrors();
}

//$stNIVELES = array();
$stNIVELES = array(['id' => '-1', 'nombre' => 'catalogo']);
$Array_to_Merge = $oCatalogo->GetAllCatalogosPadresByLoja($loja_id);
if ($Array_to_Merge != false) {
    $stNIVELES = $stNIVELES + $Array_to_Merge;
//    $Array_to_Merge = $oCatalogo->GetAllCatalogosGroupByPH($loja_id);
//    if ($Array_to_Merge != false) {
//        $stNIVELES = $stNIVELES + $Array_to_Merge;
//    }
}
$query = "SELECT * FROM templates;";
$stTEMPLATES = $oMySqliDB->Select($query, 'all');
//$stTEMPLATES = array(['id' => '1', 'nombre' => 'bebidas'], ['id' => '2', 'nombre' => 'Comidas']);
//$stNIVELES = 
/* ------------------------------------------------------------------ */

$oSmarty->assign('stNOMBRE_PT', $stNOMBRE_PT);
$oSmarty->assign('stNOMBRE_FR', $stNOMBRE_FR);
$oSmarty->assign('stNOMBRE_EN', $stNOMBRE_EN);
$oSmarty->assign('stNOMBRE_ES', $stNOMBRE_ES);
$oSmarty->assign('stNOMBRE_DE', $stNOMBRE_DE);
$oSmarty->assign('stNIVELS', HandlerSelect($stNIVELES, $stNIVEL, 'Categoria'));
$oSmarty->assign('stIMAGEN', $stIMAGEN);
$oSmarty->assign('stENABLED', $oCatalogo->getEnabled($stENABLED));
$oSmarty->assign('stHORA_DESDE', $stHORA_DESDE);
$oSmarty->assign('stHORA_HASTA', $stHORA_HASTA);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stTEMPLATES', HandlerSelect($stTEMPLATES, $stTEMPLATE, 'Template'));

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);

$oSmarty->assign('stTITLE', 'Criar cat&aacute;logo');
$oSmarty->assign('stSUBTITLE', 'Titulo de cat&aacute;logo');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('catalogos/_cat.crear.tpl');
