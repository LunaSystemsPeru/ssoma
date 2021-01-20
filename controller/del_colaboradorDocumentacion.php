<?php

require '../models/ColaboradorDocumentacion.php';
$colaboradorDocumentacion = new ColaboradorDocumentacion();

$colaboradorDocumentacion->setIdAdjunto(filter_input(INPUT_GET, 'input_idAdjunto'));
$colaboradorDocumentacion->eliminar();
