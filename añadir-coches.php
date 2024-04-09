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



//Formulario Añadir COCHES ------------------------------------------
if (isset($_REQUEST['añadir'])) {
    $matricula = $_REQUEST['matricula'];
    $modelo = $_REQUEST['modelo'];
    $año =  $_REQUEST['año'];
    $precio =  $_REQUEST['precio'];
    $motor = $_REQUEST['motor'];
    $transmision = $_REQUEST['transmision'];
    $color = $_REQUEST['color'];
    $exposicion = $_REQUEST['exposicion'];

    // Sentencia preparada para Vehiculos
    $sqlVehiculo = "INSERT INTO Vehiculos 
    (matricula, modelo, año, precio, exposicion) 
    VALUES (?, ?, ?, ?, ?)";
    $stmtVehiculo = $conexion->prepare($sqlVehiculo);
    $stmtVehiculo->bind_param("ssisi", $matricula, $modelo, $año, $precio, $exposicion);

    // Sentencia preparada para DatosModelo
    $sqlDatosModelo = "INSERT INTO DatosModelo 
    (matricula, motor, transmision, color) 
    VALUES (?, ?, ?, ?)";
    $stmtDatosModelo = $conexion->prepare($sqlDatosModelo);
    $stmtDatosModelo->bind_param("ssss", $matricula, $motor, $transmision, $color);


    if ($stmtVehiculo->execute()) {
        // Ejecutar consulta de DatosModelo
        if ($stmtDatosModelo->execute()) {
            $conexion->commit();
            $registro = "Coche añadido correctamente";
        } else {
            return ("ERROR en la inserción de DatosModelo");
        }
    } else {
        return ("ERROR en la inserción de Vehiculos");
    }
}
//--------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Añadir Coches</title>
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
                <a class="navbar-brand" href="#">
                    <img src="https://logodownload.org/wp-content/uploads/2014/05/hyundai-logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    Hyundauto Motor Concesionario Sevilla
                </a>
            </article>

            
            <!-- Nombre usuario -->
            <article class="col-2 d-flex justify-content-end">
            <h2 hidden> Usuario</h2>
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

                <!-- Zona de consultas -->
                <br>
            <section>
            <h2 hidden>Zona consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                <a class="btn btn-info active" href="lista-coches.php">Lista de Coches</a>
                <a class="btn btn-info " href="empleados.php">Añadir Coche Nuevo</a>
                <a class="btn btn-info active" href="empleados.php">Volver</a>
                </article>


                <article>
                <h2 hidden>Añadir registros</h2>
                <br>
                <?php 
                if (isset($_REQUEST['añadir'])) {
                                echo $registro;
                            }
                ?>
                <br>
                <!-- FORMULARIO AÑADIR COCHES -->
                    <form action="#" method="post" class="form">
                        <fieldset class="w-75 p-3">
                            <!-- MATRICULA -->
                            <label for="matricula" class=" form-label">Matricula</label>
                            <input type="text" name="matricula" id="matricula" class="form-control" maxlength="7" required><br>

                            <!-- MODELO -->
                            <label for="modelo" class="form-label">Modelo</label>
                                <select name="modelo" id="modelo" class="form-control" required>
                                    <option selected="selected"  disabled="disabled" value="null">--Selecciona un Modelo--</option>
                                    <option value="Hyundai Kona">Hyundai Kona</option>
                                    <option value="Hyundai Tucson">Hyundai Tucson</option>
                                    <option value="Hyundai IONIQ 6">Hyundai IONIQ 6</option>
                                    <option value="Hyundai BAYON">Hyundai BAYON</option>
                                    <option value="Hyundai i30 N">Hyundai i30 N</option>
                                    <option value="Hyundai i20 N">Hyundai i20 N</option>
                                    <option value="Hyundai i10">Hyundai i10</option>
                                </select><br>

                            <!-- AÑO -->
                            <label for="año" class="form-label">Año</label>
                            <input type="number" name="año" id="año" class="form-control" required><br>

                            <!-- PRECIO -->
                            <label for="precio" class="form-label">Precio</label>
                            <input type="text" name="precio" id="precio" class="form-control" required><br>

                            <!-- MOTOR -->
                            <label for="motor" class="form-label">Motor</label>
                                <select name="motor" id="motor" class="form-control" required>
                                    <option selected="selected" disabled="disabled" value="null">--Selecciona un Motor--</option>
                                    <option disabled="disabled" value="null">--Gasolina--</option>
                                    <option value="Kappa 1.2 100HP">kappa 1.2 100HP</option>
                                    <option value="Gamma 1.6 GDI 120HP">Gamma 1.6 GDI 120HP</option>
                                    <option value="Lamba 1.9 270HP">Lamba 1.9 270HP</option>
                                    <option disabled="disabled" value="null">--Diesel--</option>
                                    <option value="U-series VGT 1.6 125PS">U-series VGT 1.6 125PS</option>
                                    <option disabled="disabled" value="null">--Hibrido--</option>
                                    <option value="Hyundai Kona Electric (100 kW)">Hyundai Kona Electric 134 hp (100 kW)</option>
                                    <option value="Hyundai Ioniq Electric (225 kW)">Hyundai Ioniq Electric 300 hp (225 kW)</option>
                                    <option value="Hyundai Tucson Electric (150 kW)">Hyundai Tucson Electric 201 hp (150 kW)</option>
                                </select><br>

                            <!-- TRANSMISION -->
                            <label for="transmision" class="form-label">Transmision</label>
                                <select name="transmision" id="transmision" class="form-control" required>
                                    <option selected="selected" disabled="disabled" value="null">--Selecciona una Transmision--</option>
                                    <option value="6v Manual">6v Manual</option>
                                    <option value="6v Automatico">6v Automatico</option>
                                    <option value="7v Automatico">7v Automatico</option>
                                </select><br>

                            <!-- COLOR -->
                            <label for="color" class="form-label">Color</label>
                                <select name="color" id="color" class="form-control" required>
                                    <option selected="selected"  disabled="disabled" value="null">--Selecciona un Color--</option>
                                    <option value="VANILLA WHITE">VANILLA WHITE</option>
                                    <option value="BLUE ONYX PEARL">BLUE ONYX PEARL</option>
                                    <option value="STEEL GRAY">STEEL GRAY</option>
                                    <option value="EMERALD GREEN">EMERALD GREEN</option>
                                    <option value="BLUISH RED">BLUISH RED</option>
                                </select><br><br>

                            <!-- EXPOSICION -->
                            <input class="form-check-input" type="radio" name="exposicion" id="exposicion2" value="0" checked>
                            <label class="form-check-label" for="exposicion2">Coche para la Venta</label>
                                <br>
                            <input class="form-check-input" type="radio" name="exposicion" id="exposicion1" value="1">
                            <label class="form-check-label" for="exposicion1">Coche para la Exposicion</label>
                                <br><br>

                            <!-- ENVIO -->
                            <input type="submit" value="Añadir" class="btn btn-primary form-control" name="añadir"><br>
                        </fieldset>
                    </form>
                </article> 
            </section>
        </main>
    </body>
</html>
