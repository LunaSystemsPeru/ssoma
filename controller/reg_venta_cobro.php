<?php
session_start();

require '../models/BancoMovimiento.php';
require '../models/Venta.php';
require '../models/VentaCobro.php';

$movimiento = new BancoMovimiento();
$venta = new Venta();
$cobro = new VentaCobro();

$venta->setIdVenta(filter_input(INPUT_POST,'hidden_idventa'));
$venta->obtenerDatos();

$documento = "BL";

if ($venta->getIdDocumento() == 1) {
    $documento = "FT";
}

$movimiento->generarCodigo();
$movimiento->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$movimiento->setIdClasificacion(33);
$movimiento->setDescripcion("COBRO DE " . $documento . " | " . $venta->getSerie() . " - " . $venta->getNumero());
$movimiento->setIngresa(filter_input(INPUT_POST, 'input_pagar'));
$movimiento->setEgresa(0);
$movimiento->setIdBanco(filter_input(INPUT_POST, 'select_banco'));
$movimiento->setIdUsuario($_SESSION['usuario']);

$movimiento->insertar();

$cobro->setIdVenta($venta->getIdVenta());
$cobro->setIdMovimiento($movimiento->getIdMovimiento());
$cobro->setMonto($movimiento->getIngresa());

$cobro->insertar();

header("Location: ../contents/detalle_venta.php?idventa=" . $venta->getIdVenta());
