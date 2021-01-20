<?php
require '../models/Venta.php';

$venta = new Venta();

if (filter_input(INPUT_GET, 'idventa')) {
    $venta->setIdVenta(filter_input(INPUT_GET, 'idventa'));
    $venta->cerrarPago();
    header("Location: ../contents/detalle_venta.php?idventa=" .$venta->getIdVenta());
}