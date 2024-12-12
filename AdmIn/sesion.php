<?php

session_start();
include_once '../cOmmOns/config.inc.php';
require_once getLocal('ADM') . 'class.administrador.inc.php';
require_once getLocal('SUS') . 'class.suscripcion.inc.php';
require_once getLocal('ALE') . 'class.alertas.inc.php';
require_once getLocal('COMMONS') . 'func.html.inc.php';
if (isset($_SESSION['_admId'])) {
    redireccionar(getWeb('ADMIN') . 'contenido.php');
}

$error = '';

$email = obtenerValorPOST('email', FILTER_VALIDATE_EMAIL);
$password = obtenerValorPOST('password', FILTER_UNSAFE_RAW);

if ($email != null && $password != null) {
    $oAdministrador = new clsAdministrador();
    $oSuscripcion = new clsSuscripciones();
    $oSuscripcion->clearErrors();
    $oAdministrador->clearErrors();
    $oAdministrador->doLogin($email, $password);
    if (!$oAdministrador->hasErrors()) {

        $_SESSION['_admId'] = $oAdministrador->getId();
        $_SESSION['_admEmail'] = $oAdministrador->getEmail();
        $_SESSION['_admNombre'] = $oAdministrador->getNombre();
        $_SESSION['_admApellido'] = $oAdministrador->getApellido();
        $_SESSION['_admTelefono'] = $oAdministrador->getTelefono();
        $_SESSION['_admLojaId'] = $oAdministrador->getLoja_Id();
        $_SESSION['_admin'] = $oAdministrador->getAdmin();
        $_SESSION['_admAlta'] = $oAdministrador->getAlta();
        //verifico que la suscripcion esta activa
       
        if ($_SESSION['_admin'] == 'N') {
            if ($oSuscripcion->GetSuscripcionActiveByLoja($_SESSION['_admLojaId'])) {
                $_SESSION['_admSuscripcion'] = $oSuscripcion->getPlano();
                $fecha_fin = $oSuscripcion->getFin();
                $fecha_actual = date('Y-m-d');
                //cuando falten 15 dias para que la suscripcion finalice lanzo alerta al dashboard
                if (strtotime($fecha_fin) - strtotime($fecha_actual) <= 1296000) {
                    $oAlertas = new clsAlertas();
                    $oAlertas->clearAlertas();
                    $oAlertas->setLoja_Id($_SESSION['_admLojaId']);
                    $oAlertas->setMensaje('La suscripcion finaliza el ' . date("d-m-Y", strtotime($fecha_fin)));
                    $oAlertas->setTipo(2);
                    $oAlertas->Registrar();
                }
            }
        }else{
            $_SESSION['_admSuscripcion'] = 'A';
        }
    }
    if ($oAdministrador->hasErrors() || $oSuscripcion->hasErrors()) {
        $error = $oAdministrador->getErrors() . $oSuscripcion->getErrors();
        session_destroy();
    } else {
        if ($_SESSION['_admin'] == 'N') {
            if ($_SESSION['_admSuscripcion'] == 'B') {
                redireccionar(getWeb('CAT') . 'cat.listar.php');
            }else{
                redireccionar(getWeb('ADMIN') . 'contenido.php');
            }
        } else {
            redireccionar(getWeb('ADMIN') . 'contenido_admin.php');
        }
    
    }
}

$_fechapie = diaSemana(date('w')) . ', ' . date('d') . ' de ' . nombresMes(date('m')) . ' de ' . date('Y');

$oSmarty->assign('_FECHAPIE', $_fechapie);
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stEMAIL', $email);
$oSmarty->assign('_stCONTENT', array());

$oSmarty->assign('stERROR', $error);
$oSmarty->display('login.tpl');
