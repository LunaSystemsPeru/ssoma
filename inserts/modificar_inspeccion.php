<?php

ob_start();
session_start();
include ("../includes/conectar.php");
include ("../includes/varios.php");

$varios = new Varios();

$empresa = $_SESSION['empresa'];
$id = $_POST['id'];
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];

$frecuencia = strtoupper($_POST['frecuencia']);
$fecha = $varios->fecha_mysql($_POST['fecha']);


$upd_inspeccion = "update programa_inspecciones set fecha_programa = '".$fecha."', frecuencia = '".$frecuencia."' where id='".$id."' and anio = '".$anio."' and empresa = '".$empresa."' and tipo = '".$tipo."'";
echo $upd_inspeccion;
$resultado = $conn->query($upd_inspeccion);
if (!$resultado) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    echo "Entered data successfully\n";
    header("Location: ../programa_inspecciones.php");
}
ob_end_flush();
?>			
