<?php

   require '../models/Documentacion.php';
  $documentacion=new Documentacion();



$documentacion->setIdDocumento(filter_input(INPUT_GET, 'input_idDocumento'));



 $documentacion->eliminar();
