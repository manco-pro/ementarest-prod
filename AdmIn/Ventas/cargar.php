<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ementarest";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir la fecha de inicio y fin
$fecha_inicio = '2023-06-01';
$fecha_fin = '2024-07-01';

// Inicializar la fecha con la fecha de inicio
$fecha = $fecha_inicio;

// Bucle para insertar registros en la tabla
while ($fecha < $fecha_fin) {
    $loja_id = 4;
    $mesa_id = rand(230, 236);
    $total = rand(2, 200);
    
    // Formatear la fecha para que sea compatible con MySQL
    $fecha_formateada = date('Y-m-d', strtotime($fecha));
    
    // Query de inserción
    $sql = "INSERT INTO facturas (loja_id, mesa_id, total, fecha) VALUES ('$loja_id', '$mesa_id', '$total', '$fecha_formateada')";
    
    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Registro insertado correctamente para la fecha: $fecha_formateada<br>";
    } else {
        echo "Error al insertar registro: " . $conn->error;
    }
    
    // Incrementar la fecha en un mes
    $fecha = date('Y-m-d', strtotime('+1 month', strtotime($fecha)));
}

// Cerrar la conexión
$conn->close();
?>
