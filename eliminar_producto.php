<?php

$servername = "localhost:3307";
$username = "root";
$password = "admin";
$dbname = "proyecto_finalpwa";

// Verificar si se recibió el ID del producto a eliminar
if (isset($_POST['id_producto'])) {
    $idProducto = $_POST['id_producto'];

    // Crear la conexión
    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Consulta para eliminar el producto
    $consultaEliminar = "DELETE FROM productos WHERE id_producto = ?";

    // Preparar la consulta
    $stmt = $conexion->prepare($consultaEliminar);

    // Vincular el parámetro
    $stmt->bind_param("i", $idProducto);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // La eliminación fue exitosa
        $operacionExitosa = true;
    } else {
        // La eliminación falló
        $operacionExitosa = false;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conexion->close();

    // Redirigir a reporte_productos.php con el parámetro de éxito o error
    if ($operacionExitosa) {
        header('Location: reporte_productos.php?exito=accion_realizada_con_exito');
    } else {
        header('Location: reporte_productos.php?error=error_borrar_producto');
    }

    exit(); // Asegúrate de finalizar el script después de redirigir
} else {
    // Si no se proporcionó el ID del producto, redirigir con un mensaje de error
    header('Location: reporte_productos.php?error=desconocido');
    exit();
}
?>
