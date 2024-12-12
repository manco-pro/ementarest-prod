<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('MEN') . 'class.mensajes.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';

$_SESSION['_footerbar'] = 'Opiniao';
$plantilla = $_SESSION['Plantilla'];
$men = obtenerValor('men');
if (isset($_POST['inputEmail'])) {

  $oMensajes = new clsMensajes();
  $oMensajes->clearMensajes();
  $oMensajes->clearErrors();

  $nombre   = obtenerValor('inputNome');
  $email    = obtenerValor('inputEmail');
  $telefono  = obtenerValor('inputTelemovel');
  $mensaje  = obtenerValor('Textarea');

  $oMensajes->setNombre($nombre);
  $oMensajes->setEmail($email);
  $oMensajes->setTelefono($telefono);
  $oMensajes->setMensaje($mensaje);
  $oMensajes->setLoja_Id($_SESSION['LojaId']);

  if (!$oMensajes->hasErrors() && $oMensajes->Registrar()) {
    echo 'Mensagem enviada com sucesso!';
    exit;
    //redireccionar(getWeb('EMENTA') . 'opiniao.php?men=ok');
  }
}

switch ($_SESSION['idioma']) {
  case 'pt':
    $stMENSAJE_TOP = 'Conte-nos um pouco mais sobre a sua experiência para que possamos
    melhorar cada vez mais os nossos serviços.';
    $stCAMPO_NOME = 'Nome';
    $stCAMPO_EMAIL = 'Email';
    $stCAMPO_TELEFONE = 'Telefone';
    $stCAMPO_MENSAGEM = 'Mensagem';
    $stCAMPO_OPINIAO = 'Opinião';
    $stBTN_ACTION = 'Enviar';
    break;
case 'fr':
    $stMENSAJE_TOP = 'Dites-nous en un peu plus sur votre expérience pour que nous puissions';
    $stCAMPO_NOME = 'Nom';
    $stCAMPO_EMAIL = 'Email';
    $stCAMPO_TELEFONE = 'Téléphone';
    $stCAMPO_MENSAGEM = 'Message';
    $stCAMPO_OPINIAO = 'Opinion';
    $stBTN_ACTION = 'Envoyer';
    break;
case 'en':
    $stMENSAJE_TOP = 'Tell us a little more about your experience so we can';
    $stCAMPO_NOME = 'Name';
    $stCAMPO_EMAIL = 'Email';
    $stCAMPO_TELEFONE = 'Phone';
    $stCAMPO_MENSAGEM = 'Message';
    $stCAMPO_OPINIAO = 'Opinion';
    $stBTN_ACTION = 'Send';
    break;
case 'es':
    $stMENSAJE_TOP = 'Cuéntanos un poco más sobre tu experiencia para que podamos';
    $stCAMPO_NOME = 'Nombre';
    $stCAMPO_EMAIL = 'Email';
    $stCAMPO_TELEFONE = 'Teléfono';
    $stCAMPO_MENSAGEM = 'Mensaje';
    $stCAMPO_OPINIAO = 'Opinión';
    $stBTN_ACTION = 'Enviar';
    break;

case 'de':
    $stMENSAJE_TOP = 'Erzählen Sie uns ein wenig mehr über Ihre Erfahrung, damit wir';
    $stCAMPO_NOME = 'Name';
    $stCAMPO_EMAIL = 'Email';
    $stCAMPO_TELEFONE = 'Telefon';
    $stCAMPO_MENSAGEM = 'Nachricht';
    $stCAMPO_OPINIAO = 'Meinung';
    $stBTN_ACTION = 'Senden';
    break;
}


$oSmarty->assign('stMENSAJE_TOP', $stMENSAJE_TOP);
$oSmarty->assign('stCAMPO_NOME', $stCAMPO_NOME);
$oSmarty->assign('stCAMPO_EMAIL', $stCAMPO_EMAIL);
$oSmarty->assign('stCAMPO_TELEFONE', $stCAMPO_TELEFONE);
$oSmarty->assign('stCAMPO_MENSAGEM', $stCAMPO_MENSAGEM);
$oSmarty->assign('stCAMPO_OPINIAO', $stCAMPO_OPINIAO);


$oSmarty->assign('stRESPUESTA', $men);
$oSmarty->assign('stBTN_ACTION', $stBTN_ACTION);
$oSmarty->assign('stACTIVA', $_SESSION['_footerbar']);
$oSmarty->assign('stTITULO_PAGINA', '');
$oSmarty->assign('stACTION', $_SERVER['PHP_SELF']);
$oSmarty->display('ementa' . $plantilla . '/opiniao.tpl');
