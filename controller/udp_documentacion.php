<?php

   require '../models/Documentacion.php';
  $documentacion=new Documentacion();



$documentacion->setIdDocumento(filter_input(INPUT_POST, 'input_idDocumento'));
$documentacion->setAreaDocumento(filter_input(INPUT_POST, 'input_areaDocumento'));
$documentacion->setTipoDocumento(filter_input(INPUT_POST, 'input_tipoDocumento'));
$documentacion->setNroDocumento(filter_input(INPUT_POST, 'input_nroDocumento'));
$documentacion->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$documentacion->setFechaCreacion(filter_input(INPUT_POST, 'input_fechaCreacion'));
$documentacion->setFechaModificacion(filter_input(INPUT_POST, 'input_fechaModificacion'));
$documentacion->setIdUsuario(filter_input(INPUT_POST, 'input_idUsuario'));
$documentacion->setExtension(filter_input(INPUT_POST, 'input_extension'));
$documentacion->setVersion(filter_input(INPUT_POST, 'input_version'));
$documentacion->setEstado(filter_input(INPUT_POST, 'input_estado'));
$documentacion->setIdEmpresa(filter_input(INPUT_POST, 'input_idEmpresa'));



 $documentacion->actualizar();
