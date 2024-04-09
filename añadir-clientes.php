<?php
require("errores.php");
require("funciones.php")
?>

<?php
// Funcion Comprobacion de SESION
$mensajeSesion = sesion();
//--------------------------------


// Conexión con la BBDD--------
$conexion = conectarBBDD();
//------------------------------

//Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
$conexionCorrecta='';
$archivoSQL = "hyundauto.sql";
//------------------------



//Formulario Añadir Clientes ------------------------------------------
if (isset($_REQUEST['añadir'])) {
    $nif = $_REQUEST['nif'];
    $nombre = $_REQUEST['nombre'];
    $apellido =  $_REQUEST['apellido'];

    // Sentencia preparada
    $sql = "INSERT INTO Clientes 
            (nif, nombre, apellido)
            VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("sss", $nif, $nombre, $apellido);

    //Comprobacion de la consulta
    if ($stmt->execute()) {
        $registro = "Registro insertado correctamente";
    } else {
        $registro = "ERROR al añadir al cliente";
    }
    $stmt->close();
}
//--------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Añadir Clientes</title>
  <!-- Enlace a Bootstrap CSS -->
  <link rel="stylesheet" href="css/soloForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <!-- Barra de Navegación -->
    <nav class="navbar bg-body-tertiary">
        <section class="row container-fluid">
        <h2 hidden>Barra de Navegación</h2>
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
                <article class="btn-group">
                    <h2 hidden>Zona consultas</h2>
                    <a class="btn btn-primary active" href="lista-clientes.php">Lista de Clientes</a>
                    <a class="btn btn-primary " href="empleados.php">Añadir Clientes</a>
                    <a class="btn btn-primary active" href="buscar-clientes.php">Buscar Clientes</a>
                    <a class="btn btn-primary active" href="empleados.php">Volver</a>
                </article>

                <article>
                <br>
                <?php 
                if (isset($_REQUEST['añadir'])) {
                                echo $registro;
                            }
                ?>
                <br>
                    <form action="#" method="post" class="form">
                        <fieldset class="w-75 p-3">

                        <!-- NIF -->
                            <label for="cif" class="form-label">NIF</label>
                            <input type="text" name="nif" id="nif" class="form-control" maxlength="9" require><br>

                        <!-- NOMBRE -->
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" require><br>

                        <!-- APELLIDO -->
                            <label for="fundacion" class="form-label">Apellidos</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" require><br>

                        <!-- ENVIO -->
                            <input type="submit" value="Añadir" class="btn btn-primary form-control" name="añadir"><br>


                        </fieldset>
                    </form>
                </article> 
            </section>
        </main>
    </body>
</html>
