<?php
require '../models/Banco.php';

$banco = new Banco();

$banco->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$banco->setCuenta(filter_input(INPUT_POST, 'input_cuenta'));
$banco->setIdEmpresa(filter_input(INPUT_POST, 'select_empresa'));
$banco->generarCodigo();

$banco->insertar();

header("Location: ../contents/bancos.php");