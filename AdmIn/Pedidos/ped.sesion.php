<?php
session_start();
include_once '../../cOmmOns/config.inc.php';
require_once getLocal('EMP') . 'class.empleados.inc.php';
require_once getLocal('COMMONS') . 'func.html.inc.php';
if (isset($_SESSION['_EmpId'])) {
    redireccionar(getWeb('PED') . 'ped.crear_emp.php');
}


$error = '';

$email = obtenerValorPOST('email', FILTER_VALIDATE_EMAIL);
$password = obtenerValorPOST('password', FILTER_UNSAFE_RAW);

if ($email != null && $password != null) {
    $oEmpleados = new clsEmpleados();
    $oEmpleados->clearErrors();
    $oEmpleados->doLogin($email, $password);
    if (!$oEmpleados->hasErrors()) {

        $_SESSION['_EmpId'] = $oEmpleados->getId();
        $_SESSION['_EmpEmail'] = $oEmpleados->getEmail();
        $_SESSION['_EmpNombre'] = $oEmpleados->getNombre();
        $_SESSION['_EmpApellido'] = $oEmpleados->getApellido();
        $_SESSION['_EmpTelefono'] = $oEmpleados->getTelefono();
        $_SESSION['_EmpLojaId'] = $oEmpleados->getLoja_Id();
       
        if (isset($_SESSION['redirect_to'])) {
            redireccionar($_SESSION['redirect_to']);
            $_SESSION['redirect_to'] = null;

        }else{
            redireccionar(getWeb('PED') . 'ped.crear_emp.php');
        }
       
    } else {
        $error = $oEmpleados->getErrors();
    }
}

//$_fechapie = diaSemana(date('w')) . ', ' . date('d') . ' de ' . nombresMes(date('m')) . ' de ' . date('Y');

//$oSmarty->assign('_FECHAPIE', $_fechapie);
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stEMAIL', $email);
//$oSmarty->assign('_stCONTENT', array());

$oSmarty->assign('stERROR', $error);
$oSmarty->display('pedidos/_ped.login.tpl');