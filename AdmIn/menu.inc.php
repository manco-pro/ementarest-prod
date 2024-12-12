<?php
require_once getLocal('ADMIN') . 'sesion_admin.inc.php';
require_once getLocal('MEN') . 'class.mensajes.inc.php';

// Admin All
//  dashboard -->1
//  administradores-->2
//  lojas-->3
//  subscrições-->4
//  catalogos-->6
//  productos-->7
//  empregados-->8
//  mensagens-->9
//  qr-->10
//  categorias-->6
//  produtos-->7
//  empregados-->8
//  pedidos-->11
//  stock -->12
//----------------
//plano P
//  dashboard -->1
//  mia loja-->5
//  catalogos-->6
//  productos-->7
//  empregados-->8
//  mensagens-->9
//  qr-->10
//  pedidos-->11
//  stock -->12
//----------------
//plano s
//  dashboard -->1
//  mia loja-->5
//  catalogos-->6
//  productos-->7
//  empregados-->8
//  mensagens-->9
//  qr-->10
//  pedidos-->11
//----------------
//plano b
// dashboard -->11 
// mia loja-->5
// catalogos-->6
// productos-->7
// mensagens-->9
// qr-->10
//----------------


$aPlano = array(
    'A' => array(0, 2, 3, 4, 6, 7, 8, 9, 10,  11, 12, 13, 14),
    'P' => array(1, 5, 6, 7, 8, 9, 10,  11, 12, 13, 14),
    'S' => array(1, 5, 6, 7, 8, 9, 10,  11, 13, 14),
    'B' => array(5, 6, 7, 9, 13, 14)
);


$_content = array();

/*---menues---------------------------------------------------------------------------------------*/
$_content[0] = array('Desc' => 'Dashboard', 'Link' => getWeb('ADMIN') . 'contenido_admin.php', 'Img' => 'fas fa-tachometer-alt', 'Active' => active(getWeb('ADMIN')));
$_content[1] = array('Desc' => 'Dashboard', 'Link' => getWeb('ADMIN') . 'contenido.php', 'Img' => 'fas fa-tachometer-alt', 'Active' => active(getWeb('ADMIN')));

$_content[2] = array('Desc' => 'Administradores', 'Link' => getWeb('ADM') . 'adm.listar.php', 'Img' => 'fas fa-solid fa-user', 'Active' => active(getWeb('ADM')));
$_content[3] = array('Desc' => 'Lojas', 'Link' => getWeb('LOJ') . 'loj.listar.php', 'Img' => 'fas fa-store-alt', 'Active' => active(getWeb('LOJ')));
$_content[4] = array('Desc' => 'subscri&ccedil;&otilde;es', 'Link' => getWeb('SUS') . 'sus.listar.php', 'Img' => 'fas fa-money-check-alt', 'Active' => active(getWeb('SUS')));

$_content[5] = array('Desc' => 'A minha Loja', 'Link' => getWeb('LOJ') . 'loj.modificar.php?id=' . $_SESSION['_admLojaId'], 'Img' => 'fas fa-store-alt', 'Active' => active(getWeb('LOJ')));

$_content[6] = array('Desc' => 'Cat&aacute;logos', 'Link' => getWeb('CAT') . 'cat.listar.php', 'Img' => 'fas fa-server', 'Active' => active(getWeb('CAT')));
$_content[7] = array('Desc' => 'Produtos', 'Link' => getWeb('COL') . 'col.listar.php', 'Img' => 'far fa-hdd', 'Active' => active(getWeb('COL')));
$_content[8] = array('Desc' => 'Empregados', 'Link' => getWeb('EMP') . 'emp.listar.php', 'Img' => 'fas fa-users', 'Active' => active(getWeb('EMP')));
$_content[9] = array('Desc' => 'Mensagens', 'Link' => getWeb('MEN') . 'men.listar.php', 'Img' => 'fas fa-envelope', 'Active' => active(getWeb('MEN')));
//$_content[10] = array('Desc' => 'QR', 'Link' => getWeb('QR') . 'qr.listar.php', 'Img' => 'fas fa-qrcode', 'Active' => active(getWeb('QR')));
//-------------------------------------------------
$_content[10] = array('Desc' => 'Pedidos', 'Link' => '#', 'Img' => 'fas fa-concierge-bell', 'Active' => active(getWeb('PED')));
$_content[10][1] = array('Desc' => 'Pedidos Ativos', 'Link' => getWeb('PED') . 'ped.listaract.php', 'Img' => '');
$_content[10][2] = array('Desc' => 'Todos os Pedidos', 'Link' => getWeb('PED') . 'ped.listar.php', 'Img' => '');
//-------------------------------------------------
$_content[11] = array('Desc' => 'Vendas', 'Link' => getWeb('VEN') . 'ven.listar.php', 'Img' => 'fas fa-file-invoice-dollar', 'Active' => active(getWeb('VEN')));
$_content[12] = array('Desc' => 'Stock', 'Link' => getWeb('STK') . 'stk.listar.php', 'Img' => 'fas fa-cubes', 'Active' => active(getWeb('STK')));
$_content[13] = array('Desc' => 'Eventos', 'Link' => getWeb('EVE') . 'eve.listar.php', 'Img' => 'fas fa-newspaper', 'Active' => active(getWeb('EVE')));
$_content[14] = array('Desc' => 'Mesas / QRs', 'Link' => getWeb('MES') . 'mes.listar.php', 'Img' => 'fas fa-table', 'Active' => active(getWeb('MES')));

