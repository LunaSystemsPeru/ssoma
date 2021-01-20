<?php
require '../models/RecordatorioServicio.php';

$recordatorio = new RecordatorioServicio();

$recordatorio->setFecha('2020-01-01');
$recordatorio->setDia(filter_input(INPUT_POST, 'input_dia'));
$recordatorio->setServicio(filter_input(INPUT_POST, 'input_servicio'));
$recordatorio->setIdproveedor(filter_input(INPUT_POST, 'select_proveedor'));
$recordatorio->setUrl(filter_input(INPUT_POST, 'input_url'));
$recordatorio->setCodcliente(filter_input(INPUT_POST, 'input_codcliente'));

$recordatorio->generarCodigo();

$recordatorio->insertar();

header("Location: ../contents/recordatorios_pagos.php");