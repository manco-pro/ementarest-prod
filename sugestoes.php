<?php
require_once './cOmmOns/config.inc.php';
require_once getLocal('EMENTA') . 'sesion_persit.inc.php';
require_once getLocal('COL') . 'class.colecciones.inc.php';
require_once getLocal('EMENTA') . 'header_menu.php';
$oColecciones = new clsColecciones();
$oColecciones->clearColecciones();
$oColecciones->clearErrors();
$_SESSION['_footerbar'] = 'Sugestoes';
$plantilla = $_SESSION['Plantilla'];
$Catalogo_Id = obtenerValorGET('cat');
$Coleccion_id = obtenerValorGET('col');

$ArrayColecciones = $oColecciones->GetAllColeccionByDestacados_ForEmenta($_SESSION['LojaId']);
if ($ArrayColecciones == false) {
    redireccionar(getWeb('EMENTA') . 'index.php');
}
$oSmarty->assign('NOMBRE', "nombre_" . $_SESSION['idioma']);
$oSmarty->assign('DESCRIPCION', "descripcion_" . $_SESSION['idioma']);
$oSmarty->assign('stACTIVA', $_SESSION['_footerbar']);
$oSmarty->assign('stCOLECCION_ID', $Coleccion_id);
$oSmarty->assign('stLINKCOMPARTIR', $_PATH['WEB'] . $_SESSION['LojaRuta_Ementa'] . '?cat=sug&lang=' . $_SESSION['idioma']);
$oSmarty->assign('stCOLECCIONES', $ArrayColecciones);
$oSmarty->assign('stMORADA', $_SESSION['LojaMorada']);
$oSmarty->assign('stNOMBRE_RESTO', $_SESSION['LojaNombre']);

switch ($_SESSION['idioma']) {
    case 'pt':
        $stDETELLES_MENSAJE = 'Detalhes';
        $stMENSAJE1 = 'O Produto foi inserido com sucesso.';
        $stDESCRIPCION = 'Descri&ccedil;&atilde;o';
        $stRECOMENDAR = 'Recomende este prato para seus amigos!';
        $stMENSAJE_RECOMENDAR = '"Deixe-se levar pelos sabores excepcionais deste prato."';
        $stBEBIDA_SUGERIDA = 'Bebida sugerida';
        $stTITULO_PAGINA = 'Sugest&otilde;es';

        break;
    case 'fr':
        $stDETELLES_MENSAJE = 'D&eacute;tails';

        $stMENSAJE1 = 'Le produit a &eacute;t&eacute; ins&eacute;r&eacute; avec succ&egrave;s.';
        $stDESCRIPCION = 'Description';
        $stRECOMENDAR = 'Recommandez ce plat &agrave; vos amis !';
        $stMENSAJE_RECOMENDAR = 'Laissez-vous emporter par les saveurs exceptionnelles de ce plat.';
        $stBEBIDA_SUGERIDA = 'Boisson sugg&eacute;r&eacute;e';
        $stTITULO_PAGINA =  'Suggestions';

        break;
    case 'en':
        $stDETELLES_MENSAJE = 'Details';
        $stMENSAJE1 = 'The Product has been inserted successfully.';
        $stDESCRIPCION = 'Description';
        $stRECOMENDAR = 'Recommend this dish to your friends!';
        $stMENSAJE_RECOMENDAR = 'Let yourself be carried away by the exceptional flavors of this dish.';
        $stBEBIDA_SUGERIDA = 'Suggested Drink';
        $stTITULO_PAGINA =  'Suggestions';

        break;
    case 'es':
        $stDETELLES_MENSAJE = 'Detalles';
        $stMENSAJE1 = 'El Producto se ha insertado correctamente.';
        $stDESCRIPCION = 'Descripci&oacute;n';
        $stRECOMENDAR = '&iexcl;Recomienda este plato a tus amigos!';
        $stMENSAJE_RECOMENDAR = 'D&eacute;jate llevar por los sabores excepcionales de este plato.';
        $stBEBIDA_SUGERIDA = ' Bebida sugerida';
        $stTITULO_PAGINA =  'Sugerencias';

        break;
    case 'de':
        $stDETELLES_MENSAJE = 'Details';
        $stMENSAJE1 = 'Het product is succesvol geplaatst.';
        $stDESCRIPCION = 'Beschrijving';
        $stRECOMENDAR = 'Beveel dit gerecht aan bij je vrienden!';
        $stMENSAJE_RECOMENDAR = 'Laat u meeslepen door de uitzonderlijke smaken van dit gerecht.';
        $stBEBIDA_SUGERIDA = 'Aanbevolen drankje';
        $stTITULO_PAGINA =  'Suggesties';

        break;
}

$oSmarty->assign('stDETELLES_MENSAJE', $stDETELLES_MENSAJE);
$oSmarty->assign('stMENSAJE1', $stMENSAJE1);
$oSmarty->assign('stDESCRIPCION', $stDESCRIPCION);
$oSmarty->assign('stRECOMENDAR', $stRECOMENDAR);
$oSmarty->assign('stMENSAJE_RECOMENDAR', $stMENSAJE_RECOMENDAR);
$oSmarty->assign('stBEBIDA_SUGERIDA', $stBEBIDA_SUGERIDA);

$oSmarty->assign('stTITULO_PAGINA', $stTITULO_PAGINA);
$oSmarty->display('ementa' . $plantilla . '/productos.tpl');
