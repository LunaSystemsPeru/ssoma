<?php

   require '../models/Ubigeo.php';
  $ubigeo=new Ubigeo();



$ubigeo->setIdUbigeo(filter_input(INPUT_POST, 'input_idUbigeo'));
$ubigeo->setDepartamento(filter_input(INPUT_POST, 'input_departamento'));
$ubigeo->setProvincia(filter_input(INPUT_POST, 'input_provincia'));
$ubigeo->setDistrito(filter_input(INPUT_POST, 'input_distrito'));
$ubigeo->setNombre(filter_input(INPUT_POST, 'input_nombre'));



 $ubigeo->actualizar();
