<?php
session_start();
ob_start();
include ('../includes/conectar.php');

if (isset($_POST['modifica_imagen'])) {
    $id = $_POST['id'];
    $cod = str_pad($id, 3, '0', STR_PAD_LEFT);
    $anio = $_POST['anio'];
    $imagen = $_POST['imagen'];
    $correlativo = $_POST['correlativo'];
    $descripcion = strtoupper($_POST['descripcion']);
    $empresa = $_SESSION['empresa'];
    $modificar = "update imagenes_simulacro set correlativo = '" . $correlativo . "', descripcion = '" . $descripcion . "' where id = '" . $id . "' and anio = '".$anio."' and empresa = '".$empresa."' and imagen = '".$imagen."'";
    echo $modificar;
    $resultado = $conn->query($modificar);
    if ($resultado === TRUE) {
        header("Location: ../detalle_simulacro.php?id=".$id."&anio=".$anio);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die('Could not enter data: ' . mysqli_error($conn));
    }
    $conn->close();
}
ob_end_flush();
?>
