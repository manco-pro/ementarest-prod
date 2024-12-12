<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';
//require_once getLocal('STK') . 'class.suscripcion_detalle.inc.php';

class clsSuscripciones
{

    var $id = 0;
    var $loja_id = 0;
    var $type = 0;
    var $inicio = '';
    var $fin = '';
    var $plano = '';
    var $active = '';
    var $aPlanos = array();
    var $aTipos = array();


    var $Errors = array();
    var $DB;

    function clsSuscripciones()
    {
        $this->clearSuscripciones();
        $this->DB = new clsMySqliDB();
    }

    function clearSuscripciones()
    {

        $this->id = 0;
        $this->loja_id = 0;
        $this->type = 0;
        $this->inicio = date('Y-m-d');
        $this->fin = date('Y-m-d');
        $this->active = ''; //S=activo N=Inactivo C=Suspenso
        $this->plano = '';
        $this->aPlanos = array(
            array('id' => '-1', 'nombre' => 'Plano'),
            array('id' => 'B', 'nombre' => 'Basico'),
            array('id' => 'S', 'nombre' => 'Standard'),
            array('id' => 'P', 'nombre' => 'Premiun'),
        );

        $this->aTipos = array(
            array('id' => '-1', 'nombre' => 'Tipo'),
            array('id' => 'M', 'nombre' => 'Mensal'),
            array('id' => 'A', 'nombre' => 'Anual'),
        );

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

        $qInsert = "INSERT INTO suscripciones ("
            . "loja_id, "
            . "type, "
            . "plano, "
            . "inicio, "
            . "fin, "
            . "active) "
            . "VALUES("
            . "$this->loja_id, "
            . "'$this->type', "
            . "'$this->plano', "
            . "'$this->inicio', "
            . "'$this->fin', "
            . "'$this->active');";
        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O subscri&ccedil;&atilde;o n&atilde;o pode ser registrado.';
            return false;
        }
        $this->setId($rInsert);

