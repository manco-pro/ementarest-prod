<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('LOJ') . 'class.lojas.inc.php';
	require_once getLocal('COMMONS').'class.mysqli.inc.php';
	
	$oLojas = new clsLojas();

	if ($_SESSION['_admId'] != 1) {
		$oSmarty->assign('stTITLE', 'Loja Listar');
		$oSmarty->assign('stMESSAGE', 'Acceso denegado.');
		$oSmarty->display('_informacion.tpl');
		exit();
	}

	$Cid = obtenerValor('Cid');
	$Cvalue = obtenerValor('Cvalue');
	if ($Cid != false && $Cvalue != false) {
		$oLojas->findId($Cid);
		$oLojas->setEnabled($Cvalue);
		if (!$oLojas->UpdateEstado()){
			$stMESSAGE = $oLojas->getErrors();
			echo $stMESSAGE;
			exit();
		
		}else{
			echo 'ok';
			exit();
		}
	}

		$oMyDB  = new clsMySqliDB();
        $QUERY =  'SELECT id , nombre , empresa , email , telefono, logo , enabled '
                . 'FROM lojas;' ;
	
        $result = $oMyDB->Select($QUERY,'all');
        if ($result != false ){
            foreach ($result as $value) {
                $Id = $value['id'];
		$aValues[$Id]['nombre']     = $oMyDB->forShow($value['nombre']);
		$aValues[$Id]['empresa']    = $oMyDB->forShow($value['empresa']);
		$aValues[$Id]['email']      = $oMyDB->forShow($value['email']);
		$aValues[$Id]['telefono']   = $oMyDB->forShow($value['telefono']);
		$aValues[$Id]['logo']   	= $oMyDB->forShow($value['logo']);
		$aValues[$Id]['enabled']    = $oMyDB->forShow($value['enabled']);
            }
        }else{
           $aValues = array();
       }
	
// resultados


        
        
	/*---------------------------------------------------------------------*/
        $oSmarty->assign ('stSUPER_ADMIN', $_SESSION['_admin']);
       	$oSmarty->assign('stVALUES', $aValues);
	$oSmarty->assign('stTITLE', 'Listado de Lojas');
	/*---------------------------------------------------------------------*/
	$oSmarty->display('lojas/_loj.listar.tpl');
