<?php

require '../models/Usuario.php';
$usuario = new Usuario();


$usuario->setIdEmpresa(filter_input(INPUT_POST, 'select_empresas'));
$usuario->setUsername(filter_input(INPUT_POST, 'input_usuario'));
$usuario->setPassword(filter_input(INPUT_POST, 'input_contra'));
$usuario->setDato(filter_input(INPUT_POST, 'input_datos'));
$usuario->setCelular(filter_input(INPUT_POST, 'input_celular'));
$usuario->setEmail(filter_input(INPUT_POST, 'input_email'));
$usuario->setEstado(1);

if (filter_input(INPUT_POST, 'hidden_id')) {
    $usuario->setIdUsuario(filter_input(INPUT_POST, 'hidden_id'));
    $usuario->actualizar();
} else {
    $usuario->generarCodigo();
    $usuario->insertar();
}
header("Location: ../contents/usuarios.php");
