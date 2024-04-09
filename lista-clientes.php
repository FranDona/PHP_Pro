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

// BORRADO LOGICO
if (isset($_REQUEST['logico'])) {

    $sql = "UPDATE Clientes SET activo = 0 WHERE nif = ?";
    $sentPreparada = $conexion->prepare($sql);
    $sentPreparada->bind_param("s", $_REQUEST['nif']);
    if ($sentPreparada->execute()) {
        $resultado = "Borrado Lógico correcto";
    } else {
        $resultado = "ERROR en el BORRADO";
    }
}


// Cargar Datos ----------------------------------------------
    $sql = "SELECT * FROM Clientes WHERE activo = 1";
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


// Formulario de Actualización-----------------------------------------------
if (isset($_REQUEST['actualizar'])) {
    $nif = $_REQUEST['nif'];
    $nombre = $_REQUEST['nombre'];
    $apellido = $_REQUEST['apellido'];

    $sqlUpdate = "UPDATE Clientes 
                  SET nombre=?, 
                      apellido=?
                    WHERE nif=?";

     $sentenciaSQL = $conexion->prepare($sqlUpdate);
    $sentenciaSQL->bind_param("sss", $nombre, $apellido, $nif);

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
  <title>Listas Clientes</title>
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
            <h2 hidden>Hyundauto</h2>
                <!-- Logo y Nombre del Concesionario -->
                <article class="col-8">
                <h2 hidden>Logo</h2>
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
            <h2 hidden>Zona de consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                <a class="btn btn-primary " href="empleados.php">Lista de Clientes</a>
                <a class="btn btn-primary active" href="añadir-clientes.php">Añadir Clientes</a>
                <a class="btn btn-primary active" href="buscar-clientes.php">Buscar Clientes</a>
                <a class="btn btn-primary active" href="empleados.php">Volver</a>

                </article>

                <article>
                <h2 hidden>Datos de consultas</h2>
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th class="bg-primary text-light" >NIF</th>
                                <th class="bg-primary text-light">Nombre</th>
                                <th class="bg-primary text-light">Apellido</th>
                                <th class="bg-primary text-light"></th>
                                <th class="bg-primary text-light"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tabla = $conexion->query($sql);
                            $registros = $tabla->fetch_all(MYSQLI_ASSOC);
                            foreach ($registros as $registro) {
                                echo "<tr>";
                                echo "<td>" . $registro['nif'] . "</td>";
                                echo "<td>" . $registro['nombre'] . "</td>";
                                echo "<td>" . $registro['apellido'] . "</td>";

                            ?>                    
                        <td>
                            <form action="#" method="get">
                                <input type="hidden" name="nif" value="<?php echo $registro['nif'] ?>">
                                <input class="btn btn-sm btn-primary" type="submit" value="Eliminar Cliente" name="logico">
                            </form>
                        </td>
                        <td>
                            <form action="#seccionVer" method="get">
                                <input type="hidden" name="nif" value="<?php echo $registro['nif']; ?>">
                                <input class="btn btn-sm btn-primary" type="submit" name="ver" value="Editar">
                            </form>
                        </td>
                            <?php
                                
                            }
                            ?>
                        </tbody>
                    </table>
                </article>

                <!-- Parte Formulario Actualizacion -->
                <article>
                <h2 hidden>Formulario Actualizacion</h2>
                    <section id="seccionVer" aria-label="formulario">
                    <h2 hidden>Formulario Actualizacion</h2>
                        <?php
                        if (isset($_REQUEST['ver'])) {
                            
                            $sql = "SELECT * FROM Clientes WHERE nif = ?";
                            $sentenciaSQL = $conexion->prepare($sql);
                            $sentenciaSQL->bind_param("s", $_REQUEST['nif']);
                            $sentenciaSQL->execute();
                            $tabla = $sentenciaSQL->get_result();
                            $registros = $tabla->fetch_all(MYSQLI_ASSOC);
                            

                            foreach ($registros as $registro) {
                        ?>
                                <form  action="#" method="post" class="form">
                                    <fieldset id="seccionEjemplo" class="w-50 p-3">
                                        <label for="nif" class="form-label">NIF</label>
                                        <input type="text" name="nif" id="nif" class="form-control" maxlength="9" value="<?php echo $registro['nif'] ?>" disabled="disabled"><br>
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $registro['nombre'] ?>"><br>
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input type="text" name="apellido" id="apellido" class="form-control" value="<?php echo $registro['apellido'] ?>"><br>
                                    
                                        <input type="submit" value="Actualizar" class="btn btn-primary form-control" name="actualizar">
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
