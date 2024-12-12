<?php
//session_set_cookie_params(3600);
session_start();
include_once './cOmmOns/config.inc.php';
require_once getLocal('LOJ') . 'class.lojas.inc.php';
require_once getLocal('MES') . 'class.mesas.inc.php';
require_once getLocal('ALE') . 'class.alertas.inc.php';
require_once getLocal('COMMONS') . 'func.html.inc.php';

if (isset($_SESSION['LojaId'])) {
    redireccionar(getWeb('EMENTA') . 'index.php');
}

if (!isset($loja)) {
    $loja = obtenerValor('loja');
}

if (!isset($_COOKIE['loja'])) {
    $expiracion = time() + (24 * 60 * 60); // 24 horas * 60 minutos * 60 segundos

    setcookie('loja', $loja, $expiracion, "/");
}

$lang = obtenerValorGET('lang');



if ($loja != null) {
    $oLoja = new clsLojas();
    $oLoja->clearErrors();
    $oLoja->findId($loja);
    if (!$oLoja->hasErrors()) {
        $_SESSION['LojaId'] = $oLoja->getId();
        $_SESSION['LojaNombre'] = $oLoja->getNombre();
        $_SESSION['LojaTelefono'] = $oLoja->getTelefono();
        $_SESSION['LojaEmail'] = $oLoja->getEmail();
        $_SESSION['LojaMorada'] = $oLoja->getMorada();
        $_SESSION['LojaEnabled'] = $oLoja->getEnabled();
        $_SESSION['LojaFacebook'] = $oLoja->getFacebook();
        $_SESSION['LojaInstagram'] = $oLoja->getInstagram();
        $_SESSION['LojaGoogleMaps'] = $oLoja->getGoogleMaps();
        $_SESSION['LojaTripAdvisor'] = $oLoja->getTripAdvisor();
        $_SESSION['LojaRuta_Ementa'] = $oLoja->getRuta_Ementa();
        $_SESSION['Plantilla'] = $oLoja->getPlantilla();
        $_SESSION['LojaLogo'] = $oLoja->getLogo();
        if ($lang != false) {
            $_SESSION['idioma'] = $lang;
        } else {
            $_SESSION['idioma'] = 'pt';
        }
       
        if (isset($mesa)) {
            $oMesas = new clsMesas();

            if ($oMesas->findId($mesa)) {//controla si la mesa existe
                if ($oMesas->getLoja_Id() == $loja){//controla si la mesa pertenece a la loja
                        $_SESSION['LojaMesa'] = $mesa;
                        $_SESSION['LojaMesaIdentificador'] = $oMesas->getIdentificador();
                        $_SESSION['LojaMesaEnabled'] = ($oMesas->getEnabled() == 'checked') ? 'enabled' : 'disabled';
                       
                    if ($_SESSION['LojaMesaEnabled']  === 'disabled') {//si la mesa no esta habilitada dispara aviso al dashboard

                        //dispara alerta a dasboard
                        $oAlertas = new clsAlertas();
                        $oAlertas->clearAlertas();
                        $oAlertas->setLoja_Id($_SESSION['LojaId']);
                        $oAlertas->setMensaje('O QR da ' . $oMesas->getIdentificador() . ' foi escaneado. A mesa está desativada no sistema.');
                        $oAlertas->setTipo('4');
                        $oAlertas->Registrar();
                    }
                    
                } else {
                    redireccionar(getWeb('EMENTA') . 'logout.php');
                }
                
            } else {
                redireccionar(getWeb('EMENTA') . 'logout.php');
            }
        }
       //echo '<pre>';
       //print_r($_SESSION);
       //echo '</pre>';
       //exit();
        $_SESSION['_footerbar'] = 'Menu';
        //ccuando viene por un recomended
        if ($_SESSION['LojaEnabled'] == 'checked') {
            $cat = obtenerValor('cat');
            $col = obtenerValor('col');
            if ($cat != null && $col != null) {
                if ($cat == 'sug') {
                    redireccionar(getWeb('EMENTA') . 'sugestoes.php?&col=' . $col);
                } else {
                    redireccionar(getWeb('EMENTA') . 'produtos.php?cat=' . $cat . '&col=' . $col);
                }
            } else {
                redireccionar(getWeb('EMENTA') . 'index.php');
            }
            exit();
        } else {
            redireccionar(getWeb('EMENTA') . 'logout.php');
        }
    }
}