//$_content[] = array('Desc' => 'Logout', 'Link' => getWeb('ADMIN') . 'logout.php', 'Img' => 'fas fa-sign-out-alt','Active' => active(getWeb('ADMIN')));

switch ($_SESSION['_admSuscripcion']) {
    case 'P':
        $aPlano = $aPlano['P'];

        break;
    case 'S':
        $aPlano = $aPlano['S'];

        break;
    case 'B':
        $aPlano = $aPlano['B'];

        break;

    default:
        $aPlano = $aPlano['A'];
        break;
}

if ($aPlano !== null) {
    $_content = array_intersect_key($_content, array_flip($aPlano));
}


$oSmarty->assign('_stCONTENT', $_content);



//----------------------------------------------------------------------------------------------------------
function active($valor)
{
    if (strtolower($_SERVER['SERVER_NAME']) == 'localhost') {
        $arrays = explode('/', $valor); //3 y 4
        $var = $_SERVER['PHP_SELF'];
        $arrays1 = explode('/', $var); // 4 y 6
        $active = "";
        if (($arrays[4] == $arrays1[2]) && ($arrays[5] == $arrays1[3])) {
            $active = "active";
        } elseif (($arrays[5] == '') && ($arrays1[3] == 'contenido.php')) {
            $active = "active";
        }
        return $active;
    } else {

        $arrays = explode('/', $valor); //3 y 4

        $var = $_SERVER['PHP_SELF'];
        $arrays1 = explode('/', $var); // 4 y 6
        $active = "";

        if (($arrays[3] == $arrays1[1]) && ($arrays[4] == $arrays1[2])) {
            $active = "active";
        } elseif (($arrays[4] == '') && ($arrays1[2] == 'contenido.php')) {
            $active = "active";
        }
        return $active;
    }
}


//-listar mensajes top bar----------------------------------------------------------------

$oMensajes = new clsMensajes();
$stMENSAJES_DASHBOARD = array();
$stCANT_MENSAJES = '';
$stMENSAJES_DASHBOARD = $oMensajes->GetAllmensajesInLoja($_SESSION['_admLojaId']);
if ($stMENSAJES_DASHBOARD !== null) {
    $stCANT_MENSAJES = count($stMENSAJES_DASHBOARD);
}





$_profile   = getWeb('ADM') . 'adm.misdatos.php?id=' . $_SESSION['_admId'];
$_logout    = getWeb('ADMIN') . 'logout.php';

$_fechapie = diaSemana(date('w'), 'pt') . ', ' . date('d') . ' de ' . nombresMes(date('m'), 'pt') . ' de ' . date('Y');

$oSmarty->assign('Usuario', $_SESSION['_admNombre'] . ' ' . $_SESSION['_admApellido']);
$oSmarty->assign('stCANT_MENSAJES', $stCANT_MENSAJES);
$oSmarty->assign('stMENSAJES_DASHBOARD', $stMENSAJES_DASHBOARD);
$oSmarty->assign('_PROFILE', $_profile);
$oSmarty->assign('_LOGOUT', $_logout);
$oSmarty->assign('_FECHAPIE', $_fechapie);
