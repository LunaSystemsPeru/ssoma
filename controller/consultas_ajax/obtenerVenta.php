<?php
require '../../models/Venta.php';

$venta = new Venta();

$venta->setIdVenta(filter_input(INPUT_POST, 'idventa'));
$venta->obtenerDatos();

$array = array(
    "fecha" => $venta->getFecha(),
    "monto_total" => $venta->getTotal(),
    "monto_pagado" => $venta->getPagado()
    );

echo json_encode($array);