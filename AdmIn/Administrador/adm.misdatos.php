<?php

require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('ADM') . 'class.administrador.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';

$oMySqliDB = new clsMySqliDB();
$oAdministrador = new clsAdministrador();
$oLojas = new clsLojas();

$stID = 0;
$stEMAIL = '';
$stTELEFONO = '';
$vieja = '';
$nueva = '';
$confirmacion = '';
$stERROR = '';
$stMENSAJE = '';
$email_compare = false;
$telefofno_compare = false;

if ((isset($_POST['btn_action1']) || isset($_POST['btn_action2']) )) {
    $stID = $_POST['id'];
    $stTELEFONO = $_POST['telefono'];
    $vieja = !empty($_POST['old']) ? $_POST['old'] : '';
    $nueva = !empty($_POST['new']) ? $_POST['new'] : '';
    $confirmacion = !empty($_POST['confirmation']) ? $_POST['confirmation'] : '';
    
    $oAdministrador->clearErrors();
    
    if ($_SESSION['_admId'] == $stID ){
            
        if ($oAdministrador->findId($stID)) {
                       
            if ($stTELEFONO == $oAdministrador->getTelefono()){
               $telefofno_compare = true;
            }
            if (isset($_POST['btn_action1'])){
                
                if (!$oAdministrador->hasErrors() && !$telefofno_compare){
                    $oAdministrador->setTelefono($stTELEFONO);
                    $oAdministrador->Modificar();
                    if (!$oAdministrador->getErrors()) {
                        $stMENSAJE = "Informacion de contacto atualizada." ;
                    }
                }
            }
            if (isset($_POST['btn_action2'])){
                if (!$oAdministrador->hasErrors() && $vieja != '' && $nueva != '' && $confirmacion != '') {
                    if ($oAdministrador->changePassword($vieja, $nueva, $confirmacion)){
                       $stMENSAJE = $stMENSAJE . " senha atualizada." ;}
                }
            }
        }
     }else{
        $oAdministrador->Errors = array("Opera&ccedil;&atilde;o n&atilde;o permitida") ;
        $oSmarty->assign('stTITLE', 'Opera&ccedil;&atilde;o n&atilde;o permitida');
        $oSmarty->assign('stMESSAGE', $oAdministrador->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
     }    
    $stERROR = $oAdministrador->getErrors();
} elseif (isset($_GET['id'])) {
    $stID = $_GET['id'];
    
    $oAdministrador->clearErrors();

    if (!$oAdministrador->findId($stID)) {
       
        $oSmarty->assign('stTITLE', 'Modificar meus dados de login');
        $oSmarty->assign('stMESSAGE', $oAdministrador->getErrors());
        $oSmarty->display('_informacion.tpl');
        exit();
    }
} else {
    $oSmarty->assign('stTITLE', 'Modificar meus dados de login');
    $oSmarty->assign('stMESSAGE', 'Acesso negado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}

if ($_SESSION['_admin'] ==='N'){
   $oLojas->findId($_SESSION['_admLojaId'] );
    $stLOJA_NAME = $oLojas->getNombre();

}else{
    $stLOJA_NAME= 'ADMIN';
}


/* --------------------------------------------------------------------- */
$oSmarty->assign('stID'         , $stID);
$oSmarty->assign('stERROR'      , $stERROR);
$oSmarty->assign('stMENSAJE'    , $stMENSAJE);
$oSmarty->assign('stEMAIL'      , $_SESSION['_admEmail']);
$oSmarty->assign('stLOJA'       , $stLOJA_NAME);
$oSmarty->assign('stTELEFONO'   , $oAdministrador->getTelefono());

$oSmarty->assign('stACTION'     , $_SERVER['PHP_SELF']);
$oSmarty->assign('stTITLE'      , 'Modificar meus dados de login');
$oSmarty->assign('stBTN_ACTION' , 'Modificar');
/* --------------------------------------------------------------------- */
$oSmarty->display('admin/_adm.misdatos.tpl');
