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
if (isset($_POST['graba_simulacro'])) {

    $lugar = strtoupper($_POST['lugar']);
    $fecha_programa = $varios->fecha_mysql($_POST['fecha_inicio']) . ' ' . $_POST['hora_inicio'];
    $observador = $_POST['observador'];
    $tipo = $_POST['tipo'];
    $simulacion = strtoupper($_POST['simulacion']);
    $magnitud = strtoupper($_POST['magnitud']);
    $antes = strtoupper($_POST['antes']);
    $durante = strtoupper($_POST['durante']);
    $despues = strtoupper($_POST['despues']);
    $ayuda = strtoupper($_POST['ayuda_externa']);
    global $conn;

    function obtener_id($anio, $empresa) {
        $id = 1;
        global $conn;
        $consultar_id = "select id from programa_simulacros where anio = '" . $anio . "' and empresa = '" . $empresa . "' order by id desc limit 1";
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

    $insertar = "insert into programa_simulacros Values ('" . $id . "', '" . $anio_actual . "', '" . $empresa . "', '" . $lugar . "', '" . $observador . "', '" . $fecha_programa . "', '7000-01-01 00:00:00', '7000-01-01 00:00:00', '" . $tipo . "', '" . $simulacion . "', '" . $magnitud . "', '" . $antes . "', '" . $durante . "', '" . $despues . "', '" . $ayuda . "', '', '', '', '', '0')";
    echo $insertar;
    $resultado = $conn->query($insertar);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        header('Location: ../programa_simulacros.php');
    }
}
?>
