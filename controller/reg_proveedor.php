<?php
require '../models/Proveedor.php';

$proveedor = new Proveedor();

$proveedor->generarCodigo();
$proveedor->setRuc(filter_input(INPUT_POST, 'input_documento'));
$proveedor->setRazon(filter_input(INPUT_POST, 'input_razon_social'));
$proveedor->setDireccion(filter_input(INPUT_POST, 'input_direccion'));

$proveedor->insertar();

header("Location: ../contents/proveedores.php");