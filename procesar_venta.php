<?php
// Verificar si se reciben los datos del carrito
if (isset($_POST['datosCarrito'])) {
    // Obtener y decodificar los datos del carrito
    $datosCarrito = json_decode($_POST['datosCarrito'], true);

    $servername = "localhost:3307";
    $username = "root";
    $password = "admin";
    $dbname = "proyecto_finalpwa";
    
    // Validar que hay al menos un producto en el carrito
    if (count($datosCarrito['carrito']) > 0) {
        // Realizar las operaciones necesarias en la base de datos
        $idCliente = $datosCarrito['id_cliente'];
        $fechaVenta = date('Y-m-d H:i:s');
        $totalVenta = 0; // Inicializar el total de la venta

        // Insertar la venta en la tabla 'ventas'
        $conexion = new mysqli($servername, $username, $password, $dbname);
        $consultaVenta = $conexion->prepare("INSERT INTO ventas (id_cliente, fecha_venta, total_venta) VALUES (?, ?, ?)");
        $consultaVenta->bind_param("iss", $idCliente, $fechaVenta, $totalVenta);
        $consultaVenta->execute();
        $idVenta = $conexion->insert_id; // Obtener el ID de la venta recién insertada
        $consultaVenta->close();

        // Recorrer los productos del carrito y registrar en 'detalle_venta'
        foreach ($datosCarrito['carrito'] as $producto) {
            $idProducto = $producto['id'];
            $cantidad = $producto['cantidad'];
            $precioUnitario = $producto['price'];
            $totalProducto = $cantidad * $precioUnitario;

            // Insertar el detalle de la venta en 'detalle_venta'
            $consultaDetalle = $conexion->prepare("INSERT INTO detalle_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
            $consultaDetalle->bind_param("iiidd", $idVenta, $idProducto, $cantidad, $precioUnitario, $totalProducto);
            $consultaDetalle->execute();
            $consultaDetalle->close();

            // Actualizar el total de la venta
            $totalVenta += $totalProducto;
        }

        // Actualizar el total de la venta en la tabla 'ventas'
        $consultaActualizarTotal = $conexion->prepare("UPDATE ventas SET total_venta = ? WHERE id_venta = ?");
        $consultaActualizarTotal->bind_param("di", $totalVenta, $idVenta);
        $consultaActualizarTotal->execute();
        $consultaActualizarTotal->close();

        // Cerrar la conexión
        $conexion->close();

        // Redireccionar a la página de facturación con mensaje de éxito
        header("Location: facturacion.php?exito=venta_procesada");
        exit();
    } else {
        // Redireccionar a la página de facturación con mensaje de error (carrito vacío)
        header("Location: facturacion.php?error=carrito_vacio");
        exit();
    }

} else {
    header("Location: facturacion.php?error=error_desconocido");
    exit();
}
?>
