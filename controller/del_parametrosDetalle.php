<?php

   require '../models/ParametrosDetalle.php';
  $parametrosDetalle=new ParametrosDetalle();



$parametrosDetalle->setIdDetalle(filter_input(INPUT_GET, 'input_idDetalle'));



 $parametrosDetalle->eliminar();
