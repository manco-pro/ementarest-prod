<?php

require_once getLocal('COMMONS') . 'class.mysqli.inc.php';
require_once getLocal('STK') . 'class.stock.inc.php';

class clsPedidos
{

    var $id             = 0;
    var $loja_id        = 0;
    var $mesa_id        = 0;
    var $estado         = ''; // novo = N, Em curso = E ,P pronto,, F = finalizado ,C cancelado
    var $empleado_id    = 0;
    var $hora_inicio    = '';
    var $hora_fin       = '';
    var $comentarios    = '';
    var $detalle_pedido = array();

    var $Errors = array();
    var $DB;

    function clsPedidos()
    {
        $this->clearPedidos();
        $this->DB = new clsMySqliDB();
    }

    function clearPedidos()
    {

        $this->id = 0;
        $this->loja_id = 0;
        $this->mesa_id = 0;
        $this->estado = '';
        $this->empleado_id = 0;
        $this->hora_inicio = date('Y-m-d H:i:s');
        $this->hora_fin = date('Y-m-d H:i:s');
        $this->comentarios = '';
        $this->detalle_pedido = array();

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

    function PreRegistrar($arrayColecciones, $LojaId, $forUpdate = false)
    {
        $comentariosComida = '';
        $comentariosBebidas = '';
        $arraySoloColeccionesIDComida = array();
        $arraySoloColeccionesIDBebidas = array();
        foreach ($arrayColecciones as $value) {
            $newArray = explode('|', $value);
            $query = "SELECT "
                . " col.nombre_pt nombre, "
                . " cat.template as template "
                . " FROM "
                . " colecciones AS col "
                . " INNER JOIN catalogos cat ON "
                . " cat.id = col.catalogo_id "
                . " WHERE "
                . " col.id = $newArray[0] AND "
                . " cat.loja_id = $LojaId;";
            $this->loja_id = $LojaId;

            $result = $this->DB->Select($query);
            //seperar en comida y bebidas
            if ($result['template'] == 1) { //comida
                $arraySoloColeccionesIDComida[] = $newArray[0];
                if (count($newArray) == 2) {
                    $comentariosComida = $comentariosComida . "<li>" . $this->DB->forSave($result['nombre']) . ": " . $newArray[1] . "</li>";
                }
            } else {
                $arraySoloColeccionesIDBebidas[] = $newArray[0];
                if (count($newArray) == 2) {
                    $comentariosBebidas = $comentariosBebidas . "<li>" . $this->DB->forSave($result['nombre']) . ": " . $newArray[1] . "</li>";
                }
            }
        }

        if ($forUpdate == false) {
            if (!$this->Registrar($arraySoloColeccionesIDComida, $comentariosComida, $LojaId) || !$this->Registrar($arraySoloColeccionesIDBebidas, $comentariosBebidas, $LojaId)) {
                $this->Errors['Register'] = 'A ordem n&atilde;o pode ser Preregistrado.';
                return FALSE;
            };
        } else {
            if (!$this->Modificar($arraySoloColeccionesIDComida, $comentariosComida, $LojaId) || !$this->Modificar($arraySoloColeccionesIDBebidas, $comentariosBebidas, $LojaId)) {
                $this->Errors['Register'] = 'A ordem n&atilde;o pode ser Preregistrado.';
                return FALSE;
            };
        }

        //registrar stock
        $stock = new clsStock();
        $stock->setLoja_Id($LojaId);
        return TRUE;
    }

    /**
     * Calculates the total price of a given array of collection IDs.
     *
     * @param array $arraySoloColeccionesID An array of collection IDs.
     * @return float The total price of the collections.
     */
    function TotalPedido(array $arraySoloColeccionesID)
    {
        $total = 0;
        foreach ($arraySoloColeccionesID as $value) {
            $SQL = "SELECT SUM(precio) AS precio "
                . "FROM colecciones "
                . "WHERE id = $value;";
            $result = $this->DB->Select($SQL);
            $total = $total + $result['precio'];
        }
        return $total;
    }
    function PrecioColeccion($id)
    {
        $SQL = "SELECT precio "
            . "FROM colecciones "
            . "WHERE id = $id;";
        $result = $this->DB->Select($SQL);
        return $result['precio'];
    }

    function Registrar($arraySoloColeccionesID, $comentarios, $LojaId)
    {   //template 1 comida
        // template 2 bebida
        if (count($arraySoloColeccionesID) > 0) {
            $total = $this->TotalPedido($arraySoloColeccionesID);

            $qInsert = "INSERT INTO pedidos("
                . "loja_id, "
                . "mesa_id, "
                . "estado, "
                . "empleado_id, "
                . "hora_inicio, "
                . "comentarios, "
                . "total) "
                . "VALUES"
                . "($LojaId, "
                . "$this->mesa_id, "
                . "'N', "
                . "$this->empleado_id, "
                . "'$this->hora_inicio', "
                . "'$comentarios', "
                . "'$total');";

            $rInsert = $this->DB->Insert($qInsert);

            if (!$rInsert) {
                $this->Errors['Register'] = 'A ordem n&atilde;o pode ser registrado.';

                return FALSE;
            }
            $this->setId($rInsert);
            $resultado = $this->RegistrarPedidoDetalles($arraySoloColeccionesID, $this->id);
            return $resultado;
        } else {
            return true;
        }
    }

    /**
     * Registers the details of a pedido.
     *
     * This function is responsible for registering the details of a pedido by taking an array of colecciones and the ID of the pedido.
     *
     * @param array $arrayColecciones An array of colecciones.
     * @param int $id_pedido The ID of the pedido.
     * @return void
     */
    function RegistrarPedidoDetalles($arrayColecciones, $id_pedido)
    {
        $oStock = new clsStock();
        $oStock->clearStock();
        $oStockDetalle = new clsStockDetalle();
        $oStockDetalle->clearStockDetalle();
        $conteo = array_count_values($arrayColecciones);
        $values = "";

        // Mostrar los resultados
        foreach ($conteo as $coleccion_id => $cantidad) {
            $precio = $this->PrecioColeccion($coleccion_id);

            $values = "($id_pedido,"
                . "$coleccion_id,"
                . "$precio,"
                . "$cantidad)";

            $SQL  = "INSERT INTO pedido_detalle( "
                . " pedido_id,"
                . " coleccion_id,"
                . " precio,"
                . " cantidad)"
                . " VALUES $values;";

            $rInsert = $this->DB->Insert($SQL);
            if (!$rInsert) {
                $this->Errors['RegistrarPedidoDetalles'] = 'A detalhe do ordem n&atilde;o pode ser registrado.';
                return FALSE;
            }

            // Actualizar stock
            if ($oStock->find_By_Loja_Coleccion($this->loja_id, $coleccion_id)) {
                $oStock->ActualizarStockCantidad($cantidad);
                //Registrar en stock_detalles
                $oStockDetalle->clearStockDetalle();
                $oStockDetalle->stock_id = $oStock->getId();
                $cantidad = $cantidad * -1;
                $oStockDetalle->cantidad = $cantidad;
                $oStockDetalle->user = 0; //usuario designado para el sistema
                $oStockDetalle->pedido_detalle_id = $rInsert;
                $oStockDetalle->Registrar();
                $oStock->clearStock();
                $oStockDetalle->clearStockDetalle();
            }
        }
        return true;
    }
    /* ------------------------------------------------------------------------------ */
    function ModificarPedidoDetalles($arrayColecciones, $id_pedido)
    {

        $oStock = new clsStock();
        $oStock->clearStock();
        $oStockDetalle = new clsStockDetalle();
        $oStockDetalle->clearStockDetalle();
        $conteo = array_count_values($arrayColecciones);



        foreach ($conteo as $coleccion_id => $cantidad) {

            foreach ($this->detalle_pedido as $key => $value) {
                if ($value['coleccion_id'] == $coleccion_id) {
                    if ($value['cantidad'] > $cantidad) {
                        $diferencia =  $value['cantidad'] - $cantidad; //+stock
                        $tipoAdicion = 'suma';
                    } else {
                        $diferencia =  $cantidad - $value['cantidad']; //-stock
                        $tipoAdicion = 'resta';
                    }

                    // echo 'diferencia:';
                    // echo $diferencia;
                    // echo '<br>cantidad:';
                    // echo $cantidad;
                    // echo '<br>value:';
                    // echo $value['cantidad'];
                    // echo '<br>';

                    $detalle_pedido_id = $key;
                }
            }

            $SQL = "UPDATE pedido_detalle SET "
                . "cantidad = $cantidad "
                . "WHERE "
                . "id = $detalle_pedido_id;";


            $rInsert = $this->DB->Update($SQL);
            if (!$rInsert) {
                $this->Errors['RegistrarPedidoDetalles'] = 'A detalhe do ordem n&atilde;o pode ser alterado.';
                return FALSE;
            }

            // Actualizar stock
            if ($oStock->find_By_Loja_Coleccion($this->loja_id, $coleccion_id)) {
                if ($tipoAdicion == 'suma') {
                    $oStock->ActualizarStockCantidad($diferencia * -1);
                } else {
                    $oStock->ActualizarStockCantidad($diferencia);
                }

                //Registrar en stock_detalles
                $oStockDetalle->clearStockDetalle();
                $oStockDetalle->stock_id = $oStock->getId();
                if ($tipoAdicion == 'suma') {
                    $oStockDetalle->cantidad = $diferencia;
                } else {
                    $oStockDetalle->cantidad = $diferencia * -1;
                }
                //$oStockDetalle->cantidad = $diferencia;
                $oStockDetalle->user = 0; //usuario designado para el sistema
                $oStockDetalle->pedido_detalle_id = $detalle_pedido_id;
                $oStockDetalle->Registrar();
                $oStock->clearStock();
                $oStockDetalle->clearStockDetalle();
            }
        }
        return true;
    }

    function Modificar($arraySoloColeccionesID, $comentarios, $LojaId)
    {   //template 1 comida
        // template 2 bebida
        if (count($arraySoloColeccionesID) > 0) {
            $total = $this->TotalPedido($arraySoloColeccionesID);

            $qUpdate = "UPDATE pedidos SET "
                . "mesa_id   = $this->mesa_id, "
                . "comentarios = '$comentarios', "
                . "total = '$total' "
                . "WHERE "
                . "id = $this->id;";

            $rUpdate = $this->DB->Update($qUpdate);

            if (!$rUpdate) {
                $this->Errors['Update'] = 'A ordem n&atilde;o pode ser modificado.';
                return FALSE;
            }

            //logica para borrar y registrar detalles
            $PedidoDetalle = $this->GetallDetallesPedidoByPedidoId($this->id);

            foreach ($PedidoDetalle as $key => $value) {
                for ($i = 0; $i < $value['cantidad']; $i++) {
                    $aPedidoDetalle[] = $value['coleccion_id'];
                }
            }

            $arrayToInsert = array();
            $arrayToDelete = array();
            $arrayToModify = array();
            foreach ($arraySoloColeccionesID as $key => $value) {
                if (!in_array($value, $aPedidoDetalle)) {
                    $arrayToInsert[$value] = array_count_values($arraySoloColeccionesID)[$value];
                }
                if (in_array($value, $aPedidoDetalle)) {
                    if (array_count_values($arraySoloColeccionesID)[$value] != array_count_values($aPedidoDetalle)[$value]) {
                        $arrayToModify[$value] = array_count_values($arraySoloColeccionesID)[$value];
                    }
                }
            }

            foreach ($aPedidoDetalle as $key => $value) {
                if (!in_array($value, $arraySoloColeccionesID)) {
                    $arrayToDelete[$value] = array_count_values($aPedidoDetalle)[$value];
                }
            }

            foreach ($arrayToInsert as $key => $value) {
                for ($i = 0; $i < $value; $i++) {
                    $aIDS_TO_INSERT[$i] = $key;
                }
            }

            if (!empty($aIDS_TO_INSERT)) {
                $resultado = $this->RegistrarPedidoDetalles($aIDS_TO_INSERT, $this->id);
                if (!$resultado) {
                    $this->Errors['Modificar'] = 'Erro interno 548.';
                    return FALSE;
                }
            }
            foreach ($arrayToModify as $key => $value) {
                for ($i = 0; $i < $value; $i++) {
                    $aIDS_TO_MODIFY[$i] = $key;
                }
            }
            if (!empty($aIDS_TO_MODIFY)) {
                $resultado = $this->ModificarPedidoDetalles($aIDS_TO_MODIFY, $this->id);
                if (!$resultado) {
                    $this->Errors['Modificar'] = 'Erro interno 549.';
                    return FALSE;
                }
            }
            foreach ($arrayToDelete as $key => $value) {
                for ($i = 0; $i < $value; $i++) {
                    $aIDS_TO_DELETE[$i] = $key;
                }
            }
            if (!empty($aIDS_TO_DELETE)) {
                $resultado = $this->BorrarPedidoDetalles($aIDS_TO_DELETE, $this->id);
                if (!$resultado) {
                    $this->Errors['Modificar'] = 'Erro interno 550.';
                    return FALSE;
                }
            }



            if ($this->Validate()) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return true;
        }
    }

    function BorrarPedidoDetalles($arrayColecciones, $id_pedido)
    {
        $oStock = new clsStock();
        $oStock->clearStock();
        $oStockDetalle = new clsStockDetalle();
        $oStockDetalle->clearStockDetalle();
        $conteo = array_count_values($arrayColecciones);
        $values = "";

        // Mostrar los resultados
        foreach ($conteo as $coleccion_id => $cantidad) {
            foreach ($this->detalle_pedido as $key => $value) {
                if ($value['coleccion_id'] == $coleccion_id) {
                    $detalle_pedido_id = $key;
                }
            }

            $SQL  = "DELETE FROM pedido_detalle "
                . "WHERE "
                . "id = $detalle_pedido_id;";

            $rDelete = $this->DB->Remove($SQL);
            if (!$rDelete) {
                $this->Errors['BorrarPedidoDetalles'] = 'A detalhe do ordem n&atilde;o pode ser deleted.';
                return FALSE;
            }

            // Actualizar stock
            if ($oStock->find_By_Loja_Coleccion($this->loja_id, $coleccion_id)) {
                $cantidad = $cantidad * -1;
                $oStock->ActualizarStockCantidad($cantidad);
                //Registrar en stock_detalles
                $oStockDetalle->clearStockDetalle();
                $oStockDetalle->stock_id = $oStock->getId();

                $oStockDetalle->cantidad = $cantidad;
                $oStockDetalle->user = 0; //usuario designado para el sistema
                $oStockDetalle->pedido_detalle_id = 0;
                $oStockDetalle->Registrar();
                $oStock->clearStock();
                $oStockDetalle->clearStockDetalle();
            }
        }
        return true;
    }


    ///* ------------------------------------------------------------------------------ */

    function ModificarEstadoPedido($id, $estado = 'E')
    {
        $this->clearPedidos();
        if ($estado == 'F' || $estado == 'C') {
            $qModificar = "UPDATE pedidos SET estado='$estado', hora_fin='$this->hora_fin' WHERE id=$id;";
        } else {
            $qModificar = "UPDATE pedidos SET estado='$estado' WHERE id=$id;";
        }

        $rModificar = $this->DB->Update($qModificar);

        if (!$rModificar) {
            $this->Errors['ModificarEstadoPedido'] = "a ordem n&atilde;o pode ser modificado.";
            return FALSE;
        }
        return TRUE;
    }

    //---------------------------
    function Borrar_pedido_detalle()
    {

        $this->findId($this->id);


        //actualizar stock
        $aValues = $this->GetallDetallesPedidoByPedidoId($this->id);
        $oStock = new clsStock();
        $oStock->Revert_By_Array_Pedido_detalle($aValues, $this->loja_id);


        if (!$this->DB->Remove("DELETE FROM pedido_detalle WHERE pedido_id = $this->id;")) {
            $this->Errors['borrar'] = 'Erro interno.';
            return FALSE;
        }
        return TRUE;
    }

    /* --------------------------------------------------------------- */
    function GetTiempoPromedioPedido($loja_id)
    {
        $this->clearPedidos();
        $query = "SELECT "
            . " AVG(TIMESTAMPDIFF(MINUTE, hora_inicio, hora_fin)) AS tiempo_promedio_pedido"
            . " FROM pedidos"
            . " WHERE loja_id=$loja_id AND hora_fin IS NOT NULL"
            . " GROUP BY loja_id;";

        $result = $this->DB->Select($query);
        if (!$result) {
            $this->Errors['GetTiempoPromedioPedido'] = 'Erro interno.';
            return FALSE;
        }
        return  floor($result['tiempo_promedio_pedido']);
    }

    //--------------------------------------------------------------------- 
    function findId($valor)
    {
        $this->clearPedidos();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return FALSE;
            }
            $query = "SELECT * FROM pedidos WHERE id = $this->id;";
            $query2 = "SELECT pd.id, pd.coleccion_id, col.nombre_pt, pd.cantidad, pd.precio "
                . "FROM pedido_detalle pd "
                . "inner join colecciones as col "
                . "on col.id = pd.coleccion_id "
                . "WHERE pedido_id = $this->id;";


            $result = $this->DB->Select($query);
            $result2 = $this->DB->Select($query2, 'all');

            if (!$result) {
                $this->Errors['Id'] = 'A ordem n&atilde;o existe.';
                return FALSE;
            }
            $this->id = $result['id'];
            $this->loja_id = $result['loja_id'];
            $this->mesa_id = $result['mesa_id'];
            $this->estado = $result['estado'];
            $this->empleado_id = $result['empleado_id'];
            $this->hora_inicio = $result['hora_inicio'];
            $this->hora_fin = $result['hora_fin'];
            $this->comentarios = $result['comentarios'];
            $aValues = array();
            foreach ($result2 as $key => $value) {
                $aValues[$value['id']]['coleccion_id'] = $value['coleccion_id'];
                $aValues[$value['id']]['nombre_pt'] = $this->DB->forShow($value['nombre_pt']);
                $aValues[$value['id']]['cantidad'] = $value['cantidad'];
                $aValues[$value['id']]['precio'] = $value['precio'];
            }
            $this->detalle_pedido = $aValues;


            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return FALSE;
        }
    }
    //-------------------------------------------------------------------



    //------------------------------------------------------------------------------
    /**
     * Retrieves the template for a given coleccion ID.
     *
     * @param int $col_id The ID of the coleccion.
     * @return string The ID template for the coleccion.
     */
    function GetTemplate($col_id)
    {
        try {
            $query = "SELECT "
                . "cat.template "
                . "FROM "
                . "pedido_detalle AS pd "
                . "INNER JOIN colecciones AS col "
                . "ON "
                . "col.id = pd.coleccion_id "
                . "INNER JOIN catalogos AS cat "
                . "ON "
                . "cat.id = col.catalogo_id "
                . "WHERE "
                . "pd.coleccion_id = $col_id";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['GetTemplate'] = 'Erro interno.';
                return FALSE;
            }
            return $result;
        } catch (Exception $e) {
            $this->Errors['GetTemplate'] = $e->getMessage();
            return FALSE;
        }
    }

    function GetAllPedidosActiveByLoja($valor)
    {
        $this->clearPedidos();
        try {
            $query = "SELECT DISTINCT "
                . " P.id,"
                . " P.mesa_id,"
                . " M.identificador,"
                . " P.estado,"
                . " CONCAT(E.apellido, ', ', E.nombre) AS empleado,"
                . " P.hora_inicio,"
                . " CAT.template,"
                . " P.comentarios"
                . " FROM"
                . " pedidos AS P"
                . " INNER JOIN mesas AS M"
                . " ON"
                . " M.id = P.mesa_id"
                . " INNER JOIN empleados AS E"
                . " ON"
                . " E.id = P.empleado_id"
                . " INNER JOIN pedido_detalle AS PD"
                . " ON"
                . " PD.pedido_id = P.id"
                . " INNER JOIN colecciones AS COL"
                . " ON"
                . " COL.id = PD.coleccion_id"
                . " INNER JOIN catalogos AS CAT"
                . " ON"
                . " CAT.id = COL.catalogo_id"
                . " WHERE"
                . " P.estado IN('N', 'E') AND P.loja_id = $valor"
                . " ORDER BY"
                . " P.hora_inicio ASC";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllPedidosActiveByLoja'] = 'n&atilde;o existem pedidos ativos.';
                return false;
            }

            return  $result;
        } catch (Exception $e) {
            $this->Errors['GetAllPedidosActiveByLoja'] = $e->getMessage();
            return false;
        }
    }
    //-------------------------------------------------------------------
    function GetAllPedidosByLoja($loja_id)
    {
        $this->clearPedidos();
        try {
            $query = "SELECT "
                . "p.id, "
                . "m.identificador, "
                . "p.estado, "
                . "p.hora_inicio, "
                . "p.hora_fin, "
                . "CONCAT(e.apellido, ', ', e.nombre) AS empleado, "
                . "p.total "
                . "FROM "
                . "pedidos AS p "
                . "INNER JOIN mesas AS m "
                . "ON "
                . "m.id = p.mesa_id "
                . "inner join empleados as e  "
                . "on e.id = p.empleado_id "
                . "WHERE "
                . "p.loja_id = $loja_id "
                . "ORDER BY "
                . "p.hora_inicio DESC";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllPedidosActivosByLoja'] = 'n&atilde;o existem pedidos.';
                return false;
            }
            if ($result != false) {
                foreach ($result as $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['mesa']       = $this->DB->forShow($value['identificador']);

                    $aValues[$Id]['estado']     = $this->DB->forShow($value['estado']);
                    switch ($value['estado']) { // NEW = N, En preparo = E ,P pronto,, F = finalizado ,C cancelado
                        case 'N':
                            $aValues[$Id]['estado'] = 'Novo';
                            break;
                        case 'F':
                            $aValues[$Id]['estado'] = 'Finalizado';
                            break;
                        case 'E':
                            $aValues[$Id]['estado'] = 'En preparo';
                            break;
                        case 'P':
                            $aValues[$Id]['estado'] = 'Pronto';
                            break;
                        case 'C':
                            $aValues[$Id]['estado'] = 'Cancelado';
                            break;
                    }
                    $aValues[$Id]['hora_inicio'] = $this->DB->forShow($value['hora_inicio']);
                    $aValues[$Id]['empleado']   = $this->DB->forShow($value['empleado']);
                    $aValues[$Id]['total']      = $this->DB->forShow($value['total']);
                }
            }

            return  $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllPedidosByLoja'] = $e->getMessage();
            return false;
        }
    }
    //-------------------------------------------------------------------
    function FinalizarPedidosbyMesa($valor, $mesa_id)
    {
        $this->clearPedidos();
        $query = "SELECT "
            . " m.id, "
            . " m.identificador, "
            . " ROUND(SUM(p.total), 2) AS total "
            . " FROM "
            . " mesas AS m "
            . " INNER JOIN pedidos AS p "
            . " ON "
            . " p.mesa_id = m.id "
            . " WHERE "
            . " p.loja_id = $valor AND "
            . " p.estado = 'P' "
            . " GROUP BY "
            . " m.id ASC";

        $result = $this->DB->Select($query, 'all');
    }


    //-------------------------------------------------------------------11
    function GetAllPedidosProntoByLoja($valor)
    {
        $this->clearPedidos();
        try {
            $query = "SELECT "
                . " m.id, "
                . " m.identificador, "
                . " ROUND(SUM(p.total), 2) AS total "
                . " FROM "
                . " mesas AS m "
                . " INNER JOIN pedidos AS p "
                . " ON "
                . " p.mesa_id = m.id "
                . " WHERE "
                . " p.loja_id = $valor AND "
                . " p.estado = 'P' "
                . " GROUP BY "
                . " m.id "
                . " ORDER BY m.id ASC";

            $result = $this->DB->Select($query, 'all');
            if (!$result) {
                $this->Errors['GetAllPedidosActiveByLoja'] = 'n&atilde;o existem pedidos ativos.';
                return false;
            } else {
                foreach ($result as $key => $mesa) {
                    $query = "SELECT"
                        . " P.id,"
                        . " P.hora_inicio,"
                        . " PD.coleccion_id,"
                        . " COL.nombre_pt,"
                        . " PD.cantidad,"
                        . " PD.precio "
                        . " FROM"
                        . " pedidos AS P"
                        . " INNER JOIN mesas AS M"
                        . " ON"
                        . " M.id = P.mesa_id"
                        . " INNER JOIN empleados AS E"
                        . " ON"
                        . " E.id = P.empleado_id"
                        . " INNER JOIN pedido_detalle AS PD"
                        . " ON"
                        . " PD.pedido_id = P.id"
                        . " INNER JOIN colecciones AS COL"
                        . " ON"
                        . " COL.id = PD.coleccion_id"
                        . " INNER JOIN catalogos AS CAT"
                        . " ON"
                        . " CAT.id = COL.catalogo_id"
                        . " WHERE"
                        . " P.estado = 'P' AND M.id = $mesa[id]"
                        . " ORDER BY"
                        . " P.hora_inicio ASC";

                    $result2 = $this->DB->Select($query, 'all');
                    $result[$key]['Pedidos'] = $result2;
                }
            }


            return  $result;
        } catch (Exception $e) {
            $this->Errors['GetAllPedidosActiveByLoja'] = $e->getMessage();
            return false;
        }
    }
    //-------------------------------------------------------------------
    function GetAllVentasByLoja($loja_id)
    {
        $this->clearPedidos();
        try {
            $query = "SELECT "
                . "p.id, "
                . "p.estado, "
                . "p.hora_inicio, "
                . "p.hora_fin, "
                . "p.total "
                . "FROM "
                . "pedidos AS p "
                . "WHERE "
                . "p.loja_id = $loja_id AND p.estado = 'F'"
                . "ORDER BY "
                . "p.hora_inicio DESC";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllPedidosActivosByLoja'] = 'n&atilde;o existem pedidos.';
                return false;
            }
            if ($result != false) {
                foreach ($result as $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['estado']     = $this->DB->forShow($value['estado']);
                    switch ($value['estado']) { // NEW = N, En preparo = E ,P pronto,, F = finalizado ,C cancelado
                        case 'N':
                            $aValues[$Id]['estado'] = 'Novo';
                            break;
                        case 'F':
                            $aValues[$Id]['estado'] = 'Finalizado';
                            break;
                        case 'E':
                            $aValues[$Id]['estado'] = 'En preparo';
                            break;
                        case 'P':
                            $aValues[$Id]['estado'] = 'Pronto';
                            break;
                        case 'C':
                            $aValues[$Id]['estado'] = 'Cancelado';
                            break;
                    }
                    $aValues[$Id]['hora_inicio'] = $this->DB->forShow($value['hora_inicio']);
                    $aValues[$Id]['total']      = $this->DB->forShow($value['total']);
                }
            }

            return  $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllPedidosByLoja'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------
    function GetAllPedidosActivosByLoja($loja_id)
    {
        $this->clearPedidos();
        try {
            $query = "SELECT "
                . "p.id, "
                . "m.identificador, "
                . "p.estado, "
                . "p.hora_inicio, "
                . "p.hora_fin, "
                . "CONCAT(e.apellido, ', ', e.nombre) AS empleado, "
                . "p.total "
                . "FROM "
                . "pedidos AS p "
                . "INNER JOIN mesas AS m "
                . "ON "
                . "m.id = p.mesa_id "
                . "inner join empleados as e  "
                . "on e.id = p.empleado_id "
                . "WHERE "
                . "p.loja_id = $loja_id AND p.estado IN('N', 'E', 'P') "
                . "ORDER BY "
                . "p.hora_inicio DESC";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllPedidosActivosByLoja'] = 'n&atilde;o existem pedidos.';
                return false;
            }
            if ($result != false) {
                foreach ($result as $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['mesa']       = $this->DB->forShow($value['identificador']);

                    $aValues[$Id]['estado']     = $this->DB->forShow($value['estado']);
                    switch ($value['estado']) { // NEW = N, En preparo = E ,P pronto,, F = finalizado ,C cancelado
                        case 'N':
                            $aValues[$Id]['estado'] = 'Novo';
                            break;
                        case 'F':
                            $aValues[$Id]['estado'] = 'Finalizado';
                            break;
                        case 'E':
                            $aValues[$Id]['estado'] = 'En preparo';
                            break;
                        case 'P':
                            $aValues[$Id]['estado'] = 'Pronto';
                            break;
                        case 'C':
                            $aValues[$Id]['estado'] = 'Cancelado';
                            break;
                    }
                    $aValues[$Id]['hora_inicio'] = $this->DB->forShow($value['hora_inicio']);
                    $aValues[$Id]['empleado']   = $this->DB->forShow($value['empleado']);
                    $aValues[$Id]['total']      = $this->DB->forShow($value['total']);
                }
            }

            return  $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllPedidosByLoja'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------
    function GetallDetallesPedidoByPedidoId($id)
    {
        try {
            $SQL = "SELECT pd.id, pd.coleccion_id, col.nombre_pt, pd.cantidad, pd.precio "
                . "FROM pedido_detalle pd "
                . "inner join colecciones as col "
                . "on col.id = pd.coleccion_id "
                . "WHERE pedido_id = $id;";
            $result = $this->DB->Select($SQL, 'all');


            if ($result != false) {

                foreach ($result as $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['coleccion_id'] = $this->DB->forShow($value['coleccion_id']);
                    $aValues[$Id]['nombre_pt']   = $this->DB->forShow($value['nombre_pt']);
                    $aValues[$Id]['nombre_pt1']   = $value['nombre_pt'];
                    $aValues[$Id]['cantidad']      = $this->DB->forShow($value['cantidad']);
                    $aValues[$Id]['precio']        = $this->DB->forShow($value['precio']);
                }
                return  $aValues;
            }

            return  $result;
        } catch (Exception $e) {
            $this->Errors['GetallDetallesPedidoByPedidoId'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------


    function GetComentariosArray($string)
    {
        // Eliminar etiquetas HTML
        $stringSinEtiquetas = str_replace('<li>', '', $string);
        // Dividir el string en un array utilizando como delimitador '</li>'
        $arrayItems = explode("</li>", $stringSinEtiquetas);
        // Eliminar el último elemento del array (vacío)
        array_pop($arrayItems);
        // Nuevo array para almacenar los resultados
        $nuevoArray = array();
        // Dividir cada elemento del array por ":"
        foreach ($arrayItems as $item) {
            // Dividir el elemento por ":"
            $partes = explode(":", $item);
            $partes[1] = nl2br(htmlentities(stripslashes($partes[1])));
            $partes[0] = nl2br(htmlentities(stripslashes($partes[0])));
            // Agregar las partes al nuevo array
            $nuevoArray[] = array_map('trim', $partes);
        }
        // Imprimir el nuevo array

        return $nuevoArray;
    }
    function buscarYEliminarItem(&$stCOMENTARIOS, $elemento)
    {
        foreach ($stCOMENTARIOS as $clave => $subarray) {
            // Verificar si el primer elemento del subarray coincide con el elemento buscado

            if ($subarray[0] === $elemento) {
                // Obtener la segunda parte del subarray
                $valor = $subarray[1];

                // Eliminar el elemento del array
                unset($stCOMENTARIOS[$clave]);

                // Devolver el valor encontrado
                return $valor;
            }
        }
        // Si no se encuentra el elemento, devolver null
        return null;
    }
    //------------testar---------------------------------------------

    /**
     * Deletes a pedido (order) from the database.
     *
     * @param int $valor The ID of the pedido to be deleted.
     * @return bool Returns TRUE if the pedido is successfully deleted, FALSE otherwise.
     */
    function Borrar($valor)
    {
        $this->clearPedidos();
        $this->id = (int) $valor;
        $this->findId($this->id);

        //actualizar stock
        $aValues = $this->GetallDetallesPedidoByPedidoId($this->id);
        $oStock = new clsStock();
        $oStock->Revert_By_Array_Pedido_detalle($aValues, $this->loja_id);

        if (!$this->DB->Remove("DELETE FROM pedidos WHERE id = $this->id;")) {
            $this->Errors['Borrar'] = 'Erro interno A348.';
            return FALSE;
        }

        if (!$this->Borrar_pedido_detalle()) {
            $this->Errors['Borrar'] = 'Erro interno B348.';
            return FALSE;
        }
        return TRUE;
    }
    //---------------------------------------------------------
    function Cancelar($valor)
    {
        $this->clearPedidos();
        $this->id = (int) $valor;

        if (!$this->findId($this->id)) {
            $this->Errors['Cancelar'] = 'Erro interno A349.';
            return FALSE;
        } else {
            //actualizar stock
            $aValues = $this->GetallDetallesPedidoByPedidoId($this->id);
            $oStock = new clsStock();
            if (!$oStock->Revert_By_Array_Pedido_detalle($aValues, $this->loja_id)) {
                $this->Errors['Cancelar'] = 'Erro interno A350.';
                return FALSE;
            }

            if (!$this->ModificarEstadoPedido($this->id, "C")) {
                $this->Errors['Cancelar'] = 'Erro interno A355.';
                return FALSE;
            }
        }

        return TRUE;
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
    function setLoja_Id($valor)
    {
        $this->loja_id = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Loja_id'] = 'Preencha o loja do pedido.';
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

    function setMesa_Id($valor)
    {
        $this->mesa_id = $this->DB->forSave($valor);
        if (empty($valor)) {
            $this->Errors['Mesa_id'] = 'Preencha o mesa do pedido.';
        }
    }

    function getMesa_Id()
    {
        return $this->DB->forShow($this->mesa_id);
    }

    function editMesa_Id()
    {
        return $this->DB->forEdit($this->mesa_id);
    }

    //---------------------------------------------------------   
    function setEstado($valor)
    {
        $this->estado = $this->DB->forSave($valor);
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
    function setEmpleado_Id($valor)
    {
        $this->empleado_id = $this->DB->forSave($valor);
    }

    function getEmpleado_Id()
    {
        return $this->DB->forShow($this->empleado_id);
    }

    function editEmpleado_Id()
    {
        return $this->DB->forEdit($this->empleado_id);
    }

    //---------------------------------------------------------   
    function setComentarios($valor)
    {
        $this->comentarios = $this->DB->forSave($valor);
    }

    function getComentarios()
    {
        return $this->DB->forShow($this->comentarios);
    }

    function editComentarios()
    {
        return $this->DB->forEdit($this->comentarios);
    }

    //---------------------------------------------------------    
    function setHora_Inicio($valor)
    {
        $this->hora_inicio = $this->DB->verifyDate($valor, 0, '', date('Y') + 1);
    }

    function getHora_Inicio()
    {
        return $this->DB->forShow($this->hora_inicio);
    }

    function editHora_Inicio()
    {
        return $this->DB->convertDate($this->hora_inicio);
    }
    //---------------------------------------------------------    
    function setHora_Fin($valor)
    {
        $this->hora_fin = $this->DB->verifyDate($valor, 0, '', date('Y') + 1);
    }

    function getHora_Fin()
    {
        return $this->hora_fin;
    }

    function editHora_Fin()
    {
        return $this->DB->convertDate($this->hora_fin);
    }
    //----------------------------------------------------------
    function getDetallePedido()
    {
        return $this->detalle_pedido;
    }

    //---------------------------------------------------------  
}
