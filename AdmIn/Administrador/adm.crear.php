<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('ADM') . 'class.administrador.inc.php';

$oMySqliDB = new clsMySqliDB();
$oAdministrador = new clsAdministrador();
$stMENSAJE = false;

if ($_SESSION['_admId'] != 1) {
    $oSmarty->assign('stTITLE', 'Crear administrador');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stID = 0;
$stNOMBRE = '';
$stAPELLIDO = '';
$stPASSWORD = '';
$stCPASSWORD = '';
$stENABLED = '';
$stEMAIL = '';
$stTELEFONO = '';
$stLOJA = '';
$stERROR = '';

if (isset($_POST['Criar'])) {

    $stNOMBRE = $_POST['nombre'];
    $stAPELLIDO = $_POST['apellido'];
    $stEMAIL = $_POST['email'];
    $stTELEFONO = $_POST['telefono'];
    $stPASSWORD = $_POST['password'];
    $stCPASSWORD = $_POST['confirmarPassword'];
    $stLOJA = $_POST['loja'];

    if (isset($_POST['enabled'])) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }


    $oAdministrador->clearAdministrador();
    $oAdministrador->clearErrors();

    //$oAdministrador->setLoginCreacion($stLOGIN);
    $oAdministrador->setEmail($stEMAIL);
    $oAdministrador->setNombre($stNOMBRE);
    $oAdministrador->setApellido($stAPELLIDO);
    $oAdministrador->setTelefono($stTELEFONO);

    $oAdministrador->setPassword($oMySqliDB->encriptar($stPASSWORD));
    $oAdministrador->setLoja_Id($stLOJA);
    $oAdministrador->setEnabled($stENABLED);
//    echo '<pre>';
//    var_dump($oAdministrador);
//    echo '</pre>';

    if (!$oAdministrador->hasErrors() && $oAdministrador->Registrar()) {
        redireccionar(getWeb('ADM') . 'adm.modificar.php?id=' . $oAdministrador->getId() . '&cre=ok');
    }
    $stERROR = $oAdministrador->getErrors();
}
$stLOJAS = $oMySqliDB->Select('SELECT * FROM lojas order by nombre','all');

/* ------------------------------------------------------------------ */

$oSmarty->assign('stNOMBRE', $stNOMBRE);
$oSmarty->assign('stAPELLIDO', $stAPELLIDO);
$oSmarty->assign('stENABLED', $stENABLED);
$oSmarty->assign('stEMAIL', $stEMAIL);
$oSmarty->assign('stTELEFONO', $stTELEFONO);
$oSmarty->assign('stLOJAS', HandlerSelect($stLOJAS, '', 'Lojas'));
$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Criar administrador');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de registro de administrador');
$oSmarty->assign('stBTN_ACTION', 'Criar');
/* ------------------------------------------------------------------ */
$oSmarty->display('admin/_adm.crear.tpl');
