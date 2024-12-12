<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';
require_once getLocal('STK') . 'class.stock_detalle.inc.php';

class clsStock
{

    var $id = 0;
    var $coleccion_id = 0;
    var $loja_id = 0;
    var $cantidad = 0;
    var $minimo = 0;
    var $detalles;
    var $Errors = array();
    var $DB;

    function clsStock()
    {
        $this->clearStock();
        $this->DB = new clsMySqliDB();
        $this->detalles = new clsStockDetalle();
    }

    function clearStock()
    {

        $this->id = 0;
        $this->coleccion_id = 0;
        $this->loja_id = 0;
        $this->cantidad = 0;
        $this->minimo = 0;


        $this->detalles = new clsStockDetalle();
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

        $qInsert = "INSERT INTO stock("
            . "coleccion_id, "
            . "loja_id, "
            . "cantidad, "
            . "minimo) "
            . "VALUES("
            . "$this->coleccion_id, "
            . "$this->loja_id, "
            . "$this->cantidad, "
            . "$this->minimo);";

        $rInsert = $this->DB->Insert($qInsert);

        if (!$rInsert) {
            $this->Errors['Register'] = 'O Produto n&atilde;o pode ser registrado.';
            return false;
        }
        $this->setId($rInsert);

        //Registrar en stock_detalles
        $this->detalles->clearStockDetalle();
        $this->detalles->stock_id = $this->id;
        $this->detalles->cantidad = $this->cantidad;
        $this->detalles->user = $_SESSION['_admId'];
        $this->detalles->Registrar();
        //Fin de registro en stock_detalles

        return true;
    }

    /* ----------------Produto-------------------------------------------- */

    function Modificar()
    {
        if (!$this->DB->Select("SELECT id FROM stock WHERE id = $this->id;")) {
            $this->Errors['Modificar'] = "O Produto n&atilde;o existe.";
        }

        if (!$this->Validate()) {
            return false;
        }

        $qModificar = "UPDATE stock SET "
            . "coleccion_id = $this->coleccion_id, "
            . "cantidad = $this->cantidad, "
            . "minimo = $this->minimo "
            . "WHERE id = $this->id;";

        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['Modificar'] = "O Produto n&atilde;o pode ser modificado.";
            return false;
        }
        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function Borrar()
    {
        $SQL = "DELETE FROM stock WHERE id = $this->id;";
        $this->DB->Remove($SQL);

        $SQL = "DELETE FROM stock_detalle WHERE stock_id = $this->id;";
        $this->DB->Remove($SQL);

        return TRUE;
    }

    /* ------------------------------------------------------------------------- */

