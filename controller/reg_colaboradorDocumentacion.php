<?php

   require '../models/ColaboradorDocumentacion.php';
  $colaboradorDocumentacion=new ColaboradorDocumentacion();



$colaboradorDocumentacion->setIdAdjunto(filter_input(INPUT_POST, 'input_idAdjunto'));
$colaboradorDocumentacion->setNroOrden(filter_input(INPUT_POST, 'input_nroOrden'));
$colaboradorDocumentacion->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$colaboradorDocumentacion->setIdDocumento(filter_input(INPUT_POST, 'input_idDocumento'));



 $colaboradorDocumentacion->insertar();
