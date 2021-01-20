<?php

require '../models/ParametrosGenerale.php';
$parametrosGenerale = new ParametrosGenerale();

$parametrosGenerale->generarCodigo();
$parametrosGenerale->setNombre(strtoupper(filter_input(INPUT_POST, 'input_nombre')));
$parametrosGenerale->insertar();

header("Location: ../contents/parametros_generales.php");
