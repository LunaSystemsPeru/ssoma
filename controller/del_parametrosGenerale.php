<?php

   require '../models/ParametrosGenerale.php';
  $parametrosGenerale=new ParametrosGenerale();



$parametrosGenerale->setIdParametro(filter_input(INPUT_GET, 'input_idParametro'));



 $parametrosGenerale->eliminar();
