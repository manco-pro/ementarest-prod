<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('COMMONS') . 'func.upload.images.php';


$oCatalogo = new clsCatalogos();
$oColecciones = new clsColecciones();
$oLojas = new clsLojas();


$stMENSAJE = false; //??????????????????????????????????????????????????????????????

$stLOJA_ID = obtenerValor('loja_id', FILTER_UNSAFE_RAW);

if (!isset($_SESSION['_admin']) || $stLOJA_ID == null || !$oLojas->findId($stLOJA_ID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();

}
if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S') {
    $oSmarty->assign('stTITLE',  'Acceso denegado.');
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

$stDESCRIPCION_PT = '';
$stDESCRIPCION_FR = '';
$stDESCRIPCION_EN = '';
$stDESCRIPCION_ES = '';
$stDESCRIPCION_DE = '';
$stIMAGEN = '';
$stPRECIO = 0;
$stCATALOGO_ID = 0;
$stBEBIDAS_ID = '';
$stSUG_COL_ID = array();
$stDESTACADO = '';
$stENABLED = '';
$stUNIDAD = '';
$stINGREDIENTES = '';
$stINTOLERANCIAS = '';
$stCOLECCIONES = '';
$stSUGERENCIAS_COLECCIONES_IDS = '';
$stORDEN = 0;
$stORDEN_COL = 0;


$stERROR = '';
$oColecciones->clearColecciones();
$oColecciones->clearErrors();
if (isset($_POST['Criar'])) {
    
    $stNOMBRE_PT = obtenerValorPOST('nombre_pt');
    $stNOMBRE_FR = obtenerValorPOST('nombre_fr');
    $stNOMBRE_EN = obtenerValorPOST('nombre_en');
    $stNOMBRE_ES = obtenerValorPOST('nombre_es');
    $stNOMBRE_DE = obtenerValorPOST('nombre_de');

    $stDESCRIPCION_PT = obtenerValorPOST('editor_pt');
    $stDESCRIPCION_FR = obtenerValorPOST('editor_fr');
    $stDESCRIPCION_EN = obtenerValorPOST('editor_en');
    $stDESCRIPCION_ES = obtenerValorPOST('editor_es');
    $stDESCRIPCION_DE = obtenerValorPOST('editor_de');

    if (obtenerValorPOST('enabled') != false) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }

    if (obtenerValorPOST('destacado') != false) {
        $stDESTACADO = 'S';
        $stORDEN = obtenerValor('ordenSelect', FILTER_VALIDATE_INT);
    } else {
        $stDESTACADO = 'N';
    }


    $stUNIDAD  = obtenerValorPOST('unidadSelect');
    $stPRECIO =  (obtenerValorPOST('precio'));
    $stPRECIO;
    $stCATALOGO_ID = obtenerValorPOST('catalogoSelect');

    //tratar imagen
    $file_name = microtime(true);
    $stIMAGEN = $file_name . '.jpeg';
    $stIMAGEN_B = $_POST['imageB'];
    $stIMAGEN_M = $_POST['imageM'];
    $stIMAGEN_S = $_POST['imageS'];

    if ($stIMAGEN_B != false) {
        $stIMAGENB = UploadImages($stIMAGEN_B, 'colecciones', $file_name);
        $stIMAGENM = UploadImages($stIMAGEN_M, 'colecciones', 'M' . $file_name);
        $stIMAGENS = UploadImages($stIMAGEN_S, 'colecciones', 'S' . $file_name);
        if (!$stIMAGENB || !$stIMAGENM || !$stIMAGENS) {
            $oColecciones->Errors['Imagen'] = 'Tente enviar a imagem novamente.';
        }
    } else {
        $oColecciones->Errors['Imagen'] = 'Carregue uma imagem para o seu produto.';
    }

    $stINGREDIENTES = obtenerValorPOST('valoresSeleccionados');
    $stSUGERENCIAS_COLECCIONES_IDS = obtenerValorPOST('idsColSelect');

    $oColecciones->setNombre_pt($stNOMBRE_PT);
    $oColecciones->setNombre_fr($stNOMBRE_FR);
    $oColecciones->setNombre_en($stNOMBRE_EN);
    $oColecciones->setNombre_es($stNOMBRE_ES);
    $oColecciones->setNombre_de($stNOMBRE_DE);

    $oColecciones->setDescripcion_pt($stDESCRIPCION_PT);
    $oColecciones->setDescripcion_fr($stDESCRIPCION_FR);
    $oColecciones->setDescripcion_en($stDESCRIPCION_EN);
    $oColecciones->setDescripcion_es($stDESCRIPCION_ES);
    $oColecciones->setDescripcion_de($stDESCRIPCION_DE);

    $oColecciones->setImagen($stIMAGEN);
    $oColecciones->setPrecio($stPRECIO);
    $oColecciones->setCatalogo_id($stCATALOGO_ID);
    $oColecciones->setDestacado($stDESTACADO);
    $oColecciones->setEnabled($stENABLED);
    $oColecciones->setUnidad($stUNIDAD);
    $oColecciones->setIngedientes($stINGREDIENTES);
    $oColecciones->setSugerencias_Colecciones_Ids($stSUGERENCIAS_COLECCIONES_IDS);
    $oColecciones->setOrden($stORDEN);



    if (!$oColecciones->hasErrors() && $oColecciones->Registrar()) {

        redireccionar(getWeb('COL') . 'col.modificar.php?id=' . $oColecciones->getId() . '&cre=ok');
    }
    $stERROR = $oColecciones->getErrors();
    $stIMAGEN = '';
}

