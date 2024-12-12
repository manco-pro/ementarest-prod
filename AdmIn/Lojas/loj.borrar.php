<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('CAT') . 'class.catalogos.inc.php';
require_once getLocal('ADM').'class.administrador.inc.php';

$error = '';
$id = obtenerValor('id');


if ($id == null) {
	$error = 'Erro ao acessar a p&aacute;gina.';
}
if (!empty($error)) {
	$oSmarty->assign('stTITLE', 'Eliminar catalogo');
	$oSmarty->assign('stMESSAGE', $error);
	$oSmarty->display('_informacion.tpl');
	exit();
}

if (($_SESSION['_admLojaId'] != $id) && ($_SESSION['_admin'] == 'N')) {
	$oSmarty->assign('stTITLE', 'Acceso denegado.');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}

$oLojas = new clsLojas();

if (!$oLojas->findId($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oCatalogos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}
if (!$oLojas->Borrar($id)) {
	$oSmarty->assign('stTITLE', 'Eliminar produto');
	$oSmarty->assign('stMESSAGE', $oCatalogos->getErrors());
	$oSmarty->display('_informacion.tpl');
	exit();
}

$oCatalogos = new clsCatalogos();
$aCatalogos = $oCatalogos->GetAllCatByLojaId($id);
foreach ($aCatalogos as $key => $catalogo) {
	$oCatalogos->findId($catalogo['id']);
	$oCatalogos->Borrar();
}


$oAdministrador = new clsAdministrador();
$aAdminstradores = $oAdministrador->GetAllAdminsByLoja($id);
foreach ($aAdminstradores as $key => $admin) {
	$oAdministrador->findId($admin['id']);
	$oAdministrador->Borrar();
}


redireccionar(getWeb('LOJ') . 'loj.listar.php');