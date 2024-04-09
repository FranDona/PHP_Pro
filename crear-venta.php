<?php
require("errores.php");
require("funciones.php");

// Funcion Comprobacion de SESION
$mensajeSesion = sesion();
//------------------------------



// Conexión con la BBDD
$conexion = conectarBBDD();
//-------------------------



// Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
$conexionCorrecta = '';
$archivoSQL = "hyundauto.sql";
//-----------------------------


// Formulario Añadir Ventas------------------------------------------------------------
if (isset($_POST['añadir'])) {
    $matricula = $_POST['matricula'];
    $nif_cliente = $_POST['nif_cliente'];
    $fecha_venta = $_POST['fecha_venta'];

    // Sentencia preparada para insertar en Ventas
    $sqlInsertVentas = "INSERT INTO Ventas (matricula, nif_cliente, fecha_venta) VALUES (?, ?, ?)";
    $stmtInsertVentas = $conexion->prepare($sqlInsertVentas);
    $stmtInsertVentas->bind_param("sss", $matricula, $nif_cliente, $fecha_venta);

    // Ejecuto la consulta y compruebo
    if ($stmtInsertVentas->execute()) {
        // Registro insertado correctamente, ahora actualizamos el estado del vehículo
        $sqlUpdateVehiculo = "UPDATE Vehiculos SET disponible = 0 WHERE matricula = ?";
        $stmtUpdateVehiculo = $conexion->prepare($sqlUpdateVehiculo);
        $stmtUpdateVehiculo->bind_param("s", $matricula);
        
        if ($stmtUpdateVehiculo->execute()) {
            $registro = "Registro insertado y vehículo actualizado correctamente";
        } else {
            $registro = "Error al actualizar el estado del vehículo";
        }

        $stmtUpdateVehiculo->close();
    } else {
        $registro = "ERROR en la inserción";
    }
    $stmtInsertVentas->close();
}
//---------------------------------------------------------------------------------------------

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Crear Ventas</title>
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
            <h2 hidden>Barra Navegación</h2>
                <!-- Logo y Nombre del Concesionario -->
                <article class="col-8">
                <h2 hidden>Hyundauto</h2>
                    <a class="navbar-brand" href="#">
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
        <h1>Bienvenido <?php echo $mensajeSesion; ?></h1><br>

                <!-- Zona de consultas -->
            <section>
            <h2 hidden>Zona de consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                    <a class="btn btn-primary active" href="lista-ventas.php">Ver Ventas</a>
                    <a class="btn btn-primary" href="empleados.php">Crear una venta</a>
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

                        <!-- MATRICULA -->
                            <label for="matricula" class="form-label">Matricula</label>
                            <input type="text" name="matricula" id="matricula" class="form-control" maxlength="8" require><br>

                        <!-- NIF CLIENTE -->
                            <label for="nif_cliente" class="form-label">NIF del Comprador. &nbsp; (Si el cliente <span class="fw-bold">no</span> esta en la base de datos tendras que añadirlo primero <a class="fw-bold" href="añadir-clientes.php">aquí</a>)</label>
                            <input type="text" name="nif_cliente" id="nif_cliente" class="form-control" require><br>

                        <!-- FECHA VENTA -->
                            <label for="fundacion" class="form-label">Fecha de Venta</label>
                            <input type="date" name="fecha_venta" id="fecha_venta" class="form-control" require><br>

                        <!-- ENVIO -->
                            <input type="submit" value="Añadir" class="btn btn-primary form-control" name="añadir"><br>
                        </fieldset>
                    </form>
                </article>
            </section>
        </main>
    </body>
</html>
