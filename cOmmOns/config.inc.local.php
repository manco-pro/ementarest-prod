<?php
date_default_timezone_set('UTC');
if (strtolower($_SERVER['SERVER_NAME']) == 'localhost') {
    $DEBUG = TRUE;
    $SMARTY_DEBUG = FALSE;
 
    $_PATH['ROOT'] = 'C:/www/promo-resto/';
    $_PATH['WEB'] = 'http://localhost/promo-resto/';

    define('INDEX_PAGE', 'index.php');
} else {
    $DEBUG = TRUE;
    $SMARTY_DEBUG = FALSE;
  
    $_PATH['ROOT'] = '/var/www/AQUIHAGATO-NEWSLETTER.PT/';
    $_PATH['WEB'] = 'http://aquihagato-newsletter.pt/';

    define('INDEX_PAGE', 'index.php');
}
//-------------------------------------------------------------------
/* carpetas con archivos que complementan los abm------------------------------------------------ */
$_PATH['COMMONS'] = 'cOmmOns/';
$_PATH['IMAGES'] = $_PATH['COMMONS'] . 'images/';
$_PATH['IMAGES_CAT'] = $_PATH['IMAGES'] . 'catalogos/';
$_PATH['IMAGES_COL'] = $_PATH['IMAGES'] . 'colecciones/';
$_PATH['JSCRIPT'] = $_PATH['COMMONS'] . 'jscript/';
$_PATH['QR'] = $_PATH['COMMONS'] . 'QR/';
$_PATH['ESTILO'] = $_PATH['COMMONS'] . 'estilo/';
$_PATH['EDITOR'] = $_PATH['COMMONS'] . 'editor/';
$_PATH['CALENDARIO'] = $_PATH['COMMONS'] . 'calendario/';
$_PATH['AUTO'] = $_PATH['JSCRIPT'] . 'auto/';


/* fin carpetas con archivos que complementan los abm------------------------------------------------ */

$_PATH['CSS'] = $_PATH['COMMONS'] . 'css/';
$_PATH['JS'] = $_PATH['JSCRIPT'] . 'js/';
$_PATH['VENDOR'] = 'vendor/';
$_PATH['PHP-IMG'] = $_PATH['VENDOR']. 'php-upload-files/';
$_PATH['TEMPLATES'] = 'templates';
$_PATH['TEMPLATE_DIR'] = 'template/dir';
$_PATH['CONFIG_DIR'] = 'config/dir';
$_PATH['COMPILE_DIR'] = 'compile/dir';
$_PATH['CACHE_DIR'] = 'cache/dir';

/* carpetas con abm------------------------------------------------ */
$_PATH['ADMIN'] = 'AdmIn/';


$_PATH['CAT'] = $_PATH['ADMIN'] . 'Catalogos/';
$_PATH['COL'] = $_PATH['ADMIN'] . 'Colecciones/';
$_PATH['ADM'] = $_PATH['ADMIN'] . 'Administrador/';
$_PATH['LOJ'] = $_PATH['ADMIN'] . 'Lojas/';
$_PATH['EMP'] = $_PATH['ADMIN'] . 'Empleados/';
$_PATH['PED'] = $_PATH['ADMIN'] . 'Pedidos/';

/* fin carpetas con imagenes------------------------------------------------ */

$_PATH['EMENTA']    = $_PATH['ROOT'];
$_PATH['ASSETS']    = $_PATH['EMENTA'] . 'assets/';
//* carpetas con imagenes------------------------------------------------ */
//	$_PATH['FPE'] = 'arc_up/peliculas/';
//	$_PATH['FNO'] = 'arc_up/notas/';
//	$_PATH['FTE'] = 'arc_up/textures/';
//	$_PATH['FDE'] = 'arc_up/designers/';
//	$_PATH['FNE'] = 'arc_up/newsletter/';
/* fin carpetas con imagenes------------------------------------------------ */

require_once $_PATH['ROOT'] . 'vendor/autoload.php';
$oSmarty = new Smarty();
$oSmarty->debugging = $SMARTY_DEBUG;
$oSmarty->compile_check = !$SMARTY_DEBUG;

$oSmarty->setTemplateDir(getLocal('TEMPLATE_DIR'));
$oSmarty->setConfigDir(getLocal('CONFIG_DIR'));
$oSmarty->setCompileDir(getLocal('COMPILE_DIR'));
$oSmarty->setCacheDir(getLocal('CACHE_DIR'));

$oSmarty->assign('stAACTUAL', date('Y'));
$oSmarty->assign('stINDEX_PAGE', INDEX_PAGE);
$oSmarty->assign('stWEBHOME', $_PATH['WEB']);
$oSmarty->assign('stRUTAS', getAllWeb());

if ($DEBUG) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

function getAllWeb() {
    global $_PATH;
    foreach ($_PATH as $key => $value) {
        $newKey = strtolower($key);
        if ($key == 'root' || $key == 'web') {
            $RUTAS[$newKey] = $value;
        } else {
            $RUTAS[$newKey] = $_PATH['WEB'] . $value;
        }
    }
    return $RUTAS;
}

function getAllLocal() {
    global $_PATH;
    foreach ($_PATH as $key => $value) {
        $newKey = strtolower($key);
        if ($key == 'root' || $key == 'web') {
            $RUTAS[$newKey] = $value;
        } else {
            $RUTAS[$newKey] = $_PATH['ROOT'] . $value;
        }
    }
    return $RUTAS;
}

function getWeb($que) {
    global $_PATH;
    $que = strtoupper($que);
    if ($que == 'ROOT' || $que == 'WEB') {
        return $_PATH[$que];
    }
    if (isset($_PATH[$que])) {
        return $_PATH['WEB'] . $_PATH[$que];
    } else {
        return "";
    }
}

function getLocal($que) {
    global $_PATH;
    $que = strtoupper($que);
    if ($que == 'ROOT' || $que == 'WEB') {
        return $_PATH[$que];
    }
    if (isset($_PATH[$que])) {
        return $_PATH['ROOT'] . $_PATH[$que];
    } else {
        return "";
    }
}

function obtenerValorPOST($clave, $filtro = FILTER_DEFAULT) {
    // Verificar si la clave existe en $_POST
    if (isset($_POST[$clave])) {
        // Aplicar el filtro especificado (puedes ajustar según tus necesidades)
        return filter_input(INPUT_POST, $clave, $filtro);
    } else {
        // Devolver un valor predeterminado o manejar el error según sea necesario
        return null;
    }
}

function obtenerValorGET($clave, $filtro = FILTER_DEFAULT) {
    // Verificar si la clave existe en $_GET
    if (isset($_GET[$clave])) {
        // Aplicar el filtro especificado (puedes ajustar según tus necesidades)
        return filter_input(INPUT_GET, $clave, $filtro);
    } else {
        // Devolver un valor predeterminado o manejar el error según sea necesario
        return null;
    }
}

function obtenerValor($clave, $filtro = FILTER_DEFAULT) {
    // Verificar si la clave existe en $_GET
    if (isset($_REQUEST[$clave])) {
        // Aplicar el filtro especificado (puedes ajustar según tus necesidades)
        return $_REQUEST[$clave];
    } else {
        // Devolver un valor predeterminado o manejar el error según sea necesario
        return null;
    }
}
