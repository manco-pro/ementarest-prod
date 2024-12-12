<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';

$_SESSION['_footerbar'] = 'Cart';
$plantilla = $_SESSION['Plantilla'];

$oColecciones = new clsColecciones();
$aValues = array();

if (isset($_SESSION['carrito']) && (count($_SESSION['carrito']) > 0)) {
    $productos = implode(",", $_SESSION['carrito']);
    $aValues = $oColecciones->GetAllColByLoja_ToCartForEmenta($_SESSION['LojaId'], $productos);
    $oSmarty->assign('stTOTAL', $aValues['total']);
    $oSmarty->assign('stPRODUCTOS', $aValues['productos']);
}
if (isset($_SESSION['LojaMesa'])) {
    $oSmarty->assign('stMESA_ENABLED', $_SESSION['LojaMesaEnabled']);
}


$oSmarty->assign('stLOJA', $_SESSION['LojaId']);
$oSmarty->assign('stTITULO_PAGINA', '');
$oSmarty->assign('stACTIVA', $_SESSION['_footerbar']);
switch ($_SESSION['idioma']) {
    case 'pt':
        $stTOTAL_LEYENDA = 'Total';
        $stBOTON1 = 'Gerar QR do pedido';
        $stBOTON2 = 'Gerar pedido';
        $stLEYENDA = 'QR do pedido';
        $stTITULO_PAGINA = 'Carrinho';
        $stMENSAJE_CART = 'controle e rapidez dos seus pedidos. Confira sempre com atenção o pedidos.';
        $stOBSERVACION = 'Observação';
        $stCASO_QUIERA= 'Caso queira, adicione observações aos itens do pedido. <strong>Ex.:Algum tipo de restrição alimentar...</strong>';
        $stCONFIRMAR = 'Confirmar';

        break;
    case 'fr':
        $stTOTAL_LEYENDA = 'Total';
        $stBOTON1 = 'Générer le QR de commande';
        $stBOTON2 = 'Générer la commande';
        $stLEYENDA = 'QR de commande';
        $stTITULO_PAGINA = 'Panier';
        $stMENSAJE_CART = 'contrôle et rapidité de vos commandes. Vérifiez toujours attentivement les commandes.';
        $stOBSERVACION = 'Remarque';
        $stCASO_QUIERA= 'Si vous le souhaitez, ajoutez des observations aux articles de la commande. <strong>Ex.: Quelque type de restriction alimentaire...</strong>';
        $stCONFIRMAR = 'Confirmer';

        break;
    case 'en':
        $stTOTAL_LEYENDA = 'Total';
        $stBOTON1 = 'Generate Order QR';
        $stBOTON2 = 'Generate Order';
        $stLEYENDA = 'Order QR';
        $stTITULO_PAGINA = 'Cart';
        $stMENSAJE_CART = 'control and speed of your orders. Always check orders carefully.';
        $stOBSERVACION = 'Observation';
        $stCASO_QUIERA= 'If you want, add observations to the items in the order. <strong>Ex.: Some type of dietary restriction...</strong>';
        $stCONFIRMAR = 'Confirm';

        break;
    case 'es':
        $stTOTAL_LEYENDA = 'Total';
        $stBOTON1 = 'Generar QR del pedido';
        $stBOTON2 = 'Generar pedido';
        $stLEYENDA = 'QR del pedido';
        $stTITULO_PAGINA = 'Carrito';
        $stMENSAJE_CART = 'control y rapidez en sus pedidos. Siempre revise los pedidos con atención.';
        $stOBSERVACION = 'Observación';
        $stCASO_QUIERA= 'Si lo desea, agregue observaciones a los artículos del pedido. <strong>Ej.: Algún tipo de restricción alimentaria...</strong>'; 
        $stCONFIRMAR = 'Confirmar';       

        break;

    case 'de':
        $stTOTAL_LEYENDA = 'Gesamt';
        $stBOTON1 = 'QR-Code für Bestellung generieren';
        $stBOTON2 = 'Bestellung generieren';
        $stLEYENDA = 'Bestellungs-QR-Code';
        $stTITULO_PAGINA = 'Warenkorb';
        $stMENSAJE_CART = 'Kontrolle und Schnelligkeit Ihrer Bestellungen. Überprüfen Sie Bestellungen immer sorgfältig.';
        $stOBSERVACION = 'Beobachtung';
        $stCASO_QUIERA= 'Wenn Sie möchten, fügen Sie Beobachtungen zu den Artikeln in der Bestellung hinzu. <strong>Ex.: Irgendeine Art von diätetischer Einschränkung...</strong>';
        $stCONFIRMAR = 'Bestätigen';

        break;
}


$stHAY_PEDIDO = count($aValues);

$oSmarty->assign('stTOTAL_LEYENDA', $stTOTAL_LEYENDA);
$oSmarty->assign('stMENSAJE_CART', $stMENSAJE_CART);
$oSmarty->assign('stHAY_PEDIDO', $stHAY_PEDIDO);
$oSmarty->assign('stBOTON1', $stBOTON1);
$oSmarty->assign('stBOTON2', $stBOTON2);
$oSmarty->assign('stLEYENDA', $stLEYENDA);
$oSmarty->assign('stOBSERVACION', $stOBSERVACION);
$oSmarty->assign('stCASO_QUIERA', $stCASO_QUIERA);
$oSmarty->assign('stCONFIRMAR', $stCONFIRMAR);


$oSmarty->assign('stTITULO_PAGINA', $stTITULO_PAGINA);
$oSmarty->display('ementa' . $plantilla . '/cart.tpl');
//$oSmarty->display('ementa1/cart.tpl');
