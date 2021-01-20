<?php

session_start();
ob_start();
include ('../includes/conectar.php');

if (isset($_POST['enviar'])) {
    $id_epp = $_POST['array_idepp'];
    $empresa = $_SESSION["empresa"];
    $empleado = $_POST['id_empleado'];

    $items_epp = json_decode($id_epp, true);

    $elementCount = count($items_epp);

    $fecha = $_POST['fecha_entrega'];

    function fecha_db($date) {
        $from_format = 'd/m/Y';
        $to_format = 'Y-m-d';
        $date_aux = date_create_from_format($from_format, $date);
        return date_format($date_aux, $to_format);
    }

    $fecha_entrega = fecha_db($fecha);

    $id_entrega = 1;
    //selecciona ultimo id_entrega
    $ver_identrega = "select id from historial_epp where empresa = '" . $empresa . "' and empleado = '" . $empleado . "' order by id desc limit 1";
    $resultado = $conn->query($ver_identrega);
    if ($resultado->num_rows > 0) {
        if ($fila = $resultado->fetch_assoc()) {
            $id_entrega = $fila['id'] + 1;
        }
    }

    //crear historial_epp
    $ins_historial = "insert into historial_epp Values ('" . $id_entrega . "', '" . $empresa . "', '" . $empleado . "', '" . $fecha_entrega . "')";
    $insertando = $conn->query($ins_historial);
    if (!$insertando) {
        die('Could not enter data: ' . mysqli_error());
    }

    for ($x = 0; $x < $elementCount; $x++) {
        $query = "update detalle_historial_epp set estado = '1', fecha_devolucion = '" . $fecha_entrega . "' "
                . "where epp = '" . $items_epp [$x] . "' and empresa = '" . $empresa . "' and empleado = '" . $empleado . "' and estado = '0' ";
        $r_update = $conn->query($query);
        if (!$r_update) {
            die('Could not delete data from entrega_epp: ' . mysqli_error($conn));
        }
        
        global $conn;
        $ins_detalle = "insert into detalle_historial_epp Values ('" . $id_entrega . "', '" . $empresa . "', '" . $empleado . "', '" . $items_epp [$x] . "', '7000-01-01', '0')";
        $insertando = $conn->query($ins_detalle);
        if (!$insertando) {
            die('Could not enter data: ' . mysqli_error());
        }
    }
    echo'<script type="text/javascript">
		window.location="../epp_empleados.php?id=' . $empleado . '";
		</script>';
}
ob_end_flush();
?>
