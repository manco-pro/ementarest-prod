<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('EVE') . 'class.eventos.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';

$oEventos = new clsEventos();
$oEventos->clearEventos();

$plantilla = $_SESSION['Plantilla'];


$aValues = $oEventos->GetAllActiveEventsByLoja($_SESSION['LojaId']);
$Fvalues = $oEventos->GetAllFutureEventsByLoja($_SESSION['LojaId']);

//echo 'test<pre>';
//print_r($aValues);
//print_r($Fvalues);
//echo '</pre>';

$oSmarty->assign('stACTIVA', $_SESSION['_footerbar']);


switch ($_SESSION['idioma']) {
    case 'pt':

        $stMENSAJE = 'Destaques.';
        $stMENSAJE2 = 'Pr&oacute;ximos eventos.';
        $stTITULO_PAGINA = 'Eventos';
        $stMENSAJE_INICIO = 'Data de in&iacute;cio';
        $stMENSAJE3 = 'Em breve ...';
        break;
    case 'fr':

        $stMENSAJE = 'En vedette';
        $stTITULO_PAGINA =  '&Eacute;v&eacute;nements';
        $stMENSAJE2 = 'Prochains &eacute;v&eacute;nements.';
        $stMENSAJE_INICIO = 'Date de d&eacute;but';
        $stMENSAJE3 = 'Bient&ocirc;t ...';

        break;
    case 'en':

        $stMENSAJE = 'Featured';
        $stTITULO_PAGINA =  'Events';
        $stMENSAJE2 = 'Upcoming events.';
        $stMENSAJE_INICIO = 'Start date';
        $stMENSAJE3 = 'Coming soon ...';


        break;
    case 'es':

        $stMENSAJE = 'Destacados';
        $stTITULO_PAGINA =  'Eventos';
        $stMENSAJE2 = 'Pr&oacute;ximos eventos.';
        $stMENSAJE_INICIO = 'Fecha de inicio';
        $stMENSAJE3 = 'Proximamente ...';
        break;
    case 'de':

        $stMENSAJE = 'Aanbevolen';
        $stTITULO_PAGINA =  'Evenementen';
        $stMENSAJE2 = 'Komende evenementen.';
        $stMENSAJE_INICIO = 'Startdatum';
        $stMENSAJE3 = 'Binnenkort ...';
        break;
}

$oSmarty->assign('stMENSAJE', $stMENSAJE);
$oSmarty->assign('stMENSAJE2', $stMENSAJE2);
$oSmarty->assign('stMENSAJE_INICIO', $stMENSAJE_INICIO);
$oSmarty->assign('stMENSAJE3', $stMENSAJE3);


$oSmarty->assign('stTITULO_PAGINA', $stTITULO_PAGINA);
$oSmarty->assign('staVALUES', $aValues);
$oSmarty->assign('stfVALUES', $Fvalues);
$oSmarty->display('ementa' . $plantilla . '/eventos.tpl');
