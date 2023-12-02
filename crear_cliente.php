<?php
// Verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['usuario_ID'])) {
    header("Location: login.php?error=no_sesion_iniciada");
    exit();
}

// Variables para almacenar los datos del producto (inicialmente vacías)
$idProducto = $nombre = $descripcion = $precio = $cantidad = "";

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

        if (isset($_GET['error']) && $_GET['error'] === 'error_desconocido') {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al registrar el cliente'
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


                    <form action="procesar_agregar_cliente.php" method="post" class="pure-form pure-form-stacked">
                        <?php
                        // Verificar si se está editando un cliente
                        $modoEdicion = false;
                        $idCliente = null;
                        $identificacion = '';
                        $nombre = '';
                        $correo = '';
                        $direccion = '';
                        $telefonoCliente = '';

                        $servername = "localhost:3307";
                        $username = "root";
                        $password = "admin";
                        $dbname = "proyecto_finalpwa";

                        $modoEdicion = false;

                        if (isset($_GET['id'])) {
                            
                            $modoEdicion = true;
                            $idCliente = $_GET['id'];

                            // Crear la conexión
                            $conexion = new mysqli($servername, $username, $password, $dbname);

                            // Verificar la conexión
                            if ($conexion->connect_error) {
                                die("Error de conexión: " . $conexion->connect_error);
                            }

                            // Consulta para obtener los datos del cliente por su ID
                            $consultaCliente = "SELECT * FROM clientes WHERE id_cliente = ? limit 1;";
                            
                            // Preparar la consulta
                            $stmt = $conexion->prepare($consultaCliente);

                            // Vincular el parámetro
                            $stmt->bind_param("i", $idCliente);

                            // Ejecutar la consulta
                            $stmt->execute();

                            // Obtener los resultados
                            $resultado = $stmt->get_result();

                            // Verificar si se obtuvieron resultados
                            if ($resultado->num_rows > 0) {
                                // Obtener los datos del cliente
                                $cliente = $resultado->fetch_assoc();

                                // Aquí puedes utilizar los datos del cliente como necesites
                                $identificacion = $cliente['identificacion'];
                                $nombre = $cliente['nombre'];
                                $correo = $cliente['correo'];
                                $direccion = $cliente['direccion'];
                                $telefonoCliente = $cliente['telefono_cliente'];


                            }

                            // Cerrar la conexión y liberar recursos
                            $stmt->close();
                            $conexion->close();
                        }
                        ?>

                        <input type="hidden" name="id_cliente" value="<?php echo $idCliente; ?>">

                        <fieldset>
                            <label for="identificacion">Identificación:</label>
                            <input type="text" id="identificacion" name="identificacion" class="pure-input-1" value="<?php echo $identificacion; ?>" required>

                            <label for="nombre">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="pure-input-1" value="<?php echo $nombre; ?>" required>

                            <label for="correo">Correo electrónico:</label>
                            <input type="email" id="correo" name="correo" class="pure-input-1" value="<?php echo $correo; ?>">

                            <label for="direccion">Dirección:</label>
                            <input type="text" id="direccion" name="direccion" class="pure-input-1" value="<?php echo $direccion; ?>">

                            <label for="telefono_cliente">Teléfono:</label>
                            <input type="tel" id="telefono_cliente" name="telefono_cliente" class="pure-input-1" value="<?php echo $telefonoCliente; ?>">

                            <button type="submit" class="btn btn-primary"><?php echo ($modoEdicion ? 'Actualizar' : 'Agregar'); ?> Cliente</button>
                        </fieldset>
                    </form>

                </div>
                
            </div>
        </div>
        
    </div>

    <script>
        $(document).ready(function () {
            // Obtener datos del producto desde PHP (pasados como variables de PHP)
            var idProducto = "<?php echo $idProducto; ?>";
            var nombre = "<?php echo $nombre; ?>";
            var descripcion = "<?php echo $descripcion; ?>";
            var precio = "<?php echo $precio; ?>";
            var cantidad = "<?php echo $cantidad; ?>";

            // Setear los valores en el formulario
            $('#idProducto').val(idProducto);
            $('#nombre').val(nombre);
            $('#descripcion').val(descripcion);
            $('#precio').val(precio);
            $('#cantidad').val(cantidad);

            if(idProducto && idProducto !== "")
            {
                $("#add_btnprd").val("Editar Producto");
            }
        });
    </script>
</body>
</html>