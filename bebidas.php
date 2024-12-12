<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';
$oCatalogo = new clsCatalogos();
$oCatalogo->clearCatalogos();
$oCatalogo->clearErrors();
$_SESSION['_footerbar']='Bebidas';
$plantilla = $_SESSION['Plantilla'];

$catalogo_id = obtenerValorGET('cat');

if ($catalogo_id == false) {
    $ArrayCatalogo = $oCatalogo->GetallCatalogosHijosByLoja_bebidas_ForEmenta($_SESSION['LojaId']);
    $stRUTA = 'produtos';
    if ($ArrayCatalogo == false) {
        redireccionar(getWeb('EMENTA') . 'index.php');
    }
} else {
    redireccionar(getWeb('ementa').'index.php');
 
}
if ($oCatalogo->hasErrors()) {
    $oSmarty->assign('stMESSAGE', 'Problem on catalogs.');
    $oSmarty->display('ementa1/informacion.tpl');
    exit();
}
$oSmarty->assign('A', "nombre_" . $_SESSION['idioma'] );
$oSmarty->assign('stRUTA', $stRUTA);
$oSmarty->assign('stACTIVA', $_SESSION['_footerbar']);
$oSmarty->assign('stCATALOGOS', $ArrayCatalogo);









$oSmarty->assign('stTITULO_PAGINA', $stBEBIDAS);

$oSmarty->display('ementa'. $plantilla .'/submenu.tpl');