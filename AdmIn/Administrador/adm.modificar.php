<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('ADM') . 'class.administrador.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

/* ------------------------------------------------------------ */
if ($_SESSION['_admin'] == "N") {
    $oSmarty->assign('stTITLE', 'Modificar administrador');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}
/* ------------------------------------------------------------ */
$oLojas = new clsLojas();
$oAdministrador = new clsAdministrador();

$stID = 0;
$stNOMBRE = '';
$stAPELLIDO = '';
$stPASSWORD = '';
$stADMIN = '';
$stENABLED = '';
$stEMAIL = '';
$stTELEFONO = '';
$stFECNAC = '';
$stFREGUESIA = '';

$nueva = '';
$confirmacion = '';
$stERROR = '';
$stMENSAJE = '';


if (isset($_POST['Modificar'])) {
    $stID = $_POST['id'];
    $stEMAIL = trim($_POST['email']);
    $stNOMBRE = trim($_POST['nombre']);
    $stAPELLIDO = trim($_POST['apellido']);
    $stTELEFONO = trim($_POST['telefono']);
    $stLOJA = trim($_POST['loja']);

    if (isset($_POST['enabled'])) {
        $stENABLED = 'S';
    } else {
        $stENABLED = 'N';
    }
    $nueva = !empty($_POST['password']) ? $_POST['password'] : '';
    $confirmacion = !empty($_POST['confirmarPassword']) ? $_POST['confirmarPassword'] : '';

    $oAdministrador->clearErrors();

    if ($oAdministrador->findId($stID)) {
        //$oAdministrador->setLogin($stLOGIN);
        $oAdministrador->setEmail($stEMAIL);
        $oAdministrador->setLoja_Id($stLOJA);
        $oAdministrador->setNombre($stNOMBRE);
        $oAdministrador->setApellido($stAPELLIDO);
        $oAdministrador->setTelefono($stTELEFONO);
        $oAdministrador->setEnabled($stENABLED);

        if (!$oAdministrador->hasErrors() && $oAdministrador->Modificar_ADM()) {
            if ($nueva != '' && $confirmacion != '' && ($nueva == $confirmacion)) {
                $oAdministrador->changePassword_ADM($nueva, $confirmacion);
            } elseif ($nueva != '' || $confirmacion != '' && ($nueva != $confirmacion)) {
                redireccionar(getWeb('ADM') . 'adm.modificar.php?id=' . $stID . '&mod=bad');
            }
            redireccionar(getWeb('ADM') . 'adm.modificar.php?id=' . $stID . '&mod=ok');
        }
    }
    $stERROR = $oAdministrador->getErrors();
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
            $stMENSAJE = 'administrador criado com sucesso';
        }
    }


    $oAdministrador->clearErrors();

    if (!$oAdministrador->findId($stID)) {
        $oSmarty->assign('stTITLE', 'Modificar administrador');
        $oSmarty->assign('stMESSAGE', $oAdministrador->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
    }
} else {
    $oSmarty->assign('stTITLE', 'Modificar administrador');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

$stLOJAS = $oLojas->GetAllLojas(); 


/* --------------------------------------------------------------------- */
$oSmarty->assign('stID', $stID);
$oSmarty->assign('stNOMBRE', $oAdministrador->getNombre());
$oSmarty->assign('stAPELLIDO', $oAdministrador->getApellido());
$oSmarty->assign('stTELEFONO', $oAdministrador->getTelefono());
$oSmarty->assign('stEMAIL', $oAdministrador->getEmail());
$oSmarty->assign('stLOJAS', HandlerSelect($stLOJAS, $oAdministrador->getLoja_Id()));
$oSmarty->assign('stENABLED', $oAdministrador->getEnabled());
$oSmarty->assign('stERROR', $stERROR);
$oSmarty->assign('stMENSAJE', $stMENSAJE);

$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE', 'Modificar administrador ');
$oSmarty->assign('stSUBTITLE', 'formul&aacute;rio de modifica&ccedil;&atilde;o do administrador');
$oSmarty->assign('stBTN_ACTION', 'Modificar');
/* --------------------------------------------------------------------- */

$oSmarty->display('admin/_adm.crear.tpl');
