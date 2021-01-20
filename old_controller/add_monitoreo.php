<?php

session_start();
ob_start();
include ('../includes/conectar.php');
require('../includes/varios.php');
$varios = new Varios();

$empresa = $_SESSION['empresa'];

$fecha = $varios->fecha_mysql($_POST['fecha_inicio']);
$proveedor = $_POST['proveedor'];
$tipo = $_POST['tipo'];
$anio_actual = date("Y");

function obtener_id ($anio, $empresa) {
    $id           = 1;
    global  $conn;
    $consultar_id = "select id from programa_monitoreo where anio = '" . $anio . "' and empresa = '" . $empresa . "' order by id desc limit 1";
    echo $consultar_id;
    $resultado = $conn->query($consultar_id);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'] + 1;
        }
    }
    return $id;
}
$id = obtener_id($anio_actual, $empresa);
$add_monitoreo = "insert into programa_monitoreo Values ('".$id."', '".$anio_actual."', '".$empresa."', '".$fecha."', '2016-01-01', '".$proveedor."', '".$tipo."', '0')";
echo $add_monitoreo;
$r_monitoreo = $conn->query($add_monitoreo);
if (!$r_monitoreo) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    header('Location: ../programa_monitoreo.php');
}
ob_end_flush();
?>
