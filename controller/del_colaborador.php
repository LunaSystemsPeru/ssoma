<?php
include '../fixed/iniciaSession.php';

require '../models/Colaborador.php';
$colaboradore = new Colaborador();

$colaboradore->setIdColaborador(filter_input(INPUT_GET, 'codigo'));

$colaboradore->eliminar();

header("Location: ../contents/empleados.php");