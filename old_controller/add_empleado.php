<?php

session_start();
ob_start();
include ("../includes/conectar.php");

function reformatDate($date, $from_format = 'd/m/Y', $to_format = 'Y-m-d') {
    $date_aux = date_create_from_format($from_format, $date);
    return date_format($date_aux, $to_format);
}

$codigo = $_POST['codigo'];
$dni = $_POST['nro_dni'];
$empresa = $_SESSION['empresa'];
$nombres = strtoupper($_POST['nombres']);
$direccion = strtoupper($_POST['direccion']);
$email = strtoupper($_POST['email']);
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$fecha_nacimiento_db = reformatDate($fecha_nacimiento, 'd/m/Y', 'Y-m-d');
$grupo_sanguineo = $_POST['grupo_sanguineo'];
$factor_sanguineo = $_POST['factor_sanguineo'];
$celular = $_POST['celular'];
$estado_civil = $_POST['estado_civil'];
$categoria = $_POST['categoria'];
$cargo = $_POST['cargo'];
$jornal = $_POST['jornal'];
$especializacion = $_POST['especializacion'];
$seguro_pension = $_POST['input_id_seguro'];
$fecha_afiliacion = $_POST['fecha_afiliacion'];
$fecha_afiliacion_db = reformatDate($fecha_afiliacion, 'd/m/Y', 'Y-m-d');
$cuspp = strtoupper($_POST['cuspp']);
$tipo_seguro = $_POST['input_id_comision'];
$renta_5ta = $_POST['renta_5ta'];
$fecha_ingreso_db = reformatDate($_POST['fecha_ingreso'], 'd/m/Y', 'Y-m-d');
$departamento = $_POST['id_departamento'];
$provincia = $_POST['id_provincia'];
$distrito = $_POST['id_distrito'];
$new_name = "noimage.png";

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("jpeg", "jpg", "png", "JPG", "JPEG", "PNG");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 1000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $estructura = "../upload/" . $empresa . "/perfil/";
            if (!mkdir($estructura, 0777, true)) {
                // die('Fallo al crear las carpetas...');
            }
            $directorio = "../upload/" . $empresa . "/perfil/";
            $new_name = $codigo . '.' . $file_extension;

            if (move_uploaded_file($file_temporal, $directorio . $new_name)) {
                print "El archivo fue subido con éxito.";
            } else {
                print "Error al intentar subir el archivo.";
                $new_name = "noimage.png";
            }
        }
    } else {
        echo "imagen no cumple con las caracteristicas";
        echo $_FILES["file"]["type"];
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ninguna imagen";
}

global $conn;
$ins_empleado = 'insert into empleado Values ("' . $codigo . '", "' . $empresa . '", "' . $dni . '", "' . $nombres . '", "' . $direccion . '", '
        . '"' . $distrito . '", "' . $provincia . '", "' . $departamento . '", "' . $email . '", "' . $fecha_nacimiento_db . '", "' . $celular . '", "' . $estado_civil . '", '
        . '"' . $categoria . '", "' . $jornal . '", "' . $cargo . '", "' . $fecha_ingreso_db . '", "' . $especializacion . '", "' . $seguro_pension . '", "' . $fecha_afiliacion_db . '", '
        . '"' . $cuspp . '", "' . $tipo_seguro . '", "' . $grupo_sanguineo . '", "' . $factor_sanguineo . '", "' . $renta_5ta . '", "' . $new_name . '", "1")';
//echo $ins_empleado;
$resultado = $conn->query($ins_empleado);
if (!$resultado) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    echo "Entered data successfully\n";
    header("Location: ../empleados.php");
    //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
ob_end_flush();
?>			
