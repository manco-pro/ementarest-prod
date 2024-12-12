<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsMesas
{
    var $id = 0;
    var $loja_id = 0;
    var $identificador = '';
    var $enabled = '';

    var $Errors = array();
    var $DB;

    function clsMesas()
    {
        $this->clearMesas();
        $this->DB = new clsMySqliDB();
    }

    function clearMesas()
    {
        $this->id = 0;
        $this->loja_id = 0;
        $this->identificador = '';
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

        $qInsert = "INSERT INTO mesas( "
            . "loja_id, "
            . "identificador, "
            . "enabled "
            . ") "
            . "VALUES( "
            . "'$this->loja_id', "
            . "'$this->identificador', "
            . "'$this->enabled'); ";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'La mesa no pudo ser registrada.';
            return false;
        }
        $this->setId($rInsert);
        return true;
    }

    function Modificar()
    {
        $qryModificar = "UPDATE "
            . " mesas "
            . " SET "
            . " identificador = '$this->identificador',"
            . " enabled = '$this->enabled'"
            . " WHERE"
            . " id = $this->id";
        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "La mesa no pudo ser modificada.";
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
        if (!$this->DB->Remove("DELETE FROM mesas WHERE id = $this->id")) {
            $this->Errors['borrar'] = 'Error interno.';
            return false;
        }
        return true;
    }

    function findId($valor)
    {
        $this->clearMesas();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Error interno.';
                return false;
            }
            $query = "SELECT * FROM mesas WHERE id = $this->id";
            $result = $this->DB->Select($query);
            if (!$result) {
                $this->Errors['Id'] = 'La mesa no existe.';
                return false;
            }
            $this->id = $result['id'];
            $this->loja_id = $result['loja_id'];
            $this->identificador = $result['identificador'];
            $this->enabled = $result['enabled'];
            return true;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }

    function UpdateEstado()
    {
        $qryUpdate = "UPDATE mesas SET enabled = '$this->enabled' WHERE id = $this->id";
        $rUpdate = $this->DB->Update($qryUpdate);

        if (!$rUpdate) {
            $this->Errors['UpdateEstado'] = 'El estado no pudo ser modificado.';
            return false;
        }
        return true;
    }

    function GetAllMesasInLoja($valor)
    {
        $this->clearMesas();
        try {
            $query = "SELECT * FROM mesas WHERE loja_id = $valor";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllMesas'] = 'No hay mesas registradas';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllMesas'] = $e->getMessage();
            return false;
        }
    }

    function clearErrors()
    {
        $this->Errors = array();
    }

    function hasErrors()
    {
        return !empty($this->Errors);
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

    function setIdentificador($valor)
    {
        $this->identificador = $this->DB->forsave($valor);
        if (empty($valor)) {
            $this->Errors['Identificador'] = 'Preencha o Identificador.';
        }
    }

    function getIdentificador()
    {
        return $this->DB->forShow($this->identificador);
    }

    function setEnabled($valor)
    {
        $this->enabled = $valor;
        if (empty($valor)) {
            $this->Errors['$Enabled'] = 'Erro interno.';
        }
    }

    function getEnabled()
    {
        if ($this->enabled == 'S') {
            $enabled = 'checked';
            return $enabled;
        } else {
            $enabled = '';
            return $enabled;
        }
    }
}
?>
