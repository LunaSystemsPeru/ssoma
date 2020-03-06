<?php

   require '../models/DocumentacionVersion.php';
  $documentacionVersion=new DocumentacionVersion();



$documentacionVersion->setIdVersion(filter_input(INPUT_POST, 'input_idVersion'));
$documentacionVersion->setDescripcion(filter_input(INPUT_POST, 'input_descripcion'));
$documentacionVersion->setFechaModificacion(filter_input(INPUT_POST, 'input_fechaModificacion'));
$documentacionVersion->setVersion(filter_input(INPUT_POST, 'input_version'));
$documentacionVersion->setIdUsuario(filter_input(INPUT_POST, 'input_idUsuario'));
$documentacionVersion->setIdDocumento(filter_input(INPUT_POST, 'input_idDocumento'));



 $documentacionVersion->insertar();
