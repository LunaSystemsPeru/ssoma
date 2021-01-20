<?php

require '../models/ColaboradorDocumentacion.php';
$colaboradorDocumentacion = new ColaboradorDocumentacion();


$colaboradorDocumentacion->generarCodigo();
$colaboradorDocumentacion->setNroOrden(filter_input(INPUT_POST, 'input_orden'));
$colaboradorDocumentacion->setNombre(filter_input(INPUT_POST, 'input_nombre'));
$colaboradorDocumentacion->setIdDocumento(null);


$colaboradorDocumentacion->insertar();

header("Location: ../contents/documentos_colaboradores.php");
