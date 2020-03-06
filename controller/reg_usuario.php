<?php

   require '../models/Usuario.php';
  $usuario=new Usuario();



$usuario->setIdUsuario(filter_input(INPUT_POST, 'input_idUsuario'));
$usuario->setIdEmpresa(filter_input(INPUT_POST, 'input_idEmpresa'));
$usuario->setUsername(filter_input(INPUT_POST, 'input_username'));
$usuario->setPassword(filter_input(INPUT_POST, 'input_password'));
$usuario->setDato(filter_input(INPUT_POST, 'input_dato'));
$usuario->setCelular(filter_input(INPUT_POST, 'input_celular'));
$usuario->setEmail(filter_input(INPUT_POST, 'input_email'));
$usuario->setFechaRegistro(filter_input(INPUT_POST, 'input_fechaRegistro'));
$usuario->setUltimoLogin(filter_input(INPUT_POST, 'input_ultimoLogin'));
$usuario->setEstado(filter_input(INPUT_POST, 'input_estado'));



 $usuario->insertar();
