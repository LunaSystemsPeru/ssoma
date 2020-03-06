<?php

session_start();
ob_start();
include ('../includes/conectar.php');
require('../includes/varios.php');
$varios = new Varios();

$empresa = $_SESSION['empresa'];

$id = $_POST['id'];
$anio = $_POST['anio'];
global $conn;

$modificar = "update programa_monitoreo set estado = '1' where id = '" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
echo $modificar;
$resultado = $conn->query($modificar);
if (!$resultado) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    //header('Location: ../programa_monitoreo.php');
}
ob_end_flush();
?>
