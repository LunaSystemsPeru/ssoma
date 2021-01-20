<?php

   require '../models/Empresa.php';
  $empresa=new Empresa();



$empresa->setIdEmpresa(filter_input(INPUT_GET, 'input_idEmpresa'));



 $empresa->eliminar();
