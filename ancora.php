<?php
include_once './cOmmOns/config.inc.php';
session_start();
session_destroy();
$loja=1;
$mesa = obtenerValor('mesa');
require_once getLocal('EMENTA') . 'user_session.php';



