<?php
require("errores.php");
require("funciones.php")
?>

<?php
// Sesiones------
session_start();
//----------------


//Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
//------------------------


// Conexión con la BBDD--------
$servidor = "localhost";
$usuario = "root";
$clave = "root";
$bbdd = "hyundauto";
$archivoSQL = "hyundauto.sql";
//------------------------------


// Objeto conexión-----------------------------------
$conexion = new mysqli($servidor, $usuario, $clave);
// Comprobamos la conexión
if ($conexion->connect_error) {
    die("Error de Conexión: " . $conexion->connect_error);
} else {
    $conexionCorrecta = "Conexión:&nbsp;" . "<i class='fa-solid fa-lg fa-circle-check' style='color: #63E6BE;'></i>";
}

// Me ha llegado la orden de cargar la BBDD
if (isset($_REQUEST['cargarbbdd'])) {
    $contenidoSQL = file_get_contents($archivoSQL);
    $cargaBBDD = $conexion->multi_query($contenidoSQL);
    if ($cargaBBDD) {
        $mensajebbdd = "BBDD Cargada &nbsp;" . "<i class='fa-solid fa-lg fa-circle-check' style='color: #63E6BE;'></i>";
    } else {
        $mensajebbdd = "Error en la carga de la BBDD";
    }
}


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
  <title>Hyundauto - Inicio</title>
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
            <h2 hidden>Barra de navegacion</h2>
                <!-- Logo y Nombre del Concesionario -->
                <article class="col-4 ">
                    <h2 hidden>Logo y Nombre del Concesionario</h2>
                    <a class="navbar-brand" href="#">
                        <img src="https://logodownload.org/wp-content/uploads/2014/05/hyundai-logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                        Hyundauto Motor Concesionario Sevilla
                    </a>
                </article>
                

                <!-- Carga de base de datos -->
                <article class="col-2">
                <h2 hidden>Carga de base de datos</h2>
                    <form action="#" method="post" class="form justify-content-end">
                        <fieldset>
                            <input type="submit" value="Cargar BBDD" class="form-control" name="cargarbbdd">
                        </fieldset>
                        <p class="text-center"><?php echo $mensajebbdd;?></p>
                    </form>
                </article>
                

                <!-- Inicio de sesion Empleados -->
                <article class="col-4">
                    <h2 hidden>Inicio sesion Empleados</h2>
                    <form class="d-flex" role="search">
                        <input type="text" name="usuario" id="usuario" placeholder="Usuario Empleado" class="m-1 form-control">
                        <input type="password" name="clave" id="clave" placeholder="Contraseña Empleado" class="m-1 form-control">
                        <input type="submit" value="Iniciar Sesion" class="btn btn-primary m-1 form-control" name="enviar">
                    </form>
                </article>
            </section>
        </nav>

    <!-- Mensaje de conexion correcta -->
        <p class="position-absolute"><?php echo $conexionCorrecta;?></p>
    <!-- ---------------------------- -->


    <!-- mensaje de Inicio de sesion Incorrecto -->
        <p class="text-center"><?php echo $mensajesesion; ?></p>
    <!-- -------------------------------------- -->



        <!-- Contenedor principal -->
        <main class="container mt-5">

        <!-- Tarjetas Empleados y Clientes -->
            <section class="row d-flex justify-content-center mt-3">
            <h2 class="text-center">Hyundauto Motor Concesionario Sevilla </h2>

                <!-- Tarjeta Cliente -->
                <nav class="card card col-6 m-5 p-2 w-25">
                    <header>
                        <img src="css/zona_clientes.jpg" height="220" class="card-img-top" alt="ZONA CLIENTES">
                    </header>
                    <footer class="card-body">
                        <h5 class="card-title">ZONA DE CLIENTES</h5>
                        <p class="card-text">Zona de consultas para precios y modelos en exposicion. </p>
                        <a class="btn btn-primary btn-lg" href="clientes.php">Cliente</a>
                    </footer>
                </nav>

                <!-- Tarjeta Empleado -->
                <nav class="card card col-6 m-5 p-2 w-25">
                    <header>
                        <img src="css/zona_empleados.png" height="220" class="card-img-top" alt="ZONA EMPLEADOS">
                    </header>
                    <footer class="card-body">
                        <h5 class="card-title">ZONA DE EMPLEADOS</h5>
                        <p class="card-text">Zona para la gestion de los coches, clientes y ventas  </p>
                        <a class="btn btn-primary btn-lg" href="empleados.php">Empleado</a>
                    </footer>
                </nav>
            </section>
        </main>
    </body>
</html>

