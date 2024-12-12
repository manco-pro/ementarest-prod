<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';


class clsCatalogos
{

    var $id = 0;
    var $nombre_pt = '';
    var $nombre_fr = '';
    var $nombre_en = '';
    var $nombre_es = '';
    var $nombre_de = '';
    var $nivel = 0;
    var $imagen = '';
    var $template = ''; //template 1 comidas , 2 bebidas
    var $loja_id = 0; //es un field que no se va a modificar
    var $hora_desde = '';
    var $hora_hasta = '';
    var $enabled = '';
    var $Errors = array();
    var $DB;

    function clsCatalogos()
    {
        $this->clearCatalogos();
        $this->DB = new clsMySqliDB();
    }

    function clearCatalogos()
    {

        $this->id = 0;
        $this->nombre_pt = '';
        $this->nombre_fr = '';
        $this->nombre_en = '';
        $this->nombre_es = '';
        $this->nombre_de = '';
        $this->nivel = 0;
        $this->imagen = '';
        $this->template = '';
        $this->loja_id = 0;
        $this->hora_desde = '';
        $this->hora_hasta = '';
        $this->enabled = '';

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

        $qInsert = "INSERT INTO catalogos("
            . "nombre_pt, "
            . "nombre_fr, "
            . "nombre_en, "
            . "nombre_es, "
            . "nombre_de, "
            . "nivel, "
            . "imagen, "
            . "template, "
            . "loja_id, "
            . "hora_desde, "
            . "hora_hasta, "
            . "enabled) "
            . "VALUES"
            . "('$this->nombre_pt',"
            . "'$this->nombre_fr',"
            . "'$this->nombre_en',"
            . "'$this->nombre_es',"
            . "'$this->nombre_de',"
            . "$this->nivel,"
            . "'$this->imagen',"
            . "$this->template,"
            . "$this->loja_id,"
            . "'$this->hora_desde',"
            . "'$this->hora_hasta',"
            . "'$this->enabled')";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O cat&aacute;logo n&atilde;o pode ser registrado.';
            return false;
        }
        $this->setId($rInsert);
        return true;
    }

    /* ----------------cat&aacute;logo admin-------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM catalogos WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O cat&aacute;logo n&atilde;o existe.";
        }

        if (!$this->Validate()) {
            return false;
        }

        $qModificar = "UPDATE catalogos SET "
            . "nombre_pt    = '$this->nombre_pt', "
            . "nombre_fr    = '$this->nombre_fr', "
            . "nombre_en    = '$this->nombre_en', "
            . "nombre_es    = '$this->nombre_es', "
            . "nombre_de    = '$this->nombre_de', "
            . "nivel        =  $this->nivel, "
            . "imagen       = '$this->imagen', "
            . "template     = '$this->template', "
            . "hora_desde   = '$this->hora_desde', "
            . "hora_hasta   = '$this->hora_hasta', "
            . "enabled      = '$this->enabled' "
            . "WHERE "
            . "id = $this->id;";

        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O cat&aacute;logo n&atilde;o pode ser modificado.";
            return false;
        }
        return TRUE;
    }

    /* -----------------catalogos que modifica ADM--------------------------- */

    //
    //    function Modificar_ADM() {
    //        $qryModificar = "UPDATE catalogos SET "
    //                . "nombre_pt    = '$this->nombre_pt', "
    //                . "descripcion  = '$this->descripcion', "
    //                . "nivel        =  $this->nivel, "
    //                . "imagen       = '$this->imagen', "
    //                . "template     = '$this->template', "
    //                . "enabled      = '$this->enabled' "
    //                . "WHERE id     =  $this->id;";
    //
    //        $rModificar = $this->DB->Update($qryModificar);
    //        //exit();
    //        if (!$rModificar) {
    //            $this->Errors['Modificar'] = "O cat&aacute;logo n&atilde;o pode ser modificado.";
    //            return false;
    //        }
    //        return TRUE;
    //    }

    function Borrar()
    {
        //primer bloque de delete
        $SQL = "DELETE FROM catalogos WHERE id = $this->id;";
        $imagen[] = $this->getImagen();
        $result = $this->DB->Remove($SQL);
        if (!$result) {
            $this->Errors['catalogos'] = 'O catalogo n&atilde;o existe.';
            return false;
        }
        $this->borrarArchivos($imagen, getLocal('IMAGES_CAT'));

        //ver si es catalogo pai
        if ($this->nivel == 0) {
            $SQL1 = "DELETE FROM catalogos WHERE nivel = $this->id;";
            $aValues = $this->GetAllImagesCatalogos($this->id);
            $aIDs = $this->GetAll_ID_Catalogos($this->id);
            $result = $this->DB->Remove($SQL1);
            if (!$result) {
                $this->Errors['catalogos_pai'] = 'O catalogo n&atilde;o existe.';
                return false;
            }
            $this->borrarArchivos($aValues, getLocal('IMAGES_CAT'));
            //borrar colecciones que tengan el catalogo_id de los hijos del catalogo pai
           
            $IDs  =    implode(',', $aIDs);
            $SQL2 = "DELETE FROM colecciones WHERE catalogo_id IN ($IDs);";
            $aValues = $this->GetAllImagesColeccion($IDs);
            $result = $this->DB->Remove($SQL2);
            if (!$result) {
                $this->Errors['colecciones'] = 'sem cole&ccedil;&otilde;es.';
                return false;
            }
            $this->borrarArchivos($aValues, getLocal('IMAGES_COL'));
        } else {
            //borrar colecciones que tengan el catalogo_id del catalogo hijo
            $SQL3 = "DELETE FROM colecciones WHERE catalogo_id = $this->id;";
            $aValues = $this->GetAllImagesColeccion($this->id);
            $result = $this->DB->Remove($SQL3);
            if (!$result) {
                $this->Errors['colecciones'] = 'sem cole&ccedil;&otilde;es.';
                return false;
            }
            $this->borrarArchivos($aValues, getLocal('IMAGES_COL'));
        }

        return TRUE;
    }
    //------------------------------------------------------------------------------

    function GetAll_ID_Catalogos($valor)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT id FROM catalogos WHERE nivel = $valor;";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $aValues[] = $value['id'];
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllImages'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //------------------------------------------------------------------------------

    function GetAllImagesCatalogos($valor)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT imagen FROM catalogos WHERE nivel = $valor;";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $aValues[] = $value['imagen'];
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllImages'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //------------------------------------------------------------------------------    
    function GetAllImagesColeccion($valor)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT imagen FROM colecciones WHERE catalogo_id IN ($valor);";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $aValues[] = $value['imagen'];
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllImages'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //------------------------------------------------------------------------------
    function borrarArchivos($archivos, $directorio)
    {
        foreach ($archivos as $archivo) {
            if (file_exists($directorio . $archivo)) {
                unlink($directorio . $archivo);
                unlink($directorio . 'M' . $archivo);
                unlink($directorio . 'S' . $archivo);
            }
        }
    }
    /* ------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearCatalogos();
        $this->id = $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM catalogos WHERE id = $this->id;";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['Id'] = 'O cat&aacute;logo n&atilde;o existe.';
                return false;
            }
            $this->id = $result['id'];
            $this->nombre_pt = $result['nombre_pt'];
            $this->nombre_fr = $result['nombre_fr'];
            $this->nombre_en = $result['nombre_en'];
            $this->nombre_es = $result['nombre_es'];
            $this->nombre_de = $result['nombre_de'];
            $this->nivel = $result['nivel'];
            $this->imagen = $result['imagen'];
            $this->template = $result['template'];
            $this->loja_id = $result['loja_id'];
            $this->hora_desde = $result['hora_desde'];
            $this->hora_hasta = $result['hora_hasta'];
            $this->enabled = $result['enabled'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }

    //------------------------------------------------------------------------------
    function GetAllCatByLojaId($valor)
    {
        $this->clearCatalogos();

        try {
            if ($valor <= 0) {
                $this->Errors['GetAllByLojaId'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM catalogos WHERE loja_id = $valor ORDER BY nivel ASC;";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllByLojaId'] = 'O cat&aacute;logo n&atilde;o existe.';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllByLojaId'] = $e->getMessage();
            return false;
        }
    }

    // devuelve solo los catalogos padres de una loja en particular y si pasas el catalogo id no devuelve ese catalogo
    // en casos donde se hace update del catalogo no seria logico que puede elegirse como padre e hijo    
    function GetAllCatalogosPadresByLoja($valor)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT id, nombre_pt, nivel FROM catalogos WHERE loja_id= $valor AND nivel=0;";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre'] = $DB->forSave($value['nombre_pt']);
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllCatalogosPadresByLoja'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //-----------------------------------------------------------------------------------
    function GetAllCatalogosPadresByLojaForEmenta($valor)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT id, nombre_pt, nombre_fr, nombre_en, nombre_es, nombre_de , imagen FROM catalogos WHERE loja_id= $valor AND nivel<>0 AND template=1 AND enabled='S';";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre_pt'] = $DB->forShow($value['nombre_pt']);
                    $aValues[$Id]['nombre_fr'] = $DB->forShow($value['nombre_fr']);
                    $aValues[$Id]['nombre_en'] = $DB->forShow($value['nombre_en']);
                    $aValues[$Id]['nombre_es'] = $DB->forShow($value['nombre_es']);
                    $aValues[$Id]['nombre_de'] = $DB->forShow($value['nombre_de']);
                    $aValues[$Id]['imagen'] = $DB->forSave($value['imagen']);
                    $aValues[$Id]['end'] = $key % 2 == 0 ? 'end' : 'start';
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllCatalogosPadresByLoja'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //-----------------------------------------------------------------------------------

    //-----------------------------------------------------------------------------------
    function GetallCatalogosHijosByLoja($valor)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT "
            . "c1.id AS id, "
            . "c1.nombre_pt AS nombre, "
            . "c2.nombre_pt AS padre "
            . "FROM "
            . "catalogos c1 "
            . "LEFT JOIN catalogos c2 ON "
            . "c1.nivel = c2.id "
            . "WHERE NOT "
            . "EXISTS( "
            . "SELECT "
            . "1 "
            . "FROM "
            . "catalogos c3 "
            . "WHERE "
            . "c3.nivel = c1.id "
            . ") AND c1.loja_id = $valor AND c1.nivel <> 0 ";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre'] = $DB->forSave($value['padre']) . '-->' . $DB->forSave($value['nombre']);
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllCatalogosPadresByLoja'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //-----------------------------------------------------------------------------------
    function GetallCatalogosHijosByLoja_ForEmenta($loja_id, $cat_id)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT "
            . "c1.id AS id, "
            . "c1.nombre_pt AS nombre_pt, "
            . "c1.nombre_fr AS nombre_fr, "
            . "c1.nombre_en AS nombre_en, "
            . "c1.nombre_es AS nombre_es, "
            . "c1.nombre_de AS nombre_de, "
            . "c2.nombre_pt AS padre, "
            . "c1.imagen AS imagen "
            . "FROM "
            . "catalogos c1 "
            . "LEFT JOIN catalogos c2 ON "
            . "c1.nivel = c2.id "
            . "WHERE NOT "
            . "EXISTS( "
            . "SELECT "
            . "1 "
            . "FROM "
            . "catalogos c3 "
            . "WHERE "
            . "c3.nivel = c1.id "
            . ") AND c1.loja_id = $loja_id AND c1.nivel <> 0 AND c1.enabled='S' AND c2.id = $cat_id";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre_pt'] = $DB->forShow($value['nombre_pt']);
                    $aValues[$Id]['nombre_fr'] = $DB->forShow($value['nombre_fr']);
                    $aValues[$Id]['nombre_en'] = $DB->forShow($value['nombre_en']);
                    $aValues[$Id]['nombre_es'] = $DB->forShow($value['nombre_es']);
                    $aValues[$Id]['nombre_de'] = $DB->forShow($value['nombre_de']);
                    $aValues[$Id]['imagen'] = $DB->forSave($value['imagen']);
                    $aValues[$Id]['end'] = $key % 2 == 0 ? 'end' : 'start';
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllCatalogosPadresByLoja'] = $e->getMessage();
            return false;
        }
        return false;
    }
    //------------------------------------------------------------------------------
    function UpdateEstado()
    {
        $query = "UPDATE catalogos SET enabled = '$this->enabled' WHERE id = $this->id;";
        $result = $this->DB->Update($query);

        if (!$result) {
            $this->Errors['UpdateEstado'] = 'Erro interno.';
            return false;
        }
        return true;
    }
    //-----------------------------------------------------------------------------------
    function GetallCatalogosHijosByLoja_bebidas_ForEmenta($loja_id)
    {
        $DB = new clsMySqliDB();
        $query = "SELECT "
            . "c1.id AS id, "
            . "c1.nombre_pt AS nombre_pt, "
            . "c1.nombre_fr AS nombre_fr, "
            . "c1.nombre_en AS nombre_en, "
            . "c1.nombre_es AS nombre_es, "
            . "c1.nombre_de AS nombre_de, "
            . "c2.nombre_pt AS padre, "
            . "c1.imagen AS imagen "
            . "FROM "
            . "catalogos c1 "
            . "LEFT JOIN catalogos c2 ON "
            . "c1.nivel = c2.id "
            . "WHERE NOT "
            . "EXISTS( "
            . "SELECT "
            . "1 "
            . "FROM "
            . "catalogos c3 "
            . "WHERE "
            . "c3.nivel = c1.id "
            . ") AND c1.loja_id = $loja_id AND c1.nivel <> 0 AND c1.enabled='S' AND c1.template=2 "
            . " ORDER BY nombre_pt ASC";
        try {
            $result = $DB->Select($query, 'all');
            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre_pt'] = $DB->forShow($value['nombre_pt']);
                    $aValues[$Id]['nombre_fr'] = $DB->forShow($value['nombre_fr']);
                    $aValues[$Id]['nombre_en'] = $DB->forShow($value['nombre_en']);
                    $aValues[$Id]['nombre_es'] = $DB->forShow($value['nombre_es']);
                    $aValues[$Id]['nombre_de'] = $DB->forShow($value['nombre_de']);
                    $aValues[$Id]['imagen'] = $DB->forSave($value['imagen']);
                    $aValues[$Id]['end'] = $key % 2 == 0 ? 'end' : 'start';
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllCatalogosPadresByLoja'] = $e->getMessage();
            return false;
        }
        return false;
    }
    function GetAllCatByPadre_Hijo($valor)
    {
        $DB = new clsMySqliDB();
        //$this->clearCatalogos();
        $aValues = array();
        $query = "SELECT "
            . "COALESCE(padre.nombre_pt, 'Sin padre') AS nombre_padre, "
            . "hijo.nombre_pt AS nombre_hijo, "
            . "hijo.id as hijo_id,"
            . "hijo.imagen,"
            . "template.template,"
            . "hijo.enabled "
            . "FROM catalogos hijo "
            . "LEFT JOIN catalogos padre ON hijo.nivel = padre.id "
            . "INNER JOIN templates as template on hijo.template = template.id "
            . "WHERE hijo.loja_id=$valor;";
        try {
            $result = $DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['hijo_id'];
                    
                    if ($value['nombre_padre'] == 'Sin padre') {
                        //$aValues[$Id]['nivel'] = 'Cat&aacute;logo Base --> ' . $DB->forShow($value['nombre_hijo']);
                    } else {
                        $aValues[$Id]['id'] = $value['hijo_id'];
                        $aValues[$Id]['nivel'] = $DB->forShow($value['nombre_padre']) . ' --> ' . $DB->forShow($value['nombre_hijo']);
                        $aValues[$Id]['nombre'] = $DB->forShow($value['nombre_hijo']);
                        $aValues[$Id]['imagen'] = $DB->forShow($value['imagen']);
                        $aValues[$Id]['template'] = $DB->forShow($value['template']);
                        $aValues[$Id]['enabled'] = $DB->forShow($value['enabled']);
                    }
                   
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
        return false;
    }

    ////------------------------------------------------------------------------------
    //    devuelve array con todas las relaciones padres hijos   
    function GetAllCatalogosGroupByPH($valor, $catalogo_id)
    {
        $DB = new clsMySqliDB();
        $aValues = array();
        $query = "SELECT "
            . "padres.id as pai_id,"
            . "padres.nombre_pt AS pai_nombre, "
            . "hijos.nombre_pt AS hijo_nombre, "
            . "hijos.id AS hijo_id "
            . "FROM catalogos AS padres "
            . "INNER JOIN catalogos AS hijos ON padres.id = hijos.nivel "
            . "WHERE padres.loja_id = $valor"
            . " AND padres.nivel = 0"
            . " AND hijos.id <> $catalogo_id;";
        try {
            $result = $DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {

                    $Id = $value['hijo_id'];
                    $aValues[$Id]['id'] = $value['hijo_id'];
                    $aValues[$Id]['nombre'] = $this->forShow($value['pai_nombre']) . '-->' . $this->forShow($value['hijo_nombre']);
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
        return false;
    }

    //------------------------------------------------------------------------------

    function TieneHijos()
    {
        $resultado = $this->GetAllCatalogosPadresByLoja($this->getLoja_Id(), $this->getId());
        if ($resultado != false) {
            $this->Errors['Modificar'] = "O cat&aacute;logo n&atilde;o pode ser modificado; apenas os cat&aacute;logos filhos podem ser movidos dos cat&aacute;logos pais.";
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
        return $this->DB->forEdit($this->id);
    }

    //-------------------------------------------------------------------

    function setNombre_pt($valor)
    {
        $this->nombre_pt = $this->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Nombre'] = 'Preencha o Nome do cat&aacute;logo.';
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

    //---------------------------------------------------------  
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
    function setNivel($valor)
    {
        $this->nivel = $valor;
        if ($valor == "-1") {
            $this->Errors['Nivel'] = 'Selecione uma categoria ';
        }
    }

    function getNivel()
    {
        return $this->DB->forShow($this->nivel);
    }

    function editNivel()
    {
        return $this->DB->forEdit($this->nivel);
    }

    //---------------------------------------------------------   
    function setImagen($valor)
    {
        $this->imagen = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Imagen'] = 'Carregue uma imagem para o seu cat&aacute;logo.';
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

    function setTemplate($valor)
    {
        $oCatalagoPai = new clsCatalogos();
        $oCatalagoPai->clearCatalogos();
        $oCatalagoPai->findId($valor);
        $this->template = $oCatalagoPai->getTemplate();
    }

    function getTemplate()
    {
        return $this->DB->forShow($this->template);
    }

    function editTemplate()
    {
        return $this->DB->forEdit($this->template);
    }

    //---------------------------------------------------------    
    function setLoja_Id($valor)
    {
        $this->loja_id = (string) $valor;
        if (empty($valor)) {
            $this->Errors['Loja_Id'] = 'Escolha uma Loja_Id.';
        }
    }

    function getLoja_Id()
    {
        return $this->DB->forShow($this->loja_id);
    }

    function editLoja_Id()
    {
        return $this->DB->forEdit($this->loja_id);
    }

    //---------------------------------------------------------
    function setHora_Desde($valor)
    {
        $this->hora_desde = $valor;
    }

    function getHora_Desde()
    {
        return $this->DB->forShow($this->hora_desde);
    }

    function editHora_Desde()
    {
        return $this->DB->forEdit($this->hora_desde);
    }

    //---------------------------------------------------------
    function setHora_Hasta($valor)
    {
        $this->hora_hasta = $valor;
    }

    function getHora_Hasta()
    {
        return $this->DB->forShow($this->hora_hasta);
    }

    function editHora_Hasta()
    {
        return $this->DB->forEdit($this->hora_hasta);
    }

    //---------------------------------------------------------    
    function setEnabled($valor)
    {
        $this->enabled = $valor;
        if (empty($valor)) {
            $this->Errors['$Enabled'] = 'Erro interno.';
        }
    }

    function getEnabled($valor)
    {
        if ($this->enabled == 'S' || $valor == 'S') {
            $enabled = 'checked';
            return $enabled;
        } else {
            $enabled = '';
            return $enabled;
        }
    }

    //--------------------------------------------------------------------    
    function forSave($param)
    {
        return trim(preg_replace('/[^\p{L}0-9_\s]/u', '', $param));
    }

    function forShow($param)
    {
        return nl2br($this->forEdit($param));
    }

    function forEdit($param)
    {
        return htmlentities(stripslashes($param));
    }
}

//---------------------------------------------------------   
