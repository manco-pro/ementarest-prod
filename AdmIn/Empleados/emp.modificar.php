<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('EMP') . 'class.empleados.inc.php';

/* ------------------------------------------------------------ */
if (!isset($_SESSION['_admId'])) {
    $oSmarty->assign('stTITLE', 'Modificar Empregados');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
/* ------------------------------------------------------------ */
$oEmpleados = new clsEmpleados();

$stID = 0;
$stNOMBRE = '';
$stAPELLIDO = '';
$stPASSWORD = '';
$stEMAIL = '';
$stTELEFONO = '';
$stLOJA_ID = '';
$nueva = '';
$confirmacion = '';
$stERROR = '';
$stMENSAJE = '';


if (isset($_POST['Modificar'])) {
    $stID = obtenerValorPOST('id');
    $stEMAIL =  obtenerValorPOST('email');
    $stNOMBRE =  obtenerValorPOST('nombre');
    $stAPELLIDO = obtenerValorPOST('apellido');
    $stTELEFONO =  obtenerValorPOST('telefono');
    $stLOJA =  obtenerValorPOST('loja');

    $nueva = obtenerValorPOST('password');
    $confirmacion = obtenerValorPOST('confirmarPassword');

    $oEmpleados->clearErrors();
   
    if ($oEmpleados->findId($stID)) {
        $oEmpleados->setEmail($stEMAIL);
        $oEmpleados->setNombre($stNOMBRE);
        $oEmpleados->setApellido($stAPELLIDO);
        $oEmpleados->setTelefono($stTELEFONO);

        if (!$oEmpleados->hasErrors() && $oEmpleados->Modificar()) {
            if ($nueva != null && $confirmacion != null && ($nueva == $confirmacion)) {
                $oEmpleados->changePassword($nueva);
            } elseif ($nueva != '' || $confirmacion != '' && ($nueva != $confirmacion)) {
                redireccionar(getWeb('EMP') . 'emp.modificar.php?id=' . $stID . '&mod=bad');
            }
            redireccionar(getWeb('EMP') . 'emp.modificar.php?id=' . $stID . '&mod=ok');
        }
    }
    $stERROR = $oEmpleados->getErrors();
} elseif (isset($_GET['id'])) {
    $stID = $_GET['id'];
    if (isset($_GET['mod'])) {
        if ($_GET['mod'] == 'ok') {
            $stMENSAJE = 'dados alterados com sucesso';
        } else if ($_GET['mod'] == 'bad') {
            $stERROR = 'As novas senhas s&atilde;o diferentes';
        }
    }
    if (isset($_GET['cre'])) {
        if ($_GET['cre'] == 'ok') {
            $stMENSAJE = 'Empreado criado com sucesso';
        }
    }


    $oEmpleados->clearErrors();
   
    if (!$oEmpleados->findId($stID)|| ($oEmpleados->getLoja_Id() != $_SESSION['_admLojaId'] && $_SESSION['_admin'] != 'S' )) {
        $oSmarty->assign('stTITLE', 'Modificar Empregado');
        $oSmarty->assign('stMESSAGE', $oEmpleados->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
    }

} else {
    $oSmarty->assign('stTITLE', 'Modificar Empregado');
    $oSmarty->assign('stMESSAGE', 'Acceso denegados.');
    $oSmarty->display('_informacion.tpl');
    exit();
}


/* --------------------------------------------------------------------- */
$oSmarty->assign('stID', $stID);
$oSmarty->assign('stNOMBRE', $oEmpleados->getNombre());
$oSmarty->assign('stAPELLIDO', $oEmpleados->getApellido());
$oSmarty->assign('stTELEFONO', $oEmpleados->getTelefono());
$oSmarty->assign('stEMAIL', $oEmpleados->getEmail());
$oSmarty->assign('stLOJA_ID', $oEmpleados->getLoja_Id());
$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar Empregado ');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de modifica&ccedil;&atilde;o do Empregado');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
/* --------------------------------------------------------------------- */

$oSmarty->display('empleados/_emp.crear.tpl');
