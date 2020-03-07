<?php

require '../models/ParametrosDetalle.php';
$parametrosDetalle = new ParametrosDetalle();

$parametrosDetalle->generarCodigo();
$parametrosDetalle->setNombre(strtoupper(filter_input(INPUT_POST, 'input_nombre')));
$parametrosDetalle->setValor(filter_input(INPUT_POST, 'input_valor'));
$parametrosDetalle->setIdParametro(filter_input(INPUT_POST, 'input_idParametro'));


$parametrosDetalle->insertar();

header("Location: ../contents/parametros_generales.php?id=" . $parametrosDetalle->getIdParametro());
