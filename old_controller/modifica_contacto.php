<?php
session_start();
ob_start();
include ('../includes/conectar.php');

if (isset($_POST['modificar_contacto'])) {
    $empresa = $_SESSION['empresa'];
    $empleado = $_POST['empleado'];
    $contacto = $_POST['contacto'];
    $nombres = strtoupper($_POST['nombres']);
    $direccion = strtoupper($_POST['direccion']);
    $telefono = $_POST['celular'];
    $sexo = $_POST['sexo'];
    $parentesco = strtoupper($_POST['parentesco']);

    $modificar_contacto = 'update contacto_emergencia set nombre_completo = "' . $nombres . '", telefono = "' . $telefono . '", sexo = "' . $sexo . '", parentesco = "' . $parentesco . '", direccion = "' . $direccion . '" where id = "' . $contacto . '" and empleado = "' . $empleado . '" and empresa = "' . $empresa . '"';
    echo $modificar_contacto;
    $resultado = $conn->query($modificar_contacto);
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
