<?php
	require_once '../cOmmOns/config.inc.php';
	require_once getLocal('ADMIN') . 'menu.inc.php';
	require_once getLocal('COL') . 'class.colecciones.inc.php';
	require_once getLocal('PED') . 'class.pedidos.inc.php';
	
	$oSmarty->assign('stTITLE' , 'Dashboard');
	
	//-------------si es SUPER ADMIN vera otro dashboard
	
		$oColecciones = new clsColecciones();
		$aColeciones_bebidas = $oColecciones->GetAllColByLoja_Id($_SESSION['_admLojaId'], true, 2);
		$aColeciones_comidas = $oColecciones->GetAllColByLoja_Id($_SESSION['_admLojaId'], true, 1);

		if (empty($aColeciones_bebidas)) {
			$aColeciones_bebidas = array();
		}
		if (empty($aColeciones_comidas)) {
			$aColeciones_comidas = array();
		}
		$stCOLECCIONES_BEBIDAS  = sobreescribirEntidadesHTML($aColeciones_bebidas);
		$stCOLECCIONES_COMIDAS = sobreescribirEntidadesHTML($aColeciones_comidas);


		$oSmarty->assign('stCOLECCIONES_BEBIDAS', HandlerSelect($stCOLECCIONES_BEBIDAS, '-1', 'Produtos'));
		$oSmarty->assign('stCOLECCIONES_COMIDAS', HandlerSelect($stCOLECCIONES_COMIDAS, '-1', 'Produtos'));
		
		$oSmarty->display('contenido.tpl');
	
	
	
	
