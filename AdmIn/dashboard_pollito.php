<?php

require_once '../cOmmOns/config.inc.php';
require_once getLocal('COMMONS') . 'func.html.inc.php';

require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';

$oSmarty->assign('stTITLE', 'Dashboard');
$loja = 4;
//-------------si es SUPER ADMIN vera otro dashboard

$oSmarty->assign('stTITLE', 'Painel de pedidos POLLITO');
$oSmarty->assign('stLOJA', $loja);
$oSmarty->display('dashboard_lojas.tpl');
