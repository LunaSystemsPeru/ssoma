<?php
require '../models/Usuario.php';
require '../models/Empresa.php';
require '../tools/Zebra_Session.php';
require_once '../models/Conectar.php';

$usuario = new Usuario();
$empresa = new Empresa();
$conectar = Conectar::getInstancia();

$usuario->setUsername(filter_input(INPUT_POST, 'usuario'));
$password = filter_input(INPUT_POST, 'password');

if (!$usuario->validarUsuario()) {
    //echo "no existe usuario";
    header("Location: ../contents/login.php?error=2");
} else {
    if (!$password == $usuario->getPassword()) {
        //echo "contraseña incorrecta";
        header("Location: ../contents/login.php?error=3");
    } else {
        $usuario->obtenerDatos();
        $usuario->actualizarLogin();
        if ($usuario->getEstado() == 1) {
            $empresa->setIdEmpresa($usuario->getIdEmpresa());
            $empresa->obtenerDatos();
            $link = $conectar->getLink();
            /* if (isset($_SESSION)) {
                 session_destroy();
             }
 */
            try {
                $zebra = new Zebra_Session($link, 'sEcUr1tY_c0dE');
            } catch (Exception $e) {
                echo $e;
            }

            $_SESSION["usuario"] = $usuario->getIdUsuario();
            $_SESSION["empresa"] = $usuario->getIdEmpresa();
            $_SESSION["ruc_empresa"] = $empresa->getRuc();
            $_SESSION["nombre_empresa"] = $empresa->getRazon();
            $_SESSION["empleado"] = $usuario->getDato();
            // xx
            //print_r($_SESSION);
            header("Location: ../contents/index.php");
        } else {
            //usuario bloqueado
            //echo "error al ingresar";
            session_destroy();
            header("Location: ../contents/login.php?error=4");
        }
    }
}