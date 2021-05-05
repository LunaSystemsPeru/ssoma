<?php
include '../fixed/iniciaSession.php';
$ruc_empresa = $_SESSION['ruc_empresa'];

require '../models/ColaboradoresAdjunto.php';
$colaboradoresAdjunto = new ColaboradoresAdjunto();

$colaboradoresAdjunto->setId(filter_input(INPUT_GET, 'codigo'));
$colaboradoresAdjunto->obtenerDatos();

$colaboradoresAdjunto->eliminar();

$dir_subida = '../upload/' . $ruc_empresa . '/empleados/adjuntos/' . $colaboradoresAdjunto->getArchivo();
unlink($dir_subida);

header("Location: ../contents/resumen_empleado.php?id=" . $colaboradoresAdjunto->getIdColaborador());