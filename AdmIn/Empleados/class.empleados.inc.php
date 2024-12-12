<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';
class clsEmpleados
{

    var $id         = 0;
    var $nombre      = '';
    var $apellido   = '';
    var $loja_id    = '';
    var $telefono   = '';
    var $password   = '';
    var $email      = '';

    var $Errors     = array();
    var $DB;

    function clsEmpleados()
    {
        $this->clearEmpleados();
        $this->DB = new clsMySqliDB();
    }

    function clearEmpleados()
    {

        $this->id       = 0;
        $this->nombre   = '';
        $this->apellido = '';
        $this->loja_id  = 0;
        $this->telefono = '';
        $this->password = '';
        $this->email    = '';

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
        if ($this->DB->Select("SELECT id FROM empleados WHERE email = '$this->email';")) {
            $this->Errors['Email'] = 'O email j&aacute; est&aacute; registrado';
        }
        if (!$this->Validate()) {
            return FALSE;
        }

        //$contrasena_encriptada = password_hash($this->password, PASSWORD_DEFAULT);

        $qInsert = "INSERT INTO empleados "
            . "(nombre,"
            . "apellido,"
            . "loja_id,"
            . "telefono,"
            . "password,"
            . "email)"
            . "VALUES"
            . "('$this->nombre',"
            . "'$this->apellido',"
            . "'$this->loja_id',"
            . "'$this->telefono',"
            . "'$this->password',"
            . "'$this->email')";
        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O Empleado n&atilde;o pode ser registrado.';
            return FALSE;
        }
        $this->setId($rInsert);
        return true;
    }

    /* -----------------Empleados comunes------------------------------------------------------------------------ */

    function Modificar()
    {
        $qryModificar = "UPDATE empleados SET " .
            "nombre     = '$this->nombre', " .
            "apellido   = '$this->apellido', " .
            "telefono    = '$this->telefono', " .
            "password    = '$this->password', " .
            "email      = '$this->email' " .
            "WHERE id   = $this->id;";

        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O Empleado n&atilde;o pode ser modificado.";
            return FALSE;
        }
        return TRUE;
    }

    function Borrar()
    {
        if ($this->id <= 0) {
            $this->Errors['borrar'] = 'Error interno.';
            return FALSE;
        }
        if (!$this->DB->Remove("DELETE FROM empleados WHERE id = $this->id;")) {
            $this->Errors['borrar'] = 'Erro interno.';
            return FALSE;
        }
        return TRUE;
    }

    /* -------------------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearEmpleados();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return FALSE;
            }
            $query = "SELECT * FROM empleados WHERE id = $this->id;";
            $result = $this->DB->Select($query);
            if (!$result) {
                $this->Errors['Id'] = 'O Empleado n&atilde;o existe.';
                return FALSE;
            }
            $this->id = $result['id'];
            $this->nombre = $result['nombre'];
            $this->apellido = $result['apellido'];
            $this->loja_id = $result['loja_id'];
            $this->telefono = $result['telefono'];
            $this->password = $result['password'];
            $this->email = $result['email'];
            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return FALSE;
        }
    }
    //----------------------------------------------------------------------
    function changePassword($valor)
    {
        $nuevaPassword = $this->DB->encriptar($valor);

        $result = $this->DB->Update("UPDATE empleados SET password = '$nuevaPassword' WHERE id = $this->id");

        if (!$result) {
            $this->Errors['Password'] = 'A senha n&atilde;o pode ser modificada.';
            return FALSE;
        }
        return TRUE;
    }

    //---------------------------------------------------------
    function GetAllEmpleadosInLoja($valor)
    {
        $this->clearEmpleados();
        try {

            $query =  "SELECT e.id , "
                . "e.nombre ,"
                . "e.apellido ,"
                . "e.email ,"
                . "e.telefono as telefono "
                . "FROM empleados as e "
                . "INNER JOIN lojas AS l ON l.id = e.loja_id "
                . "where e.loja_id = $valor;";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllEmpleados'] = 'N&atilde;o h&aacute; Empleados registrados';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllAdmins'] = $e->getMessage();
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

    function setPassword($valor)
    {
        $this->password = $valor;
        if (empty($valor)) {
            $this->Errors['Password'] = 'Preencha a senha.';
        }
    }

    function getPassword()
    {
        return $this->password;
    }

    function editPassword()
    {
        return $this->password;
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

    function editNombre()
    {
        return $this->DB->forEdit($this->nombre);
    }

    //---------------------------------------------------------
    function setApellido($valor)
    {
        $this->apellido = $this->DB->forsave($valor);
        if (empty($valor)) {
            $this->Errors['Apellido'] = 'Preencha o Sobrenome.';
        }
    }

    function getApellido()
    {
        return $this->DB->forShow($this->apellido);
    }

    function editApellido()
    {
        return $this->DB->forEdit($this->apellido);
    }

    //---------------------------------------------------------
    function setTelefono($valor)
    {
        $this->telefono = $this->DB->forsave($valor);
        if (empty($valor)) {
            $this->Errors['Telefono'] = 'Preencha o telefone.';
        }
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
        if (empty($valor)) {
            $this->Errors['Email'] = 'Preencha o endere&ccedil;o.';
        }
        $this->email = $this->DB->forSave($valor);
        $aValidacion = $this->email;

        if ($aValidacion[0] == false) {
            $this->Errors['Email'] = $aValidacion[1];
        }
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
    function setLoja_Id($valor)
    {
        $this->loja_id = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Loja_Id'] = 'Escolha uma loja.';
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
    function doLogin($email, $password)
    {

        $this->clearEmpleados();
        $this->setEmail($email);
        $this->setPassword($password);

        $qLogin = "SELECT id, password FROM empleados WHERE email = '$email'";

        $rLogin = $this->DB->Select($qLogin);

        if (!$rLogin) {
            $this->Errors['Login'] = 'Por favor insira suas credenciais corretamente';
            return FALSE;
        }
        if (!$this->DB->VerificarPasswords($rLogin['password'], $password)) {
            $this->Errors['Login'] = 'Por favor insira suas credenciais corretamente.';
            return FALSE;
        }

        if (!$this->findId($rLogin['id'])) {
            return FALSE;
        }
        return TRUE;
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
