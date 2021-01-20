<?php
session_start();
$ruc_empresa = $_SESSION['ruc_empresa'];

require '../models/ColaboradoresAdjunto.php';
$colaboradoresAdjunto = new ColaboradoresAdjunto();

if (!empty($_FILES["file"])) {

    $colaboradoresAdjunto->setIdColaborador(filter_input(INPUT_POST, 'input_empleado'));
    $colaboradoresAdjunto->setFechaFirma(filter_input(INPUT_POST, 'input_fechaFirma'));
    $colaboradoresAdjunto->setIdAdjunto(filter_input(INPUT_POST, 'input_idAdjunto'));
    $colaboradoresAdjunto->generarCodigo();

//subir foto perfil
    $file = $_FILES["file"];
    $filename = $file['name'];
    $file_temporal = $file['tmp_name'];

    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    if ($file["error"] > 0) {
        die("Return Code: " . $file["error"] . "<br/><br/>");
    } else {
        //establecer directorio de subida
        $dir_subida = '../upload/' . $ruc_empresa . '/empleados/adjuntos/';
        if (!file_exists($dir_subida)) {
            if (!mkdir($dir_subida, 0777, true)) {
                die('Fallo al crear las carpetas...');
            }
        }

        //establecer nombre de archivo
        $nombre_archivo = $colaboradoresAdjunto->getIdColaborador() . "_" . $colaboradoresAdjunto->getIdAdjunto(). "_" . $colaboradoresAdjunto->getId() . "." . $file_extension;

        if (move_uploaded_file($file_temporal, $dir_subida . $nombre_archivo)) {
            //print "El archivo fue subido con éxito.";
        } else {
            print "Error al intentar subir el archivo.";
        }
    }

    $colaboradoresAdjunto->setArchivo($nombre_archivo);
    $colaboradoresAdjunto->insertar();

    header("Location: ../contents/resumen_empleado.php?id=" . $colaboradoresAdjunto->getIdColaborador());
} else {
    print "no hay archivo seleccionado";
}