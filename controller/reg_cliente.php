<?php
require '../models/Cliente.php';

$cliente = new Cliente();

$cliente->generarCodigo();
$cliente->setRuc(filter_input(INPUT_POST, 'input_documento'));
$cliente->setRazon(filter_input(INPUT_POST, 'input_razon_social'));
$cliente->setDireccion(filter_input(INPUT_POST, 'input_direccion'));

$cliente->insertar();

header("Location: ../contents/clientes.php");