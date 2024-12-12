<?php
include_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'user_session.php';
$plantilla = $_SESSION['Plantilla'];




$oSmarty->display('ementa'. $plantilla .'/start.tpl');
