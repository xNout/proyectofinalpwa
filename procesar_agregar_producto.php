<?php

session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_ID'])) {
    http_response_code(401);
    echo "Unauthorized - No tienes permiso para realizar esta acción.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];

    // Validar y procesar los datos (puedes agregar más validaciones según sea necesario)


    $servername = "localhost:3307";
    $username = "root";
    $password = "admin";
    $dbname = "proyecto_finalpwa";
    // Conectar a la base de datos (reemplaza con tus propios datos de conexión)
    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
    // Verificar si el producto ya existe en la base de datos
    $consultaExistencia = $conexion->prepare("SELECT id_producto FROM productos WHERE nombre = ?");
    $consultaExistencia->bind_param("s", $nombre);
    $consultaExistencia->execute();
    $consultaExistencia->store_result();

    if ($consultaExistencia->num_rows > 0) {
        // El producto ya existe, realizar una actualización
        $consulta = $conexion->prepare("UPDATE productos SET descripcion = ?, precio = ?, cantidad = ? WHERE nombre = ?");
        $consulta->bind_param("sdis", $descripcion, $precio, $cantidad, $nombre);
    } else {
        // El producto no existe, realizar una inserción
        $consulta = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)");
        $consulta->bind_param("ssdi", $nombre, $descripcion, $precio, $cantidad);
    }

    // Ejecutar la consulta
    if ($consulta->execute()) {

        $idProducto = $consulta->insert_id;

        // Cerrar la conexión y liberar recursos
        $consultaExistencia->close();
        $consulta->close();
        $conexion->close();

        header("Location: crear_producto.php?id=$idProducto&exito=accion_realizada_con_exito");
        exit();
    } else {
        header("Location: crear_producto.php?id=$idProducto&error=error_desconocido");
        exit();
    }
}
?>
