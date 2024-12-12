<?php
require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsAlertas
{
    var $id       = 0;
    var $loja_id  = '';
    var $mensaje  = '';
    var $fecha    = '';
    var $tipo     = ''; // 1: atender, 2:  economica, 3: falta Stock, 4: qr mesa desactivado, 5: pedido eliminado
    var $Errors   = array();
    var $DB;

    function clsAlertas()
    {
        $this->clearAlertas();
        $this->DB = new clsMySqliDB();
    }

    function clearAlertas()
    {
        $this->id      = 0;
        $this->loja_id = '';
        $this->mensaje = '';
        $this->fecha   = date('Y-m-d H:i:s');
        $this->tipo    = ''; 
        $this->Errors  = array();

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
      $qInsert = "INSERT INTO alertas (loja_id, mensaje, fecha, tipo) VALUES ($this->loja_id, '$this->mensaje', '$this->fecha', '$this->tipo')";
        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'La alerta no se puede registrar.';
            return false;
        }

        $this->setId($rInsert);
        return true;
    }

    function Modificar()
    {
        $qryModificar = "UPDATE alertas SET loja_id = '$this->loja_id', mensaje = '$this->mensaje', fecha = '$this->fecha', tipo = '$this->tipo' WHERE id = $this->id";
        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = 'La alerta no se puede modificar.';
            return false;
        }

        return true;
    }

    function Borrar()
    {
        $SQL = "DELETE FROM alertas WHERE id = $this->id";
        if (!$this->DB->Remove($SQL)) {
            $this->Errors['Borrar'] = 'Error interno.';
            return false;
        }

        return true;
    }

    function findId($valor)
    {
        $this->clearAlertas();
        $this->id = (int) $valor;

        if ($this->id <= 0) {
            $this->Errors['id'] = 'Error interno.';
            return false;
        }

        $query = "SELECT * FROM alertas WHERE id = $this->id";
        $result = $this->DB->Select($query);

        if (!$result) {
            $this->Errors['id'] = 'La alerta no existe.';
            return false;
        }

        $this->id      = $result['id'];
        $this->loja_id = $result['loja_id'];
        $this->mensaje = $result['mensaje'];
        $this->fecha   = $result['fecha'];
        $this->tipo    = $result['tipo'];

        return true;
    }

    function GetAllAlertasInLoja($valor)
    {
        $this->clearAlertas();
        $query = "SELECT * FROM alertas WHERE loja_id = $valor";
        $result = $this->DB->Select($query, 'all');

        if ($result !== false) {
            $aValues = array();
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id']      = $value['id'];
                $aValues[$Id]['loja_id'] = $this->DB->forShow($value['loja_id']);
                $aValues[$Id]['mensaje'] = $this->DB->forSave($value['mensaje']);
                $aValues[$Id]['fecha']   = $this->DB->forShow($value['fecha']);
                $aValues[$Id]['tipo']    = $this->getTipoIcono($value['tipo']);
                $aValues[$Id]['tipo_id'] = $value['tipo'];
                $aValues[$Id]['color']   = $this->colorAlert($value['tipo']);
            
            }
            return $aValues;
        } else {
            $this->Errors['GetAllAlertas'] = 'Error al obtener alertas.';
            return array();
        }
    }
    function colorAlert($valor){
        switch ($valor) { // 1: atender, 2:  economica, 3: falta Stock, 4: qr mesa desactivado
            case 1:
                return 'bg-info';
                break;
            case 2:
                return 'bg-success';
                break;
            case 3:
                return 'bg-danger';
                break;
            case 4:
                return 'bg-warning';
                break;
            case 5:
                return 'bg-warning';
                break;
        }
    }
    function getAlertas($valor)
    {
        $query = "SELECT * FROM alertas WHERE loja_id=$valor ORDER BY fecha DESC";
        $result = $this->DB->Select($query, 'all');

        if ($result) {
            return $result;
        } else {
            $this->Errors['getAlertas'] = 'No se pudo obtener las alertas.';
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
        return implode('<br>', $this->Errors);
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
        $this->loja_id = $valor;
    }

    function getLoja_Id()
    {
        return $this->DB->forShow($this->loja_id);
    }

    function setMensaje($valor)
    {
        $this->mensaje = $this->DB->forSave($valor);
    }

    function getMensaje()
    {
        return $this->DB->forShow($this->mensaje);
    }

    function setFecha($valor)
    {
        $this->fecha = $valor;
    }

    function getFecha()
    {
        return $this->DB->forShow($this->fecha);
    }

    function setTipo($valor)
    {
        $this->tipo = $this->DB->forSave($valor);
    }

    function getTipo()
    {
        
        return $this->DB->forShow($this->tipo);
    }

    function getTipoIcono($valor)
    {

        switch ($valor) { // 1: atender, 2:  economica, 3: falta Stock, 4: qr mesa desactivado
            case 1:
                return '<i class="fas fa-concierge-bell text-white"></i>';
                break;
            case 2:
                return '<i class="fas fa-donate text-white"></i>';
                break;
            case 3:
                return '<i class="fas fa-exclamation-triangle text-white"></i>';
                break;
            case 4:
                return '<i class="fas fa-qrcode fa-spin" style="color: #e10909;"></i>';
                break;
            case 5:
               return ' <i class="fas fa-utensils fa-spin style="color: #4a09e1;"></i>';
               break;
        }
     
    }
}
