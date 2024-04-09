<?php
require("errores.php");
require("funciones.php")
?>

<?php
// Funcion Comprobacion de SESION
$mensajeSesion = sesion();
//-------------------------------


//Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
//------------------------


// Conexión con la BBDD-------
$servidor = "localhost";
$usuario = "root";
$clave = "root";
$bbdd = "hyundauto";
$archivoSQL = "hyundauto.sql";
//-----------------------------


// Objeto conexión-----------------------------------
$conexion = new mysqli($servidor, $usuario, $clave);
// Comprobamos la conexión
if ($conexion->connect_error) {
    die("Error de Conexión: " . $conexion->connect_error);
} else {
    $conexionCorrecta = "Conexión:&nbsp;" . "<i class='fa-solid fa-lg fa-circle-check' style='color: #63E6BE;'></i>";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Zona Empleados</title>
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
                <article class="col-8">
                <h2 hidden>Hyundauto</h2>
                    <a class="navbar-brand" href="index.php">
                        <img src="https://logodownload.org/wp-content/uploads/2014/05/hyundai-logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                        Hyundauto Motor Concesionario Sevilla
                    </a>
                </article>
                
                <!-- Nombre usuario -->
                <article class="col-2 d-flex justify-content-end">
                <h2 hidden>Usuario</h2>
                    <p>Usuario: <?php echo $mensajeSesion; ?></p>
                </article>

                <!-- Boton Desloguearse -->
                <article class="col-1 d-flex justify-content-end">
                <h2 hidden>Desloguearse</h2>
                        <form action="#" method="post" class="form">
                            <fieldset>
                                <input type="submit" value="Cerrar Sesion" class="btn btn-primary form-control" name="salir">
                            </fieldset>  
                        </form>
                </article>
            </section>
        </nav>

    <!-- Mensaje de conexion correcta -->
        <p><?php echo $conexionCorrecta;?></p>
    <!-- ---------------------------- -->


    <!-- mensaje de Inicio de sesion Incorrecto -->
        <p class="text-center"><?php echo $mensajesesion; ?></p>
    <!-- -------------------------------------- -->


        <!-- Contenedor principal -->
        <main class="container mt-5">
        <h1>Bienvenido <?php echo $mensajeSesion; ?></h1>
        <br>
                <!-- Zona de consultas -->
            <section>
            <h2 hidden>Zona consultas</h2>
                <article class="w-100 btn-group">
                <h2 hidden>Consultas</h2>
                    <a class="btn btn-primary " href="lista-clientes.php">Lista de Clientes</a>
                    <a class="btn btn-primary " href="añadir-clientes.php">Añadir Clientes</a>
                    <a class="btn btn-primary " href="buscar-clientes.php">Buscar Clientes</a>
                
                    <a class="btn btn-info " href="lista-coches.php">Lista de Coches</a>
                    <a class="btn btn-info " href="añadir-coches.php">Añadir Coche Nuevo</a>

                    <a class="btn btn-primary " href="lista-ventas.php">Ver ventas</a>
                    <a class="btn btn-primary " href="crear-venta.php">Crear una venta</a>
                </article>
            </section>
        </main>
    </body>
</html>
