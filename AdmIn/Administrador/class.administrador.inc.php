<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';
//echo (getLocal('COMMONS').'class.mysqli.inc.php');
class clsAdministrador
{

    var $id         = 0;
    var $alta       = '';
    var $login      = '';
    var $password   = '';
    var $nombre     = '';
    var $apellido   = '';
    var $enabled    = '';
    var $admin      = '';
    var $email      = '';
    var $telefono   = '';
    var $loja_id    = ''; //por defecto tiene que ser 0 cuando es SUPER ADMIN este tipo de admin se crea desde la base de datos
    var $fecnac     = '';
    var $Errors     = array();
    var $DB;

    function clsAdministrador()
    {
        $this->clearAdministrador();
        $this->DB = new clsMySqliDB();
    }

    function clearAdministrador()
    {

        $this->id       = 0;
        $this->alta     = date('Y-m-d H:i:s');
        $this->login    = '';
        $this->password = '';
        $this->nombre   = '';
        $this->apellido = '';
        $this->enabled  = '';
        $this->email    = '';
        $this->telefono = '';
        $this->loja_id  = 0;
        $this->admin    = '';
        $this->fecnac   = '';
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
        if ($this->DB->Select("SELECT id FROM administradores WHERE email = '$this->email';")) {
            $this->Errors['Email'] = 'O email j&aacute; est&aacute; registrado';
        }
        if (!$this->Validate()) {
            return FALSE;
        }

        //$contrasena_encriptada = password_hash($this->password, PASSWORD_DEFAULT);

        $qInsert = "INSERT INTO administradores "
            . "(email,"
            . "nombre,"
            . "apellido,"
            . "telefono,"
            . "loja_id,"
            . "password,"
            . "admin,"
            . "enabled,"
            . "alta)"
            . "VALUES"
            . "('$this->email',"
            . "'$this->nombre',"
            . "'$this->apellido',"
            . "'$this->telefono',"
            . "$this->loja_id,"
            . "'$this->password',"
            . "'N',"
            . "'$this->enabled'"
            . ",'$this->alta')";
        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O administrador n&atilde;o pode ser registrado.';
            return FALSE;
        }
        $this->setId($rInsert);
        return true;
    }

    /* ----------------administrador admin---------------------------------------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM administradores WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O administrador n&atilde;o existe.";
        }
        if (!$this->Validate()) {
            return FALSE;
        }

        $qModificar = "UPDATE administradores SET telefono = '$this->telefono' WHERE id = $this->id;";
        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O administrador n&atilde;o pode ser modificado.";
            return FALSE;
        }
        return TRUE;
    }

    /* -----------------administradores comunes------------------------------------------------------------------------ */

    function Modificar_ADM()
    {

        $qryModificar = "UPDATE administradores SET " .
            "nombre     = '$this->nombre', " .
            "apellido   = '$this->apellido', " .
            "enabled    = '$this->enabled', " .
            "email      = '$this->email', " .
            "telefono   = '$this->telefono', " .
            "loja_id  = $this->loja_id " .
            "WHERE id   = $this->id;";

        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O administrador n&atilde;o pode ser modificado.";
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
        if (!$this->DB->Remove("DELETE FROM administradores WHERE id = $this->id;")) {
            $this->Errors['borrar'] = 'Erro interno.';
            return FALSE;
        }
        return TRUE;
    }

    /* ----------------para el admin------------------------------------------------- */

    function changePassword($vieja, $nueva, $confirmacion)
    {
        if (empty($vieja) || empty($nueva) || empty($confirmacion) || $nueva != $confirmacion) {
            $this->Errors['Password'] = 'A nova senha n&atilde;o corresponde &agrave; confirma&ccedil;&atilde;o.';
            return FALSE;
        }
        if ($nueva == $vieja) {
            $this->Errors['Password'] = 'A nova senha &eacute; igual &agrave; antiga.';
            return FALSE;
        }
        $result = $this->DB->Select("SELECT id, password FROM administradores WHERE id = $this->id ;");


        if (!$this->DB->VerificarPasswords($result['password'], $vieja)) {
            $this->Errors['Password'] = 'A senha antiga n&atilde;o est&aacute; correta.';
            return FALSE;
        }
        //
        $password_encriptada = $this->DB->encriptar($nueva);
        $result1 = $this->DB->Update("UPDATE administradores SET password = '$password_encriptada' WHERE id = '$this->id'");
        if ($result1 == null) {
            $this->Errors['Password'] = 'A senha n&atilde;o pode ser modificada.';
            return FALSE;
        }
        return TRUE;
    }

    /* -------------------para los administradores------------------------------------ */

    function changePassword_ADM($nueva, $confirmacion)
    {
        if (empty($nueva) || $nueva != $confirmacion) {
            $this->Errors['Password'] = 'A nova senha n&atilde;o corresponde &agrave; confirma&ccedil;&atilde;o.';
            return FALSE;
        }
        $nuevaPassword = $this->DB->encriptar($nueva);

        $result = $this->DB->Update("UPDATE administradores SET password = '$nuevaPassword' WHERE id = '$this->id'");

        if (!$result) {
            $this->Errors['Password'] = 'A senha n&atilde;o pode ser modificada.';
            return FALSE;
        }
        return TRUE;
    }

    /* -------------------------------------------------------------------------------------- */
    function UpdateEstado()
    {
        $qryUpdate = "UPDATE administradores SET enabled = '$this->enabled' WHERE id = $this->id;";
        $rUpdate = $this->DB->Update($qryUpdate);

        if (!$rUpdate) {
            $this->Errors['UpdateEstado'] = 'Erro interno.';
            return FALSE;
        }
        return TRUE;
    }
      
    
    
    /* -----------------para los administradores------------------------------------------------ */


    function findId($valor)
    {
        $this->clearAdministrador();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return FALSE;
            }
            $query = "SELECT * FROM administradores WHERE id = $this->id;";
            $result = $this->DB->Select($query);
            if (!$result) {
                $this->Errors['Id'] = 'O administrador n&atilde;o existe.';
                return FALSE;
            }
            $this->id = $result['id'];
            $this->alta = $result['alta'];
            $this->password = $result['password'];
            $this->nombre = $result['nombre'];
            $this->apellido = $result['apellido'];
            $this->enabled = $result['enabled'];
            $this->email = $result['email'];
            $this->telefono = $result['telefono'];
            $this->admin = $result['admin'];
            $this->loja_id = $result['loja_id'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return FALSE;
        }
    }
    //---------------------------------------------------------
    function GetAllAdmins()
    {
        $this->clearAdministrador();
        try {

            $query =  "SELECT a.id , "
                . "a.nombre ,"
                . "a.apellido ,"
                . "a.email ,"
                . "a.telefono ,"
                . "l.nombre as loja ,"
                . "a.enabled "
                . "FROM administradores as a "
                . "INNER JOIN lojas AS l ON l.id = a.loja_id "
                . "where a.admin = 'N';";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllAdmins'] = 'N&atilde;o h&aacute; administradores registrados';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllAdmins'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------
    function GetAllAdminsByLoja($valor)
    {
        $this->clearAdministrador();
        try {

            $query =  "SELECT a.id , "
                . "a.nombre ,"
                . "a.apellido ,"
                . "a.email ,"
                . "l.nombre as loja ,"
                . "a.enabled "
                . "FROM administradores as a "
                . "INNER JOIN lojas AS l ON l.id = a.loja_id "
                . "where a.admin = 'N' AND "
                . "a.loja_id = $valor ;";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllAdminsByLoja'] = 'N&atilde;o h&aacute; administradores registrados';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllAdminsByLoja'] = $e->getMessage();
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
    //    function setLogin($valor) {
    //        $this->login = $this->DB->forSave($valor);
    //        if (empty($valor)) {
    //            $this->Errors['Login'] = 'Preencha o usu&aacute;rio.';
    //        } elseif ((trim($valor) != $valor)) {
    //            $this->Errors['Login'] = 'O Login n&atilde;o deve conter espa&ccedil;os no in&iacute;cio ou no final.';
    //        }
    //    }
    //
    //    function setLoginCreacion($valor) {
    //        $this->login = $this->DB->forSave($valor);
    //        if (empty($valor)) {
    //            $this->Errors['Login'] = 'Preencha o usu&aacute;rio.';
    //        }
    //        if ($valor == 'admin') {
    //            $this->Errors['Login'] = 'nome de usuario n&atilde;o permitido.';
    //        } elseif ((trim($valor) != $valor)) {
    //            $this->Errors['Login'] = 'O Login n&atilde;o deve conter espa&ccedil;os no in&iacute;cio ou no final.';
    //        }
    //    }
    //
    //    function getLogin() {
    //        return $this->login;
    //    }
    //
    //    function editLogin() {
    //        return $this->login;
    //    }
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

    //-------------------------------------------------------------------
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

    //---------------------------------------------------------
    function setNombre($valor)
    {
        $this->nombre = (string) $valor;
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
        $this->apellido = (string) $valor;
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
        $this->telefono = (string) $valor;
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
    function setAdmin($valor)
    {
        $this->admin = (string) $valor;
    }

    function getAdmin()
    {
        return $this->DB->forShow($this->admin);
    }

    function editAdmin()
    {
        return $this->DB->forEdit($this->admin);
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
    function setFecNac($valor)
    {
        $this->fecnac = $this->DB->verifyDate($valor, 0, '', date('Y') + 1);
    }

    function getFecNac()
    {
        return $this->DB->forShow($this->fecnac);
    }

    function editFecNac()
    {
        return $this->DB->convertDate($this->fecnac);
    }

    //---------------------------------------------------------
    function setLoja_Id($valor)
    {
        $this->loja_id = (string) $valor;
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

    function setAlta($valor)
    {
        $this->alta = $this->DB->verifyDate($valor, 0, '', date('Y') + 1);
    }

    function getAlta()
    {
        return $this->DB->forShow($this->alta);
    }

    function editAlta()
    {
        return $this->DB->convertDate($this->alta);
    }

    //---------------------------------------------------------
    function doLogin($email, $password)
    {

        $this->clearAdministrador();
        $this->setEmail($email);
        $this->setPassword($password);

        $qLogin = "SELECT id, password, enabled FROM administradores WHERE email = '$email'";

        $rLogin = $this->DB->Select($qLogin);

        if (!$rLogin) {
            $this->Errors['Login'] = 'Por favor insira suas credenciais corretamente.';
            return FALSE;
        }
        if (!$this->DB->VerificarPasswords($rLogin['password'], $password)) {
            $this->Errors['Login'] = 'Por favor insira suas credenciais corretamente.';
            return FALSE;
        }
        if ($rLogin['enabled'] != 'S') {
            $this->Errors['Login'] = 'O usuário não está habilitado, entre em contato com o administrador.';
            return FALSE;
        }
        if (!$this->findId($rLogin['id'])) {
            return FALSE;
        }
        return TRUE;
    }

    //---------------------------------------------------------
    function checkIdentidad($email, $ruta)
    {
        $checkAdmin = "SELECT id FROM administradores WHERE email = '$email';";
        $resultAdmin = $this->DB->Query($checkAdmin);
        $datosAdmin = '';
        if ($resultAdmin) {
            //$datosAdmin = mysql_fetch_assoc($resultAdmin);
        } else {
            $this->Errors['Nuevo_password'] = 'Entrada incorrecta de datos .';
        }
        if (!isset($this->Errors['Nuevo_password'])) {
            $idAdmin = $datosAdmin['id'];
            $nueva_password = time();

            if ($this->DB->Command("UPDATE administradores SET password = password('$nueva_password') WHERE id = $idAdmin;")) {
                require_once $ruta . 'func.mail.php';

                if (has_no_newlines($email)) {
                    $texto = 'XXXXXXXXXX - Nova senha' . "\n" . "\n" .
                        'Sua nova senha: ' . $nueva_password;
                    $html = "<html>
                            <head>
                            <title>XXXXXXXXXX - Nova senha</title>
                            <style type='text/css'>
                            body{background-color: #E8ECF0;}
                            td {font-family: arial;font-size: 11px;}
                            </style>
                            </head>
                            <body>
                                <table>
                                    <tr><td colspan='2'><h1>XXXXXXXX - Nova senha</h1></td></tr>
                                    <tr><td><strong>Sua nova senha:</strong>&nbsp;</td><td>$nueva_password</td></tr>
                                </table>
                            </body>
                            </html>";
                    if (!send_mail($email, 'info@XXXXXXXX.com', 'XXXXXXX - Nova senha', $html, $texto)) {
                        $this->Errors['Envio'] = 'mposs&iacute;vel enviar a mensagem. Por favor, tente novamente mais tarde.';
                    }
                } else {
                    $this->Errors['Envio'] = 'O e-mail cont&eacute;m caracteres inv&aacute;lidos.';
                }
            } else {
                $this->Errors['Nueva'] = 'Erro interno.';
            }
        }
    }

    //---------------------------------------------------------
    function forSave($param)
    {
        $var =  stripslashes((string) $param);
        return $var;
    }

    function forEdit($param)
    {
        return htmlentities(stripslashes($param));
    }

    function forShow($param)
    {
        return nl2br($this->forEdit($param));
    }

    function forHtml($param)
    {
        return nl2br(stripslashes($param));
    }
}
