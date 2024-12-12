<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('COMMONS') . 'func.upload.images.php';

$oMySqliDB = new clsMySqliDB();
$oCatalogo = new clsCatalogos();
$oLojas = new clsLojas();
$stNIVEL_BLOCK = false;
/* ------------------------------------------------------------ */

$loja_id = obtenerValor('loja_id', FILTER_UNSAFE_RAW);

if (!isset($_SESSION['_admin'])  || $loja_id == null || !$oLojas->findId($loja_id)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
/* ------------------------------------------------------------ */

$stMENSAJE = false;

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

if (isset($_POST['Modificar'])) {
    $oCatalogo->clearErrors();
    $stID = obtenerValorPOST('id');

    $stNOMBRE_PT = obtenerValorPOST('nombre_pt');
    $stNOMBRE_FR = obtenerValorPOST('nombre_fr');
    $stNOMBRE_EN = obtenerValorPOST('nombre_en');
    $stNOMBRE_ES = obtenerValorPOST('nombre_es');
    $stNOMBRE_DE = obtenerValorPOST('nombre_de');
    $stNIVEL = obtenerValorPOST('nivelSelect');
    if ($stNIVEL === null) {
        $stNIVEL = 0;
    }

    //TRATAR img

    $stIMAGEN_B = obtenerValorPOST('imageB');

    if ($stIMAGEN_B != false) {
        $file_name = microtime(true);
        $stIMAGEN = $file_name . '.jpeg';
        $stIMAGEN_M = obtenerValorPOST('imageM');
        $stIMAGEN_S = obtenerValorPOST('imageS');

        $stIMAGENB = UploadImages($stIMAGEN_B, 'catalogos', $file_name);
        $stIMAGENM = UploadImages($stIMAGEN_M, 'catalogos', 'M' . $file_name);
        $stIMAGENS = UploadImages($stIMAGEN_S, 'catalogos', 'S' . $file_name);


        if (!$stIMAGENB || !$stIMAGENM || !$stIMAGENS) {
            $oCatalogo->Errors['Imagen'] = 'Tente enviar a imagem novamente.';
        }
    }


    $stTEMPLATE = obtenerValorPOST('templateSelect');
    $stLOJA_ID = obtenerValorPOST('loja_id');
    $stHORA_DESDE = obtenerValorPOST('hora_desde');
    $stHORA_HASTA = obtenerValorPOST('hora_hasta');

    if (isset($_POST['enabled'])) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }
    if ($oCatalogo->findId($stID)) {

        $oCatalogo->setNombre_pt($stNOMBRE_PT);
        $oCatalogo->setNombre_fr($stNOMBRE_FR);
        $oCatalogo->setNombre_en($stNOMBRE_EN);
        $oCatalogo->setNombre_es($stNOMBRE_ES);
        $oCatalogo->setNombre_de($stNOMBRE_DE);
        $oCatalogo->setNivel($stNIVEL);

        if ($stIMAGEN != '') {

            $borrado1 = DeleteIMG($oCatalogo->getImagen(), getLocal('images') . 'catalogos/');
            $borrado2 = DeleteIMG('M' . $oCatalogo->getImagen(), getLocal('images') . 'catalogos/');
            $borrado3 = DeleteIMG('S' . $oCatalogo->getImagen(), getLocal('images') . 'catalogos/');

            $oCatalogo->setImagen($stIMAGEN);
        }
        //envio el nivel para que le asigne el template del catalogo pai
        $oCatalogo->setTemplate($stNIVEL);
        $oCatalogo->setLoja_Id($stLOJA_ID);
        $oCatalogo->setHora_Desde($stHORA_DESDE);
        $oCatalogo->setHora_Hasta($stHORA_HASTA);
        $oCatalogo->setEnabled($stENABLED);
        //        echo '<pre>';
        //        print_r($oCatalogo);
        //        echo '</pre>';    

        if (!$oCatalogo->hasErrors() && $oCatalogo->Modificar()) {

            redireccionar(getWeb('CAT') . 'cat.modificar.php?id=' . $stID . '&loja_id=' . $stLOJA_ID . '&mod=ok');
        }
    }
    $stERROR = $oCatalogo->getErrors();
} elseif (isset($_GET['id'])) {

    $stID = $_GET['id'];
    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = 'XXXXXXX';
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'cat&aacute;logo criada com sucesso';
        }
    }

    $oCatalogo->clearErrors();

    if (!$oCatalogo->findId($stID)) {

        $oSmarty->assign('stTITLE', 'Modificar cat&aacute;logo');
        $oSmarty->assign('stMESSAGE', $oCatalogo->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
    } elseif ($oCatalogo->getLoja_Id() != $loja_id) {
        $oSmarty->assign('stTITLE', 'Modificar cat&aacute;logo');
        $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
        $oSmarty->display('_informacion.tpl');
        exit();
    }
} else {
    $oSmarty->assign('stTITLE', 'Modificar cat&aacute;logo');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stNIVELES = array();
//$stNIVELES = array(['id' => '0', 'nombre' => 'catalogo base (pai)']);


//echo $oCatalogo->getId();


$Array_to_Merge = $oCatalogo->GetAllCatalogosPadresByLoja($loja_id);
//echo '<pre>';
//print_r($Array_to_Merge);
//echo '</pre>';
if ($Array_to_Merge != false) {
    $stNIVELES = $stNIVELES + $Array_to_Merge;
    //    $Array_to_Merge = $oCatalogo->GetAllCatalogosGroupByPH($loja_id,$oCatalogo->getId());
    //    if ($Array_to_Merge != false) {
    //        $stNIVELES = $stNIVELES + $Array_to_Merge;
    //    }
}


if ($oCatalogo->getNivel() == 0) {
    $stNIVEL_BLOCK = true;
}

$query = "SELECT * FROM templates;";
$stTEMPLATES = $oMySqliDB->Select($query, 'all');

/* --------------------------------------------------------------------- */
$oSmarty->assign('stID', $stID);
$oSmarty->assign('stNOMBRE_PT', $oCatalogo->getNombre_pt());
$oSmarty->assign('stNOMBRE_FR', $oCatalogo->getNombre_fr());
$oSmarty->assign('stNOMBRE_EN', $oCatalogo->getNombre_en());
$oSmarty->assign('stNOMBRE_ES', $oCatalogo->getNombre_es());
$oSmarty->assign('stNOMBRE_DE', $oCatalogo->getNombre_de());
$oSmarty->assign('stNIVEL_BLOCK', $stNIVEL_BLOCK);

$oSmarty->assign('stNIVELS', HandlerSelect($stNIVELES, $oCatalogo->getNivel(), 'Categoria'));
$oSmarty->assign('stIMAGEN', $oCatalogo->getImagen());
$oSmarty->assign('stENABLED', $oCatalogo->getEnabled($stENABLED));
$oSmarty->assign('stHORA_DESDE', $oCatalogo->getHora_Desde());
$oSmarty->assign('stHORA_HASTA', $oCatalogo->getHora_Hasta());
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stTEMPLATES', HandlerSelect($stTEMPLATES, $oCatalogo->getTemplate(), 'Template'));

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar cat&aacute;logo ');
$oSmarty->assign('stSUBTITLE', 'Formul&aacute;rio de modifica&ccedil;&atilde;o do cat&aacute;logo');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
$oSmarty->assign('stBTN_ACTION_D', 'deletar');
/* --------------------------------------------------------------------- */

$oSmarty->display('catalogos/_cat.crear.tpl');
