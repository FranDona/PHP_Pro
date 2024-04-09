<?php

// 1. Función para devolver objeto conexión a BBDD
function conectarBBDD()
{
    /* Conexión con la BBDD hyundauto */
    $servidor = "localhost";
    $usuario = "root";
    $clave = "root";
    $bbdd = "hyundauto";


    // Objeto conexión
    $conexion = new mysqli($servidor, $usuario, $clave, $bbdd);
    // Comprobamos la conexión
    if ($conexion->connect_error) {
        die("Error de Conexión: " . $conexion->connect_error);
    }

    return $conexion;
}

//BORRADO LOGICO VENTAS
function borradoLogicoVentas($conexion, $matricula) {
    $sql = "UPDATE Ventas SET activo = 0 WHERE matricula = ?";
    $sentPreparada = $conexion->prepare($sql);
    $sentPreparada->bind_param("s", $_REQUEST['matricula']);
    if ($sentPreparada->execute()) {
        $resultado = "Borrado Lógico correcto";
    } else {
        $resultado = "ERROR en el BORRADO";
    }
}



// BORRADO FISICO COCHES
function borradoFisicoCoches($conexion, $matricula) {
        // Eliminar datos relacionados en DatosModelo
    $sqlDeleteDatosModelo = "DELETE FROM DatosModelo WHERE matricula = ?";
    $sentPreparadaDatosModelo = $conexion->prepare($sqlDeleteDatosModelo);
    $sentPreparadaDatosModelo->bind_param("s", $_REQUEST['matricula']);

    // Realizar la eliminación en DatosModelo
    if ($sentPreparadaDatosModelo->execute()) {
        // Ahora que se han eliminado los datos relacionados, proceder con la eliminación en Vehiculos
        $sqlDeleteVehiculo = "DELETE FROM Vehiculos WHERE matricula = ?";
        $sentPreparadaVehiculo = $conexion->prepare($sqlDeleteVehiculo);
        $sentPreparadaVehiculo->bind_param("s", $_REQUEST['matricula']);


    // Eliminar datos relacionados en Ventas
    $sqlDeleteVentas = "DELETE FROM Ventas WHERE matricula = ?";
    $sentPreparadaVentas = $conexion->prepare($sqlDeleteVentas);
    $sentPreparadaVentas->bind_param("s", $_REQUEST['matricula']);

    // Realizar la eliminación en Ventas
    if ($sentPreparadaVentas->execute()) {
        // Ahora que se han eliminado los datos relacionados en Ventas, proceder con la eliminación en Vehiculos
        $sqlDeleteVehiculo = "DELETE FROM Vehiculos WHERE matricula = ?";
        $sentPreparadaVehiculo = $conexion->prepare($sqlDeleteVehiculo);
        $sentPreparadaVehiculo->bind_param("s", $_REQUEST['matricula']);

        // Realizar la eliminación en Vehiculos
        if ($sentPreparadaVehiculo->execute()) {
            $resultado = "Borrado FISICO correcto";
        } else {
            $resultado = "ERROR en el DELETE en Vehiculos";
        }
    } else {
        $resultado = "ERROR en el DELETE en Ventas";
    }
}}


// BORRADO LOGICO COCHES
function borradoLogicoCoches($conexion, $matricula) {
    $sql = "UPDATE Vehiculos SET disponible = 0 WHERE matricula = ?";
    $sentPreparada = $conexion->prepare($sql);
    $sentPreparada->bind_param("s", $_REQUEST['matricula']);
    if ($sentPreparada->execute()) {
        $resultado = "Borrado Lógico correcto";
    } else {
        $resultado = "ERROR en el BORRADO";
    }
}



// Función sesion
function sesion()
{
    // Sesiones
    session_start();

    // Salir de la sesión
    if (isset($_REQUEST['salir'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }

    // Comprobar que estoy logado
    if ($_SESSION['usuario'] != "admin") {
        header("Location: login.php");
        exit();
    } else {
        return $_SESSION['usuario'] . "<br>";
    }
}