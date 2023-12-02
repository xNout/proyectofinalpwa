<?php
// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['usuario_ID'])) {
    header("Location: login.php?error=no_sesion_iniciada");
    exit();
}

$servername = "localhost:3307";
$username = "root";
$password = "admin";
$dbname = "proyecto_finalpwa";

// Obtener el rol del usuario desde la sesión
$rolUsuario = $_SESSION['rol_ID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/purecss/pure.min.css">
    <link rel="stylesheet" href="css/purecss/grid/base.min.css">
    <link rel="stylesheet" href="css/purecss/grid/grids.min.css">
    <link rel="stylesheet" href="css/purecss/grid/grids.responsive.css">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/container.css">
    <link rel="stylesheet" href="css/layout.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet"> 
    <script src="https://kit.fontawesome.com/0b2df8ce61.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/jquery.js"></script>
    <script src="js/sbmenu.js"></script>

    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

    </style>
</head>
<body>

    <?php

    if (isset($_GET['exito']) && $_GET['exito'] === 'accion_realizada_con_exito') {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Informacion',
                    text: 'Acción realizada con éxito'
                });
            </script>";
    }

    if (isset($_GET['error']) && $_GET['error'] === 'error_borrar_cliente') {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al eliminar el cliente'
                });
            </script>";
    }

    if (isset($_GET['error']) && $_GET['error'] === 'desconocido') {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error desconocido'
                });
            </script>";
    }
    ?>

    <div class="pure-g contenedor">

        <div class="nav pure-u-1">

            <div class="pure-u-4-24 pure-u-sm-2-24 pure-u-md-2-24 pure-u-lg-1-24 submenu">
                <i class="fas fa-bars" id="sbmenu_btn"></i>
            </div>

            <div class="pure-u-10-24 pure-u-sm-5-24 pure-u-md-5-24 pure-u-lg-3-24 user_options">
                
                <span>Hola, <?php echo $_SESSION['nombre_usuario']; ?></span>
                <a href="#"><i class="fas fa-sign-out-alt"></i></a>
                
            </div>
        </div>

        <div class="main pure-u-1">

            <div class="submenu pure-u-5-12 pure-u-sm-1-4 pure-u-md-1-4 pure-u-lg-1-6" id="submenu" style="display: none">

            <div class="items pure-u-24-24">

<a class="item pure-u-1" href="#">
    <div class="icono_sbmenu pure-u-3-24">
        <i class="fas fa-columns"></i>
    </div>
    <div class="descp pure-u-16-24">
        Dashboard
    </div>

</a>

<div class="item pure-u-1 item_sb" href="#">
    <div class="icono_sbmenu pure-u-3-24">
        <i class="fas fa-users"></i>
    </div>
    <div class="descp pure-u-16-24">
        Ventas
    </div>
    <div class="subitems_menu pure-u-24-24" style="display: none">
        <a class="sbitem_menu" href="facturacion.php">
            <i class="fas fa-caret-right"></i> Facturar
        </a>
        <a class="sbitem_menu" href="reporte_ventas.php">
            <i class="fas fa-caret-right"></i> Ver reporte
        </a>
    </div>
</div>

<div class="item pure-u-1 item_sb">
    <div class="icono_sbmenu pure-u-3-24">
        <i class="fas fa-users"></i>
    </div>
    <div class="descp pure-u-16-24">
        Clientes
    </div>
    <div class="subitems_menu pure-u-24-24" style="display: none">
        <a class="sbitem_menu" href="crear_cliente.php">
            <i class="fas fa-caret-right"></i> Añadir
        </a>
        <a class="sbitem_menu" href="reporte_clientes.php">
            <i class="fas fa-caret-right"></i> Ver Listado
        </a>
    </div>
</div>

<div class="item pure-u-1 item_sb">
    <div class="icono_sbmenu pure-u-3-24">
        <i class="fas fa-truck"></i>
    </div>
    <div class="descp pure-u-16-24">
        Productos
    </div>
    <div class="subitems_menu pure-u-24-24" style="display: none">
        <a class="sbitem_menu" href="crear_producto.php">
            <i class="fas fa-caret-right"></i> Añadir
        </a>
        <a class="sbitem_menu" href="reporte_productos.php">
            <i class="fas fa-caret-right"></i> Ver Listado
        </a>
    </div>
</div>

</div>
            </div>

            <div class="bodycontent pure-u-1 pure-u-sm-18-24 pure-u-md-18-24 pure-u-lg-20-24" id="bdysbncontent">
                <div class="container">

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>ID Venta</th>
                            <th>Identificación Cliente</th>
                            <th>Nombre Cliente</th>
                            <th>Fecha de Venta</th>
                            <th>Total Venta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $servername = "localhost:3307";
                        $username = "root";
                        $password = "admin";
                        $dbname = "proyecto_finalpwa";

                        // Crear la conexión
                        $conexion = new mysqli($servername, $username, $password, $dbname);

                        // Verificar la conexión
                        if ($conexion->connect_error) {
                            die("Conexión fallida: " . $conexion->connect_error);
                        }

                        // Consulta para obtener el reporte de ventas
                        $consultaVentas = "SELECT v.id_venta, c.identificacion, c.nombre AS nombre_cliente, v.fecha_venta, v.total_venta
                                        FROM ventas v
                                        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
                                        ORDER BY v.fecha_venta DESC";

                        $resultadoVentas = $conexion->query($consultaVentas);
                        
                        if ($resultadoVentas->num_rows > 0) {
                            while ($venta = $resultadoVentas->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$venta['id_venta']}</td>";
                                echo "<td>{$venta['identificacion']}</td>";
                                echo "<td>{$venta['nombre_cliente']}</td>";
                                echo "<td>{$venta['fecha_venta']}</td>";
                                echo "<td>{$venta['total_venta']}</td>";
                                echo "<td><a class='btn btn-primary' href='ver_detalles_venta.php?id={$venta['id_venta']}'>Ver Detalles</a></td>";
                                echo "</tr>";
                            }
                        }
                        else {
                            echo "<tr><td colspan='6'>No hay ventas disponibles.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                </div>
                
            </div>
        </div>
        
    </div>

    <script>
        function confirmarEliminacion(idCliente) {
            return Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                
                if (result.isConfirmed) {
                    // Crear un formulario dinámicamente
                    const form = document.createElement('form');
                    form.method = 'post';
                    form.action = 'eliminar_cliente.php';

                    // Crear un campo oculto para enviar el ID del cliente
                    const inputIdCliente = document.createElement('input');
                    inputIdCliente.type = 'hidden';
                    inputIdCliente.name = 'id_cliente';
                    inputIdCliente.value = idCliente;

                    // Adjuntar el campo oculto al formulario
                    form.appendChild(inputIdCliente);

                    // Adjuntar el formulario al cuerpo del documento y enviarlo
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
