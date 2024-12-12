<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';
class clsMensajes
{

    var $id         = 0;
    var $loja_id    = '';
    var $mensaje    = '';
    var $nombre     = '';
    var $telefono   = '';
    var $email      = '';
    var $fecha      = '';
    var $estado     = '';

    var $Errors     = array();
    var $DB;

    function clsMensajes()
    {
        $this->clearMensajes();
        $this->DB = new clsMySqliDB();
    }

    function clearMensajes()
    {

        $this->id       = 0;
        $this->loja_id  = '';
        $this->mensaje  = '';
        $this->nombre   = 0;
        $this->telefono = '';
        $this->email    = '';
        $this->fecha    = date('Y-m-d H:i:s');
        $this->estado   = '';


        $this->DB       = new clsMySqliDB();
        $this->Errors   = array();
    }

    function Validate()
    {
        if (empty($this->Errors)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function Registrar()
    {
        $qInsert = "INSERT INTO mensajes "
            . "(loja_id,"
            . "mensaje,"
            . "nombre,"
            . "telefono,"
            . "email,"
            . "fecha,"
            . "estado)"
            . "VALUES"
            . "($this->loja_id,"
            . "'$this->mensaje',"
            . "'$this->nombre',"
            . "'$this->telefono',"
            . "'$this->email',"
            . "'$this->fecha',"
            . "'N')";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O mensagem n&atilde;o pode ser registrado.';
            return FALSE;
        }
        $this->setId($rInsert);
        return true;
    }

    /* -----------------Mensajes comunes------------------------------------------------------------------------ */

    function Modificar()
    {
        $qryModificar = "UPDATE mensajes SET " .
            "estado     = '$this->estado' " .
            "WHERE id   = $this->id;";

        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O mensagem n&atilde;o pode ser modificado.";
            return FALSE;
        }
        return TRUE;
    }

    function Borrar()
    {
        $SQL = "DELETE FROM mensajes WHERE id = $this->id;";
        if (!$this->DB->Remove($SQL)) {
            $this->Errors['borrar'] = 'Erro interno.';
            return FALSE;
        }
        return TRUE;
    }

    /* -------------------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearMensajes();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['id'] = 'Erro interno.';
                return FALSE;
            }
            $query = "SELECT * FROM mensajes WHERE id = $this->id;";
            $result = $this->DB->Select($query);
            if (!$result) {
                $this->Errors['id'] = 'O mensagem n&atilde;o existe.';
                return FALSE;
            }
            $this->id = $result['id'];
            $this->loja_id = $result['loja_id'];
            $this->mensaje = $result['mensaje'];
            $this->nombre = $result['nombre'];
            $this->telefono = $result['telefono'];
            $this->email = $result['email'];
            $this->fecha = $result['fecha'];
            $this->estado = $result['estado'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return FALSE;
        }
    }

    //---------------------------------------------------------
    function GetAllMensajesInLoja($valor)
    {
        $this->clearMensajes();
        try {

            $query =  "SELECT id , "
                . "nombre ,"
                . "fecha ,"
                . "email ,"
                . "estado ,"
                . "mensaje ,"
                . "telefono "
                . "FROM mensajes "
                . "where loja_id = $valor;";

            $result = $this->DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];
                    $aValues[$Id]['nombre'] = $this->DB->forShow($value['nombre']);
                    $aValues[$Id]['email'] = $this->DB->forShow($value['email']);

                    $fecha = new DateTime($value['fecha']);
                    $fecha->setTimezone(new DateTimeZone('Europe/Lisbon'));
                    $aValues[$Id]['fecha'] = $fecha->format('d-F-y');
                    $aValues[$Id]['telefono'] = $this->DB->forShow($value['telefono']);
                    $aValues[$Id]['estado'] = $this->DB->forShow($value['estado']);
                    $aValues[$Id]['mensaje'] = $this->DB->forShow($value['mensaje']);
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllMensajes'] = $e->getMessage();
            return array();
        }
    }
    //---------------------------------------------------------
    function GetAllMensajesDashboard($valor)
    {
        $this->clearMensajes();
        try {

            $query =  "SELECT id , "
                . "nombre ,"
                . "fecha ,"
                . "email ,"
                . "estado ,"
                . "mensaje ,"
                . "telefono "
                . "FROM mensajes "
                . "where loja_id = $valor;";

            $result = $this->DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['id'] = $value['id'];

                    if ($aValues[$Id]['nombre'] != '') {
                        $aValues[$Id]['nombre'] = $this->DB->forShow($value['nombre']);
                    } else {
                        $aValues[$Id]['nombre'] = $this->DB->forShow($value['email']);
                    }

                    $fecha = new DateTime($value['fecha']);
                    $fecha->setTimezone(new DateTimeZone('Europe/Lisbon'));
                    $aValues[$Id]['fecha'] = $fecha->format('d-F-y');
                    $aValues[$Id]['estado'] = $this->DB->forShow($value['estado']);
                    $aValues[$Id]['mensaje'] = substr($this->DB->forShow($value['mensaje']), 0, 30);;
                }
                return $aValues;
            }
        } catch (Exception $e) {
            $this->Errors['GetAllMensajesDashboard'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------
    function clearErrors()
    {
        $this->Errors = array();
    }

    function hasErrors()
    {
        if (empty($this->Errors)) {
            return FALSE;
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
        $this->id = (int) $valor;
        if (empty($valor)) {
            $this->Errors['Id'] = 'Erro interno.';
        }
    }

    function getId()
    {
        return $this->id;
    }
    //---------------------------------------------------------
    function setLoja_Id($valor)
    {
        $this->loja_id = $this->DB->forSave($valor);
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
    function setMensaje($valor)
    {
        $this->mensaje = $this->DB->forsave($valor);
    }

    function getMensaje()
    {
        return $this->DB->forShow($this->mensaje);
    }

    function editMensaje()
    {
        return $this->DB->forEdit($this->mensaje);
    }
    //-------------------------------------------------------------
    function setNombre($valor)
    {
        $this->nombre = $this->DB->forsave($valor);
    }

    function getNombre()
    {
        return $this->DB->forShow($this->nombre);
    }

    function editNombre()
    {
        return $this->DB->forEdit($this->nombre);
    }
    //---------------------------------------------------------
    function setTelefono($valor)
    {
        $this->telefono = $this->DB->forsave($valor);
    }

    function getTelefono()
    {
        return $this->DB->forShow($this->telefono);
    }

    function editTelefono()
    {
        return $this->DB->forEdit($this->telefono);
    }
    //---------------------------------------------------------
    function setEmail($valor)
    {
        $this->email = $this->DB->forSave($valor);
    }

    function getEmail()
    {
        return $this->DB->forShow($this->email);
    }

    function editEmail()
    {
        return $this->DB->forEdit($this->email);
    }

    //---------------------------------------------------------
    function setFecha($valor)
    {
        $this->fecha = $valor;
    }

    function getFecha()
    {
        return $this->DB->forShow($this->fecha);
    }

    function editFecha()
    {
        return $this->DB->forEdit($this->fecha);
    }
    //---------------------------------------------------------
    function setEstado($valor)
    {
        $this->estado = $this->DB->forsave($valor);
    }

    function getEstado()
    {
        return $this->DB->forShow($this->estado);
    }

    function editEstado()
    {
        return $this->DB->forEdit($this->estado);
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
    //---------------------------------------------------------
}
