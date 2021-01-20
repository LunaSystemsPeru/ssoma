<?php

session_start();
ob_start();
include ('../includes/conectar.php');
require('../includes/varios.php');
$varios = new Varios();

if (isset($_POST['modificar_familiar'])) {
    $empresa = $_SESSION['empresa'];
    $empleado = $_POST['empleado'];
    $nro_dni = $_POST['nro_dni'];
    $nombres = strtoupper($_POST['nombres']);
    $direccion = strtoupper($_POST['direccion']);
    $telefono = $_POST['celular'];
    $sexo = $_POST['sexo'];
    $parentesco = strtoupper($_POST['parentesco']);
    $fecha_nacimiento = $varios->fecha_mysql($_POST['fecha_nacimiento']);
    $modificar_familiar = 'update datos_familiares set nombre_completo = "' . $nombres . '", fecha_nacimiento = "' . $fecha_nacimiento . '", telefono = "' . $telefono . '", sexo = "' . $sexo . '", parentesco = "' . $parentesco . '", direccion = "' . $direccion . '" where dni = "' . $nro_dni . '" and empleado = "' . $empleado . '" and empresa = "' . $empresa . '"';
    echo $modificar_familiar;
    $resultado = $conn->query($modificar_familiar);
    if ($resultado === TRUE) {
        header("Location: ../familia_empleado.php?id=" . $empleado);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        die('Could not enter data: ' . mysqli_error($conn));
    }
    $conn->close();
} else {
    echo "no hizo clic en el boton";
}
ob_end_flush();
?>
