<?php
session_start();

require '../models/Usuario.php';
require '../models/Empresa.php';

$usuario = new Usuario();
$empresa = new Empresa();

$empresa->setRuc(filter_input(INPUT_POST, 'empresa'));
$usuario->setUsername(filter_input(INPUT_POST, 'usuario'));
$password = filter_input(INPUT_POST, 'password');

if (!$empresa->validarRuc()) {
    //no existe empresa
    header("Location: ../contents/login.php?error=1");
} else {
    $usuario->setIdEmpresa($empresa->getIdEmpresa());
    if (!$usuario->validarUsuario()) {
        //echo "no existe usuario";
        header("Location: ../contents/login.php?error=2");
    } else {
        echo $password;
        echo $usuario->getPassword();
        if (!$password == $usuario->getPassword()) {
            //echo "contraseña incorrecta";
            header("Location: ../contents/login.php?error=3");
        } else {
            $usuario->obtenerDatos();
            $usuario->actualizarLogin();
            if ($usuario->getEstado() == 1) {
                $_SESSION["usuario"] = $usuario->getIdUsuario();
                $_SESSION["empresa"] = $empresa->getIdEmpresa();
                $_SESSION["empleado"] = $usuario->getDato();
                header("Location: ../contents/index.php");
            } else {
                //usuario bloqueado
                session_destroy();
                header("Location: ../contents/login.php?error=4");
            }
        }
    }
}