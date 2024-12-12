<?php
require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsStockDetalle
{

    var $id = 0;
    var $stock_id = 0;
    var $cantidad = 0;
    var $comentario = '';
    var $pedido_detalle_id = 0;
    var $date;
    var $user = 0;

    var $Errors = array();
    var $DB;

    function clsStockDetalle()
    {
        $this->clearStockDetalle();
        $this->DB = new clsMySqliDB();
    }

    function clearStockDetalle()
    {

        $this->id = 0;
        $this->stock_id = 0;
        $this->cantidad = 0;
        $this->date = date('Y-m-d H:i:s');
        $this->user = 0;

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

    /**
     * Registers the stock detail.
     *
     * This function is responsible for registering the stock detail.
     * It performs the necessary operations to add the stock detail to the system.
     *
     * @return void
     */
    function Registrar()
    {
        // Function implementation goes here
        $qInsert = "INSERT INTO stock_detalle("
            . "stock_id, "
            . "cantidad, "
            . "date, "
            . "comentario, "
            . "user) "
            . "VALUES("
            . "$this->stock_id, "
            . "$this->cantidad, "
            . "'$this->date', "
            . "'$this->comentario', "
            . "$this->user);";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O Stock Det. n&atilde;o pode ser registrado.';
            return false;
        }
        $this->setId($rInsert);
        return true;
    }

    /* ----------------Produto admin-------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM stock_detalle WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O stock det. n&atilde;o existe.";
        }

        if (!$this->Validate()) {
            return false;
        }

        $qModificar = "UPDATE stock_detalle SET "
            . "stock_id = $this->stock_id, "
            . "cantidad = $this->cantidad, "
            . "date = '$this->date', "
            . "user = $this->user "
            . "WHERE id = $this->id;";

        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O stock det. n&atilde;o pode ser modificado.";
            return false;
        }
        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function Borrar()
    {
        $SQL = "DELETE FROM stock_detalle WHERE id = $this->id;";
        $result = $this->DB->Remove($SQL);
        if (!$result) {
            $this->Errors['stock_detalle'] = 'O stock detalhe n&atilde;o existe.';
            return false;
        }
    
        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearStockDetalle();
        $this->id = $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM stock_detalle WHERE id = $this->id;";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['Id'] = 'O stock det. n&atilde;o existe.';
                return false;
            }
            $this->id = $result['id'];
            $this->stock_id = $result['stock_id'];
            $this->cantidad = $result['cantidad'];
            $this->date = $result['date'];
            $this->comentario = $result['comentario'];
            $this->pedido_detalle_id = $result['pedido_detalle_id'];
            $this->user = $result['user'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }

    //------------------------------------------------------------------------------
function GetAllStockDetalle($valor)
    {
        $this->clearStockDetalle();
        try {
            $query = "SELECT sd.id, sd.cantidad, sd.date, CONCAT(a.nombre, ', ', a.apellido) as nombre, sd.comentario FROM stock_detalle as sd
            INNER JOIN administradores as a ON sd.user = a.id
            WHERE stock_id = $valor ORDER BY sd.date DESC;";
            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllStockDetalle'] = 'n&atilde;o h&aacute; detalhes cadastrados';
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['cantidad'] = $value['cantidad'];
                $date = new DateTime($value['date']);
                $aValues[$Id]['date'] = $date->format('Y-m-d H:i');
                $aValues[$Id]['nombre'] = $value['nombre'];
                $aValues[$Id]['comentario'] = $value['comentario'];
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllStockDetalle'] = $e->getMessage(); 
            return false;
        }
    }
    //----------------------------------------------------------------------------

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
    //---------------------------------------------------------  

    function setStock_Id($valor)
    {
        $this->stock_id = $valor;
        if (empty($valor)) {
            $this->Errors['Stock_Id'] = 'Selecione um Stock.';
        }
    }

    function getStock_Id()
    {
        return $this->DB->forEdit($this->stock_id);
    }

    function editStock_Id()
    {
        return $this->DB->forEdit($this->stock_id);
    }

    //---------------------------------------------------------

    function setDate($valor)
    {
        $this->date = $valor;
        if (empty($valor)) {
            $this->Errors['Date'] = 'Preencha a data.';
        }
    }

    function getDate()
    {
        return $this->DB->forEdit($this->date);
    }

    function editDate()
    {
        return $this->DB->forEdit($this->date);
    }

    //---------------------------------------------------------

    function setUser($valor)
    {
        $this->user = $valor;
        if (empty($valor)) {
            $this->Errors['User'] = 'Selecione um usu&aacute;rio.';
        }
    }

    function getUser()
    {
        return $this->DB->forEdit($this->user);
    }

    function editUser()
    {
        return $this->DB->forEdit($this->user);
    }

    //---------------------------------------------------------


    function setCantidad($valor)
    {
        $this->cantidad = $valor;
        if (empty($valor) && $valor != 0) {
            $this->Errors['Cantidad'] = 'Preencha a quantidade.';
        }
    }

    function getCantidad()
    {
        return $this->DB->forEdit($this->cantidad);
    }

    function editCantidad()
    {
        return $this->DB->forEdit($this->cantidad);
    }

   //---------------------------------------------------------

   function setComentario($valor)
   {
       $this->comentario = $valor;
   }

    function getComentario()
    {
         return $this->DB->forEdit($this->comentario);
    }

    function editComentario()
    {
        return $this->DB->forEdit($this->comentario);
    }

    //---------------------------------------------------------

    function setpedido_detalle_id($valor)
    {
        $this->pedido_detalle_id = $valor;
    }

    function getpedido_detalle_id()
    {
        return $this->DB->forEdit($this->pedido_detalle_id);
    }

    function editpedido_detalle_id()
    {
        return $this->DB->forEdit($this->pedido_detalle_id);
    }

    //---------------------------------------------------------
}
