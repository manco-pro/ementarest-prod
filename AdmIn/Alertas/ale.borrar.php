<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('ALE') . 'class.alertas.inc.php';

$oAlerta = new clsAlertas();
$id = obtenerValor('id');



if ((!isset($_SESSION['_admin']) || !$oAlerta->findId($id))) {
    $oSmarty->assign('stTITLE', 'Acceso denegado.');
    $oSmarty->assign('stMESSAGE', 'Acceso denegado.');
    $oSmarty->display('_informacion.tpl');
    exit();
}



if ($id != null) {
    // Intentar encontrar la alerta por su ID
            // Intentar eliminar la alerta
        if ($oAlerta->Borrar()) {
            // La alerta se eliminó correctamente
            echo json_encode(array('success' => true, 'message' => 'Alerta eliminada correctamente'));
        } else {
            // Error al eliminar la alerta
            echo json_encode(array('success' => false, 'message' => 'Error al eliminar la alerta'));
        }
    
} else {
    // No se recibió un ID válido para la alerta a eliminar
    echo json_encode(array('success' => false, 'message' => 'ID de alerta no válido'));
}
