<?php

ob_start();
include ('../includes/conectar.php');
require('../includes/varios.php');

$varios = new Varios();

if (isset($_POST['devolver_epp'])) {
    $id_entrega = $_POST['id_entrega'];
    $id_epp = $_POST['id_epp'];
    $id_empresa = $_POST['id_empresa'];
    $id_empleado = $_POST['id_empleado'];
    $fecha_entrega = $varios->fecha_mysql($_POST['fecha_devolucion']);

    $devolver = 'update detalle_historial_epp set fecha_devolucion = "' . $fecha_entrega . '" , estado = "1" where id = "' . $id_entrega . '" and empresa = "' . $id_empresa . '" and empleado = "' . $id_empleado . '" and epp = "' . $id_epp . '"';
    $resultado = $conn->query($devolver);
    if ($resultado === TRUE) {
        header("Location: ../epp_empleados.php?id=" . $id_empleado);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die('Could not enter data: ' . mysqli_error($conn));
    }
    $conn->close();
}
ob_end_flush();
?>