$stCATALOGO_SELECT = $oCatalogo->GetallCatalogosHijosByLoja($stLOJA_ID);
$stINGREDIENTES = $oColecciones->GetAllIngredientes();
//solo filtra por bebidas template = 2
$arrayBebidas = $oColecciones->GetAllColByLoja_Id_Template($stLOJA_ID, true, 2);

if ($arrayBebidas!= false) {
    $stCOLECCIONES  = sobreescribirEntidadesHTML($arrayBebidas);
}else{
$stCOLECCIONES  = array();  
}
if ($stSUGERENCIAS_COLECCIONES_IDS != '') {
   $stSUG_COL_ID = $oColecciones->GetSugerenciasBebidas($stSUGERENCIAS_COLECCIONES_IDS);
}

if ($stCATALOGO_SELECT === false) {
    $oSmarty->assign('stTITLE', 'Crear Produto');
    $oSmarty->assign('stMESSAGE', 'Primeiro deve haver pelo menos 1 cat&aacute;logo filho para criar um produto.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
$aDestacados = $oColecciones->SelectDestacados($stLOJA_ID);




$oSmarty->assign('stID', $stID);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stNOMBRE_PT', $stNOMBRE_PT);
$oSmarty->assign('stNOMBRE_FR', $stNOMBRE_FR);
$oSmarty->assign('stNOMBRE_EN', $stNOMBRE_EN);
$oSmarty->assign('stNOMBRE_ES', $stNOMBRE_ES);
$oSmarty->assign('stNOMBRE_DE', $stNOMBRE_DE);

$oSmarty->assign('stDESCRIPCION_PT', $stDESCRIPCION_PT);
$oSmarty->assign('stDESCRIPCION_FR', $stDESCRIPCION_FR);
$oSmarty->assign('stDESCRIPCION_EN', $stDESCRIPCION_EN);
$oSmarty->assign('stDESCRIPCION_ES', $stDESCRIPCION_ES);
$oSmarty->assign('stDESCRIPCION_DE', $stDESCRIPCION_DE);

$oSmarty->assign('stIMAGEN', $stIMAGEN);
$oSmarty->assign('stPRECIO', $stPRECIO);
$oSmarty->assign('stCATALOGO_SELECT', HandlerSelect($stCATALOGO_SELECT, $stCATALOGO_ID, 'Cat&aacute;logo'));
$oSmarty->assign('stBEBIDAS_ID', $stBEBIDAS_ID);
$oSmarty->assign('stSUG_COL_ID', $stSUG_COL_ID);
$oSmarty->assign('stDESTACADO', $stDESTACADO);
$oSmarty->assign('stENABLED', $oColecciones->getEnabled($stENABLED));
$oSmarty->assign('stUNIDAD', $stUNIDAD);
$oSmarty->assign('stINGREDIENTES', $stINGREDIENTES);
$oSmarty->assign('stINTOLERANCIAS', $stINTOLERANCIAS);
$oSmarty->assign('stCOLECCIONES', HandlerSelect($stCOLECCIONES, '-1', 'Produtos'));

$oSmarty->assign('stORDEN', $aDestacados);
$oSmarty->assign('stORDEN_COL', $stORDEN_COL);

$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Criar Produto');
$oSmarty->assign('stSUBTITLE', 'Nome de produto');
$oSmarty->assign('stBTN_ACTION', 'Criar');
$oSmarty->assign('stBTN_ACTION_D', '');
/* ------------------------------------------------------------------ */
$oSmarty->display('colecciones/_col.crear.tpl');
