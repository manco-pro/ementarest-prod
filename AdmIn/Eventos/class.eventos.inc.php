<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsEventos
{
    var $id = 0;
    var $loja_id = 0;
    var $nombre = '';
    var $imagen = '';
    var $inicio = '';
    var $fin = '';
    var $enabled = '';

    var $Errors = array();
    var $DB;

    function clsEventos()
    {
        $this->clearEventos();
        $this->DB = new clsMySqliDB();
    }

    function clearEventos()
    {
        $this->id = 0;
        $this->loja_id = 0;
        $this->nombre = '';
        $this->imagen = '';
        $this->inicio = '';
        $this->fin = '';
        $this->enabled = '';

        $this->DB = new clsMySqliDB();
        $this->Errors = array();
    }

    function Validate()
    {
        if (empty($this->Errors)) {
            return true;
        } else {
            return false;
        }
    }

    function Registrar()
    {
        if (!$this->Validate()) {
            return false;
        }

        $qInsert = "INSERT INTO eventos( "
            . "loja_id, "
            . "nombre, "
            . "imagen, "
            . "inicio, "
            . "fin, "
            . "enabled "
            . ") "
            . "VALUES( "
            . "'$this->loja_id', "
            . "'$this->nombre', "
            . "'$this->imagen', "
            . "'$this->inicio', "
            . "'$this->fin', "
            . "'$this->enabled'); ";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'El evento no pudo ser registrado.';
            return false;
        }
        $this->setId($rInsert);
        return true;
    }

    function Modificar()
    {
        echo  $qryModificar = "UPDATE "
            . " eventos "
            . " SET "
            . " nombre = '$this->nombre',"
            . " imagen = '$this->imagen',"
            . " enabled = '$this->enabled',"
            . " inicio = '$this->inicio',"
            . " fin = '$this->fin'"
            . " WHERE"
            . " id = $this->id";
        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "El evento no pudo ser modificado.";
            return false;
        }
        return true;
    }

    function Borrar()
    {
        if ($this->id <= 0) {
            $this->Errors['borrar'] = 'Error interno.';
            return false;
        }
        if (!$this->DB->Remove("DELETE FROM eventos WHERE id = $this->id")) {
            $this->Errors['borrar'] = 'Error interno.';
            return false;
        }
        include_once getLocal('COMMONS') . 'func.upload.images.php';
        DeleteIMG($this->imagen, getLocal('IMAGES_EVE'));

        return true;
    }

    function findId($valor)
    {
        $this->clearEventos();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Error interno.';
                return false;
            }
            $query = "SELECT * FROM eventos WHERE id = $this->id";
            $result = $this->DB->Select($query);
            if (!$result) {
                $this->Errors['Id'] = 'El evento no existe.';
                return false;
            }
            $this->id = $result['id'];
            $this->loja_id = $result['loja_id'];
            $this->nombre = $result['nombre'];
            $this->imagen = $result['imagen'];
            $this->enabled = $result['enabled'];
            $this->inicio = $result['inicio'];
            $this->fin = $result['fin'];
            return true;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }
    function UpdateEstado()
    {
        $qryUpdate = "UPDATE eventos SET enabled = '$this->enabled' WHERE id = $this->id";
        $rUpdate = $this->DB->Update($qryUpdate);

        if (!$rUpdate) {
            $this->Errors['UpdateEstado'] = 'El estado no pudo ser modificado.';
            return false;
        }
        return true;
    }

    function GetAllEventosInLoja($valor)
    {
        $this->clearEventos();
        try {
            $query = "SELECT * FROM eventos WHERE loja_id = $valor";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllEventos'] = 'No hay eventos registrados';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllEventos'] = $e->getMessage();
            return false;
        }
    }

    function GetAllActiveEventsByLoja($valor)
    {
        $this->clearEventos();
        try {
            $query = "SELECT * FROM eventos WHERE loja_id = $valor AND enabled = 'S' AND inicio <= NOW() AND fin >= NOW()";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllActiveEvents'] = 'No hay eventos activos.';
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];



                $aValues[$Id]['nombre'] = $value['nombre'];
                $aValues[$Id]['imagen'] = $value['imagen'];
                $aValues[$Id]['inicio'] = $value['inicio'];
                $aValues[$Id]['fin'] = $value['fin'];
                $aValues[$Id]['enabled'] = $value['enabled'];
            }

            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllActiveEvents'] = $e->getMessage();
            return false;
        }
    }

    function GetAllFutureEventsByLoja($valor)
    {
        $this->clearEventos();
        try {
            $query = "SELECT * FROM eventos WHERE loja_id = $valor AND enabled = 'S' AND inicio > NOW()";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllFutureEvents'] = 'No hay eventos futuros.';
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];



                $aValues[$Id]['nombre'] = $value['nombre'];
                $aValues[$Id]['imagen'] = $value['imagen'];
                $aValues[$Id]['inicio'] = $value['inicio'];
                $aValues[$Id]['fin'] = $value['fin'];
                $aValues[$Id]['enabled'] = $value['enabled'];
            }

            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllFutureEvents'] = $e->getMessage();
            return false;
        }
    }

    function clearErrors()
    {
        $this->Errors = array();
    }

    function hasErrors()
    {
        if (empty($this->Errors)) {
            return false;
        } else {
            return true;
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

    function setId($valor)
    {
        $this->id = (int) $valor;
        if (empty($valor)) {
            $this->Errors['Id'] = 'Error interno.';
        }
    }

    function getId()
    {
        return $this->id;
    }

    function setLoja_Id($valor)
    {
        $this->loja_id = (int) $valor;
        if (empty($valor)) {
            $this->Errors['Loja_Id'] = 'Escolha uma loja.';
        }
    }

    function getLoja_Id()
    {
        return $this->loja_id;
    }

    function setNombre($valor)
    {
        $this->nombre = $this->DB->forsave($valor);
        if (empty($valor)) {
            $this->Errors['Nombre'] = 'Preencha o Nome.';
        }
    }

    function getNombre()
    {
        return $this->DB->forShow($this->nombre);
    }

    function setImagen($valor)
    {
        $this->imagen = $this->DB->forsave($valor);
        if (empty($valor)) {
            $this->Errors['Imagen'] = 'Preencha a imagem.';
        }
    }

    function getImagen()
    {
        return $this->DB->forShow($this->imagen);
    }

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
    function setInicio($valor)
    {
        if ($valor == '') {
            $this->Errors['Data Inicio'] = 'selecione uma data de in&iacute;cio.';
        }
        $this->inicio = $this->DB->forsave($valor);
    }

    function getInicio()
    {
        return $this->DB->forShow($this->inicio);
    }

    function setFin($valor)
    {
        if ($valor == '') {
            $this->Errors['Data Fim'] = 'selecione uma data de fim.';
        }
        $this->fin = $this->DB->forsave($valor);
    }

    function getFin()
    {
        return $this->DB->forShow($this->fin);
    }

    //---------------------------------------------------------
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
