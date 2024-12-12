<?php
require_once '../cOmmOns/config.inc.php';
require_once getLocal('ADMIN') . 'menu.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('PED') . 'class.pedidos.inc.php';



$oSmarty->assign('stTITLE', 'Dashboard');





$oSmarty->display('contenido_admin.tpl');
