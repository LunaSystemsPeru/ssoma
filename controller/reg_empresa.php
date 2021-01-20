<?php

require '../models/Empresa.php';
$empresa = new Empresa();

$empresa->generarCodigo();
$empresa->setRuc(filter_input(INPUT_POST, 'input_documento'));
$empresa->setRazon(filter_input(INPUT_POST, 'input_razon_social'));
$empresa->setDireccion(filter_input(INPUT_POST, 'input_direccion'));
$empresa->setUsuariosunat(filter_input(INPUT_POST, 'input_usunat'));
$empresa->setClavesunat(filter_input(INPUT_POST, 'input_csunat'));

//subir foto perfil
if (!empty($_FILES["file_lado1"])) {
    $file = $_FILES["file_lado1"];
    $filename = $file['name'];
    $file_temporal = $file['tmp_name'];

    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    if ($file["error"] > 0) {
        //die("Return Code: " . $file["error"] . "<br/><br/>");
    } else {
        //establecer directorio de subida
        $dir_subida = '../upload/' . $empresa->getRuc() . '/';
        if (!file_exists($dir_subida)) {
            if (!mkdir($dir_subida, 0777, true)) {
                die('Fallo al crear las carpetas...');
            }
        }

        //establecer nombre de archivo
        $nombre_archivo = $empresa->getRuc() . "." . $file_extension;
        $empresa->setLogo($nombre_archivo);

        if (move_uploaded_file($file_temporal, $dir_subida . $nombre_archivo)) {
            //print "El archivo fue subido con éxito.";
        } else {
            print "Error al intentar subir el archivo.";
        }
    }
} else {
    print "no hay archivo seleccionado";
}

$empresa->insertar();

header("Location: ../contents/empresas.php");
