<?php
require '../../models/Ubigeo.php';

$ubigeo = new Ubigeo();

$ubigeo->setDepartamento(filter_input(INPUT_POST, 'id_departamento'));
$ubigeo->setProvincia(filter_input(INPUT_POST, 'id_provincia'));

$resultado = $ubigeo->verDistritos();
$html = "";

foreach ($resultado as $fila) {
    $html .= '<option value=' . $fila['id_ubigeo'] . '>' . strtoupper($fila['nombre']) . '</option>';
}

echo $html;