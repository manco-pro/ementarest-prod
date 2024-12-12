<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsLojas
{

    var $id = 0;
    var $nombre = '';
    var $telefono = '';
    var $nif = 0;
    var $empresa = '';

    var $enabled = '';
    var $email = '';
    var $morada = '';
    var $mesas = 0;
    var $freguesia = 0;
    var $alta = '';
    var $facebook = '';
    var $instagram = '';
    var $logo = '';
    var $ruta_ementa = '';
    var $googlemaps = '';
    var $tripadvisor = '';
    var $plantilla = 1; // 1 = plantilla por defecto 2 = plantilla dark 3 = plantilla light



    var $Errors = array();
    var $DB;

    function clsLojas()
    {
        $this->clearLojas();
        $this->DB = new clsMySqliDB();
    }

    function clearLojas()
    {

        $this->id = 0;
        $this->nombre = '';
        $this->telefono = '';
        $this->nif = 0;
        $this->empresa = '';
        $this->enabled = '';
        $this->email = '';
        $this->morada = '';
        $this->mesas = 0;
        $this->freguesia = 0;
        $this->alta = date('Y-m-d H:i:s');
        $this->facebook = '';
        $this->instagram = '';
        $this->logo = '';
        $this->ruta_ementa = '';
        $this->googlemaps = '';
        $this->tripadvisor = '';
        $this->plantilla = 1;


        $this->DB = new clsMySqliDB();
        $this->Errors = array();
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
        if ($this->DB->Select("SELECT id FROM lojas WHERE email = '$this->email';")) {
            $this->Errors['Email'] = 'O email j&aacute; est&aacute; registrado';
        }
        if (!$this->Validate()) {
            return FALSE;
        }

        $qInsert = "INSERT INTO lojas("
            . "nombre, "
            . "telefono, "
            . "NIF, "
            . "empresa, "
            . "enabled, "
            . "email, "
            . "morada, "
            . "mesas, "
            . "freguesia, "
            . "facebook, "
            . "instagram, "
            . "logo, "
            . "ruta_ementa, "
            . "googlemaps, "
            . "tripadvisor, "
            . "plantilla,"
            . "alta)"
            . "VALUES"
            . "('$this->nombre',"
            . "'$this->telefono',"
            . "$this->nif,"
            . "'$this->empresa',"
            . "'$this->enabled',"
            . "'$this->email',"
            . "'$this->morada',"
            . "$this->mesas,"
            . "$this->freguesia,"
            . "'$this->facebook',"
            . "'$this->instagram',"
            . "'$this->logo',"
            . "'$this->ruta_ementa',"
            . "'$this->googlemaps',"
            . "'$this->tripadvisor',"
            . "'$this->plantilla',"
            . "'$this->alta')";

        $rInsert = $this->DB->Insert($qInsert);
        if (!$rInsert) {
            $this->Errors['Register'] = 'O loja n&atilde;o pode ser registrado.';
            return FALSE;
        }
        $this->setId($rInsert);

        if (!$this->CreatePathForEmenta($this->ruta_ementa, $this->id)) {
            $this->Errors['Register'] = 'O ruta Ementa n&atilde;o pode ser registrado.';
            return FALSE;
        }


        return true;
    }
    /************************************************************************ */
    function CreatePathForEmenta($ruta_ementa, $id)
    {

        $filename = getLocal('ementa') . $ruta_ementa;
        $file = fopen($filename, 'a');

        if ($file == false) {
            //echo 'Error al abrir el archivo';
            return false;
        } else {
            $content = "<?php\r\n"
                . "include_once './cOmmOns/config.inc.php';\r\n"
                . "\$loja = $id;\r\n"
                . "\$mesa = obtenerValor('mesa');\r\n"
                . "require_once getLocal('EMENTA') . 'user_session.php';";
            fwrite($file, $content);
            fclose($file);
            return true;
        }
    }
    //-------------------------------------------------------------------------------
    function UpdateEstado()
    {
        $query = "UPDATE lojas SET enabled = '$this->enabled' WHERE id = $this->id;";
        $result = $this->DB->Update($query);

        if (!$result) {
            $this->Errors['UpdateEstado'] = 'Erro interno.';
            return false;
        }
        return true;
    }

    function AltaMesas($mesas)
    {
        $qInsert = "INSERT INTO mesas(loja_id,identificador) VALUES";
        for ($i = 1; $i <= $mesas; $i++) {
            $qInsert .= "($this->id, 'Mesa $i'),";
        }
        $qInsert = substr($qInsert, 0, -1);

        $rInsert = $this->DB->Insert($qInsert);
        if (!$rInsert) {
            $this->Errors['RegisterMesas'] = 'O Mesas n&atilde;o pode ser registradas.';
            return FALSE;
        }
        return true;
    }
    /************************************************************************ */
    function ActualizarMesas($mesas)
    {
        $qDelete = "DELETE FROM mesas WHERE loja_id = $this->id;";
        $rDelete = $this->DB->Remove($qDelete);
        if (!$rDelete) {
            $this->Errors['ActualizarMesas'] = 'O Mesas n&atilde;o pode ser atualizadas.';
            return FALSE;
        }
        $this->AltaMesas($mesas);
        return true;
    }

    function getAllMesas()
    {
        $query = "SELECT * FROM mesas WHERE loja_id = $this->id ORDER BY id ASC;";
        $result = $this->DB->Select($query, 'all');
        if (!$result) {
            $this->Errors['getAllMesas'] = 'N&atilde;o h&aacute; mesas cadastradas.';
            return false;
        }
        return $result;
    }



    /* ----------------loja admin-------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM lojas WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O loja n&atilde;o existe.";
        }
        if (!$this->Validate()) {
            return FALSE;
        }

        $qModificar = "UPDATE lojas SET "
            . "nombre       = '$this->nombre', "
            . "empresa      = '$this->empresa', "
            . "NIF          = $this->nif, "
            . "telefono     = '$this->telefono', "
            . "email        = '$this->email', "
            . "morada       = '$this->morada', "
            . "freguesia    = $this->freguesia,"
            . "facebook     = '$this->facebook',"
            . "instagram    = '$this->instagram',"
            . "googlemaps   = '$this->googlemaps',"
            . "tripadvisor  = '$this->tripadvisor',"
            . "plantilla    = '$this->plantilla',"
            . "logo         = '$this->logo'"
            . "WHERE "
            . "id = $this->id;";

        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O loja n&atilde;o pode ser modificado.";
            return FALSE;
        }
        return TRUE;
    }

    /* -----------------lojas comunes---------------------------------------- */

    function Modificar_ADM()
    {
        $qryModificar = "UPDATE lojas SET "
            . "nombre       = '$this->nombre', "
            . "telefono     = '$this->telefono', "
            . "NIF          =  $this->nif, "
            . "empresa      = '$this->empresa', "
            . "enabled      = '$this->enabled', "
            . "email        = '$this->email', "
            . "morada       = '$this->morada', "
            . "mesas        =  $this->mesas, "
            . "freguesia    =  $this->freguesia, "
            . "facebook     = '$this->facebook', "
            . "instagram    = '$this->instagram', "
            . "logo         = '$this->logo', "
            . "googlemaps   = '$this->googlemaps', "
            . "tripadvisor  = '$this->tripadvisor', "
            . "plantilla    = '$this->plantilla', "
            . "ruta_ementa  = '$this->ruta_ementa' "
            . "WHERE id     =  $this->id;";

        $rModificar = $this->DB->Update($qryModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O loja n&atilde;o pode ser modificado.";
            return FALSE;
        }
        return TRUE;
    }
    //---------------------------no habilitado de momento------------------
    function Borrar()
    {
        if (!$this->DB->Remove("DELETE FROM lojas WHERE id = $this->id;")) {
            $this->Errors['borrar'] = 'Erro interno.';
            return FALSE;
        }

        $archivo_a_borrar = getLocal('ementa') . $this->ruta_ementa;

        // Borrar la Ruta de la ementa
        if (file_exists($archivo_a_borrar)) {
            // Intentar borrar el archivo
            if (!unlink($archivo_a_borrar)) {
                $this->Errors['borrarPathToEmenta'] = 'Erro interno.';
            }
        } else {
            $this->Errors['borrarPathToEmenta'] = 'err.10.';
        }

        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearLojas();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return FALSE;
            }
            $query = "SELECT * FROM lojas WHERE id = $this->id;";
            $result = $this->DB->Select($query);


            if (!$result) {
                $this->Errors['Id'] = 'O loja n&atilde;o existe.';
                return FALSE;
            }
            $this->id = $result['id'];
            $this->nombre = $result['nombre'];
            $this->telefono = $result['telefono'];
            $this->nif = $result['NIF'];
            $this->empresa = $result['empresa'];
            $this->enabled = $result['enabled'];
            $this->email = $result['email'];
            $this->morada = $result['morada'];
            $this->mesas = $result['mesas'];
            $this->freguesia = $result['freguesia'];
            $this->facebook = $result['facebook'];
            $this->instagram = $result['instagram'];
            $this->googlemaps = $result['googlemaps'];
            $this->tripadvisor = $result['tripadvisor'];
            $this->logo = $result['logo'];
            $this->ruta_ementa = $result['ruta_ementa'];
            $this->alta = $result['alta'];
            $this->plantilla = $result['plantilla'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return FALSE;
        }
    }

    //---------------------------------------------------------
    function GetAllFreguesias()
    {
        $this->clearLojas();
        try {
            $query = "SELECT "
                . "f.id, "
                . "CONCAT(c.nombre, ' --> ', f.nombre) AS nombre "
                . "FROM "
                . "freguesias AS f "
                . "INNER JOIN consejos AS c "
                . "ON "
                . "c.id = f.consejo_id "
                . "ORDER BY "
                . "c.nombre;";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllFreguesias'] = 'N&atilde;o h&aacute; freguesias cadastradas no sistema.';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllFreguesias'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------
    function GetPlantillas()
    {
        try {
            $query = "SELECT * FROM plantillas ORDER BY id;";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllPlantillas'] = 'N&atilde;o h&aacute; plantillas cadastradas no sistema.';
                return false;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetAllPlantillas'] = $e->getMessage();
            return false;
        }
    }
    //------------------------------------------------------------------------- 

    function FindMesa($valor)
    {
        $query = "SELECT * FROM mesas WHERE id = $valor AND loja_id = $this->id;";
        $result = $this->DB->Select($query);
        if (!$result) {
            $this->Errors['FindMesa'] = 'O c&oacute;digo QR n&atilde;o &eacute; mais v&aacute;lido';
            return false;
        }
        return true;
    }
    //------------------------------------------------------------------------- 






    //
    function GetAllLojas()
    {
        $this->clearLojas();
        try {
            $query = "SELECT * FROM lojas ORDER BY nombre ASC;";
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
    //---------------------------------------------------------
    function GetAllLojasForEmenta()
    {
        $this->clearLojas();
        try {
            $query = "SELECT * FROM lojas WHERE enabled='S' ORDER BY nombre ASC;";
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

    //-------------------------------------------------------------------

    function setNombre($valor)
    {
        $this->nombre = $this->DB->forSave($valor);
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
    function setTelefono($valor)
    {
        $this->telefono = $this->DB->forSave($valor);
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
    function setNIF($valor)
    {
        $this->nif = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['NIF'] = 'Preencha o NIF';
        }
    }

    function getNIF()
    {
        return $this->DB->forShow($this->nif);
    }

    function editNIF()
    {
        return $this->DB->forEdit($this->nif);
    }

    //---------------------------------------------------------   
    function setEmpresa($valor)
    {
        $this->empresa = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Empresa'] = 'Preencha o nome do Empresa.';
        }
    }

    function getEmpresa()
    {
        return $this->DB->forShow($this->empresa);
    }

    function editEmpresa()
    {
        return $this->DB->forEdit($this->empresa);
    }

    //---------------------------------------------------------    
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
    function setMorada($valor)
    {
        $this->morada = $this->DB->forSave($valor);
    }

    function getMorada()
    {
        return $this->DB->forShow($this->morada);
    }

    function editMorada()
    {
        return $this->DB->forEdit($this->morada);
    }

    //---------------------------------------------------------    
    function setMesas($valor)
    {
        $this->mesas = $this->DB->forSave($valor);
    }

    function getMesas()
    {
        return $this->DB->forShow($this->mesas);
    }

    function editMesas()
    {
        return $this->DB->forEdit($this->mesas);
    }

    //---------------------------------------------------------    
    function setFreguesia($valor)
    {
        $this->freguesia = $valor;
        if ($valor == "-1") {
            $this->Errors['Freguesia'] = 'Selecione uma Freguesia. ';
        }
    }

    function getFreguesia()
    {
        return $this->DB->forShow($this->freguesia);
    }

    function editFreguesia()
    {
        return $this->DB->forEdit($this->freguesia);
    }
    //---------------------------------------------------------    
    function setFacebook($valor)
    {
        $this->facebook = $this->DB->forSave($valor);
    }

    function getFacebook()
    {
        return $this->DB->forShow($this->facebook);
    }

    function editFacebook()
    {
        return $this->DB->forEdit($this->facebook);
    }
    //---------------------------------------------------------    
    function setInstagram($valor)
    {
        $this->instagram = $this->DB->forSave($valor);
    }

    function getInstagram()
    {
        return $this->DB->forShow($this->instagram);
    }

    function editInstagram()
    {
        return $this->DB->forEdit($this->instagram);
    }
    //---------------------------------------------------------    
    function setLogo($valor)
    {
        $this->logo = $this->DB->forSave($valor);
    }

    function getLogo()
    {
        return $this->DB->forShow($this->logo);
    }

    function editLogo()
    {
        return $this->DB->forEdit($this->logo);
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
    function setRuta_Ementa($valor)
    {
        $this->ruta_ementa = $this->DB->forSave($valor);
    }
    function getRuta_Ementa()
    {
        return $this->DB->forShow($this->ruta_ementa);
    }
    function editRuta_Ementa()
    {
        return $this->DB->forEdit($this->ruta_ementa);
    }
    //---------------------------------------------------------
    function setGooglemaps($valor)
    {
        $this->googlemaps = $this->DB->forSave($valor);
    }
    function getGooglemaps()
    {
        return $this->DB->forShow($this->googlemaps);
    }
    function editGooglemaps()
    {
        return $this->DB->forEdit($this->googlemaps);
    }
    //---------------------------------------------------------
    function setTripadvisor($valor)
    {
        $this->tripadvisor = $this->DB->forSave($valor);
    }
    function getTripadvisor()
    {
        return $this->DB->forShow($this->tripadvisor);
    }
    function editTripadvisor()
    {
        return $this->DB->forEdit($this->tripadvisor);
    }
    //---------------------------------------------------------  
    function setPlantilla($valor)
    {
        $this->plantilla = $valor;
        if ($valor == "-1") {
            $this->Errors['Plantilla'] = 'Selecione uma Pantilla. ';
        }
    }
    function getPlantilla()
    {
        return $this->DB->forShow($this->plantilla);
    }
    function editPlantilla()
    {
        return $this->DB->forEdit($this->plantilla);
    }
    //---------------------------------------------------------

    function forSave($param)
    {
        return trim(preg_replace('/[^\p{L}0-9_\s]/u', '', $param));
    }
}
