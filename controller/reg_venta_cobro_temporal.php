<?php

require '../models/VentaCobroTemporal.php';

$temporal = new VentaCobroTemporal();

$temporal->setIdventa(filter_input(INPUT_POST, 'hidden_idventa'));
$temporal->setFecha(filter_input(INPUT_POST, 'input_fecha'));
$temporal->setIdbanco(filter_input(INPUT_POST, 'select_banco'));
$temporal->setMonto(filter_input(INPUT_POST, 'input_pagar'));
$temporal->setNota(filter_input(INPUT_POST, 'input_notas'));

$temporal->insertar();

header("Location: ../contents/detalle_venta.php?idventa=" . $temporal->getIdventa());
