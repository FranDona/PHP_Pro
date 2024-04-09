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
//-----------------------------//

//Declaracion de variables
$mensajebbdd = '';
$mensajesesion = '';
$mensaje = '';
$conexionCorrecta='';
$archivoSQL = "hyundauto.sql";
$resultado = '';
//------------------------


// Tratar formulario (Borrado LOGICO)
if (isset($_REQUEST['logico'])) {
    $resultado = borradoLogicoVentas($conexion, $_REQUEST['matricula']);
}


// Visualizar información de ventas con detalles de vehículos y clientes
$sql = "SELECT Ventas.fecha_venta, Vehiculos.modelo, Vehiculos.matricula, Clientes.nombre, Clientes.apellido
        FROM Ventas
        JOIN Vehiculos ON Ventas.matricula = Vehiculos.matricula
        JOIN Clientes ON Ventas.nif_cliente = Clientes.nif
        WHERE Ventas.activo = 1;";

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="css/hyundai-logo.ico" type="image/x-icon">
  <title>Lista de Ventas</title>
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
            <h2 hidden>Zona Consultas</h2>
                <article class="btn-group">
                <h2 hidden>Consultas</h2>
                    <a class="btn btn-primary" href="empleados.php">Ver Ventas</a>
                    <a class="btn btn-primary active" href="crear-venta.php">Crear una venta</a>
                    <a class="btn btn-primary active" href="empleados.php">Volver</a>
                </article>

                <article>
                <h2 hidden>Datos de Consulta</h2>
                    <table class="table text-center table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-light bg-primary">Fecha de Venta</th>
                                <th class="text-light bg-primary">Modelo</th>
                                <th class="text-light bg-primary">Matrícula</th>
                                <th class="text-light bg-primary">Nombre del Cliente</th>
                                <th class="text-light bg-primary">Apellido del Cliente</th>
                                <th class="text-light bg-primary"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT Ventas.fecha_venta, Vehiculos.modelo, Vehiculos.matricula, Clientes.nombre, Clientes.apellido
                            FROM Ventas
                            JOIN Vehiculos ON Ventas.matricula = Vehiculos.matricula
                            JOIN Clientes ON Ventas.nif_cliente = Clientes.nif
                            WHERE Ventas.activo = 1;";

                            $tabla = $conexion->query($sql);
                            $registros = $tabla->fetch_all(MYSQLI_ASSOC);
                            foreach ($registros as $registro) {
                                echo "<tr>";
                                echo "<td>" . $registro['fecha_venta'] . "</td>";
                                echo "<td>" . $registro['modelo'] . "</td>";
                                echo "<td>" . $registro['matricula'] . "</td>";
                                echo "<td>" . $registro['nombre'] . "</td>";
                                echo "<td>" . $registro['apellido'] . "</td>";
                                
                            
                            ?>  
                            <td>
                                <form action="#" method="get">
                                    <input type="hidden" name="matricula" value="<?php echo $registro['matricula'] ?>">
                                    <input type="submit" value="Eliminar venta" name="logico">
                                </form>
                            </td> 
                            <?php
                                echo "</tr>";      
                            }           
                            ?>
                        </tbody>
                    </table>
                </article>
            </section>
        </main>
    </body>
</html>
