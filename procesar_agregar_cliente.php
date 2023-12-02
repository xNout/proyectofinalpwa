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
    $idCliente = isset($_POST["id_cliente"]) ? $_POST["id_cliente"] : null;
    $identificacion = $_POST["identificacion"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];
    $telefonoCliente = $_POST["telefono_cliente"];

    // Validar y procesar los datos (puedes agregar más validaciones según sea necesario)

    $servername = "localhost:3307";
    $username = "root";
    $password = "admin";
    $dbname = "proyecto_finalpwa";
    
    // Conectar a la base de datos
    $conexion = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Verificar si el cliente ya existe en la base de datos
    $consultaExistencia = $conexion->prepare("SELECT id_cliente FROM clientes WHERE identificacion = ?");
    $consultaExistencia->bind_param("s", $identificacion);
    $consultaExistencia->execute();
    $consultaExistencia->store_result();

    if ($consultaExistencia->num_rows > 0) {
        // El cliente ya existe, realizar una actualización
        $consulta = $conexion->prepare("UPDATE clientes SET nombre = ?, correo = ?, direccion = ?, telefono_cliente = ? WHERE identificacion = ?");
        $consulta->bind_param("sssss", $nombre, $correo, $direccion, $telefonoCliente, $identificacion);
    } else {
        // El cliente no existe, realizar una inserción
        $consulta = $conexion->prepare("INSERT INTO clientes (identificacion, nombre, correo, direccion, telefono_cliente) VALUES (?, ?, ?, ?, ?)");
        $consulta->bind_param("sssss", $identificacion, $nombre, $correo, $direccion, $telefonoCliente);
    }

    // Ejecutar la consulta
    if ($consulta->execute()) {
        // Obtener el ID del cliente
        $idCliente = ($idCliente) ? $idCliente : $consulta->insert_id;

        // Cerrar la conexión y liberar recursos
        $consultaExistencia->close();
        $consulta->close();
        $conexion->close();

        header("Location: crear_cliente.php?id=$idCliente&exito=accion_realizada_con_exito");
        exit();
    } else {
        header("Location: crear_cliente.php?id=$idCliente&error=error_desconocido");
        exit();
    }
} else {
    // Si no se envió una solicitud POST, redirigir con un mensaje de error
    header("Location: crear_cliente.php?error=error_desconocido");
    exit();
}
?>