        return true;
    }

    /* ----------------Produto-------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM suscripciones WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O subscri&ccedil;&atilde;o n&atilde;o existe.";
        }

        if (!$this->Validate()) {
            return false;
        }

        $qModificar = "UPDATE suscripciones SET "
            . "type = '$this->type', "
            . "plano = '$this->plano', "
            . "inicio = '$this->inicio', "
            . "fin = '$this->fin', "
            . "active = '$this->active' "
            . "WHERE id = $this->id;";

        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O subscri&ccedil;&atilde;o n&atilde;o pode ser modificado.";
            return false;
        }
        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function Borrar()
    {
        $SQL = "DELETE FROM suscripciones WHERE id = $this->id;";
        $this->DB->Remove($SQL);

        $SQL = "DELETE FROM suscripcion_detalle WHERE suscripcion_id = $this->id;";
        $this->DB->Remove($SQL);

        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearSuscripciones();
        $this->id = $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM suscripciones WHERE id = $this->id;";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['Id'] = 'O subscri&ccedil;&atilde;o n&atilde;o existe.';
                return false;
            }
            $this->id = $result['id'];
            $this->loja_id = $result['loja_id'];
            $this->plano = $result['plano'];
            $this->type = $result['type'];
            $this->inicio = $result['inicio'];
            $this->fin = $result['fin'];
            $this->active = $result['active'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }

    //------------------------------------------------------------------------------
    function GetSuscripcionByLoja($valor)
    {
        $this->clearSuscripciones();
        try {
            $query = "SELECT s.id, l.nombre, s.type, s.plano, s.inicio, s.fin, s.active "
                . "FROM suscripciones as s "
                . "inner join lojas l "
                . "on l.id = s.loja_id "
                . "WHERE loja_id = $valor;";
            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues['id']     = $value['id'];
                $aValues['nombre'] = $this->DB->forShow($value['nombre']);
                $aValues['type']   =  $this->obtenerNombreArray($value['type'], $this->aTipos);
                $aValues['plano']  = $this->obtenerNombreArray($value['plano'], $this->aPlanos);
                $aValues['inicio'] = date("d-m-Y", strtotime($this->DB->forShow($value['inicio'])));
                $aValues['fin']    = date("d-m-Y", strtotime($this->DB->forShow($value['fin'])));    
                $aValues['active'] = $value['active'];
                //dias de suscripcion restantes
                $fecha_actual = date("Y-m-d");
                $fecha_entrada = $value['fin'];
                $dias = (strtotime($fecha_entrada) - strtotime($fecha_actual)) / 86400;
                $aValues['dias_restantes'] = $dias;
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllSuscripcionesByLoja'] = $e->getMessage();
            return false;
        }
    }
    //----------------------------------------------------------------------------
    //solo devuelve la suscripcion activa
    function GetSuscripcionActiveByLoja($loja_id)
    {
        $this->clearSuscripciones();
        $this->loja_id = $loja_id;

        try {
            if ($this->loja_id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM suscripciones WHERE loja_id = $this->loja_id AND active='S';";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['GetSuscripcionActiveByLoja'] = 'Loja sem subscri&ccedil;&atilde;o activa.';
                return false;
            }
            
            $this->id       = $result['id'];
            $this->loja_id  = $result['loja_id'];
            $this->plano    = $result['plano'];
            $this->type     = $result['type'];
            $this->inicio   = $result['inicio'];
            $this->fin      = $result['fin'];
            $this->active   = $result['active'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }
    //----------------------------------------------------------------------------
    function GetAllSuscripciones()
    {
        $this->clearSuscripciones();
        $aValues = array();
        try {
          $query = "SELECT s.id, l.nombre, s.type, s.plano, s.inicio, s.fin, s.active "
                . "FROM suscripciones as s "
                . "inner join lojas l "
                . "on l.id = s.loja_id;";
            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id']     = $value['id'];
                $aValues[$Id]['nombre'] = $this->DB->forShow($value['nombre']);
                $aValues[$Id]['type']   =  $this->obtenerNombreArray($value['type'], $this->aTipos);
                $aValues[$Id]['plano']  = $this->obtenerNombreArray($value['plano'], $this->aPlanos);
                $aValues[$Id]['inicio'] = date("d-m-Y" , strtotime($this->DB->forShow($value['inicio'])));
                $aValues[$Id]['fin']    = date("d-m-Y" , strtotime($this->DB->forShow($value['fin'])));
                $aValues[$Id]['active'] = $this->getActiveNombre($value['active']);
                //dias de suscripcion restantes
                $fecha_actual = date("Y-m-d");
                $fecha_entrada = $value['fin'];
                $dias = (strtotime($fecha_entrada) - strtotime($fecha_actual)) / 86400;
                if ($dias < 0) {
                    $dias = 0;
                }
                $aValues[$Id]['dias_restantes'] = $dias;
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllSuscripciones'] = $e->getMessage();
            return false;
        }
    }

    //----------------------------------------------------------------------------

    function ActualizarSuscripcion()
    {
        $qModificar = "UPDATE suscripciones SET "
            . "type = $this->type, "
            . "plano = '$this->plano', "
            . "inicio = '$this->inicio', "
            . "fin = '$this->fin', "
            . "WHERE id = $this->id;";
        $rModificar = $this->DB->Update($qModificar);
        if (!$rModificar) {
            $this->Errors['ActualizarSuscripcionCantidad'] = 'Erro interno.';
            return false;
        }
        return true;
    }

    //-----------------------------------------------------------------------------------
    function GetAllLojasSinSuscripcion()
    {
        try {
            $query = "SELECT id, nombre FROM lojas WHERE id NOT IN (SELECT DISTINCT loja_id FROM suscripciones);";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllLojas'] = 'N&atilde;o h&aacute; instala&ccedil;&otilde;es cadastradas no sistema.';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllLojas'] = $e->getMessage();
            return false;
        }
    }
    //-----------------------------------------------------------------------------------

    function obtenerNombreArray($id, $array)
    {
        foreach ($array as $Item) {
            if ($Item['id'] == $id) {
                return $Item['nombre'];
                exit;
            }
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
    function setLoja_Id($valor)
    {
        $this->loja_id = $valor;
        if (empty($valor) || $valor === '-1') {
            $this->Errors['loja_id'] = 'Preencha o Loja.';
        }
    }

    function getLoja_Id()
    {
        return $this->DB->forEdit($this->loja_id);
    }
    //---------------------------------------------------------
    function setType($valor)
    {
        $this->type = $valor;
        if (empty($valor) || $valor === '-1') {
            $this->Errors['type'] = 'Preencha o tipo de subscri&ccedil;&atilde;o.';
        }
    }

    function getType()
    {
        return $this->DB->forEdit($this->type);
    }

    //---------------------------------------------------------

    function setInicio($valor)
    {
        $this->inicio = $valor;
        if (empty($valor)) {
            $this->Errors['inicio'] = 'selecione a data de in&iacute;cio.';
        }
    }

    function getInicio()
    {
        return $this->DB->forEdit($this->inicio);
    }

    //---------------------------------------------------------

    function setFin($valor)
    {
        $this->fin = $valor;
    }

    function getFin()
    {
        return $this->DB->forEdit($this->fin);
    }

    //---------------------------------------------------------

    function setPlano($valor)
    {
        $this->plano = $valor;
        if (empty($valor) || $valor === '-1') {
            $this->Errors['plano'] = 'Preencha o plano.';
        }
    }

    function getPlano()
    {
        return $this->DB->forEdit($this->plano);
    }

    function getPlanos()
    {
        return $this->aPlanos;
    }
    //---------------------------------------------------------

    function getTipos()
    {
        return $this->aTipos;
    }

    function setActive($valor)
    {
        $this->active = $valor;
    }

    function getActiveNombre($valor)
    {

        switch ($valor) {
            case 'C':
                return 'Suspenso';
                break;

            case 'S':
                return 'Ativo';
                break;

            default:
                return 'Inativo';
                break;
        }
    }

    function getActive()
    {

        if ($this->active == 'S' || $this->active == 'N') {
            return  '';
        } else {
            return 'checked';
        }
    }
}
