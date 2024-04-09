<?php
require("errores.php");
require("funciones.php")
?>

<?php
// Sesiones
session_start();

// Conexión con la BBDD-------
$conexion = conectarBBDD();
//-----------------------------

//Declaracion de variables
$mensajebbdd = '';
$mensaje = '';
$conexionCorrecta='';
$archivoSQL = "hyundauto.sql";
$resultado = '';
//------------------------


//Visualizar datos---------------------------------------
$sql = "SELECT * FROM Vehiculos
WHERE disponible = 1 
AND exposicion = 0
AND año >= 2024 ;";

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


// Tratar formulario
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
  <title>Lista Coches</title>
  <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="css/restoPaginas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
    <body>
        <?php echo $resultado; ?>
        <!-- Barra de Navegación -->
        <nav class="navbar bg-body-tertiary">
            <section class="row container-fluid">
            <h2 hidden>Barra Navegación</h2>
                <!-- Logo y Nombre del Concesionario -->
                <article class="col-4 ">
                <h2 hidden>Hyundauto</h2>
                    <a class="navbar-brand" href="index.php">
                        <img src="https://logodownload.org/wp-content/uploads/2014/05/hyundai-logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                        Hyundauto Motor Concesionario Sevilla
                    </a>
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




        <!-- Contenedor principal -->
        <main class="container mt-5">
        <h1>Bienvenido Cliente</h1>
        <br>

                <!-- Zona de consultas -->
            <section>
            <h2 hidden>Zona de Consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                    <a class="btn btn-primary active" href="lista-coches-clientes.php">Ver coches disponibles</a>
                    <a class="btn btn-primary" href="clientes.php">Coches de este año</a>
                    <a class="btn  btn-primary active" href="lista-modelos.php">Ver modelos</a>            
                    <a class="btn btn-primary active" href="clientes.php">Volver</a>
                </article>

                <article>
                <h2 hidden>Datos de consulta</h2>
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th class="bg-primary text-light">Modelo</th>
                                <th class="bg-primary text-light">Año</th>
                                <th class="bg-primary text-light">Precio</th>
                                <th class="bg-primary text-light">Disponibilidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tabla = $conexion->query($sql);
                            $registros = $tabla->fetch_all(MYSQLI_ASSOC);
                            foreach ($registros as $registro) {
                                echo "<tr>";
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
                            }
                            ?>                    
                        </tbody>
                    </table>
                </article>  
            </section>
        </main>
    </body>
</html>