    function findId($valor)
    {
        $this->clearStock();
        $this->id = $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return false;
            }
            $query = "SELECT * FROM stock WHERE id = $this->id;";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['Id'] = 'O Produto n&atilde;o existe.';
                return false;
            }
            $this->id = $result['id'];
            $this->coleccion_id = $result['coleccion_id'];
            $this->loja_id = $result['loja_id'];
            $this->cantidad = $result['cantidad'];
            $this->minimo = $result['minimo'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }

    //------------------------------------------------------------------------------
    function GetAllStockByLoja($valor)
    {
        $this->clearStock();
        try {
            $query = "SELECT s.id, c.nombre_pt, c.imagen, s.minimo, s.cantidad "
                . "FROM stock as s "
                . "inner join colecciones c "
                . "on c.id=s.coleccion_id "
                . "WHERE loja_id = $valor;";
            $result = $this->DB->Select($query, 'all');



            if (!$result) {

                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['nombre_pt'] = $this->DB->forShow($value['nombre_pt']);
                $aValues[$Id]['imagen'] = $this->DB->forShow($value['imagen']);
                $aValues[$Id]['minimo'] = $this->DB->forShow($value['minimo']);
                $aValues[$Id]['cantidad'] = $value['cantidad'];
                $x = ($aValues[$Id]['minimo'] * 100) / 20;
                $porc = ($aValues[$Id]['cantidad'] * 100) / $x;
                $aValues[$Id]['porcentaje'] = round($porc, 0);
                switch (true) {
                    case $porc < 20:
                        $aValues[$Id]['color'] = '#D04848';
                        $aValues[$Id]['color1'] = 'danger';
                        break;
                    case ($porc >= 20 && $porc < 50):
                        $aValues[$Id]['color'] = '#F6C23E';
                        $aValues[$Id]['color1'] = 'warning';
                        break;
                    case $porc >= 50:
                        $aValues[$Id]['color'] = '#1CC88A';
                        $aValues[$Id]['color1'] = 'success';
                        break;
                }
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllStockByLoja'] = $e->getMessage();
            return false;
        }
    }
    //----------------------------------------------------------------------------
    function GetAllStockColIds($loja_id)
    {
        $DB = new clsMySqliDB();
        try {
            $query = "SELECT "
                . "coleccion_id "
                . "FROM "
                . "stock "
                . "WHERE "
                . "loja_id = $loja_id;";
            $result = $DB->Select($query, 'all');

            if ($result != false) {
                foreach ($result as $key => $value) {
                    $aValues[] = $value['coleccion_id'];
                }
                return $aValues;
            }
            return array();
        } catch (Exception $e) {
            $this->Errors['GetAllStockColIds'] = $e->getMessage();
            return false;
        }
    }
    //----------------------------------------------------------------------------
    /**
     * Finds stock items by store and collection.
     *
     * @param int $loja_id The ID of the store.
     * @param int $coleccion_id The ID of the collection.
     * @return array An array of stock items matching the store and collection.
     */
    function find_By_Loja_Coleccion($loja_id, $coleccion_id)
    {

        $this->clearStock();
        $this->loja_id = $loja_id;
        $this->coleccion_id = $coleccion_id;

        try {
            $query = "SELECT * FROM stock WHERE loja_id = $this->loja_id AND coleccion_id = $this->coleccion_id;";
            $result = $this->DB->Select($query);

            if (!$result) {
                return false;
            }
            $this->id = $result['id'];
            $this->coleccion_id = $result['coleccion_id'];
            $this->loja_id = $result['loja_id'];
            $this->cantidad = $result['cantidad'];
            $this->minimo = $result['minimo'];

            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return false;
        }
    }
    //----------------------------------------------------------------------------

    function Revert_By_Array_Pedido_detalle($aValues, $loja_id)
    {
        $oStockDetalle = new clsStockDetalle();

        foreach ($aValues as $key => $value) {
            $this->clearStock();

            if ($this->find_By_Loja_Coleccion($loja_id, $value['coleccion_id'])) {
                $this->ActualizarStockCantidad($value['cantidad'] * -1);
                //Registrar en stock_detalles

                $oStockDetalle->clearStockDetalle();
                $oStockDetalle->stock_id = $this->getId();

                $oStockDetalle->cantidad = $value['cantidad'];
                $oStockDetalle->user = 0; //usuario designado para el sistema
                $oStockDetalle->pedido_detalle_id = $value['id'];
                $oStockDetalle->comentario = 'Esta transa&ccedil;&atilde;o foi revertida devido a uma altera&ccedil;&atilde;o no pedido.';
                $oStockDetalle->Registrar();
                $oStockDetalle->clearStockDetalle();
            }
        }
        return true;
    }



    //-----------------------------------------------------------------------------------
    /**
     * Updates the stock quantity by subtracting the given amount.
     *
     * @param int $cantidad The amount to subtract from the current stock quantity.
     * @return bool Returns true if the stock quantity was successfully updated, false otherwise.
     */
    function ActualizarStockCantidad($cantidad)
    {
        $this->cantidad = $this->cantidad - $cantidad;
        $qModificar = "UPDATE stock SET cantidad = $this->cantidad WHERE id = $this->id;";

        $rModificar = $this->DB->Update($qModificar);
        if ($this->cantidad < $this->minimo) {
            $this->AlertaMinimo($this->coleccion_id, $this->loja_id, $this->cantidad, $this->minimo);
        }
        if (!$rModificar) {
            $this->Errors['ActualizarStockCantidad'] = 'Erro interno.';
            return false;
        }
        return true;
    }
    //-----------------------------------------------------------------------------------

    function AlertaMinimo($coleccion_id, $loja_id, $cantidad, $minimo)
    {
        require_once getLocal('ALE') . 'class.alertas.inc.php';
        //get nombre de la coleccion
        $DB = new clsMySqliDB();
        $query = "SELECT nombre_pt FROM colecciones WHERE id = $coleccion_id;";
        $result = $DB->Select($query);
        $nombre = $result['nombre_pt'];

        $oAlertas = new clsAlertas();
        $oAlertas->clearAlertas();
        $oAlertas->loja_id = $loja_id;
        $oAlertas->mensaje = 'O produto ' . $nombre . ' tem ' . $cantidad . ' Unidades disponíveis, o mínimo é ' . $minimo . '.';
        $oAlertas->fecha = date('Y-m-d H:i:s');
        $oAlertas->tipo = 3;
        $oAlertas->Registrar();
        return true;
    }
    //-----------------------------------------------------------------------------------
    //listado de los 10 productos con menor % stock
    function GetStockMinimo($loja_id)
    {
        $DB = new clsMySqliDB();
        try {
            $query = "SELECT s.id, c.nombre_pt, c.imagen, s.minimo, s.cantidad "
                . "FROM stock as s "
                . "inner join colecciones c "
                . "on c.id=s.coleccion_id "
                . "WHERE loja_id = $loja_id "
                . "ORDER BY (s.cantidad * 100) / (s.minimo * 100) ASC "
                . "LIMIT 12;";
            $result = $DB->Select($query, 'all');

            if (!$result) {
                return false;
            }
            foreach ($result as $key => $value) {
                $Id = $value['id'];
                $aValues[$Id]['id'] = $value['id'];
                $aValues[$Id]['nombre'] = $DB->forShow($value['nombre_pt']);
                $aValues[$Id]['imagen'] = $DB->forShow($value['imagen']);
                $aValues[$Id]['minimo'] = $DB->forShow($value['minimo']);
                $aValues[$Id]['cantidad'] = $value['cantidad'];
                $x = ($aValues[$Id]['minimo'] * 100) / 20;
                $porc = ($aValues[$Id]['cantidad'] * 100) / $x;
                $aValues[$Id]['porc'] = round($porc, 0);
                switch (true) {
                    case $porc < 20:
                        $aValues[$Id]['color'] = '#D04848';
                        $aValues[$Id]['color1'] = 'danger';
                        break;
                    case ($porc >= 20 && $porc < 50):
                        $aValues[$Id]['color'] = '#F6C23E';
                        $aValues[$Id]['color1'] = 'warning';
                        break;
                    case $porc >= 50:
                        $aValues[$Id]['color'] = '#1CC88A';
                        $aValues[$Id]['color1'] = 'success';
                        break;
                }
            }
            return $aValues;
        } catch (Exception $e) {
            $this->Errors['GetStockMinimo'] = $e->getMessage();
            return false;
        }

    }




    //-----------------------------------------------------------------------------------

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
    function setColeccion_Id($valor)
    {
        $this->coleccion_id = $valor;
        if (empty($valor)) {
            $this->Errors['Coleccion_Id'] = 'Selecione uma Cole&ccedil;&atilde;o.';
        }
    }

    function getColeccion_Id()
    {
        return $this->DB->forEdit($this->coleccion_id);
    }

    function editColeccion_Id()
    {
        return $this->DB->forEdit($this->coleccion_id);
    }

    //---------------------------------------------------------
    function setLoja_Id($valor)
    {
        $this->loja_id = $valor;
    }

    function getLoja_Id()
    {
        return $this->DB->forEdit($this->loja_id);
    }
    //---------------------------------------------------------

    function setCantidad($valor)
    {
        $this->cantidad = $valor;
        if (empty($valor) && $valor != 0) {
            $this->Errors['Cantidad'] = 'Preencha a dispon&iacute;vel.';
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

    function setMinimo($valor)
    {
        $this->minimo = $valor;
        if (empty($valor)) {
            $this->Errors['Minimo'] = 'Preencha o minimo.';
        }
    }

    function getMinimo()
    {
        return $this->DB->forEdit($this->minimo);
    }

    function editMinimo()
    {
        return $this->DB->forEdit($this->minimo);
    }

    //---------------------------------------------------------
}
