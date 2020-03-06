<?php

   require '../models/ColaboradoresAdjunto.php';
  $colaboradoresAdjunto=new ColaboradoresAdjunto();



$colaboradoresAdjunto->setIdColaborador(filter_input(INPUT_POST, 'input_idColaborador'));
$colaboradoresAdjunto->setFechaFirma(filter_input(INPUT_POST, 'input_fechaFirma'));
$colaboradoresAdjunto->setIdAdjunto(filter_input(INPUT_POST, 'input_idAdjunto'));
$colaboradoresAdjunto->setArchivo(filter_input(INPUT_POST, 'input_archivo'));



 $colaboradoresAdjunto->actualizar();
