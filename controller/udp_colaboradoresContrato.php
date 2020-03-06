<?php

   require '../models/ColaboradoresContrato.php';
  $colaboradoresContrato=new ColaboradoresContrato();



$colaboradoresContrato->setIdContrato(filter_input(INPUT_POST, 'input_idContrato'));
$colaboradoresContrato->setFechaInicio(filter_input(INPUT_POST, 'input_fechaInicio'));
$colaboradoresContrato->setFechaFin(filter_input(INPUT_POST, 'input_fechaFin'));
$colaboradoresContrato->setTipoContrato(filter_input(INPUT_POST, 'input_tipoContrato'));
$colaboradoresContrato->setIdColaborador(filter_input(INPUT_POST, 'input_idColaborador'));



 $colaboradoresContrato->actualizar();
