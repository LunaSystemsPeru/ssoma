<?php
require '../models/Colaborador.php';
$colaborador = new Colaborador();

$colaborador->setIdColaborador(filter_input(INPUT_GET, 'input_idColaborador'));

$colaboradore->eliminar();
