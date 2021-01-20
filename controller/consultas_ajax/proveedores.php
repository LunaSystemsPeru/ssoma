<?php
require_once '../../models/Proveedor.php';

$proveedor = new Proveedor();
$array = array();

foreach ($proveedor->verFilas() as $fila) {
    $array[] = array(
        "id" => $fila['id_proveedor'],
        "value" => $fila['ruc'] . " | " . $fila['razon_social'],
        "ruc" => $fila['ruc'],
        "razon" => $fila['razon_social'],
        "label" => $fila['ruc'] . " | " . $fila['razon_social']
    );
}

echo json_encode($array);