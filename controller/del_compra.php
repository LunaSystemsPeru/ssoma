<?php
session_start();

require '../models/Compra.php';

$compra =new Compra();

$compra->setIdCompra(filter_input(INPUT_GET, 'codigo'));
$compra->eliminar();

header("Location: ../contents/compras.php");