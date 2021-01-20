<?php

ob_start();
session_start();
include ("../includes/conectar.php");

$empresa = $_SESSION['empresa'];
$nombres = strtoupper($_POST['nombres']);
$ape_pat = strtoupper($_POST['ape_pat']);
$ape_mat = strtoupper($_POST['ape_mat']);
$direccion = strtoupper($_POST['direccion']);
$sexo = $_POST['sexo'];
$telefono = $_POST['celular'];
$parentesco = strtoupper($_POST['parentesco']);
$empleado = $_POST['empleado'];
$nombre_completo = $ape_pat . ' ' . $ape_mat . ' ' . $nombres;

function obtenerid($empleado, $empresa) {
    $id = 1;
    $consultar_id = "select id from contacto_emergencia where empleado = '" . $empleado . "' and empresa = '" . $empresa . "' order by id desc limit 1";
    echo $consultar_id;
    $resultado = $conn->query($consultar_id);
    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'] + 1;
        }
    }
    return $id;
}

$id = obtenerid($empleado, $empresa);

$ins_familiar = "insert into contacto_emergencia values ('" . $id . "', '" . $empleado . "', '" . $empresa . "', '" . $nombre_completo . "', '" . $direccion . "', '" . $sexo . "', '" . $telefono . "', '" . $parentesco . "')";
$resultado = $conn->query($ins_familiar);
if (!$resultado) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    echo "Entered data successfully\n";
    header("Location: ../familia_empleado.php?id=" . $empleado);
}
ob_end_flush();
?>			
