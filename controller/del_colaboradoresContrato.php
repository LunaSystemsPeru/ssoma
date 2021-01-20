<?php

   require '../models/ColaboradoresContrato.php';
  $colaboradoresContrato=new ColaboradoresContrato();



$colaboradoresContrato->setIdContrato(filter_input(INPUT_GET, 'input_idContrato'));



 $colaboradoresContrato->eliminar();
