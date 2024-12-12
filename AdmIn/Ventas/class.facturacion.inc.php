<?php
require_once getLocal('COMMONS') . 'class.mysqli.inc.php';

class clsFacturas
{

    var $id             = 0;
    var $loja_id        = 0;
    var $mesa_id        = 0;
    var $total          = 0;
    var $fecha          = '';

    var $Errors = array();
    var $DB;

    function clsFacturas()
    {
        $this->clearFacturas();
        $this->DB = new clsMySqliDB();
    }
    //---------------------------------------------------------
    function clearFacturas()
    {
        $this->id = 0;
        $this->loja_id = 0;
        $this->mesa_id = 0;
        $this->total = 0;
        $this->fecha = date('Y-m-d H:i:s');

        $this->DB = new clsMySqliDB();
        $this->Errors = array();
    }
    //---------------------------------------------------------
    function Validate()
    {
        if (empty($this->Errors)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    //---------------------------------------------------------

    function Registrar($aPedidos, $mesa_id)
    {
        $this->clearFacturas();
        try {
            $total = 0;
            foreach ($aPedidos as $key => $pedido) {
                $total += $pedido['precio'] * $pedido['cantidad'];
            }

            $LojaId = $_SESSION['_admLojaId'];
            $fecha = date('Y-m-d H:i:s');
            $qInsert = "INSERT INTO facturas("
                . "loja_id, "
                . "mesa_id, "
                . "total, "
                . "fecha) "
                . "VALUES"
                . "($LojaId, "
                . "$mesa_id, "
                . "$total, "
                . "'$fecha');";

            $rInsert = $this->DB->Insert($qInsert);

            if (!$rInsert) {
                $this->Errors['Register'] = 'A ordem n&atilde;o pode ser registrado.';
                return FALSE;
            }
            $this->setId($rInsert);
            $resultado = $this->RegistrarFacturaDetalles($aPedidos, $this->id);
            return $resultado;
        } catch (Exception $e) {
            $this->Errors['Registrar fact'] = $e->getMessage();
            return false;
        }
    }
    //---------------------------------------------------------
    function RegistrarFacturaDetalles($aPedidos, $id_factura)
    {
        // Mostrar los resultados
        $values = ""; // Initialize the variable $values
        foreach ($aPedidos as $pedido) {
            $values = $values . "($id_factura,"
                . $pedido["coleccion_id"] . ","
                . $pedido["precio"] . ","
                . $pedido["cantidad"] . "),";
        }
        $values = substr($values, 0, -1); // Remove the last comma

        $SQL  = "INSERT INTO factura_detalle( "
            . " factura_id,"
            . " coleccion_id,"
            . " precio,"
            . " cantidad)"
            . " VALUES $values;";

        $rInsert = $this->DB->Insert($SQL);
        if (!$rInsert) {
            $this->Errors['RegistrarPedidoDetalles'] = 'A detalhe do ordem n&atilde;o pode ser registrado.';
            return FALSE;
        }

        return true;
    }
    /* ------------------------------------------------------------------------------ */

    function findId($valor)
    {
        $this->clearFacturas();
        $this->id = (int) $valor;

        try {
            if ($this->id <= 0) {
                $this->Errors['Id'] = 'Erro interno.';
                return FALSE;
            }
            $query = "SELECT * FROM facturas WHERE id = $this->id;";
            $result = $this->DB->Select($query);

            if (!$result) {
                $this->Errors['Id'] = 'A ordem n&atilde;o existe.';
                return FALSE;
            }
            $this->id       = $result['id'];
            $this->loja_id  = $result['loja_id'];
            $this->mesa_id  = $result['mesa_id'];
            $this->total    = $result['total'];
            $this->fecha    = $result['fecha'];
           
            return TRUE;
        } catch (Exception $e) {
            $this->Errors['findId'] = $e->getMessage();
            return FALSE;
        }
    }
   
    //-------------------------------------------------------------------
    function GetAllFacturasByLoja($loja_id)
    {
        $this->clearFacturas();
        try {
            $query = "SELECT "
                . "f.id, "
                . "m.identificador, "
                . "f.total, "
                . "f.fecha "
                . "FROM "
                . "facturas AS f "
                . "INNER JOIN mesas AS m "
                . "ON "
                . "m.id = f.mesa_id "
                . "WHERE "
                . "f.loja_id = $loja_id "
                . "ORDER BY "
                . "f.fecha DESC";

            $result = $this->DB->Select($query, 'all');

            if (!$result) {
                $this->Errors['GetAllFacturasByLoja'] = 'n&atilde;o existem fact.';
                return false;
            }
            if ($result != false) {
                foreach ($result as $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['mesa']       = $this->DB->forShow($value['identificador']);
                    $aValues[$Id]['total']     = $this->DB->forShow($value['total']);
                    $aValues[$Id]['fecha'] = $this->DB->forShow($value['fecha']);
                }
            }

            return  $aValues;
        } catch (Exception $e) {
            $this->Errors['GetAllFacturasByLoja'] = $e->getMessage();
            return false;
        }
    }
    //-------------------------------------------------------
    function GetReportXmeses($loja_id, $meses = 12)
    {
        $this->clearfacturas();

        $SQL = "SELECT "
            . " YEAR(fecha) AS ano,"
            . " MONTH(fecha) AS mes,"
            . " SUM(total) AS total_facturado"
            . " FROM"
            . " facturas"
            . " WHERE"
            . " loja_id = $loja_id AND"
            . " fecha >= DATE_SUB("
            . " CURRENT_DATE,"
            . " INTERVAL $meses MONTH"
            . " )"
            . " GROUP BY"
            . " YEAR(fecha),"
            . " MONTH(fecha)"
            . " ORDER BY"
            . " ano ASC,"
            . " mes ASC;";

        $result = $this->DB->Select($SQL, 'all');
        if ($result != false) {
            foreach ($result as $value) {
                //$aValuesMes[] = date('F', mktime(0, 0, 0, $value['mes'], 1));
                $aValuesMes[] = date('M', mktime(0, 0, 0, $value['mes'], 1));
                $aValuesTotal[] = $this->DB->forShow($value['total_facturado']);
            }
            $aValues['mes'] = $aValuesMes;
            $aValues['total'] = $aValuesTotal;

            return  $aValues;
        }
    }
    //---------------------------------------------------------
    function GetVentasMes($loja_id)
    {

        //importe total de las ventas el mes en curso
        $SQL = "SELECT SUM(total) AS total_ventas_mes
        FROM facturas
        WHERE loja_id = $loja_id AND
        YEAR(fecha) = YEAR(CURDATE())
        AND MONTH(fecha) = MONTH(CURDATE());";
        $rTotalVentasMes = $this->DB->Select($SQL);
        if ($rTotalVentasMes) {
            return $rTotalVentasMes['total_ventas_mes'];
        } else {
            return 0;
        }
    }
    //---------------------------------------------------------
    function GetVentasCantidadMes($loja_id)
    {

        //importe total de las ventas el mes en curso
        $SQL = "SELECT COUNT(id) AS total_ventas_mes
        FROM facturas
        WHERE loja_id = $loja_id AND
        YEAR(fecha) = YEAR(CURDATE())
        AND MONTH(fecha) = MONTH(CURDATE());";
        $rTotalVentasMes = $this->DB->Select($SQL);
        if ($rTotalVentasMes) {
            return $rTotalVentasMes['total_ventas_mes'];
        } else {
            return 0;
        }
    }
    //---------------------------------------------------------
    //sacar promedio de dinero generado por ventas de bebidas y venta de comida en el mes en curso
    function GetPromedioVentasMes($loja_id)
    {

        //importe total de las ventas el mes en curso
        $SQL = "SELECT SUM(total) AS total_ventas_mes
        FROM facturas
        WHERE loja_id = $loja_id AND
        YEAR(fecha) = YEAR(CURDATE())
        AND MONTH(fecha) = MONTH(CURDATE());";
        $rTotalVentasMes = $this->DB->Select($SQL);
        if ($rTotalVentasMes) {
            $totalVentasMes = $rTotalVentasMes['total_ventas_mes'];
        } else {
            $totalVentasMes = 0;
        }

        //importe total de las ventas de bebidas el mes en curso
        $SQL = "SELECT SUM(fd.precio * fd.cantidad) AS total_ventas_bebidas_mes
        FROM factura_detalle fd
        INNER JOIN facturas f
        ON f.id = fd.factura_id
        WHERE f.loja_id = $loja_id AND
        YEAR(f.fecha) = YEAR(CURDATE())
        AND MONTH(f.fecha) = MONTH(CURDATE())
        AND fd.coleccion_id IN 
        (SELECT c.id
        FROM colecciones c
        INNER JOIN catalogos ca ON
        ca.id = c.catalogo_id
        WHERE
        ca.template = 2 AND ca.loja_id = $loja_id);";
        $rTotalVentasBebidasMes = $this->DB->Select($SQL);
        if ($rTotalVentasBebidasMes) {
            $totalVentasBebidasMes = $rTotalVentasBebidasMes['total_ventas_bebidas_mes'];
        } else {
            $totalVentasBebidasMes = 0;
        }

        //importe total de las ventas de comida el mes en curso
        $SQL = "SELECT SUM(fd.precio * fd.cantidad) AS total_ventas_comida_mes
        FROM factura_detalle fd
        INNER JOIN facturas f
        ON f.id = fd.factura_id
        WHERE f.loja_id = $loja_id AND
        YEAR(f.fecha) = YEAR(CURDATE())
        AND MONTH(f.fecha) = MONTH(CURDATE())
        AND fd.coleccion_id IN 
        (SELECT c.id
        FROM colecciones c
        INNER JOIN catalogos ca ON
        ca.id = c.catalogo_id
        WHERE
        ca.template = 1 AND ca.loja_id = $loja_id);";
        $rTotalVentasComidaMes = $this->DB->Select($SQL);
        if ($rTotalVentasComidaMes) {
            $totalVentasComidaMes = $rTotalVentasComidaMes['total_ventas_comida_mes'];
        } else {
            $totalVentasComidaMes = 0;
        }

        $aValues['total_ventas_mes'] = $totalVentasMes;
        $aValues['total_ventas_bebidas_mes'] = $totalVentasBebidasMes;
        $aValues['total_ventas_comida_mes'] = $totalVentasComidaMes;
        
        return $aValues;
    }
    //---------------------------------------------------------
    //top 12 prodductos mas vendidos del mes en curso
    function GetTop7ProductosMasVendidos($loja_id, $meses = 1)
{
    if ($meses == 1) {
        $SQL = "SELECT c.nombre_pt AS nombre, SUM(fd.cantidad) AS cantidad
        FROM factura_detalle fd
        INNER JOIN facturas f ON f.id = fd.factura_id
        INNER JOIN colecciones c ON c.id = fd.coleccion_id
        WHERE f.loja_id = $loja_id AND
        YEAR(f.fecha) = YEAR(CURDATE()) AND
        MONTH(f.fecha) = MONTH(CURDATE())
        GROUP BY c.nombre_pt
        ORDER BY cantidad DESC
        LIMIT 7;";
    } else {
        $SQL = "SELECT c.nombre_pt AS nombre, SUM(fd.cantidad) AS cantidad
        FROM factura_detalle fd
        INNER JOIN facturas f ON f.id = fd.factura_id
        INNER JOIN colecciones c ON c.id = fd.coleccion_id
        WHERE f.loja_id = $loja_id AND
        f.fecha >= DATE_SUB(CURDATE(), INTERVAL $meses MONTH)
        GROUP BY c.nombre_pt
        ORDER BY cantidad DESC
        LIMIT 7;";
    }

    $result = $this->DB->Select($SQL, 'all');
    if ($result != false) {
        foreach ($result as $value) {
            $NValues[] = $value['nombre'];
            $CValues[] = $value['cantidad'];
        }
        $aValues['nombre'] = $NValues;
        $aValues['cantidad'] = $CValues;
        return $aValues;
    }
}


    //---------------------------------------------------------
    function GetallDetallesFacturaByFacturaId($id)
    {
        try {
           $SQL = "SELECT "
                . " fd.id,"
                . " fd.coleccion_id,"
                . " col.nombre_pt,"
                . " fd.cantidad,"
                . " fd.precio"
                . " FROM factura_detalle fd"
                . " INNER JOIN colecciones as col"
                . " ON col.id = fd.coleccion_id"
                . " WHERE fd.factura_id = $id;";

            $result = $this->DB->Select($SQL, 'all');
            if ($result != false) {
                foreach ($result as $value) {
                    $Id = $value['id'];
                    $aValues[$Id]['coleccion_id'] = $this->DB->forShow($value['coleccion_id']);
                    $aValues[$Id]['nombre_pt']    = $this->DB->forShow($value['nombre_pt']);
                    $aValues[$Id]['nombre_pt1']   = $value['nombre_pt'];
                    $aValues[$Id]['cantidad']     = $this->DB->forShow($value['cantidad']);
                    $aValues[$Id]['precio']       = $this->DB->forShow($value['precio']);
                }
                
                return  $aValues;
            }

            return  $result;
        } catch (Exception $e) {
            $this->Errors['GetallDetallesFacturaByFacturaId'] = $e->getMessage();
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
    //---------------------------------------------------------
    function getMesa_Id()
    {
        return $this->DB->forShow($this->mesa_id);
    }

    function editMesa_Id()
    {
        return $this->DB->forEdit($this->mesa_id);
    }




    //---------------------------------------------------------    
    function setFecha($valor)
    {
        $this->fecha = $this->DB->verifyDate($valor, 0, '', date('Y') + 1);
    }

    function getFecha()
    {
        return $this->DB->forShow($this->fecha);
    }

    function editFecha()
    {
        return $this->DB->convertDate($this->fecha);
    }



    //---------------------------------------------------------  
}
