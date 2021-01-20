<?php

session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:../login.php");
}
include("../includes/conectar.php");
require("../includes/varios.php");

$varios = new Varios();

$mes_actual = date("m");
$anio_actual = date("Y");

$empresa = $_SESSION['empresa'];

$id = $_POST['id'];
$anio = $_POST['anio'];

if (isset($_POST['modifica_simulacro'])) {

    $lugar = strtoupper($_POST['lugar']);
    $fecha_programa = $varios->fecha_hora_mysql($_POST['fecha_inicio']);
    $observador = $_POST['observador'];
    $tipo = $_POST['tipo'];
    $simulacion = strtoupper($_POST['simulacion']);
    $magnitud = strtoupper($_POST['magnitud']);
    $antes = strtoupper($_POST['antes']);
    $durante = strtoupper($_POST['durante']);
    $despues = strtoupper($_POST['despues']);
    $ayuda = strtoupper($_POST['ayuda']);
    global $conn;

    $actualizar = "update programa_simulacros set lugar =  '" . $lugar . "', observador = '" . $observador . "', fecha_programado = '" . $fecha_programa . "', tipo = '" . $tipo . "', simulacion_creada = '" . $simulacion . "', magnitud = '" . $magnitud . "', antes = '" . $antes . "', durante = '" . $durante . "', despues = '" . $despues . "', externo = '" . $ayuda . "' where id = '" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
    echo $actualizar;
    $resultado = $conn->query($actualizar);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        header('Location: ../programa_simulacros.php');
    }
}
?>
