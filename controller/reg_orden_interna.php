<?php
session_start();
require '../models/Orden_Interna.php';
$orden = new Orden_Interna();

$orden->generarNroOrden();
$orden->generarCodigo();
$orden->setFechaGenerado(filter_input(INPUT_POST, 'input_fecha_generado'));
$orden->setFechaInicio(filter_input(INPUT_POST, 'input_fecha_inicio'));
$orden->setDuracion(filter_input(INPUT_POST, 'input_duracion'));
$orden->setMonto(filter_input(INPUT_POST, 'input_monto'));
$orden->setDetalle(filter_input(INPUT_POST, 'input_descripcion'));
$orden->setObservaciones(filter_input(INPUT_POST, 'input_servico'));
$orden->setSolicitante(filter_input(INPUT_POST, 'input_solicitud'));
$orden->setResponsable(filter_input(INPUT_POST, 'input_responsable'));
$orden->setSedeServicio(filter_input(INPUT_POST, 'input_sucursal'));
$orden->setIdTipoServicio(filter_input(INPUT_POST, 'select_tipo_servicio'));
$orden->setIdCliente(filter_input(INPUT_POST, 'select_cliente'));
$orden->setIdUsuario($_SESSION['usuario']);
$orden->setIdEmpresa(filter_input(INPUT_POST, 'select_empresas'));

$orden->insertar();

header("Location: ../contents/ordenes_internas.php");