<?php
	require_once '../../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN').'menu.inc.php';
	require_once getLocal('COMMONS').'class.mysqli.inc.php';
	require_once getLocal('COMMONS').'class.paginado.inc.php';

	$oMyDB  = new clsMyDB();
	$aOrder = array('id'=>'id','email'=>'email', 'login'=>'login', 'nivel'=>'nivel', 'ciudad'=>'ciudad','habilitado'=>'habilitado');
	$stORD  = 'id';
	$stSNT  = 'ASC';
	$stTEXT = '';
	$stFILT = '';
//ordenamiento
	if (!empty($_REQUEST['orden'])){$stORD = $_REQUEST['orden']; $stSNT = $_REQUEST['sentido']=='ASC'?'DESC':'ASC';}
//busqueda
	if(!empty($_REQUEST['texto'])){
		$stTEXT = $_REQUEST['texto'];
		$stFILT.= " AND login LIKE '%$stTEXT%' ";
	}
	$QUERY =  'SELECT a.id , a.login , a.email , c.nombre as ciudad , n.nombre as nivel , a.habilitado '
                . 'FROM administradores as a, ciudades as c, niveles as n where n.id=a.nivel and c.id=a.ciudad '.$stFILT.' '
                . 'ORDER BY a.'.$aOrder[$stORD].' '.$stSNT;
	
	$PAGE  = (isset($_GET['page']))?(integer)$_GET['page']:1;
// paginado
	$oPaginado = new clsPaginadoMySQL($QUERY, $oMyDB, $PAGE,20);
	$oPaginado->doPaginar();

	if ($oPaginado->getCantidadRegistros() == 0){
		if ($stTEXT == ''){
			$stMENSAJE = 'No hay administradores registrados.';
			$stARRAY = array('desc'=>'Crear Administrador', 'link'=>'adm.crear.php');
		} else {
			$stMENSAJE = 'La b&uacute;squeda no devolvi&oacute; resultados.';
			$stARRAY = array('desc'=>'Volver', 'link'=>'adm.listar.php');
		}
		$oSmarty->assign ('stTITLE', 'Listado de Administradores');
		$oSmarty->assign ('stLINKS', array($stARRAY));
		$oSmarty->assign ('stMESSAGE', $stMENSAJE);
		$oSmarty->display('_informacion.tpl.html');
		exit();
	}
	$result = &$oPaginado->registros;
// resultados
	while ($result && $fila = mysql_fetch_assoc($result)){
		$Id = $fila['id'];
		$aValues[$Id]['login']= $oMyDB->forShow($fila['login']);
		$aValues[$Id]['email']= $oMyDB->forShow($fila['email']);
		$aValues[$Id]['ciudad']= $oMyDB->forShow($fila['ciudad']);
		$aValues[$Id]['nivel']= $oMyDB->forShow($fila['nivel']);
		$aValues[$Id]['habilitado']= $oMyDB->forShow($fila['habilitado']);
	}
	/*---------------------------------------------------------------------*/
	$oPaginado->removeParametro('orden');
	$oPaginado->removeParametro('sentido');

	$oSmarty->assign_by_ref('stVALUES', $aValues);
	$oSmarty->assign('stTEXT', $stTEXT);
	$oSmarty->assign('stSNT' , $stSNT);

	$oSmarty->assign('stREG_TOTAL' , $oPaginado->getCantidadRegistros());
	$oSmarty->assign('stPARAMETROS', $oPaginado->parametros);
	$oSmarty->assign('stLINKS', $oPaginado->links);
	$oSmarty->assign('stPAGES', $oPaginado->linksPaginas);
	$oSmarty->assign('stPAGE' , $oPaginado->getPaginaActual());
	$oSmarty->assign('stTITLE', 'Listado de Administradores');
	/*---------------------------------------------------------------------*/
	$oSmarty->display('_adm.listar.tpl.html');
?>