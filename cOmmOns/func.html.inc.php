<?php

/**
 * se pasa un array $datos el indice es el value del option y el dato contenido en el indice es el que se va a mostrar
 * devuelve una cadena de texto la cual dibujara los options del select
 * @param array $datos
 * @param indice que va a estar seleccionado $seleccionado
 * @return cadena de texto que forma los options de un select
 */
function llenarSelect($datos, $seleccionado = "")
{ //
    $Opciones = ""; //
    if (count($datos) > 0) {
        foreach ($datos as $indice => $valor) { //
            $elegida = ""; //
            if ($indice == $seleccionado) {
                $elegida = " SELECTED ";
            } //
            $valor = htmlentities($valor);

            $Opciones .= "<option value='$indice' $elegida>$valor</option>\n"; // se arma el html para select
        }
    }
    return $Opciones; //
}

/* -------------------------------------------------- */

function HandlerSelect($handler, $seleccionado = '', $nombre_select = '')
{
    $arrResult = array();
    if ($seleccionado == '' || $seleccionado == '-1') {
        $arrResult[-1] = $nombre_select;
    }
    foreach ($handler as $Items => $Item) {
        $keys = array_keys($Item);
        $id = $Item[$keys[0]];
        $arrResult[$id] = $Item[$keys[1]];
    }
    return llenarSelect($arrResult, $seleccionado);
}

/* ---------------------------------------------------- */

function HandlerSelectMultiple($handler, $seleccionado)
{
    $arrResult = array();
    while ($handler && $fila = mysqli_fetch_array($handler)) {
        $id = $fila[0];
        $arrResult[$id] = $fila[1];
    }
    return llenarSelectMultiple($arrResult, $seleccionado);
}

//------------------------------------------------------------------------------------
function llenarSelectMultiple($datos, $seleccionados)
{
    $Opciones = "";
    if (!is_array($seleccionados)) {
        $seleccionados = array($seleccionados);
    }
    foreach ($datos as $indice => $valor) {
        $elegida = "";
        if (in_array($indice, $seleccionados)) {
            $elegida = " SELECTED ";
            $Opciones .= "<option value='$indice' $elegida>$valor</option>\n";
        }
    }
    return $Opciones;
}

//------------------------------------------------------------------------------------
function noCache()
{
   header("Expires: Mon, 26 Jul 1997 05:00:00 UTC");
   header("Last-Modified: " . date("D, d M Y H:i:s") . " UTC");
   header("Cache-Control: no-store, no-cache, must-revalidate");
   header("Cache-Control: post-check=0, pre-check=0", false);
   header("Pragma: no-cache");
}

//------------------------------------------------------------------------------------

/**
 * direcciona a una pagina o escribe con en echo un link deacuerdo a los parametros que le pasemos
 * si no utilizamos la variable $dlink direccionara a otra pagina
 * @param url $pagina
 * @param texto del link $dlink
 */
function redireccionar($pagina, $dlink = "")
{
    if (empty($dlink)) {
        header("Location: $pagina");
    } else {
        echo "<a href='$pagina'>$dlink</a>";
    }
    exit();
}

//------------------------------------------------------------------------------------

/**
 * se pasa en numero de mes y devuelve el nombre del mismo
 * 	$idioma si no se usa por defecto es espa�ol, si se usa puede ser en,fr,de
 * @param numero 1-12 $nro_mes
 * @param es,en,fr,de $idioma
 * @return  nombre mes
 */
function nombresMes($nro_mes, $idioma = 'es')
{
    $nro_mes = is_int($nro_mes) ? $nro_mes : (int) $nro_mes;
    $nro_mes = $nro_mes > 0 && $nro_mes < 13 ? $nro_mes : 1;

    $arMeses = array(
        'es' => array(1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'),
        'en' => array(1 => 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        'fr' => array(1 => 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Dicembre'),
        'pt' => array(1 => 'Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'),
        'de' => array(1 => 'Januar', 'Februar', 'Marz', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember')
    );
    return $arMeses[$idioma][$nro_mes];
}

//------------------------------------------------------------------------------------

/**
 * se pasa en numero de dia y devuelve el nombre del mismo
 * 	$idioma si no se usa por defecto es espa�ol, si se usa puede ser en,fr,de
 * @param numero 1-12 $nro_dia
 * @param es,en,fr,de $idioma
 * @return  nombre dia
 */
function diaSemana($nro_dia, $idioma = 'es')
{
    $nro_dia = is_int($nro_dia) ? $nro_dia : (int) $nro_dia;
    $nro_dia = $nro_dia >= 0 && $nro_dia <= 6 ? $nro_dia : 0;

    $arrDias = array(
        'es' => array('Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'),
        'en' => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'),
        'fr' => array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'),
        'pt' => array('Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'S&aacute;bado'),
        'de' => array('Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag')
    );
    return $arrDias[$idioma][$nro_dia];
}

//------------------------------------------------------------------------------------
function numDiaSemana($mes, $anio)
{
    $numDiaSemana = date('w', mktime(0, 0, 0, $mes, 1, $anio));
    $numDiaSemana = $numDiaSemana == 0 ? 6 : $numDiaSemana - 1;

    return $numDiaSemana;
}

//------------------------------------------------------------------------------------
function ultimoDiaMes($mes, $anio)
{
    $ultimoDia = 28;
    while (checkdate($mes, $ultimoDia + 1, $anio)) {
        $ultimoDia++;
    }
    return $ultimoDia;
}

function sobreescribirEntidadesHTML($array) {
    // Recorrer cada subarray
    foreach ($array as $indice1 => $subarray) {
        // Verificar si el elemento es un array
        if (is_array($subarray)) {
            // Si es un array, recorrer cada elemento del subarray
            foreach ($subarray as $indice2 => $elemento) {
                // Verificar si el elemento es una cadena de texto
                if (is_string($elemento)) {
                    // Convertir entidades HTML a caracteres correspondientes
                    $array[$indice1][$indice2] = html_entity_decode($elemento, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
        } else {
            // Si es una cadena de texto, convertir entidades HTML a caracteres correspondientes
            $array[$indice1] = html_entity_decode($subarray, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
    }
    return $array;
}
