<?php

   require '../models/Colaborador.php';
  $colaboradore=new Colaboradore();



$colaboradore->setIdColaborador(filter_input(INPUT_POST, 'input_idColaborador'));
$colaboradore->setDocumento(filter_input(INPUT_POST, 'input_documento'));
$colaboradore->setDato(filter_input(INPUT_POST, 'input_dato'));
$colaboradore->setDomicilio(filter_input(INPUT_POST, 'input_domicilio'));
$colaboradore->setIdUbigeo(filter_input(INPUT_POST, 'input_idUbigeo'));
$colaboradore->setFechaNacimiento(filter_input(INPUT_POST, 'input_fechaNacimiento'));
$colaboradore->setTelefono(filter_input(INPUT_POST, 'input_telefono'));
$colaboradore->setIdCargo(filter_input(INPUT_POST, 'input_idCargo'));
$colaboradore->setFoto(filter_input(INPUT_POST, 'input_foto'));
$colaboradore->setEstado(filter_input(INPUT_POST, 'input_estado'));
$colaboradore->setUltimoIngreso(filter_input(INPUT_POST, 'input_ultimoIngreso'));
$colaboradore->setIdEmpresa(filter_input(INPUT_POST, 'input_idEmpresa'));
$colaboradore->setNacionalidad(filter_input(INPUT_POST, 'input_nacionalidad'));
$colaboradore->setProfesion(filter_input(INPUT_POST, 'input_profesion'));
$colaboradore->setIdGrupoSanguineo(filter_input(INPUT_POST, 'input_idGrupoSanguineo'));
$colaboradore->setIdFactorSanguineo(filter_input(INPUT_POST, 'input_idFactorSanguineo'));
$colaboradore->setIdEstadoCivil(filter_input(INPUT_POST, 'input_idEstadoCivil'));
$colaboradore->setFichaPersonalScan(filter_input(INPUT_POST, 'input_fichaPersonalScan'));



 $colaboradore->actualizar();
