<?php
session_start();
require '../models/Compra.php';

$compra = new Compra();

$compra->setIdEmpresa(filter_input(INPUT_POST,'select_empresas'));
$compra->setPeriodo(filter_input(INPUT_POST,'input_periodo'));
$compra->setFecha(filter_input(INPUT_POST,'input_fecha'));
$compra->setIdDocumento(filter_input(INPUT_POST,'select_documento'));
$compra->setSerie(filter_input(INPUT_POST,'input_serie'));
$compra->setNumero(filter_input(INPUT_POST,'input_numero'));
$compra->setIdProveedor(filter_input(INPUT_POST,'hidden_idproveedor'));
$compra->setTotal(filter_input(INPUT_POST,'input_total'));
$compra->setAfecto(filter_input(INPUT_POST,'select_afecto'));
$compra->setIdUsuario($_SESSION['usuario']);
$compra->generarCodigo();

$compra->insertar();

header("Location: ../contents/ver_compras.php");
