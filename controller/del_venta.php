<?php
session_start();

require '../models/Venta.php';
require '../models/VentaNota.php';

$venta =new Venta();
$ventanota = new VentaNota();

$ventanota->setIdNota(filter_input(INPUT_GET, 'codigo'));
$ventanota->eliminar();

$venta->setIdVenta(filter_input(INPUT_GET, 'codigo'));
$venta->eliminar();

header("Location: ../contents/ventas.php");