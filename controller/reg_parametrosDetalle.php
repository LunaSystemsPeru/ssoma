<?php

   require '../models/ParametrosDetalle.php';
  $parametrosDetalle=new ParametrosDetalle();



$parametrosDetalle->setIdDetalle(filter_input(INPUT_POST, 'input_idDetalle'));
$parametrosDetalle->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$parametrosDetalle->setValor(filter_input(INPUT_POST, 'input_valor'));
$parametrosDetalle->setIdParametro(filter_input(INPUT_POST, 'input_idParametro'));



 $parametrosDetalle->insertar();
