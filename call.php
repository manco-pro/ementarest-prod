<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('ALE') . 'class.alertas.inc.php';

header('Content-Type: application/text');

$id = obtenerValor('id');
if ($id != false) {
   //dispara alerta a dasboard
   $oAlertas = new clsAlertas();
   $oAlertas->clearAlertas();
   $oAlertas->setLoja_Id($_SESSION['LojaId']);
   $oAlertas->setMensaje("Olá! Um cliente está chamando o emplegrado na mesa " . $_SESSION['LojaMesaIdentificador'] . ". Por favor, dirija-se à mesa dele o mais rápido possível. Obrigado!");
   $oAlertas->setTipo('1');
   $oAlertas->Registrar();
      
    echo 'ok';
} else {
    echo 'bad';
}