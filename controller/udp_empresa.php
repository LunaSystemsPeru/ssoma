<?php

   require '../models/Empresa.php';
  $empresa=new Empresa();



$empresa->setIdEmpresa(filter_input(INPUT_POST, 'input_idEmpresa'));
$empresa->setRuc(filter_input(INPUT_POST, 'input_ruc'));
$empresa->setRazonSocial(filter_input(INPUT_POST, 'input_razonSocial'));
$empresa->setDireccion(filter_input(INPUT_POST, 'input_direccion'));
$empresa->setLogo(filter_input(INPUT_POST, 'input_logo'));
$empresa->setFechaRegistro(filter_input(INPUT_POST, 'input_fechaRegistro'));



 $empresa->actualizar();
