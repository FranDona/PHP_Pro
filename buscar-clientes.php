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
//------------------------



if (isset($_POST['buscar'])) {
    // Incluir la lógica de búsqueda aquí
    $nif = $_POST['nif'];
    
    $sql = "SELECT * FROM Clientes WHERE nif = ?";
    $sentPreparada = $conexion->prepare($sql);

    if ($sentPreparada === false) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $sentPreparada->bind_param("s", $nif);
    $sentPreparada->execute();

    if ($sentPreparada === false) {
        die("Error en la ejecución de la consulta: " . $sentPreparada->error);
    }

    $tabla = $sentPreparada->get_result();
    $registros = $tabla->fetch_all(MYSQLI_ASSOC);

    //Verifica que se encontrarin registros
    $registrosEncontrados = count($registros) > 0;
}
//-----------------------------------------------------------------------
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Buscador de Clientes</title>
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
        <h1>Bienvenido <?php echo $mensajeSesion; ?></h1>


                <!-- Zona de consultas -->
                <br> 
            <section>
            <h2 hidden>Zona consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                    <a class="btn btn-primary active" href="lista-clientes.php">Lista de Clientes</a>
                    <a class="btn btn-primary active" href="añadir-clientes.php">Añadir Clientes</a>
                    <a class="btn btn-primary " href="empleados.php">Buscar Clientes</a>
                    <a class="btn btn-primary active" href="empleados.php">Volver</a>
                </article>
                <br><br>
                <form method="post" action="#">
                    <label for="nif">Introduce el NIF:</label>
                    <input type="text" id="nif" name="nif">
                    <button class="btn btn-primary btn-sm" type="submit" name="buscar">Buscar</button>
                </form>
                <article>
                    <br>
                <?php
                if (isset($_POST['buscar'])) {
                    if ($registrosEncontrados) {
                    foreach ($registros as $registro) {
                            ?>
                            <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th class="bg-primary text-light">NIF</th>
                                    <th class="bg-primary text-light">Nombre</th>
                                    <th class="bg-primary text-light">Apellido</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- Mostrar los resultados -->
                                <tr> 
                                    <th><?php echo $registro["nif"];?> </th>
                                    <th><?php echo $registro["nombre"];?> </th>
                                    <th><?php echo $registro["apellido"];?> </th>
                                </tr>

                        <?php
                            } }  else {
                                echo '<p class="text-danger">No se encontraron registros con el NIF proporcionado.</p>';
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </article>
            </section>
        </main>
    </body>
</html>
