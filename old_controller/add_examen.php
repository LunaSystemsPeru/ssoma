<?php

session_start();
ob_start();
include ("../includes/conectar.php");
require("../includes/varios.php");
$varios = new Varios();

$empleado = $_POST['empleado'];
$empresa = $_SESSION['empresa'];
$evaluadora = strtoupper($_POST['evaluadora']);
$res_examen = strtoupper($_POST['resultados']);
$observaciones = strtoupper($_POST['observaciones']);
$fecha_evaluacion = $varios->fecha_mysql($_POST['fecha']);
$new_name = "";

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("doc", "docx", "pdf", "DOC", "DOCX", "PDF");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "application/msword") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || ($_FILES["file"]["type"] == "application/pdf")) && ($_FILES["file"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $estructura = "../upload/" . $empresa . "/examen/";
            if (!mkdir($estructura, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            $directorio = "../upload/" . $empresa . "/examen/";
            $new_name = $empleado . '-' . $fecha_evaluacion . '.' . $file_extension;

            if (move_uploaded_file($file_temporal, $directorio . $new_name)) {
                print "El archivo fue subido con éxito.";
            } else {
                print "Error al intentar subir el archivo.";
                $new_name = "";
            }
        }
    } else {
        echo "el archivo no cumple con las caracteristicas";
        echo $_FILES["file"]["type"];
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ningun documento";
}

global $conn;
$id_examen = 1;
$consultar_id = "select id from examen_medico where empleado = '" . $empleado . "' and empresa = '" . $empresa . "' order by id desc limit 1";
echo $consultar_id;
$resultado = $conn->query($consultar_id);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $id_examen = $fila['id'] + 1;
    }
}


$ins_examen = 'insert into examen_medico Values ("' . $id_examen . '", "' . $empleado . '", "' . $empresa . '", "' . $fecha_evaluacion . '", "' . $res_examen . '", "' . $observaciones . '", "' . $evaluadora . '", "' . $new_name . '")';
echo $ins_examen;
$resultado = $conn->query($ins_examen);
if (!$resultado) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    echo "Entered data successfully\n";
    header("Location: examen_medico.php?id=" . $empleado);
    //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
ob_end_flush();
?>			
