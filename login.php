<?php
require("errores.php");
require("funciones.php")
?>
<?php
$mensajesesion = '';

// Sesiones
session_start();

// Conexión con la BBDD-------
$conexion = conectarBBDD();
//-----------------------------


// Tratar formulario login
if (isset($_REQUEST['enviar'])) {
    $usuario = $_REQUEST['usuario'];
    $clave = $_REQUEST['clave'];
  
    if ($usuario == "admin" && $clave == "soltel") {
        $_SESSION['usuario'] = $usuario;
        header("Location: empleados.php");
        exit();
    } else {
        $mensajesesion = "Usuario o contraseña incorrectos <i class='fa-solid fa-circle-xmark fa-lg' style='color: #e01b24;'></i>";
    }
  }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
    <title>Login</title>
    <link rel="stylesheet" href="css/soloLogin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
    <body>
    <!-- Barra de Navegación -->
    <nav class="navbar bg-body-tertiary">
        <section class="container-fluid">
        <h2 hidden>Barra Navegación</h2>
            <!-- Logo y Nombre del Concesionario -->
            <a class="navbar-brand" href="index.php">
                <img src="https://logodownload.org/wp-content/uploads/2014/05/hyundai-logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Hyundauto Motor Concesionario Sevilla
            </a>
            
            <a class="btn btn-primary" href="index.php">Atras</a>
        </section>
    </nav>
        <section class="login-container">
            <h2>Iniciar Sesión</h2>
            <?php if (isset($mensaje_error)) : ?>
                <p style="color: red;"><?php echo $mensaje_error; ?></p>
            <?php endif; ?>
            <form action="#" method="post" class="form">

                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control">

                <label for="clave" class="form-label">Contraseña</label>
                <input type="password" name="clave" id="clave" class="form-control">

                <input type="submit" value="Iniciar Sesion" class="btn btn-primary mt-4 form-control" name="enviar">

                    <!-- mensaje de Inicio de sesion Incorrecto -->
                    <p class="text-center"><?php echo $mensajesesion; ?></p>
                     <!-- -------------------------------------- -->
            </form>
        </section>
    </body>
</html>
