<?php
require '../../models/Ubigeo.php';

$ubigeo = new Ubigeo();

$ubigeo->setDepartamento(filter_input(INPUT_POST, 'id_departamento'));

$resultado = $ubigeo->verProvincias();
$html = "";

foreach ($resultado as $fila) {
    $html .= '<option value=' . $fila['provincia'] . '>' . strtoupper($fila['nombre']) . '</option>';
}

echo $html;