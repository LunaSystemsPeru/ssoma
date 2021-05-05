<?php
include '../fixed/iniciaSession.php';

require '../models/Documentacion.php';
$documentacion = new Documentacion();


$documentacion->generarCodigo();
$documentacion->setAreaDocumento(filter_input(INPUT_POST, 'select_areaDocumento'));
$documentacion->setTipoDocumento(filter_input(INPUT_POST, 'select_tipoDocumento'));
$documentacion->setNroDocumento(filter_input(INPUT_POST, 'input_nroDocumento'));
$documentacion->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$documentacion->setFechaCreacion(filter_input(INPUT_POST, 'input_fechaCreacion'));
$documentacion->setFechaModificacion($documentacion->getFechaCreacion());
$documentacion->setIdUsuario($_SESSION['usuario']);
$documentacion->setVersion(filter_input(INPUT_POST, 'input_version'));
$documentacion->setEstado(1);
$documentacion->setIdEmpresa($_SESSION['empresa']);

$ruc_empresa = $_SESSION['ruc_empresa'];

if (!empty($_FILES["file"])) {
    $file = $_FILES["file"];
    $filename = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    if ($file["error"] > 0) {
        die("Return Code: " . $file["error"] . "<br/><br/>");
    } else {
        //establecer directorio de subida
        $dir_subida = '../upload/' . $ruc_empresa . '/documentos/';

        if (!file_exists($dir_subida)) {
            if (!mkdir($dir_subida, 0777, true)) {
                die('Fallo al crear las carpetas...');
            }
        }

        //establecer nombre de archivo
        $documentacion->setExtension($file_extension);
        $nombre_archivo = $documentacion->getAreaDocumento() . $documentacion->getTipoDocumento() . $documentacion->getNroDocumento() . "." . $documentacion->getExtension();

        if (move_uploaded_file($file_temporal, $dir_subida . $nombre_archivo)) {
            //print "El archivo fue subido con éxito.";
            $documentacion->insertar();

            header("Location: ../contents/documentos.php");
        } else {
            print "Error al intentar subir el archivo.";
        }
    }
} else {
    print "no hay archivo seleccionado";
}