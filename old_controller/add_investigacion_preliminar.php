<?php

session_start();
ob_start();
include ("../includes/conectar.php");
require("../includes/varios.php");
$varios = new Varios();

$id = 1;
$anio = date("Y");
$empresa = $_SESSION['empresa'];
$usuario = $_SESSION['usuario'];
$consecuencia = $_POST['consecuencia'];
$tipo_accidente = $_POST['tipo_accidente'];
$fecha = $varios->fecha_mysql($_POST['fecha']);
$hora = $_POST['hora'];
$involucrado = $_POST['involucrado'];
$ubicacion = strtoupper($_POST['ubicacion']);
$area = strtoupper($_POST['area']);
$evento = strtoupper($_POST['evento']);
$perdida = strtoupper($_POST['perdida']);
$causas_inmediatas = strtoupper($_POST['causas_inmediatas']);
$causas_basicas = $_POST['causas_basicas'];
$acciones_inmediatas = $_POST['acciones_inmediatas'];
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

$buscar_id = "select id from preliminar_incidente where anio = '" . $anio . "' and empresa = '" . $empresa . "'";
echo $buscar_id;
$resultado = $conn->query($buscar_id);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $id = $fila['id'] + 1;
    }
}


$ins_investigacion = 'insert into preliminar_incidente Values ("' . $id . '", "' . $anio . '", "' . $empresa . '", "' . $tipo_accidente . '", "' . $consecuencia . '", "' . $fecha . '", "' . $hora . '", "' . $ubicacion . '", "' . $involucrado . '", "' . $usuario . '", "' . $area . '", "' . $evento . '", "' . $perdida . '", "' . $causas_inmediatas . '", "' . $causas_basicas . '", "' . $acciones_inmediatas . '", "1")';
echo $ins_investigacion;
$resultado = $conn->query($ins_investigacion);
if (!$resultado) {
    die('Could not enter data: ' . mysqli_error($conn));
} else {
    echo "Entered data successfully\n";
    header("Location: ../preliminar_incidentes.php");
    //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
ob_end_flush();
?>			
