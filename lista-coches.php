<?php
require("errores.php");
require("funciones.php")
?>

<?php
// Funcion Comprobacion de SESION
$mensajeSesion = sesion();
//-------------------------------


// Conexión con la BBDD-------
$conexion = conectarBBDD();
//-----------------------------

//Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
$conexionCorrecta='';
$archivoSQL = "hyundauto.sql";
$resultado = '';
//------------------------


// (Borrado FISICO)
if (isset($_REQUEST['fisico'])) {
    $resultado = borradoFisicoCoches($conexion, $_REQUEST['matricula']);
}

// (Borrado LOGICO)
if (isset($_REQUEST['logico'])) {
    $resultado = borradoLogicoCoches($conexion, $_REQUEST['matricula']);
}



//Visualizar datos---------------------------------------
    $sql = "SELECT * FROM Vehiculos";
    $sentPreparada = $conexion->prepare($sql);

    // Verificar si la preparación de la sentencia fue exitosa
    if ($sentPreparada === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $sentPreparada->execute();

    // Verificar si la ejecución de la sentencia fue exitosa
    if ($sentPreparada === false) {
        die("Error en la ejecución de la consulta: " . $sentPreparada->error);
    }

    $tabla = $sentPreparada->get_result();
    $registros = $tabla->fetch_all(MYSQLI_ASSOC);

//-----------------------------------------------------------------------


//Zona de Actualización-----------------------------------------------
if (isset($_REQUEST['actualizar'])) {
    $matricula = $_REQUEST['matricula'];
    $modelo = $_REQUEST['modelo'];
    $año = $_REQUEST['año'];
    $precio = $_REQUEST['precio'];
    $exposicion = $_REQUEST['exposicion'];

    $sqlUpdate = "UPDATE Vehiculos 
                    SET modelo=?, 
                      año=?,
                      precio=?,
                      exposicion=?
                    WHERE matricula=?";

    $sentenciaSQL = $conexion->prepare($sqlUpdate);
    $sentenciaSQL->bind_param("siiis", $modelo, $año, $precio, $exposicion, $matricula);

    if ($sentenciaSQL->execute()) {
        $resultado .= "<br> Registro actualizado correctamente";
    } else {
        $resultado .= "<br> ERROR en la actualización";
    }
}
// -----------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Lista Coches</title>
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
        <!-- Mensaje de registro creado -->
        <?php echo $resultado; ?>
        <!-- -------------------------- -->

                <!-- Zona de consultas -->
            <section>
            <h2 hidden>Zona Consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                    <a class="btn btn-info " href="empleados.php">Lista de Coches</a>
                    <a class="btn btn-info active" href="añadir-coches.php">Añadir Coche Nuevo</a>
                    <a class="btn btn-info active" href="empleados.php">Volver</a>
            </article>


                <article>
                <h2 hidden>Datos de consulta</h2>
                    <table class="table text-center table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-light bg-info">Matricula</th>
                                <th class="text-light bg-info">Modelo</th>
                                <th class="text-light bg-info">Año</th>
                                <th class="text-light bg-info">Precio</th>
                                <th class="text-light bg-info">Disponibilidad</th>
                                <th class="text-light bg-info">Exposicion</th>
                                <th class="text-light bg-info"></th>
                                <th class="text-light bg-info"></th>
                                <th class="text-light bg-info"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tabla = $conexion->query($sql);
                            $registros = $tabla->fetch_all(MYSQLI_ASSOC);
                            foreach ($registros as $registro) {
                                echo "<tr>";
                                echo "<td>" . $registro['matricula'] . "</td>";
                                echo "<td>" . $registro['modelo'] . "</td>";
                                echo "<td>" . $registro['año'] . "</td>";
                                echo "<td>" . $registro['precio'] ." €" ."</td>";
                                echo "<td>";
                                if ($registro['disponible'] == 1) {
                                    echo "<i class='fa-solid fa-circle-check' style='color: #2ec27e;'></i>"; 
                                } else {
                                    echo "<i class='fa-solid fa-circle-xmark' style='color: #e01b24;'></i>";
                                }
                                echo "</td>";
                                echo "<td>";
                                if ($registro['exposicion'] == 1) {
                                    echo "Si  <i class='fa-solid fa-triangle-exclamation' style='color: #f5c211;'></i>"; 
                                } else{
                                    echo "No  <i class='fa-solid fa-circle-check' style='color: #2ec27e;'></i>"; 
                                }
                                echo "</td>";
                            ?>                    
                            <td>
                            <form action="#" method="get">
                                <input type="hidden" name="matricula" value="<?php echo $registro['matricula'] ?>">
                                <input type="submit" value="Borrado Fisico" name="fisico">
                            </form>
                        </td>
                        <td>
                            <form action="#" method="get">
                                <input type="hidden" name="matricula" value="<?php echo $registro['matricula'] ?>">
                                <input type="submit" value="Borrado Lógico" name="logico">
                            </form>
                        </td>
                                <td>
                                    <form action="#seccionVer" method="get">
                                        <input type="hidden" name="matricula" value="<?php echo $registro['matricula']; ?>">
                                        <input type="submit" name="ver" value="Editar">
                                    </form>
                                </td>
                            <?php
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </article>

                <!-- Parte Formulario Actualizacion -->
                <article>
                <h2 hidden>Zona de Actualizacion</h2>
                    <section id="seccionVer" aria-label="formulario">
                    <h2 hidden>Formulario Actualizacion</h2>
                        <?php
                        if (isset($_REQUEST['ver'])) {
                            
                            $sql = "SELECT * FROM Vehiculos WHERE matricula = ?";
                            $sentenciaSQL = $conexion->prepare($sql);
                            $sentenciaSQL->bind_param("s", $_REQUEST['matricula']);
                            $sentenciaSQL->execute();
                            $tabla = $sentenciaSQL->get_result();
                            $registros = $tabla->fetch_all(MYSQLI_ASSOC);
                            

                        foreach ($registros as $registro) {
                        ?>
                            <form  action="#" method="post" class="form">
                                <fieldset id="seccionEjemplo" class="w-50 p-3">

                                    <!-- MATRICULA -->
                                    <label for="nif" class="form-label">Matricula</label>
                                    <input type="text" name="matricula" id="matricula" class="form-control" maxlength="9" value="<?php echo $registro['matricula'] ?>" disabled="disabled"><br>

                                    <!-- MODELO -->
                                    <label for="modelo" class="form-label">Modelo</label>
                                    <input type="text" name="modelo" id="modelo" class="form-control" value="<?php echo $registro['modelo'] ?>"><br>

                                    <!-- AÑO -->
                                    <label for="año" class="form-label">Año</label>
                                    <input type="text" name="año" id="año" class="form-control" value="<?php echo $registro['año'] ?>"><br>

                                    <!-- PRECIO -->
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="text" name="precio" id="precio" class="form-control" value="<?php echo $registro['precio'] ?>"><br>
                                

                                    <!-- EXPOSICION -->
                                    <input class="form-check-input" type="radio" name="exposicion" id="exposicion2" value="0" >
                                    <label class="form-check-label" for="exposicion2">Coche para la Venta</label>
                                        <br>
                                    <input class="form-check-input" type="radio" name="exposicion" id="exposicion1" value="1">
                                    <label class="form-check-label" for="exposicion1">Coche para la Exposicion</label>
                                    

                                    <!-- BOTON ACTUALIZAR -->
                                    <input type="submit" value="Actualizar" class="form-control" name="actualizar">
                                </fieldset>
                            </form>
                        <?php
                            }
                        }
                        ?>
                    </section>
                </article>
            </section>
        </main>
    </body>
</html>
