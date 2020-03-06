<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:../login.php");
}
include("../includes/conectar.php");
require("../includes/varios.php");

$varios = new Varios();

$mes_actual  = date("m");
$anio_actual = date("Y");

$empresa = $_SESSION['empresa'];
if (isset($_POST['graba_capacitacion'])) {
    
    
    $tema      = strtoupper($_POST['tema']);
    $fecha     = $varios->fecha_mysql($_POST['fecha_inicio']) . ' ' . $_POST['hora_inicio'];
    $duracion  = strtoupper($_POST['duracion']);
    $expositor = strtoupper($_POST['expositor']);
    global $conn;
    
    $id           = 1;
    $consultar_id = "select id from programa_capacitaciones where anio = '" . $anio_actual . "' and empresa = '" . $empresa . "' order by id desc limit 1";
    echo $consultar_id;
    $resultado = $conn->query($consultar_id);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'] + 1;
        }
    }
    
    
    $insertar = "insert into programa_capacitaciones Values ('" . $id . "', '" . $anio_actual . "', '" . $empresa . "', '" . $tema . "', '" . $expositor . "', '" . $fecha . "', '7000-01-01 00:00:00', '7000-01-01 00:00:00', '" . $duracion . "', '0', '0')";
    echo $insertar;
    $resultado = $conn->query($insertar);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        header('Location: ../programa_capacitaciones.php');
    }
    
}
?>
