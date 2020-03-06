<?php

   require '../models/ParametrosGenerale.php';
  $parametrosGenerale=new ParametrosGenerale();



$parametrosGenerale->setIdParametro(filter_input(INPUT_POST, 'input_idParametro'));
$parametrosGenerale->setNombre(filter_input(INPUT_POST, 'input_nombre'));



 $parametrosGenerale->actualizar();
