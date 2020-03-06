<?php

session_start();
ob_start();
include ("../includes/conectar.php");
require("../includes/varios.php");
$varios = new Varios();

$empresa = $_SESSION['empresa'];
$usuario = $_SESSION['usuario'];
$anio = $_POST['anio'];
$id = $_POST['id'];
$tipo_archivo = strtoupper($_POST['tipo_archivo']);

$new_name = "";

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("doc", "docx", "pdf", "DOC", "DOCX", "PDF", "ppt", "pptx", "PPT", "PPTX");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "application/msword") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || ($_FILES["file"]["type"] == "application/pdf")) && ($_FILES["file"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $cod = str_pad($id, 3, '0', STR_PAD_LEFT);
            $directorio = "../upload/" . $empresa . "/simulacros/" . $anio . $cod . "/archivos/";
            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }

            if (move_uploaded_file($file_temporal, $directorio . $file)) {
                print "El archivo fue subido con éxito.";
                $ins_archivo = 'insert into archivos_capacitaciones Values ("' . $id . '", "' . $anio . '", "' . $empresa . '", "' . $usuario . '", now(), "' . $file . '", "' . $tipo_archivo . '")';
                echo $ins_archivo;
                $resultado = $conn->query($ins_archivo);
                if (!$resultado) {
                    die('Could not enter data: ' . mysqli_error($conn));
                } else {
                    echo "Entered data successfully\n";
                    header("Location: ../detalle_simulacro.php?id=" . $id . "&anio=" . $anio);
                    //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
                }
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
ob_end_flush();
?>			
