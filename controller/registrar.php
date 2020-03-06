<?php

require '../models/Empresa.php';
require '../models/Usuario.php';

$empresa = new Empresa();
$usuario = new Usuario();

$empresa->setRuc(filter_input(INPUT_POST, 'input_ruc'));
$empresa->setRazon(filter_input(INPUT_POST, 'input_razon'));
$empresa->setDireccion(filter_input(INPUT_POST, 'input_direccion'));
$empresa->generarCodigo();

if ($empresa->validarRuc()) {
    //empresa existe
    header("Location: ../contents/registrar.php?error=1");
}

$registrar_empresa = false;


    $file = $_FILES['file_logo']['name'];
    $file_temporal = $_FILES['file_logo']['tmp_name'];

    $temporary = explode(".", $_FILES["file_logo"]["name"]);
    $file_extension = end($temporary);
    if ($_FILES["file_logo"]["error"] > 0) {
        die("Return Code: " . $_FILES["file_logo"]["error"] . "<br/><br/>");
        //print "no hay archivo seleccionado";
    } else {

        //establecer directorio de subida
        $dir_subida = '../upload/'.$empresa->getRuc().'/documentos/';
        if (!file_exists($dir_subida)) {
            mkdir($dir_subida, 0777, true);

        }

        //establecer nombre de archivo
        $empresa->setLogo($empresa->getRuc() . '.' . $file_extension);

        if (move_uploaded_file($file_temporal, $dir_subida . $empresa->getLogo())) {
            //print "El archivo fue subido con éxito.";
            $registrar_empresa = $empresa->insertar();

            //header("Location: ../contents/ver_clientes.php");
        } else {
            print "Error al intentar subir el archivo.";
        }
    }

$usuario->setUsername(filter_input(INPUT_POST, 'input_username'));
$usuario->setPassword(filter_input(INPUT_POST, 'input_password'));
$usuario->setDato(filter_input(INPUT_POST, 'input_datos'));
$usuario->setCelular(filter_input(INPUT_POST, 'input_celular'));
$usuario->setEmail(filter_input(INPUT_POST, 'input_email'));
$usuario->setIdEmpresa($empresa->getIdEmpresa());
$usuario->generarCodigo();

if ($registrar_empresa) {
    $usuario->insertar();
    header("Location: ../contents/login.php");
}