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


/* ------------------------------------------------------------ */

$stID = obtenerValor('id', FILTER_UNSAFE_RAW);

$oColecciones->clearErrors();

if (!isset($_SESSION['_admin']) || $stID == null || !$oColecciones->findId($stID)) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


/* ------------------------------------------------------------ */

$stMENSAJE = false;


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
$stSUGERENCIAS_COLECCIONES_IDS = '';
$stORDEN = 0;

$stERROR = '';

if (isset($_POST['Modificar'])) {
    
    
    $oColecciones->clearErrors();
    
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
    $stPRECIO =  obtenerValorPOST('precio');
    
    $stCATALOGO_ID = obtenerValorPOST('catalogoSelect');

    //tratar imagen
    

    $stIMAGEN_B = obtenerValorPOST('imageB');

    if ($stIMAGEN_B != false) {
        $file_name = microtime(true);    
        $stIMAGEN = $file_name . '.jpeg';
        $stIMAGEN_M = obtenerValorPOST('imageM');
        $stIMAGEN_S = obtenerValorPOST('imageS');

        $stIMAGENB = UploadImages($stIMAGEN_B, 'colecciones', $file_name);
        $stIMAGENM = UploadImages($stIMAGEN_M, 'colecciones', 'M' . $file_name);
        $stIMAGENS = UploadImages($stIMAGEN_S, 'colecciones', 'S' . $file_name);

        if (!$stIMAGENB || !$stIMAGENM || !$stIMAGENS) {
            $oCatalogo->Errors['Imagen'] = 'Tente enviar a imagem novamente.';
        }
    } 

    $stLOJA_ID = obtenerValorPOST('loja_id');

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

    $oColecciones->setPrecio($stPRECIO);
    $oColecciones->setCatalogo_id($stCATALOGO_ID);
    $oColecciones->setDestacado($stDESTACADO);
    $oColecciones->setEnabled($stENABLED);
    $oColecciones->setUnidad($stUNIDAD);
    $oColecciones->setIngedientes($stINGREDIENTES); 
    $oColecciones->setSugerencias_Colecciones_Ids($stSUGERENCIAS_COLECCIONES_IDS);
    $oColecciones->setOrden($stORDEN);


    if ($stIMAGEN != '') {

        $borrado1 = DeleteIMG($oColecciones->getImagen(), getLocal('images') . 'colecciones/');
        $borrado2 = DeleteIMG('M' . $oColecciones->getImagen(), getLocal('images') . 'colecciones/');
        $borrado3 = DeleteIMG('S' . $oColecciones->getImagen(), getLocal('images') . 'colecciones/');

        $oColecciones->setImagen($stIMAGEN);
    }else{
        $stIMAGEN = $oColecciones->getImagen();
    }

    if (!$oColecciones->hasErrors() && $oColecciones->Modificar()) {
            redireccionar(getWeb('COL') . 'col.modificar.php?id=' . $stID . '&mod=ok');
    }
    $stERROR = $oColecciones->getErrors();
    $stIMAGEN = '';
} elseif (isset($_GET['id'])) {

    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = $oColecciones->getErrors();
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'Produto criado com sucesso';
        }
    }

    $stSUGERENCIAS_COLECCIONES_IDS = $oColecciones->getSugerencias_Colecciones_Ids();
    $stLOJA_ID = $oColecciones->GetLojaIdByColeccion($stID);

        if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S' ) {
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
$arrayIngredientes = explode(",", $oColecciones->getIngedientes());

foreach ($stINGREDIENTES as $id => $ingrediente) {
    if (in_array($ingrediente['id'],$arrayIngredientes)){
        $stINGREDIENTES[$id]['seleccionado'] = 'checked';
    }
    
}
$aDestacados = $oColecciones->SelectDestacados($stLOJA_ID);
$stORDEN_COL = $oColecciones->getOrden();
$aDestacados[$stORDEN_COL] = $stORDEN_COL;
$aDestacados[0] = 'Ordem';
ksort($aDestacados);

/* --------------------------------------------------------------------- */
$oSmarty->assign('stID', $stID);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stNOMBRE_PT', $oColecciones->getNombre_pt());
$oSmarty->assign('stNOMBRE_FR', $oColecciones->getNombre_fr());
$oSmarty->assign('stNOMBRE_EN', $oColecciones->getNombre_en());
$oSmarty->assign('stNOMBRE_ES', $oColecciones->getNombre_es());
$oSmarty->assign('stNOMBRE_DE', $oColecciones->getNombre_de());

$oSmarty->assign('stDESCRIPCION_PT', $oColecciones->getDescripcion_pt());
$oSmarty->assign('stDESCRIPCION_FR', $oColecciones->getDescripcion_fr());
$oSmarty->assign('stDESCRIPCION_EN', $oColecciones->getDescripcion_en());
$oSmarty->assign('stDESCRIPCION_ES', $oColecciones->getDescripcion_es());
$oSmarty->assign('stDESCRIPCION_DE', $oColecciones->getDescripcion_de());

$oSmarty->assign('stIMAGEN', $oColecciones->getImagen());
$oSmarty->assign('stPRECIO', $oColecciones->getPrecio());
$oSmarty->assign('stCATALOGO_SELECT', HandlerSelect($stCATALOGO_SELECT, $oColecciones->getCatalogo_id(), 'Cat&aacute;logo'));
$oSmarty->assign('stCOLECCIONES', HandlerSelect($stCOLECCIONES, '-1', 'Produtos'));

$oSmarty->assign('stDESTACADO', $oColecciones->getDestacado());
$oSmarty->assign('stENABLED', $oColecciones->getEnabled($stENABLED));
$oSmarty->assign('stUNIDAD', $oColecciones->getUnidad());
$oSmarty->assign('stINGREDIENTES', $stINGREDIENTES);

//$oSmarty->assign('stINTOLERANCIAS', $stINTOLERANCIAS);
//$oSmarty->assign('stBEBIDAS_ID', $stBEBIDAS_ID);
$oSmarty->assign('stSUG_COL_ID', $stSUG_COL_ID);
$oSmarty->assign('stORDEN_COL', $stORDEN_COL);
$oSmarty->assign('stORDEN', $aDestacados);


$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar Produto ');
$oSmarty->assign('stSUBTITLE', 'Formul&aacute;rio de modifica&ccedil;&atilde;o do produto ');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
$oSmarty->assign('stBTN_ACTION_D', 'deletar');
/* --------------------------------------------------------------------- */

$oSmarty->display('colecciones/_col.crear.tpl');
