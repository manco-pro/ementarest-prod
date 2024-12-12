<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsColecciones
{

    var $id = 0;
    var $nombre_pt = '';
    var $nombre_en = '';
    var $nombre_fr = '';
    var $nombre_es = '';
    var $nombre_de = '';
    var $descripcion_pt = '';
    var $descripcion_en = '';
    var $descripcion_fr = '';
    var $descripcion_es = '';
    var $descripcion_de = '';
    var $imagen = '';
    var $precio = '';
    var $catalogo_id = 0;
    var $bebidas_ids = '';
    var $sugerencias_colecciones_ids = '';
    var $destacado = '';
    var $enabled = '';
    var $unidad = ''; // D=doce;P=peso fijo 2peso
    var $ingredientes = '';
    var $intolerancias = '';
    var $orden = 0;

    var $Errors = array();
    var $DB;

    function clsColecciones()
    {
        $this->clearColecciones();
        $this->DB = new clsMySqliDB();
    }

    function clearColecciones()
    {
        $this->id = 0;
        $this->nombre_pt = '';
        $this->nombre_en = '';
        $this->nombre_fr = '';
        $this->nombre_es = '';
        $this->nombre_de = '';
        $this->descripcion_pt = '';
        $this->descripcion_en = '';
        $this->descripcion_fr = '';
        $this->descripcion_es = '';
        $this->descripcion_de = '';
        $this->imagen = '';
        $this->precio = '';
        $this->catalogo_id = 0;
        $this->bebidas_ids = '';
        $this->sugerencias_colecciones_ids = '';
        $this->destacado = '';
        $this->enabled = '';
        $this->unidad = 0; // 1 para kg || 0 para dosis
        $this->ingredientes = '';
        $this->intolerancias = '';
        $this->orden = 0;

        $this->DB = new clsMySqliDB();
        $this->Errors = array();
    }

    function Validate()
    {
        if (empty($this->Errors)) {
            return TRUE;
        } else {
            return false;
        }
    }

    function Registrar()
    {

        $qInsert = " INSERT INTO colecciones( "
            . " nombre_pt, "
            . " nombre_en, "
            . " nombre_fr, "
            . " nombre_es, "
            . " nombre_de, "
            . " descripcion_pt, "
            . " descripcion_en, "
            . " descripcion_fr, "
            . " descripcion_es, "
            . " descripcion_de, "
            . " imagen, "
            . " precio, "
            . " catalogo_id, "
            . " bebidas_ids, "
            . " sugerencias_colecciones_ids, "
            . " destacado, "
            . " enabled, "
            . " unidad, "
            . " ingredientes, "
            . " orden,"
            . " intolerancias )"
            . " VALUES( "
            . "'$this->nombre_pt' ,"
            . "'$this->nombre_en' ,"
            . "'$this->nombre_fr' ,"
            . "'$this->nombre_es' ,"
            . "'$this->nombre_de' ,"
            . "'$this->descripcion_pt' ,"
            . "'$this->descripcion_en' ,"
            . "'$this->descripcion_fr' ,"
            . "'$this->descripcion_es' ,"
            . "'$this->descripcion_de' ,"
            . "'$this->imagen' ,"
            . " $this->precio ,"
            . " $this->catalogo_id ,"
            . "'$this->bebidas_ids' ,"
            . "'$this->sugerencias_colecciones_ids' ,"
            . "'$this->destacado' ,"
            . "'$this->enabled' ,"
            . "$this->unidad ,"
            . "'$this->ingredientes' ,"
            . "$this->orden ,"
            . "'$this->intolerancias');";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O produto n&atilde;o pode ser registrado.';
            return false;
        }

        $this->setId($rInsert);
        //if ($this->orden != 0) {
        //    if (!$this->ActualizarOrden($this->id, $this->orden)) {
        //        $this->Errors['Register'] = 'err 41.';
        //        return false;
        //    };
        //}
        return true;
    }
    //----------------------------------------------------------------------------------
    function SelectDestacados($loja_id)
    {
        $query_Todos = "SELECT
        col.id col,
        col.catalogo_id AS cat,
        col.orden
    FROM
        colecciones AS col
    INNER JOIN catalogos AS cat
    ON
        cat.id = col.catalogo_id
    WHERE
        orden <> 0 AND cat.loja_id =(
        SELECT DISTINCT
            cat.loja_id AS lojas
        FROM
            colecciones AS col
        INNER JOIN catalogos AS cat
        ON
            cat.id = col.catalogo_id
        WHERE
            cat.loja_id = $loja_id
    )ORDER BY orden ASC;";

        $result_Todos = $this->DB->Select($query_Todos, 'all');
        $indice = 1;
        if ($result_Todos != false) {
            foreach ($result_Todos as $key => $value) {
                while ($indice < $value['orden']) {
                    $aSelect[$indice] =  $indice;
                    $indice++;
                }
                $indice++;
            }
        }

        while ($indice <= 30) {
            $aSelect[$indice] =  $indice;
            $indice++;
        }

        return $aSelect;
    }

    /* ----------------produto admin-------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM colecciones WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O produto n&atilde;o existe.";
        }

        if (!$this->Validate()) {
            return false;
        }

       $qModificar = "UPDATE colecciones SET "
            . " nombre_pt 					= '$this->nombre_pt', "
            . " nombre_en 					= '$this->nombre_en', "
            . " nombre_fr 					= '$this->nombre_fr', "
            . " nombre_es 					= '$this->nombre_es', "
            . " nombre_de 					= '$this->nombre_de', "
            . " descripcion_pt 				= '$this->descripcion_pt', "
            . " descripcion_en 				= '$this->descripcion_en', "
            . " descripcion_fr			 	= '$this->descripcion_fr', "
            . " descripcion_es			 	= '$this->descripcion_es', "
            . " descripcion_de			 	= '$this->descripcion_de', "
            . " imagen 						= '$this->imagen', "
            . " precio 						=  $this->precio, "
            . " catalogo_id 				=  $this->catalogo_id, "
            . " bebidas_ids 				= '$this->bebidas_ids', "
            . " sugerencias_colecciones_ids = '$this->sugerencias_colecciones_ids', "
            . " destacado 					= '$this->destacado', "
            . " enabled 					= '$this->enabled', "
            . " unidad 						=  $this->unidad, "
            . " ingredientes 				= '$this->ingredientes', "
            . " orden 						=  $this->orden, "
            . " intolerancias 				= '$this->intolerancias' "
            . " WHERE id = $this->id ;";
        
        $rModificar = $this->DB->Update($qModificar);


        if (!$rModificar) {
            $this->Errors['Modificar'] = "O produto n&atilde;o pode ser modificado.";
            return false;
        }
        //if ($this->orden != 0) {
        //    if (!$this->ActualizarOrden($this->id, $this->orden)) {
        //        $this->Errors['Modificar'] = 'err 41.';
        //        return false;
        //    };
        //}
        return TRUE;
    }
    //----------------------------------------------------------------------------------
    function Borrar()
    {
        $SQL = "DELETE FROM colecciones WHERE id = $this->id;";

        $result = $this->DB->Remove($SQL);

        if (!$result) {
            $this->Errors['Id'] = 'O produto n&atilde;o existe.';
            return false;
        }

        return TRUE;
    }

    /* ------------------------------------------------------------------------- */
    function UpdateEstado()
    {
        $query = "UPDATE colecciones SET enabled = '$this->enabled' WHERE id = $this->id;";
        $result = $this->DB->Update($query);

        if (!$result) {
            $this->Errors['UpdateEstado'] = 'Erro interno.';
            return false;
        }
        return true;
    }
    /* -----------------  FINDS  ----------------------------------------------- */
    function findId($valor)
    {
        $this->clearColecciones();
        try {
            if ($valor <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM colecciones WHERE id = $valor;";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['Id'] = 'O produto n&atilde;o existe.';
                return false;
            }

            $this->id = $result['id'];
            $this->nombre_pt = $result['nombre_pt'];
            $this->nombre_en = $result['nombre_en'];
            $this->nombre_fr = $result['nombre_fr'];
            $this->nombre_es = $result['nombre_es'];
            $this->nombre_de = $result['nombre_de'];
            $this->descripcion_pt = $result['descripcion_pt'];
            $this->descripcion_en = $result['descripcion_en'];
            $this->descripcion_fr = $result['descripcion_fr'];
            $this->descripcion_es = $result['descripcion_es'];
            $this->descripcion_de = $result['descripcion_de'];
            $this->imagen = $result['imagen'];
            $this->precio = $result['precio'];
            $this->catalogo_id = $result['catalogo_id'];
            $this->bebidas_ids = $result['bebidas_ids'];
            $this->sugerencias_colecciones_ids = $result['sugerencias_colecciones_ids'];
            $this->destacado = $result['destacado'];
            $this->enabled = $result['enabled'];
            $this->unidad = $result['unidad']; // 1 para kg || 0 para dosis
            $this->ingredientes = $result['ingredientes'];
            $this->intolerancias = $result['intolerancias'];
            $this->orden = $result['orden'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }

    //------------------------------------------------------------------------------
    function GetAllColeccionByCatalogoId($valor)
    {
        $this->clearColecciones();

        try {
            if ($valor <= 0) {
                $this->Errors['GetAllColeccionByCatalogoId'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM colecciones WHERE catalogo_id = $valor ORDER BY id ASC;";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllColeccionByCatalogoId'] = 'O produto n&atilde;o existe.';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllColeccionByCatalogoId'] = $e->getMessage();
            return false;
        }
    }
    //------------------------------------------------------------------------------
    function GetSugerenciasBebidas($SugerenciasIds)
    {
        try {

            $query = "SELECT "
                . "C.id, "
                . "C.nombre_pt, "
                . "C.nombre_fr, "
                . "C.nombre_en, "
                . "C.nombre_es, "
                . "C.nombre_de, "
                . "C.imagen, "
                . "C.descripcion_pt, "
                . "C.descripcion_fr, "
                . "C.descripcion_en, "
                . "C.descripcion_es, "
                . "C.descripcion_de, "
                . "C.precio "
                . "FROM "
                . "colecciones AS C "
                . "INNER JOIN catalogos AS cat "
                . "ON "
                . "cat.id = C.catalogo_id "
                . "WHERE "
                . "cat.template = 2 AND C.id IN($SugerenciasIds) "
                . "ORDER BY "
                . "C.nombre_pt ASC;";
            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                $this->Errors['GetAllColeccionByCatalogoId'] = 'O produto n&atilde;o existe.';
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['nombre_pt'] = $this->DB->forShow($value['nombre_pt']);
                $aValues[$Id]['nombre_fr'] = $this->DB->forShow($value['nombre_fr']);
                $aValues[$Id]['nombre_en'] = $this->DB->forShow($value['nombre_en']);
                $aValues[$Id]['nombre_es'] = $this->DB->forShow($value['nombre_es']);
                $aValues[$Id]['nombre_de'] = $this->DB->forShow($value['nombre_de']);
                $aValues[$Id]['imagen'] = $this->DB->forSave($value['imagen']);
                $aValues[$Id]['descripcion_pt'] = $this->DB->forHtml($value['descripcion_pt']);
                $aValues[$Id]['descripcion_fr'] = $this->DB->forHtml($value['descripcion_fr']);
                $aValues[$Id]['descripcion_en'] = $this->DB->forHtml($value['descripcion_en']);
                $aValues[$Id]['descripcion_es'] = $this->DB->forHtml($value['descripcion_es']);
                $aValues[$Id]['descripcion_de'] = $this->DB->forHtml($value['descripcion_de']);
                $aValues[$Id]['precio'] = $this->DB->forSave($value['precio']);
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetSugerencias'] = $e->getMessage();
            return false;
        }
    }


    //------------------------------------------------------------------------------
    function GetAllColeccionByCatalogoId_ForEmenta($loja_id, $catalogo_id)
    {
        $this->clearColecciones();

        try {

            $query = "SELECT "
                . " COL.id, "
                . " COL.nombre_pt, "
                . " COL.nombre_fr, "
                . " COL.nombre_en, "
                . " COL.nombre_es, "
                . " COL.nombre_de, "
                . " COL.imagen, "
                . " COL.descripcion_pt, "
                . " COL.descripcion_fr, "
                . " COL.descripcion_en, "
                . " COL.descripcion_es, "
                . " COL.descripcion_de, "
                . " COL.sugerencias_colecciones_ids, "
                . " COL.unidad, "
                . " COL.precio "
                . " FROM "
                . " colecciones as COL  "
                . " INNER JOIN catalogos as CAT "
                . " ON CAT.id = COL.catalogo_id "
                . " WHERE "
                . " COL.catalogo_id = $catalogo_id AND CAT.loja_id=$loja_id AND COL.enabled='S' "
                . " ORDER BY "
                . " COL.nombre_pt ASC;";
            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                $this->Errors['GetAllColeccionByCatalogoId'] = 'O produto n&atilde;o existe.';
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['nombre_pt'] = $this->DB->forShow($value['nombre_pt']);
                $aValues[$Id]['nombre_fr'] = $this->DB->forShow($value['nombre_fr']);
                $aValues[$Id]['nombre_en'] = $this->DB->forShow($value['nombre_en']);
                $aValues[$Id]['nombre_es'] = $this->DB->forShow($value['nombre_es']);
                $aValues[$Id]['nombre_de'] = $this->DB->forShow($value['nombre_de']);
                $aValues[$Id]['imagen'] = $this->DB->forSave($value['imagen']);
                $aValues[$Id]['descripcion_pt'] = $this->DB->forHtml($value['descripcion_pt']);
                $aValues[$Id]['descripcion_fr'] = $this->DB->forHtml($value['descripcion_fr']);
                $aValues[$Id]['descripcion_en'] = $this->DB->forHtml($value['descripcion_en']);
                $aValues[$Id]['descripcion_es'] = $this->DB->forHtml($value['descripcion_es']);
                $aValues[$Id]['descripcion_de'] = $this->DB->forHtml($value['descripcion_de']);
                if ($value['sugerencias_colecciones_ids'] != '') {
                    $aValues[$Id]['sugerencias_colecciones_ids'] = $this->GetSugerencias_ForEmenta($value['sugerencias_colecciones_ids']);
                } else {
                    $aValues[$Id]['sugerencias_colecciones_ids'] = "";
                }
                $aValues[$Id]['unidad'] = $this->DB->forSave($value['unidad']);
                $aValues[$Id]['precio'] = $this->DB->forSave($value['precio']);
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllColeccionByCatalogoId'] = $e->getMessage();
            return false;
        }
    }
    //------------------------------------------------------------------------------
    function GetSugerencias_ForEmenta($ids)
    {

        try {

            $query = "SELECT "
                . " id, "
                . " nombre_pt, "
                . " nombre_fr, "
                . " nombre_en, "
                . " nombre_es, "
                . " nombre_de, "
                . " imagen, "
                . " precio "
                . " FROM "
                . " colecciones "
                . " WHERE "
                . " id IN ($ids) AND enabled='S' "
                . " ORDER BY "
                . " orden ASC;";
            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                $this->Errors['GetSugerencias_ForEmenta'] = 'O produto n&atilde;o existe.';
                return false;
            }
            foreach ($result as $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['nombre_pt'] = $this->DB->forShow($value['nombre_pt']);
                $aValues[$Id]['nombre_fr'] = $this->DB->forShow($value['nombre_fr']);
                $aValues[$Id]['nombre_en'] = $this->DB->forShow($value['nombre_en']);
                $aValues[$Id]['nombre_es'] = $this->DB->forShow($value['nombre_es']);
                $aValues[$Id]['nombre_de'] = $this->DB->forShow($value['nombre_de']);
                $aValues[$Id]['imagen'] = $this->DB->forSave($value['imagen']);
                $aValues[$Id]['precio'] = $this->DB->forSave($value['precio']);
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetSugerencias_ForEmenta'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------------------------------
    function GetAllColeccionByDestacados_ForEmenta($loja_id)
    {
        $this->clearColecciones();

        try {

            $query = "SELECT "
                . " COL.id, "
                . " COL.nombre_pt, "
                . " COL.nombre_fr, "
                . " COL.nombre_en, "
                . " COL.nombre_es, "
                . " COL.nombre_de, "
                . " COL.imagen, "
                . " COL.descripcion_pt, "
                . " COL.descripcion_fr, "
                . " COL.descripcion_en, "
                . " COL.descripcion_es, "
                . " COL.descripcion_de, "
                . " COL.sugerencias_colecciones_ids, "
                . " COL.unidad, "
                . " COL.precio "
                . " FROM "
                . " colecciones as COL  "
                . " INNER JOIN catalogos as CAT "
                . " ON CAT.id = COL.catalogo_id "
                . " WHERE "
                . " CAT.loja_id=$loja_id AND COL.destacado='S' AND COL.enabled='S' AND orden <> 0  "
                . " ORDER BY "
                . " COL.orden ASC;";
            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                $this->Errors['GetAllColeccionByCatalogoId'] = 'O produto n&atilde;o existe.';
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['nombre_pt'] = $this->DB->forShow($value['nombre_pt']);
                $aValues[$Id]['nombre_fr'] = $this->DB->forShow($value['nombre_fr']);
                $aValues[$Id]['nombre_en'] = $this->DB->forShow($value['nombre_en']);
                $aValues[$Id]['nombre_es'] = $this->DB->forShow($value['nombre_es']);
                $aValues[$Id]['nombre_de'] = $this->DB->forShow($value['nombre_de']);
                $aValues[$Id]['imagen'] = $this->DB->forSave($value['imagen']);
                $aValues[$Id]['descripcion_pt'] = $this->DB->forHtml($value['descripcion_pt']);
                $aValues[$Id]['descripcion_fr'] = $this->DB->forHtml($value['descripcion_fr']);
                $aValues[$Id]['descripcion_en'] = $this->DB->forHtml($value['descripcion_en']);
                $aValues[$Id]['descripcion_es'] = $this->DB->forHtml($value['descripcion_es']);
                $aValues[$Id]['descripcion_de'] = $this->DB->forHtml($value['descripcion_de']);
                if ($value['sugerencias_colecciones_ids'] != '') {
                    $aValues[$Id]['sugerencias_colecciones_ids'] = $this->GetSugerencias_ForEmenta($value['sugerencias_colecciones_ids']);
                } else {
                    $aValues[$Id]['sugerencias_colecciones_ids'] = "";
                }
                $aValues[$Id]['unidad'] = $this->DB->forSave($value['unidad']);
                $aValues[$Id]['precio'] = $this->DB->forSave($value['precio']);
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllColeccionByCatalogoId'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------------------------------
    function GetAllColByLoja_Id_Template($valor, $enabled = false, $template = 1)
    {

        $DB = new clsMySqliDB();
        $activos = '';
        try {
            if ($valor <= 0) {
                $this->Errors['GetAllColByLoja_Id_Template'] = 'Erro interno.';
                return false;
            }

            /* si es $enabled es true devuelve solamente las colecciones activas*/
            if ($enabled == true) {
                $activos = "AND col.enabled = 'S' ";
            }

            $query = "SELECT "
                . "col.id AS id, "
                . "col.nombre_pt AS coleccion, "
                . "cat.nombre_pt AS catalogo, "
                . "col.precio AS precio, "
                . "col.imagen AS imagen, "
                . "col.destacado AS destacado, "
                . "col.enabled "
                . "FROM "
                . "colecciones AS col "
                . "INNER JOIN catalogos AS cat "
                . "ON "
                . "cat.id = col.catalogo_id "
                . "WHERE "
                . "cat.loja_id = $valor $activos AND cat.template = $template "
                . "ORDER BY "
                . "col.nombre_pt ASC;";


            $result = $DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['coleccion'] = $DB->forShow($value['coleccion']);
                    $aValues[$Id]['catalogo'] = $DB->forShow($value['catalogo']);
                    $aValues[$Id]['precio'] = $DB->forShow($value['precio']);
                    $aValues[$Id]['imagen'] = $DB->forShow($value['imagen']);
                    $aValues[$Id]['destacado'] = $DB->forShow($value['destacado']);
                    $aValues[$Id]['enabled'] = $DB->forShow($value['enabled']);
                }
                return $aValues;
            }
            return false;
        } catch (Exception $e) {
            $this->Errors['GetAllColByLoja_Id_Template'] = $e->getMessage();
            return false;
        }
    }

    //----------------------------------------------------------------------------
    /**
     * Retrieves all collections by store ID.
     *
     * @param mixed $valor The value to search for.
     * @param bool $enabled (optional) Whether to only retrieve enabled collections. Default is false.
     * @param bool $template (optional) Whether to retrieve collections by templates. Default is false. 1 to comida, 2 to bebida.
     * @return array An array of collections matching the search criteria.
     */
    function GetAllColByLoja_Id($valor, $enabled = false, $template = false)
    {

        $DB = new clsMySqliDB();
        $activos = '';
        try {
            if ($valor <= 0) {
                $this->Errors['GetAllColByLoja_Id'] = 'Erro interno.';
                return false;
            }

            /* si es $enabled es true devuelve solamente las colecciones activas*/
            if ($enabled == true) {
                $activos = "AND col.enabled = 'S' ";
            }
            if ($template != false) {
                $ByTemplate = "AND cat.template = $template ";
            } else {
                $ByTemplate = '';
            }

            $query = "SELECT "
                . "col.id AS id, "
                . "col.nombre_pt AS coleccion, "
                . "cat.nombre_pt AS catalogo, "
                . "col.precio AS precio, "
                . "col.imagen AS imagen, "
                . "col.destacado AS destacado, "
                . "col.orden AS orden,"
                . "col.enabled "
                . "FROM "
                . "colecciones AS col "
                . "INNER JOIN catalogos AS cat "
                . "ON "
                . "cat.id = col.catalogo_id "
                . "WHERE "
                . "cat.loja_id = $valor $activos"
                . $ByTemplate
                . "ORDER BY "
                . "col.nombre_pt ASC;";


            $result = $DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['coleccion1'] = $DB->forShow($value['catalogo']) . '-->' . $DB->forShow($value['coleccion']);
                    $aValues[$Id]['coleccion'] = $DB->forShow($value['coleccion']);
                    $aValues[$Id]['catalogo'] = $DB->forShow($value['catalogo']);
                    $aValues[$Id]['precio'] = $DB->forShow($value['precio']);
                    $aValues[$Id]['imagen'] = $DB->forShow($value['imagen']);
                    $aValues[$Id]['destacado'] = $DB->forShow($value['destacado']);
                    $aValues[$Id]['enabled'] = $DB->forShow($value['enabled']);
                    if ($value['orden'] == 0) {
                        $aValues[$Id]['orden'] = '0';
                    } else {
                        $aValues[$Id]['orden'] = $DB->forShow($value['orden']);
                    }
                    //$aValues[$Id]['orden'] = $DB->forShow($value['orden']);

                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllColByLoja_Id'] = $e->getMessage();
            return false;
        }
    }

    //----------------------------------------------------------------------------
    function GetAllColByLoja_ToCartForEmenta($loja_id, $coleccions_ids)
    {
        $Acoleccions_ids = explode(',', $coleccions_ids);
        $DB = new clsMySqliDB();

        try {

            $query = "SELECT "
                . "col.id AS id, "
                . "col.nombre_pt AS coleccion_pt, "
                . "col.nombre_fr AS coleccion_fr, "
                . "col.nombre_en AS coleccion_en, "
                . "col.nombre_es AS coleccion_es, "
                . "col.nombre_de AS coleccion_de, "
                . "cat.nombre_pt AS catalogo, "
                . "col.precio AS precio, "
                . "col.imagen AS imagen, "
                . "col.destacado AS destacado, "
                . "col.enabled "
                . "FROM "
                . "colecciones AS col "
                . "INNER JOIN catalogos AS cat "
                . "ON "
                . "cat.id = col.catalogo_id "
                . "WHERE "
                . "cat.loja_id = $loja_id AND "
                . "col.id in ($coleccions_ids) AND col.enabled='S' "
                . "ORDER BY "
                . "col.nombre_pt ASC;";


            $result = $DB->Select($query, 'all');
            $total = 0;
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre_pt'] = $DB->forShow($value['coleccion_pt']);
                    $aValues[$Id]['nombre_fr'] = $DB->forShow($value['coleccion_fr']);
                    $aValues[$Id]['nombre_en'] = $DB->forShow($value['coleccion_en']);
                    $aValues[$Id]['nombre_es'] = $DB->forShow($value['coleccion_es']);
                    $aValues[$Id]['nombre_de'] = $DB->forShow($value['coleccion_de']);
                    $aValues[$Id]['catalogo'] = $DB->forShow($value['catalogo']);
                    $aValues[$Id]['precio'] = $DB->forShow($value['precio']);
                    $aValues[$Id]['imagen'] = $DB->forShow($value['imagen']);
                    $aValues[$Id]['destacado'] = $DB->forShow($value['destacado']);
                    $aValues[$Id]['enabled'] = $DB->forShow($value['enabled']);
                    $aValues[$Id]['cantidad'] = array_count_values($Acoleccions_ids)[$Id];
                    $total = $total + ($aValues[$Id]['cantidad'] * $aValues[$Id]['precio']);
                }
                $resultado = ['productos' => $aValues, 'total' => $total];
                return $resultado;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllColByLoja_ToCartForEmenta'] = $e->getMessage();
            return false;
        }
    }
    //------------------------------------------------------------------------------
    function GetAllIngredientes()
    {
        $DB = new clsMySqliDB();

        try {

            $query = "SELECT * FROM ingredientes ORDER BY ingrediente ASC;";
            $result = $DB->Select($query, 'all');

            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllIngredientes'] = $e->getMessage();
            return false;
        }
    }
    //-----------------------------------------------------------------------------
    function GetLojaIdByColeccion($valor)
    {
        $DB = new clsMySqliDB();
        try {
            $query = "SELECT cat.loja_id FROM colecciones as col "
                . "INNER JOIN catalogos as cat "
                . "ON cat.id = col.catalogo_id "
                . "WHERE col.id = $valor ;";
            $result = $DB->Select($query);
            return $result['loja_id'];
        } catch (Exception $e) {
            $this->Errors['GetLojaIdByColeccion'] = $e->getMessage();
            return false;
        }
    }
    //-----------------------------------------------------------------------------
    function GetColeccionForPedidoQR($ColecionesID)
    {
        $oColecciones = new clsColecciones();
        try {
            $i = 0;
            foreach ($ColecionesID as $key => $value) {
                $aColecc = explode('|', $value);
                $oColecciones->findId($aColecc[0]);
                $Id = $i;
                $aValues[$Id]['id'] = $oColecciones->getId();
                $aValues[$Id]['nombre_pt'] = $oColecciones->getNombre_pt();
                if (isset($aColecc[1])) {
                    $aValues[$Id]['comentario'] = $aColecc[1];
                } else {
                    $aValues[$Id]['comentario'] = '';
                }

                $i++;
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetColeccionForPedidoQR'] = $e->getMessage();
            return false;
        }
    }

    //------------------------------------------------------------------------------
    function clearErrors()
    {
        $this->Errors = array();
    }

    function hasErrors()
    {
        if (empty($this->Errors)) {
            return false;
        } else {
            return TRUE;
        }
    }

    function getErrors()
    {
        $error = '';
        foreach ($this->Errors as $description) {
            $error .= $description . '<br>';
        }
        return $error;
    }

    //---------------------------------------------------------  
    function setId($valor)
    {
        $this->id = $valor;
        if (empty($valor)) {
            $this->Errors['Id'] = 'Erro interno.';
        }
    }

    function getId()
    {
        return $this->id;
    }

    //-------------------------------------------------------------------

    function setNombre_pt($valor)
    {
        $this->nombre_pt = $this->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Nombre'] = 'Preencha o Nome do produto.';
        }
    }

    function getNombre_pt()
    {
        return $this->DB->forShow($this->nombre_pt);
    }

    function editNombre_pt()
    {
        return $this->DB->forEdit($this->nombre_pt);
    }

    //------------------------------------------------------------------------------
    function setNombre_fr($valor)
    {
        $this->nombre_fr = $this->forSave($valor);
    }

    function getNombre_fr()
    {
        return $this->DB->forShow($this->nombre_fr);
    }

    function editNombre_fr()
    {
        return $this->DB->forEdit($this->nombre_fr);
    }

    //---------------------------------------------------------   
    function setNombre_en($valor)
    {
        $this->nombre_en = $this->forSave($valor);
    }

    function getNombre_en()
    {
        return $this->DB->forShow($this->nombre_en);
    }

    function editNombre_en()
    {
        return $this->DB->forEdit($this->nombre_en);
    }
    //-------------------------------------------------------------------
    function setNombre_es($valor)
    {
        $this->nombre_es = $this->forSave($valor);
    }

    function getNombre_es()
    {
        return $this->DB->forShow($this->nombre_es);
    }

    function editNombre_es()
    {
        return $this->DB->forEdit($this->nombre_es);
    }
    //-----------------------------------------------------------
    function setNombre_de($valor)
    {
        $this->nombre_de = $this->forSave($valor);
    }

    function getNombre_de()
    {
        return $this->DB->forShow($this->nombre_de);
    }

    function editNombre_de()
    {
        return $this->DB->forEdit($this->nombre_de);
    }
    //-------------------------------------------------------------

    function setDescripcion_pt($valor)
    {
        $this->descripcion_pt = $this->DB->forSave($valor);
    }

    function getDescripcion_pt()
    {
        return $this->DB->forEdit($this->descripcion_pt);
    }

    function editDescripcion_pt()
    {
        return $this->DB->forEdit($this->descripcion_pt);
    }

    //------------------------------------------------------------------------------
    function setDescripcion_fr($valor)
    {
        $this->descripcion_fr = $this->DB->forSave($valor);
    }

    function getDescripcion_fr()
    {
        return $this->DB->forEdit($this->descripcion_fr);
    }

    function editDescripcion_fr()
    {
        return $this->DB->forEdit($this->descripcion_fr);
    }

    //---------------------------------------------------------   
    function setDescripcion_en($valor)
    {
        $this->descripcion_en = $this->DB->forSave($valor);
    }

    function getDescripcion_en()
    {
        return $this->DB->forEdit($this->descripcion_en);
    }

    function editDescripcion_en()
    {
        return $this->DB->forEdit($this->descripcion_en);
    }
    //---------------------------------------------------------   
    function setDescripcion_es($valor)
    {
        $this->descripcion_es = $this->DB->forSave($valor);
    }

    function getDescripcion_es()
    {
        return $this->DB->forEdit($this->descripcion_es);
    }

    function editDescripcion_es()
    {
        return $this->DB->forEdit($this->descripcion_es);
    }
    //--------------------------------------------------------- 
    function setDescripcion_de($valor)
    {
        $this->descripcion_de = $this->DB->forSave($valor);
    }

    function getDescripcion_de()
    {
        return $this->DB->forEdit($this->descripcion_de);
    }

    function editDescripcion_de()
    {
        return $this->DB->forEdit($this->descripcion_de);
    }
    //--------------------------------------------------------- 
    function setImagen($valor)
    {
        $this->imagen = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Imagen'] = 'Carregue uma imagem para o seu produto.';
        }
    }

    function getImagen()
    {
        return $this->DB->forShow($this->imagen);
    }

    function editImagen()
    {
        return $this->DB->forEdit($this->imagen);
    }
    //---------------------------------------------------------   
    function setPrecio($valor)
    {
        $this->precio = str_replace(',', '.', $valor);
        if (empty($valor)) {
            $this->Errors['Precio'] = 'Insira o pre&ccedil;o do produto.';
        }
    }

    function getPrecio()
    {
        return $this->DB->forShow($this->precio);
    }

    function editPrecio()
    {
        return $this->DB->forEdit($this->precio);
    }
    //----------------------------------------------------------------
    function setCatalogo_id($valor)
    {
        $this->catalogo_id = $valor;
        if ($valor == "-1") {
            $this->Errors['Nivel'] = 'Selecione uma categoria ';
        }
    }

    function getCatalogo_id()
    {
        return $this->DB->forShow($this->catalogo_id);
    }

    function editCatalogo_id()
    {
        return $this->DB->forEdit($this->catalogo_id);
    }
    //---------------------------------------------------------
    function setBebidas_ids($valor)
    {
        $this->bebidas_ids = $valor;
    }

    function getBebidas_ids()
    {
        return $this->DB->forShow($this->bebidas_ids);
    }

    function editBebidas_ids()
    {
        return $this->DB->forEdit($this->bebidas_ids);
    }
    //---------------------------------------------------------
    function setSugerencias_Colecciones_Ids($valor)
    {
        $this->sugerencias_colecciones_ids = $valor;
    }

    function getSugerencias_Colecciones_Ids()
    {
        return $this->DB->forShow($this->sugerencias_colecciones_ids);
    }

    function editSugerencias_Colecciones_Ids()
    {
        return $this->DB->forEdit($this->sugerencias_colecciones_ids);
    }
    //------------------------------------------------------------
    function setDestacado($valor)
    {
        $this->destacado = $valor;
        if (empty($valor)) {
            $this->Errors['Destacado'] = 'Erro interno.';
        }
    }

    function getDestacado($valor = '')
    {
        $destacado = '';
        if ($this->destacado == 'S' || $valor == 'S') {
            $destacado = 'checked';
        }
        return $destacado;
    }
    //---------------------------------------------------------    
    function setEnabled($valor)
    {
        $this->enabled = $valor;
        if (empty($valor)) {
            $this->Errors['Enabled'] = 'Erro interno.';
        }
    }

    function getEnabled($valor = '')
    {
        $enabled = '';
        if ($this->enabled == 'S' || $valor == 'S') {
            $enabled = 'checked';
        }
        return $enabled;
    }
    //----------------------------------------------------------------
    function setUnidad($valor)
    {
        $this->unidad = intval($valor);
        if (empty($valor)) {
            $this->Errors['Unidad'] = 'Erro interno.';
        }
    }


    function getUnidad()
    {
        return $this->DB->forShow($this->unidad);
    }

    function editUnidad()
    {
        return $this->DB->forEdit($this->unidad);
    }

    //---------------------------------------------------------    

    function setIngedientes($valor)
    {
        $this->ingredientes = $valor;
    }

    function getIngedientes()
    {
        return $this->DB->forShow($this->ingredientes);
    }

    function editIngedientes()
    {
        return $this->DB->forEdit($this->ingredientes);
    }

    //---------------------------------------------------------
    function setIntolerancias($valor)
    {
        $this->intolerancias = $valor;
    }

    function getIntolerancias()
    {
        return $this->DB->forShow($this->intolerancias);
    }

    function editIntolerancias()
    {
        return $this->DB->forEdit($this->intolerancias);
    }

    //---------------------------------------------------------
    function setOrden($valor)
    {
        $this->orden = $valor;
    }

    function getOrden()
    {
        return $this->DB->forShow($this->orden);
    }

    function editOrden()
    {
        return $this->DB->forEdit($this->orden);
    }



    //--------------------------------------------------------------------    
    function forSave($param)
    {
        return $this->DB->forSave($param);
    }

    function forEdit($param)
    {
        return $this->DB->forEdit($param);
    }

    function forShow($param)
    {
        return $this->DB->forShow($param);
    }

    function forHtml($param)
    {
        return $this->DB->forHtml($param);
    }
}
