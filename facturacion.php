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
    </style>
</head>
<body>

    <?php

        if (isset($_GET['exito']) && $_GET['exito'] === 'venta_procesada') {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Informacion',
                        text: 'Venta registrada con éxito'
                    });
                </script>";
        }
        
        if (isset($_GET['error']) && $_GET['error'] === 'carrito_vacio') {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'El carrito está vacío'
                    });
                </script>";
        }

        if (isset($_GET['error']) && $_GET['error'] === 'error_desconocido') {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al registrar la venta'
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

                    <!-- Seleccionar Cliente -->
                    <label for="clienteSelect">Seleccionar Cliente:</label>
                    <select id="clienteSelect" class="form-control">
                        <?php
                        // Conectar a la base de datos (reemplaza con tus propios datos de conexión)
                        $servername = "localhost:3307";
                        $username = "root";
                        $password = "admin";
                        $dbname = "proyecto_finalpwa";

                        $conexion = new mysqli($servername, $username, $password, $dbname);

                        // Verificar conexión
                        if ($conexion->connect_error) {
                            die("Conexión fallida: " . $conexion->connect_error);
                        }

                        // Consultar clientes desde la base de datos
                        $consultaClientes = $conexion->query("SELECT id_cliente, nombre FROM clientes");

                        // Verificar si hay resultados
                        if ($consultaClientes->num_rows > 0) {
                            while ($cliente = $consultaClientes->fetch_assoc()) {
                                echo "<option value='{$cliente['id_cliente']}'>{$cliente['nombre']}</option>";
                            }
                        } else {
                            echo "<option value=''>No hay clientes disponibles.</option>";
                        }

                        // Cerrar la conexión y liberar recursos
                        $consultaClientes->close();
                        $conexion->close();
                        ?>
                    </select>

                    <!-- Lista de productos -->
                    <h2>Productos Disponibles</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Conectar a la base de datos (reemplaza con tus propios datos de conexión)
                            $conexion = new mysqli($servername, $username, $password, $dbname);

                            // Verificar conexión
                            if ($conexion->connect_error) {
                                die("Conexión fallida: " . $conexion->connect_error);
                            }

                            // Consultar productos desde la base de datos
                            $consultaProductos = $conexion->query("SELECT id_producto, nombre, precio, cantidad FROM productos");

                            // Verificar si hay resultados
                            if ($consultaProductos->num_rows > 0) {
                                while ($producto = $consultaProductos->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$producto['nombre']}</td>";
                                    echo "<td>$ {$producto['precio']}</td>";
                                    echo "<td>{$producto['cantidad']}</td>";
                                    echo "<td><button class='btn btn-primary' onclick='agregarAlCarrito({$producto['id_producto']}, \"{$producto['nombre']}\", {$producto['precio']})'>Agregar al carrito</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No hay productos disponibles.</td></tr>";
                            }

                            // Cerrar la conexión y liberar recursos
                            $consultaProductos->close();
                            $conexion->close();
                            ?>
                        </tbody>
                    </table>

                    <!-- Carrito de compras -->
                    <div class="cart">
                        <h2>Carrito de compras</h2>
                        <table id="cart-table" class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se insertarán dinámicamente las filas de la tabla del carrito -->
                            </tbody>
                        </table>
                        <p>Total: <span id="cart-total">$0.00</span></p>
                        <button class="btn btn-success" onclick="facturar()">Facturar</button>
                    </div>

                    <form id="ventaForm" action="procesar_venta.php" method="post">
                        <!-- Campo oculto para enviar los datos del carrito -->
                        <input type="hidden" name="datosCarrito" id="datosCarritoInput">
                    </form>

                </div>



                </div>
                
            </div>
        </div>
        
    </div>

    <script>
    const productList = document.getElementById('product-list');
    let cart = [];
    let total = 0;

    function agregarAlCarrito(productoId, nombre, precio) {

        const producto = {
            id: productoId,
            name: nombre,
            price: precio,
            cantidad: 1
            // ... otros detalles del producto
        };

        // Agregar el producto al carrito
        const productoEnCarrito = cart.find(item => item.id === producto.id);
        if (productoEnCarrito) {
            // Si el producto ya está en el carrito, aumentar la cantidad en lugar de agregarlo nuevamente
            productoEnCarrito.cantidad++;
        } else {
            // Si es la primera vez que se agrega, inicializar la cantidad en 1
            cart.push({ ...producto, cantidad: 1 });
        }

        total += producto.price;

        // Actualizar el carrito en la página
        actualizarCarrito();
    }

    function eliminarDelCarrito(productoId) {
        // Buscar el índice del producto en el carrito
        const index = cart.findIndex(item => item.id === productoId);

        if (index !== -1) {
            // Restar el total y eliminar el producto del carrito
            total -= cart[index].price * cart[index].cantidad;
            cart.splice(index, 1);

            // Actualizar el carrito en la página
            actualizarCarrito();
        }
    }

    function actualizarCarrito() {
        const cartTable = document.getElementById('cart-table');
        const cartTotal = document.getElementById('cart-total');

        cartTable.innerHTML = '';
        cart.forEach(producto => {
            const row = cartTable.insertRow();

            const cellName = row.insertCell(0);
            cellName.innerHTML = producto.name;

            const cellCantidad = row.insertCell(1);
            cellCantidad.innerHTML = producto.cantidad;

            const cellPrecio = row.insertCell(2);
            cellPrecio.innerHTML = `$${(producto.price * producto.cantidad).toFixed(2)}`;

            const cellEliminar = row.insertCell(3);
            const deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-danger';
            deleteButton.innerText = 'Eliminar';
            deleteButton.onclick = () => eliminarDelCarrito(producto.id);

            cellEliminar.appendChild(deleteButton);
        });

        cartTotal.innerText = `$${total.toFixed(2)}`;
    }

    function confirmarFacturacion() {
        Swal.fire({
            title: '¿Estás seguro de facturar?',
            text: 'Se procesará la venta con los productos en el carrito.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, facturar'
        }).then((result) => {
            if (result.isConfirmed) {
                
                let datos = {
                    id_cliente: $("#clienteSelect").val(),
                    carrito: cart
                }
                // Actualiza el campo oculto del formulario con los datos del carrito
                document.getElementById('datosCarritoInput').value = JSON.stringify(datos);

                // Envía el formulario al servidor
                document.getElementById('ventaForm').submit();

                // Limpia el carrito después de la facturación
                cart = [];
                total = 0;
                actualizarCarrito();
            }
        });
    }

    function facturar() {
        // Validar que haya al menos un producto en el carrito
        if (cart.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No hay productos en el carrito. Agrega al menos un producto antes de facturar.'
            });
            return;
        }

        // Mostrar SweetAlert de confirmación antes de facturar
        confirmarFacturacion();
    }

</script>
</body>
</html>