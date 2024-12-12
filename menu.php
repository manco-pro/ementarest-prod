<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';
$oCatalogo = new clsCatalogos();
$oCatalogo->clearCatalogos();
$oCatalogo->clearErrors();
$_SESSION['_footerbar'] = 'Menu';

$plantilla = $_SESSION['Plantilla'];


    $ArrayCatalogo = $oCatalogo->GetAllCatalogosPadresByLojaForEmenta($_SESSION['LojaId']);
    $stRUTA = 'produtos';
    if ($ArrayCatalogo == false) {
        $oSmarty->assign('stMESSAGE', 'Problem on catalogs.');
        $oSmarty->display('ementa1/informacion.tpl');
        exit();
    }

if ($oCatalogo->hasErrors()) {
    $oSmarty->assign('stMESSAGE', 'Problem on catalogs.');
    $oSmarty->display('ementa1/informacion.tpl');
    exit();
}


$oSmarty->assign('stRUTA', $stRUTA);
$oSmarty->assign('A', "nombre_" . $_SESSION['idioma'] );
$oSmarty->assign('stACTIVA', $_SESSION['_footerbar']);
$oSmarty->assign('stCATALOGOS', $ArrayCatalogo);
$oSmarty->assign('stTITULO_PAGINA', $stMENU);
$oSmarty->display('ementa'. $plantilla .'/submenu.tpl');


