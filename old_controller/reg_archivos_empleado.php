<?php
session_start();
require '../class/cl_archivos_empleados.php';

$c_archivos = new cl_archivos_empleados();

$c_archivos->setId_empresa($_SESSION['empresa']);
$c_archivos->setId_empleado(filter_input(INPUT_POST, 'input_empleado'));
$c_archivos->setId_archivo($c_archivos->obtener_id());
$c_archivos->setNombre(filter_input(INPUT_POST, 'input_descripcion'));

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("doc", "docx", "pdf", "DOC", "DOCX", "PDF");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "application/msword") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || ($_FILES["file"]["type"] == "application/pdf")) && ($_FILES["file"]["size"] < 50000000) || in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $directorio = "../upload/" . $c_archivos->getId_empresa() . "/perfil/" . $c_archivos->getId_empleado() . "/documentos/";

            if (!file_exists($directorio)) {
                if (!mkdir($directorio, 0777, true)) {
                    $error = error_get_last();
                    echo $error['message'];
                }
            }

            $nuevo_nombre = $c_archivos->getId_archivo() . '.' . $file_extension;
            $c_archivos->setArchivo($nuevo_nombre);

            if (move_uploaded_file($file_temporal, $directorio . $nuevo_nombre)) {
                //echo "se guardo EL ARCHIVO, ahora se insertara a la base de datos";
                $c_archivos->insertar();
                
                header("Location: ../resumen_empleado.php?id=" . $c_archivos->getId_empleado());
            } else {
                echo "NO SE PUEDE GUARDAR EL ARCHIVO";
            }
        }
    } else {
        echo "el archivo no cumple con las caracteristicas";
        echo $_FILES["file"]["type"];
        //echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ningun documento";
}