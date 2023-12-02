<?php
// Configuración de la conexión a la base de datos (reemplaza con tus propios datos)
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para verificar el usuario y la contraseña
    $sql = "SELECT ID, Usuario, Contraseña, Rol_ID, Nombre FROM Usuarios WHERE Usuario='$usuario' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($contrasena == $row['Contraseña']) {

            session_start();
            // Iniciar sesión y redirigir al usuario
            $_SESSION['usuario_ID'] = $row['ID'];
            $_SESSION['rol_ID'] = $row['Rol_ID'];
            $_SESSION['nombre_usuario'] = $row['Nombre'];

            header("Location: index.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}



// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Agrega enlaces a Bootstrap y tus estilos de CSS aquí -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Agrega tus estilos personalizados aquí si es necesario -->
    <style>
        body {
            background-color: #f8f9fa;
            padding: 50px;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #dcdcdc;
            border-radius: 5px;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
        }
        input {
            margin-bottom: 20px;
        }
    </style>

</head>
<body>
<div class="container mt-5">
        <h2>Login</h2>
        <?php

        if (isset($_GET['error']) && $_GET['error'] === 'no_sesion_iniciada') {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Debes iniciar sesión primero.'
                    });
                </script>";
        }

        if (isset($_GET['exito']) && $_GET['exito'] === 'cierre_sesion_exitoso') {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Informacion',
                        text: 'Has cerrado sesión'
                    });
                 </script>";
        }

        if (isset($error)) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '$error',
                        showConfirmButton: false,
                        timer: 3000
                    });
                  </script>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" class="form-control" name="contrasena" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
