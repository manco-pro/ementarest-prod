<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('EMP') . 'class.empleados.inc.php';

$oMySqliDB = new clsMySqliDB();
$oEmpleados = new clsEmpleados();

$stMENSAJE = false;

if (!isset($_SESSION['_admId'])) {
    $oSmarty->assign('stTITLE', 'Criar Empregado');
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
$stLOJA_ID = obtenerValor('loja_id', FILTER_UNSAFE_RAW);
$stERROR = '';

if ($stLOJA_ID != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S' ) {
    $oSmarty->assign('stTITLE', 'Modificar Produto');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


if (isset($_POST['Criar'])) {

    $stNOMBRE = $_POST['nombre'];
    $stAPELLIDO = $_POST['apellido'];
    //$stLOJA = $_POST['loja'];
    $stTELEFONO = $_POST['telefono'];
    $stPASSWORD = $_POST['password'];
    $stCPASSWORD = $_POST['confirmarPassword'];
    $stEMAIL = $_POST['email'];

    $oEmpleados->clearEmpleados();
    $oEmpleados->clearErrors();

    //$oempleados->setLoginCreacion($stLOGIN);
    $oEmpleados->setEmail($stEMAIL);
    $oEmpleados->setNombre($stNOMBRE);
    $oEmpleados->setApellido($stAPELLIDO);
    $oEmpleados->setTelefono($stTELEFONO);
    $oEmpleados->setPassword($oMySqliDB->encriptar($stPASSWORD));
    $oEmpleados->setLoja_Id($stLOJA_ID);


    if (!$oEmpleados->hasErrors() && $oEmpleados->Registrar()) {

        redireccionar(getWeb('EMP') . 'emp.modificar.php?id=' . $oEmpleados->getId() . '&cre=ok');
    }
    $stERROR = $oEmpleados->getErrors();
}
//$stLOJAS = $oMySqliDB->Select('SELECT * FROM lojas order by nombre','all');

/* ------------------------------------------------------------------ */

$oSmarty->assign('stID', $stID);
$oSmarty->assign('stNOMBRE', $stNOMBRE);
$oSmarty->assign('stAPELLIDO', $stAPELLIDO);
$oSmarty->assign('stENABLED', $stENABLED);
$oSmarty->assign('stEMAIL', $stEMAIL);
$oSmarty->assign('stTELEFONO', $stTELEFONO);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Criar empregado');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de registro de empregados');
$oSmarty->assign('stBTN_ACTION', 'Criar');
/* ------------------------------------------------------------------ */
$oSmarty->display('empleados/_emp.crear.tpl');
