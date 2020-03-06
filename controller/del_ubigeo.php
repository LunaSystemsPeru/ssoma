<?php

   require '../models/Ubigeo.php';
  $ubigeo=new Ubigeo();



$ubigeo->setIdUbigeo(filter_input(INPUT_GET, 'input_idUbigeo'));



 $ubigeo->eliminar();
