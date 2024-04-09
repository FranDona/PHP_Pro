<?php
require("errores.php");
require("funciones.php")
?>

<?php
// Sesiones------
session_start();
//----------------

// Conexión con la BBDD-------
$conexion = conectarBBDD();
//-----------------------------


//Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
//------------------------


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
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Zona Clientes</title>
  <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="css/restoPaginas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

  <!-- Barra de Navegación -->
  <nav class="navbar bg-body-tertiary">
      <section class="row container-fluid">
      <h2 hidden>Barra Navegación</h2>
        <!-- Logo y Nombre del Concesionario -->
        <article class="col-4">
        <h2 hidden>Hyundauto</h2>
            <a class="navbar-brand" href="index.php">
                <img src="https://logodownload.org/wp-content/uploads/2014/05/hyundai-logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Hyundauto Motor Concesionario Sevilla
            </a>
        </article>  


        <!-- Inicio de sesion Empleados -->
        <article class="col-4">
        <h2 hidden>Inicio sesion</h2>
        <form class="d-flex" role="search">
            <input type="text" name="usuario" id="usuario" placeholder="Usuario Empleado" class="m-1 form-control">
            <input type="password" name="clave" id="clave" placeholder="Contraseña Empleado" class="m-1 form-control">
            <input type="submit" value="Iniciar Sesion" class="btn btn-primary m-1 form-control" name="enviar">
        </form>
        </article>

      </section>
    </nav>


    <!-- mensaje de Inicio de sesion Incorrecto -->
    <p class="text-center"><?php echo $mensajesesion; ?></p>
    <!-- -------------------------------------- -->

  <!-- Contenedor principal -->
  <main class="container mt-5">

    <h1>Bienvenido Cliente</h1>
    <br>
    <!-- Zona de consultas -->
    <section>
    <h2 hidden>Zona Consultas</h2>
        <article class="btn-group">
        <h2 hidden>Consultas</h2>
            <a class="btn btn-primary" href="lista-coches-clientes.php">Ver coches disponibles</a>
            <a class="btn btn-primary" href="lista-ultimo-año.php">Coches de este año</a>
            <a class="btn btn-primary" href="lista-modelos.php">Ver modelos</a>
            <a class="btn btn-primary" href="index.php">Volver</a>
        </article>

    </section>
  </main>
</body>
</html>
