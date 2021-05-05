<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../fixed/iniciaSession.php';

require '../models/Venta.php';
require '../models/Cliente.php';
require '../models/Empresa.php';
require '../tools/varios.php';

$venta = new Venta();
$empresa = new Empresa();
$cliente = new Cliente();
$varios = new Varios();

if (filter_input(INPUT_POST, 'hidden_idventa')) {
    $venta->setIdVenta(filter_input(INPUT_POST, 'hidden_idventa'));
} else {
    $venta->generarCodigo();
}
$venta->setIdEmpresa(filter_input(INPUT_POST, 'select_empresas'));
$venta->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$venta->setIdCliente(filter_input(INPUT_POST, 'select_cliente'));
$venta->setIdDocumento(filter_input(INPUT_POST, 'select_documento'));
$venta->setNumero(filter_input(INPUT_POST, 'input_numero'));
$venta->setSerie(filter_input(INPUT_POST, 'select_serie'));
$venta->setTotal(filter_input(INPUT_POST, 'input_total'));
$venta->setAfecto(filter_input(INPUT_POST, 'select_afecto'));
$venta->setIdUsuario($_SESSION['usuario']);
$venta->setDescripcion(filter_input(INPUT_POST, 'input_servico'));
$venta->setDescripcion(strtoupper($venta->getDescripcion()));
$venta->setAnexo(filter_input(INPUT_POST, 'input_observaciones'));
$venta->setDetraccion(filter_input(INPUT_POST, 'input_detraccion'));

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
        $nombre_archivo = $venta->getIdVenta() . "." . $file_extension;
        $venta->setAdjunto($nombre_archivo);

        if (move_uploaded_file($file_temporal, $dir_subida . $nombre_archivo)) {
            //print "El archivo fue subido con éxito.";
        } else {
            //print "Error al intentar subir el archivo.";
        }
    }
} else {
    //print "no hay archivo seleccionado";
}


if (filter_input(INPUT_POST, 'hidden_idventa')) {
    $venta->modificar();
} else {
    $venta->insertar();
}

$periodo = $varios->fecha_periodo($venta->getFecha());
if (filter_input(INPUT_POST, 'hidden_idventa')) {
    header("Location: ../contents/detalle_venta.php?idventa=".$venta->getIdVenta());
} else {
    header("Location: ../contents/ventas.php?id_empresa=".$venta->getIdEmpresa()."&periodo=" . $periodo);
}
