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


// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el rol del usuario desde la sesión
$rolUsuario = $_SESSION['rol_ID'];

// Cerrar la conexión a la base de datos
$conn->close();
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
    <script src="js/jquery.js"></script>
    <script src="js/sbmenu.js"></script>
</head>
<body>


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

                    <div class="pure-g">
                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="card">
                                <div class="card-header">
                                    Total de Clientes
                                </div>
                                <div class="card-body">

                                    <?php
                                    // Conexión a la base de datos (reemplaza con tus propios datos de conexión)
                                    $conexion = new mysqli($servername, $username, $password, $dbname);
            
                                    // Verificar conexión
                                    if ($conexion->connect_error) {
                                        die("Conexión fallida: " . $conexion->connect_error);
                                    }
            
                                    // Consulta SQL para obtener el total de clientes
                                    $consultaClientes = "SELECT COUNT(*) AS total FROM clientes";
                                    $resultadoClientes = $conexion->query($consultaClientes);
            
                                    // Verificar si la consulta fue exitosa
                                    if ($resultadoClientes) {
                                        $filaClientes = $resultadoClientes->fetch_assoc();
                                        $totalClientes = $filaClientes['total'];
                                        echo "<h1 class='card-title'>$totalClientes</h1>";
                                    } else {
                                        echo "Error en la consulta: " . $conexion->error;
                                    }
            
                                    // Cerrar la conexión
                                    $conexion->close();
                                ?>
                                </div>
                            </div>
                        </div>

                        <div class="pure-u-1 pure-u-md-1-2">
                            <div class="card">
                                <div class="card-header">
                                    Total de Ventas Hoy
                                </div>
                                <div class="card-body">
                                <?php
                                        // Conexión a la base de datos (reemplaza con tus propios datos de conexión)
                                        $conexion = new mysqli($servername, $username, $password, $dbname);
                
                                        // Verificar conexión
                                        if ($conexion->connect_error) {
                                            die("Conexión fallida: " . $conexion->connect_error);
                                        }
                
                                        // Consulta SQL para obtener el total de ventas hoy
                                        $consultaVentasHoy = "SELECT COUNT(*) AS total FROM ventas WHERE DATE(fecha_venta) = CURDATE()";
                                        $resultadoVentasHoy = $conexion->query($consultaVentasHoy);
                
                                        // Verificar si la consulta fue exitosa
                                        if ($resultadoVentasHoy) {
                                            $filaVentasHoy = $resultadoVentasHoy->fetch_assoc();
                                            $totalVentasHoy = $filaVentasHoy['total'];
                                            echo "<h1 class='card-title'>$totalVentasHoy</h1>";
                                        } else {
                                            echo "Error en la consulta: " . $conexion->error;
                                        }
                
                                        // Cerrar la conexión
                                        $conexion->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

    
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
</body>
</html>