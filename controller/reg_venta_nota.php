<?php
include '../fixed/iniciaSession.php';
require_once '../models/Venta.php';
require_once '../models/Empresa.php';
require_once '../models/VentaNota.php';

$nota = new Venta();
$venta = new Venta();
$empresa = new Empresa();
$ventanota = new VentaNota();

$venta->setIdVenta(filter_input(INPUT_POST, 'hidden_idventa'));
$venta->obtenerDatos();

$nota->generarCodigo();
$nota->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$nota->setIdCliente($venta->getIdCliente());
$nota->setIdDocumento(36);
$nota->setSerie("E001");
$nota->setNumero(filter_input(INPUT_POST, 'input_numero'));
$nota->setTotal($venta->getTotal() * -1);
$nota->setAfecto(2);
$nota->setIdEmpresa($venta->getIdEmpresa());
$nota->setDescripcion("ANULACION DE " . $venta->getDescripcion());
$nota->setDetraccion(0);
$nota->setIdUsuario($_SESSION['usuario']);


$empresa->setIdEmpresa($venta->getIdEmpresa());
$empresa->obtenerDatos();

if (!empty($_FILES["input_archivo"])) {
    $file = $_FILES["input_archivo"];
    $filename = $file['name'];
    $file_temporal = $file['tmp_name'];

    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    if ($file["error"] > 0) {
        //die("Return Code: " . $file["error"] . "<br/><br/>");
    } else {
        //establecer directorio de subida
        $dir_subida = '../upload/' . $empresa->getRuc() . '/ventas/';
        if (!file_exists($dir_subida)) {
            if (!mkdir($dir_subida, 0777, true)) {
                die('Fallo al crear las carpetas...');
            }
        }

        //establecer nombre de archivo
        $nombre_archivo = $nota->getIdVenta() . "." . $file_extension;
        $nota->setAdjunto($nombre_archivo);

        if (move_uploaded_file($file_temporal, $dir_subida . $nombre_archivo)) {
            //print "El archivo fue subido con éxito.";
        } else {
            //print "Error al intentar subir el archivo.";
        }
    }
} else {
    //print "no hay archivo seleccionado";
}

$nota->insertar();

$ventanota->setIdNota($nota->getIdVenta());
$ventanota->setIdVenta($venta->getIdVenta());
$ventanota->insertar();



header("Location: ../contents/ventas.php");