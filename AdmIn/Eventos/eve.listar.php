<?php
require_once '../../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('EVE') . 'class.eventos.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
$oLojas = new clsLojas();
$oEventos = new clsEventos();
$stLOJA_ID = 0;
$arrayLojas = array();
$result = array();

if (!isset($_SESSION['_admId'])) {
	$oSmarty->assign('stTITLE', 'Criar Evento');
	$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
	$oSmarty->display('_informacion.tpl');
	exit();
}
$Cid = obtenerValor('Cid');
$Cvalue = obtenerValor('Cvalue');
if ($Cid != false && $Cvalue != false) {
    $oEventos->findId($Cid);
    $oEventos->setEnabled($Cvalue);
    if (!$oEventos->UpdateEstado()){
        $stMESSAGE = $oEventos->getErrors();
        echo 'bad';
        exit();
    
    }else{
        echo 'ok';
        exit();
    }
}

if ($_SESSION['_admLojaId'] == 0) { //caso admin

	$arrayLojas = $oLojas->GetAllLojas();
	$stLOJA_ID = obtenerValorPOST('loja_id', FILTER_UNSAFE_RAW);
	if ($stLOJA_ID != null) {
		$result = $oEventos->GetAllEventosInLoja($stLOJA_ID);
	} else {
		$stLOJA_ID = -1;
		$stTITLE = 'Selecione uma loja para listar seus Eventos';
	}
} else { //caso usuario
	$result = $oEventos->GetAllEventosInLoja($_SESSION['_admLojaId']);
}

if ($stLOJA_ID != -1) {

	if ($_SESSION['_admLojaId'] == 0) {
		$oLojas->findId($stLOJA_ID);
	} else {
		$oLojas->findId($_SESSION['_admLojaId']);
	}

	$stTITLE = 'lista de Eventos do : ' . $oLojas->getNombre();
	$stLOJA_ID = $oLojas->getId();
}


if ($result != false) {
	foreach ($result as $value) {
		$Id = $value['id'];
		$aValues[$Id]['id']       = $Id;
		$aValues[$Id]['nombre']   = $oEventos->forShow($value['nombre']);
		$aValues[$Id]['imagen']   = $oEventos->forShow($value['imagen']);
		if ($value['inicio'] == '0000-00-00'){
			$aValues[$Id]['inicio'] = 'Sem Dados';
		}else{
			$aValues[$Id]['inicio']   = date("d-m-Y" , strtotime($oEventos->forShow($value['inicio'])));
		}
		if ($value['fin'] == '0000-00-00'){
			$aValues[$Id]['fin'] = 'Sem Dados';
		}else{
			$aValues[$Id]['fin']      = date("d-m-Y" , strtotime($oEventos->forShow($value['fin'])));
		}
		$aValues[$Id]['enabled']  = $oEventos->forShow($value['enabled']);
		$aValues[$Id]['loja_id']  = $oEventos->forShow($value['loja_id']);
	}           
	                   
} else {
	$aValues = array();
}

// resultados

/*---------------------------------------------------------------------*/
$oSmarty->assign('stSUPER_ADMIN', $_SESSION['_admin']);
$oSmarty->assign('stLOJA_ID', $stLOJA_ID);
$oSmarty->assign('stLOJAS_SELECT', HandlerSelect($arrayLojas, $stLOJA_ID, 'Lojas'));
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->assign('stVALUES', $aValues);
$oSmarty->assign('stTITLE', $stTITLE);
/*---------------------------------------------------------------------*/
$oSmarty->display('eventos/_eve.listar.tpl');