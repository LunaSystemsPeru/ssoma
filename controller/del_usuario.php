<?php

   require '../models/Usuario.php';
  $usuario=new Usuario();



$usuario->setIdUsuario(filter_input(INPUT_GET, 'input_idUsuario'));



 $usuario->eliminar();
