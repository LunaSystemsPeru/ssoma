<?php

session_start();
ob_start();
include ('../includes/conectar.php');
include('../includes/varios.php');
$varios = new Varios();

$empresa = $_SESSION['empresa'];

if (isset($_POST['graba_fin'])) {


    $id = $_POST['id'];
    $anio = $_POST['anio'];
    $cantidad = $_POST['cantidad'];
    $fecha_inicio = $varios->fecha_hora_segundos_mysql($_POST['fecha_capacitacion'] . ' ' . $_POST['hora_inicio']);
    $fecha_fin = $varios->fecha_hora_segundos_mysql($_POST['fecha_capacitacion'] . ' ' . $_POST['hora_fin']);
    global $conn;

    $modificar = "update programa_capacitaciones set asistentes = '" . $cantidad . "', fecha_ejecutado = '" . $fecha_inicio . "', fecha_fin = '" . $fecha_fin . "', estado = '1' where id = '" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
    echo $modificar;
    $resultado = $conn->query($modificar);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        //	header('Location: ../programa_capacitaciones.php');
    }
}
ob_end_flush();
?>
