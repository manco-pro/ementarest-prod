<?php
$current_page = $_SERVER['PHP_SELF'];
$GET = '';
if (!empty($_SERVER['QUERY_STRING'])) {
    $cadena_modificada = preg_replace('/lang=[a-zA-Z]{2}/', '', $_SERVER['QUERY_STRING']);
    $cadena_modificada = str_replace('&', '', $cadena_modificada);
    if (!empty($cadena_modificada)) {
        $GET = '&' . $cadena_modificada;
    }
}


switch ($_SESSION['idioma']) {
    case 'pt':
        $stINICIO = 'In&iacute;cio';
        $stMENU = 'Menu';   
        $stBEBIDAS = 'Bebidas';
        $stCART = 'Carrinho';
        $stSUGESTOES = 'Sugest&otilde;es';
        $stEVENTOS = 'Eventos';
        $stOPINIAO = 'A sua opini&atilde;o';
        $stSIGANOS = 'Siga-nos:';
        $stTERMOSeCOND = 'Termos e condi&ccedil;&otilde;es';
        $stIVA = 'Todos os Produtos Incluem a Taxa de Iva em Vigor.';

         
        $stMENSAJE_BIEN_TRAD = 'Bem-vindo ao nosso servi&ccedil;o de tradu&ccedil;&atilde;o!';
        $stMENSAJE_BIEN_TRAD2 = 'Selecione o idioma abaixo para traduzindo todo o conte&uacute;do do site.';
        $stMENSAJE_EMPlEADO_MESA ='Deseja solicitar a ajuda do funcion&aacute;rio da mesa?';
        $stMENSAJE_BOTON_CANCELAR = 'Cancelar';
        $stMENSAJE_BOTON_CONFIRMAR = 'Confirmar';
        $stMENSAJE_TITULO_EMPLEADO = 'Emplegado da mesa';



        break;
    case 'fr':
        $stINICIO = 'Accueil';
        $stMENU = 'Menu';   
        $stBEBIDAS = 'Boissons';
        $stCART = "Panier d'achat";
        $stSUGESTOES = 'Suggestions';
        $stEVENTOS = '&Eacute;v&eacute;nements';
        $stOPINIAO = 'Votre opinion';
        $stSIGANOS = 'Suivez-nous:';
        $stTERMOSeCOND = 'Termes et conditions';
        $stIVA = 'Tous les Produits Incluent la Taxe de TVA en Vigueur.';

        $stMENSAJE_BIEN_TRAD = 'Bienvenue sur notre service de traduction !';
        $stMENSAJE_BIEN_TRAD2 = 'S&eacute;lectionnez la langue ci-dessous pour traduire tout le contenu du site.';
        $stMENSAJE_EMPlEADO_MESA ='Voulez-vous demander l\'aide de l\'employ&eacute; de la table?';
        $stMENSAJE_BOTON_CANCELAR = 'Annuler';
        $stMENSAJE_BOTON_CONFIRMAR = 'Confirmer';
        $stMENSAJE_TITULO_EMPLEADO = 'Employ&eacute; de table';

        break;
    case 'en':
        $stINICIO = 'Home';
        $stMENU = 'Menu';   
        $stBEBIDAS = 'Drinks';
        $stCART = 'Cart';
        $stSUGESTOES = 'Suggestions';
        $stEVENTOS = 'Events';
        $stOPINIAO = 'Your opinion';
        $stSIGANOS = 'Follow us:';
        $stTERMOSeCOND = 'Terms and Conditions';
        $stIVA = 'All Products Include the Applicable VAT Rate.';

        $stMENSAJE_BIEN_TRAD = 'Welcome to our translation service!';
        $stMENSAJE_BIEN_TRAD2 = 'Select the language below to translate all the content of the site.';
        $stMENSAJE_EMPlEADO_MESA ='Do you want to request the help of the table employee?';
        $stMENSAJE_BOTON_CANCELAR = 'Cancel';
        $stMENSAJE_BOTON_CONFIRMAR = 'Confirm';
        $stMENSAJE_TITULO_EMPLEADO = 'Table employee';



        break;
    case 'es':
        $stINICIO = 'Inicio';
        $stMENU = 'Menu';   
        $stBEBIDAS = 'Bebidas';
        $stCART = 'Carrito';
        $stSUGESTOES = 'Sugerencias';
        $stEVENTOS = 'Eventos';
        $stOPINIAO = 'Su opini&oacute;n';
        $stSIGANOS = 'S&iacute;guenos:';
        $stTERMOSeCOND = 'T&eacute;rminos y Condiciones';
        $stIVA = 'Todos los Productos Incluyen el Tipo de IVA Aplicable.';

        $stMENSAJE_BIEN_TRAD = '&iexcl;Bienvenido a nuestro servicio de traducci&oacute;n!';
        $stMENSAJE_BIEN_TRAD2 = 'Seleccione el idioma a continuaci&oacute;n para traducir todo el contenido del sitio.';
        $stMENSAJE_EMPlEADO_MESA ='&iquest;Desea solicitar la ayuda del empleado de la mesa?';
        $stMENSAJE_BOTON_CANCELAR = 'Cancelar';
        $stMENSAJE_BOTON_CONFIRMAR = 'Confirmar';
        $stMENSAJE_TITULO_EMPLEADO = 'Empleado de mesa';

        break;
    case 'de':
        $stINICIO = 'Startseite';
        $stMENU = 'Menu';   
        $stBEBIDAS = 'Drankjes';
        $stCART = 'Einkaufswagen';
        $stSUGESTOES = 'Vorschl&auml;ge';
        $stEVENTOS = 'Veranstaltungen';
        $stOPINIAO = 'Jouw mening';
        $stSIGANOS = 'Volg ons:';
        $stTERMOSeCOND = 'Voorwaarden';
        $stIVA = 'Alle Produkte enthalten die geltende Mehrwertsteuer.';

        $stMENSAJE_BIEN_TRAD = 'Willkommen bei unserem &Uuml;bersetzungsservice!';
        $stMENSAJE_BIEN_TRAD2 = 'W&auml;hlen Sie unten die Sprache aus, um den gesamten Inhalt der Website zu &uuml;bersetzen.';
        $stMENSAJE_EMPlEADO_MESA ='M&ouml;chten Sie die Hilfe des Tischarbeiters anfordern?';
        $stMENSAJE_BOTON_CANCELAR = 'Stornieren';
        $stMENSAJE_BOTON_CONFIRMAR = 'Best&auml;tigen';
        $stMENSAJE_TITULO_EMPLEADO = 'Tischarbeiter';

        break;
}

