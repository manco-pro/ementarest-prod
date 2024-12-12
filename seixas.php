<?php
include_once './cOmmOns/config.inc.php';
session_start();
session_destroy();
$loja=2;
$mesa = obtenerValor('mesa');
//if ($mesa == false) {
    //unset($mesa);
//}
require_once getLocal('EMENTA') . 'user_session.php';



