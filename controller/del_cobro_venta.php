<?php
require '../models/VentaCobro.php';
require '../models/BancoMovimiento.php';

$cobro = new VentaCobro();
$movimiento = new BancoMovimiento();

$cobro->setIdVenta(filter_input(INPUT_GET, 'idventa'));
$cobro->setIdMovimiento(filter_input(INPUT_GET, 'idmovimiento'));
$cobro->eliminar();

$movimiento->setIdMovimiento(filter_input(INPUT_GET, 'idmovimiento'));
$movimiento->eliminar();

header("Location: ../contents/detalle_venta.php?idventa=" . $cobro->getIdVenta());