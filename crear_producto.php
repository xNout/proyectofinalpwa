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



// Verificar si se proporciona un parámetro 'id' en la URL
if (isset($_GET['id'])) {
    // Se proporcionó un ID, intentar recuperar los datos del producto
    $idProducto = $_GET['id'];
    $conexion = new mysqli($servername, $username, $password, $dbname);
    // Verificar conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Consultar datos del producto por ID
    $consulta = $conexion->prepare("SELECT nombre, descripcion, precio, cantidad FROM productos WHERE id_producto = ?");
    $consulta->bind_param("i", $idProducto);
    $consulta->execute();
    $consulta->bind_result($nombre, $descripcion, $precio, $cantidad);

    // Verificar si se encontraron datos
    if ($consulta->fetch()) {
        // Datos del producto encontrados
    } else {
        // Producto no encontrado, manejar de acuerdo a tus necesidades (redireccionar, mostrar mensaje, etc.)
        echo "Producto no encontrado.";
        exit();
    }

    // Cerrar la consulta
    $consulta->close();
    // Cerrar la conexión
    $conexion->close();
}

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

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .pure-form input[type="text"],
        .pure-form input[type="number"],
        .pure-form input[type="submit"] {
            width: 100%;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .pure-form input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .pure-form input[type="submit"]:hover {
            background-color: #0056b3;
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
                        text: 'Ocurrió un error al registrar el producto'
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


                <form class="pure-form pure-form-stacked" action="procesar_agregar_producto.php" method="POST">
                    <label for="nombre">Nombre del Producto:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" rows="2" style="width:100%"></textarea>

                    <label for="precio">Precio:</label>
                    <input type="number" id="precio" name="precio" step="0.01" required>

                    <label for="cantidad">Cantidad en Inventario:</label>
                    <input type="number" id="cantidad" name="cantidad" required>

                    <input type="submit" id="add_btnprd" value="Agregar Producto">
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