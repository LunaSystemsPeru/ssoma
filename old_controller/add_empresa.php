<?php

ob_start();
include ("../includes/conectar.php");

$registro_aceptado = false;

if (isset($_POST['ruc']) && isset($_POST['razon_social']) && isset($_POST['direccion'])) {
    $ruc = $_POST['ruc'];
    $raz_soc = strtoupper($_POST['razon_social']);
    $direccion = strtoupper($_POST['direccion']);
    $telefono = $_POST['telefono'];

    $empresa_registrada = false;

    //registrar empresa
    $add_empresa = "insert into empresa Values ('" . $ruc . "','" . $raz_soc . "', '" . $direccion . "', 'noimage.jpg', '1', current_date())";
    $resultado = $conn->query($add_empresa);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        //echo "<p>Empresa registrada </p>";
        $empresa_registrada = true;
    }
    //$resultado -> close();

    $nick = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $email = $_POST['email'];
    $usu_telefono = $_POST['user_telefono'];
    $ape_pat = strtoupper($_POST['ape_pat']);
    $ape_mat = strtoupper($_POST['ape_mat']);
    $nombres = strtoupper($_POST['nombres']);

    global $registro_aceptado;
    if ($empresa_registrada == true) {
        //registrar usuario
        $add_empresa = "insert into usuario Values ('" . $ruc . "', '" . $nick . "','" . $ape_pat . "','" . $ape_mat . "','" . $nombres . "','" . $usu_telefono . "', '" . $contrasena . "', current_date(), '2020-01-01', '" . $email . "', '1')";
        $resultado = $conn->query($add_empresa);
        if (!$resultado) {
            die('Could not enter data: ' . mysqli_error($conn));
        } else {
            //echo "<p>usuario registrado</p>";
            $registro_aceptado = true;
        }
    }

    if ($registro_aceptado == true) {
        header("Location: ../empresas.php");
    }
    //enviar mail de confirmacion
}
ob_end_flush();
?>