$oSmarty->assign('CURRENT_PAGE', $current_page);
$oSmarty->assign('GET', $GET);
$oSmarty->assign('stINICIO', $stINICIO);
$oSmarty->assign('stMENU', $stMENU);
$oSmarty->assign('stBEBIDAS', $stBEBIDAS);
$oSmarty->assign('stCART', $stCART);
$oSmarty->assign('stSUGESTOES', $stSUGESTOES);
$oSmarty->assign('stEVENTOS', $stEVENTOS);
$oSmarty->assign('stOPINIAO', $stOPINIAO);
$oSmarty->assign('stSIGANOS', $stSIGANOS);
$oSmarty->assign('stTERMOSeCOND', $stTERMOSeCOND);
$oSmarty->assign('stIVA', $stIVA);
$oSmarty->assign('stMENSAJE_EMPlEADO_MESA', $stMENSAJE_EMPlEADO_MESA);
$oSmarty->assign('stMENSAJE_BOTON_CANCELAR', $stMENSAJE_BOTON_CANCELAR);
$oSmarty->assign('stMENSAJE_BOTON_CONFIRMAR', $stMENSAJE_BOTON_CONFIRMAR);
$oSmarty->assign('stMENSAJE_TITULO_EMPLEADO', $stMENSAJE_TITULO_EMPLEADO);

//ementa2
$oSmarty->assign('stMENSAJE_BIEN_TRAD', $stMENSAJE_BIEN_TRAD);
$oSmarty->assign('stMENSAJE_BIEN_TRAD2', $stMENSAJE_BIEN_TRAD2);




