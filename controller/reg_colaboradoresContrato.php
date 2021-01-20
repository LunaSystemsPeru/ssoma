<?php

require '../models/ColaboradoresContrato.php';
$colaboradoresContrato = new ColaboradoresContrato();

$colaboradoresContrato->generarCodigo();
$colaboradoresContrato->setFechaInicio(filter_input(INPUT_POST, 'input_fechaInicio'));
$colaboradoresContrato->setFechaFin("1001-01-01");
$colaboradoresContrato->setTipoContrato(filter_input(INPUT_POST, 'input_tipoContrato'));
$colaboradoresContrato->setIdColaborador(filter_input(INPUT_POST, 'input_idColaborador'));

$colaboradoresContrato->insertar();

header("Location: ../contents/resumen_empleado.php?id=" .$colaboradoresContrato->getIdColaborador());
