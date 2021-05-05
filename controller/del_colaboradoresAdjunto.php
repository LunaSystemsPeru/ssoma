<?php

require '../models/ColaboradoresAdjunto.php';
$colaboradoresAdjunto = new ColaboradoresAdjunto();

$colaboradoresAdjunto->setIdColaborador(filter_input(INPUT_GET, 'input_idColaborador'));

$colaboradoresAdjunto->eliminar();
