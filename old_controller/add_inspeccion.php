<?php

ob_start();
session_start();
include ("../includes/conectar.php");
include("../includes/varios.php");
$varios = new Varios();
$empresa = $_SESSION['empresa'];
$id = $_POST['id'];
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];

$local = strtoupper($_POST['local']);
$area = strtoupper($_POST['area']);
$inspector = $_POST['inspector'];
$fecha = $varios->fecha_mysql($_POST['fecha']);

switch ($tipo) {
    case "EPP":
        function obtener_id() {
            global $conn;
            $item = 1;
            $consulta = "select item from inspecciones_epp where id = '" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
            $resultado = $conn->query($consulta);
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $item = $fila['item'] + 1;
                }
            }
            return $item;
        }

        $item = obtener_id();
        $ins_inspeccion = "insert into inspeccion_epp values ('" . $id . "', '" . $anio . "', '" . $empresa . "', '" . $item . "','" . $fecha . "', '" . $inspector . "', '" . $area . "', '" . $local . "', '-', '0')";
        $resultado = $conn->query($ins_inspeccion);
        if (!$resultado) {
            die('Could not enter data: ' . mysqli_error($conn));
        } else {
            echo "Entered data successfully\n";
            header("Location: ../inspeccion_epp.php?id=" . $id . "&anio=" . $anio . "&tipo=" . $tipo);
        }
        break;
    case "ORDEN Y LIMPIEZA":
        echo "i es igual a 1";
        break;
    case "ALMACEN":
        function obtener_id() {
            global $conn;
            $item = 1;
            $consulta = "select item from inspecciones_almacen where id = '" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
            $resultado = $conn->query($consulta);
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $item = $fila['item'] + 1;
                }
            }
            return $item;
        }

        $item = obtener_id();
        $ins_inspeccion = "insert into inspeccion_almacen values ('" . $id . "', '" . $anio . "', '" . $empresa . "', '" . $item . "','" . $fecha . "', '" . $inspector . "', '" . $area . "', '" . $local . "', '-', '0')";
        $resultado = $conn->query($ins_inspeccion);
        if (!$resultado) {
            die('Could not enter data: ' . mysqli_error($conn));
        } else {
            echo "Entered data successfully\n";
            header("Location: ../inspeccion_almacen.php?id=" . $id . "&anio=" . $anio);
        }
        break;
}

ob_end_flush();
?>			
