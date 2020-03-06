<?php

session_start();
include ("../includes/conectar.php");

include("../class/reduce_img.php");

$empresa = $_SESSION['empresa'];
$usuario = $_SESSION['usuario'];
$anio = $_POST['anio'];
$id = $_POST['id'];

if (!empty($_FILES)) {
    for ($i = 0; $i < count($_FILES["archivo"]["name"]); $i++) {
        if ($_FILES["archivo"]["type"][$i] == "image/jpeg" || $_FILES["archivo"]["type"][$i] == "image/pjpeg" || $_FILES["archivo"]["type"][$i] == "image/gif" || $_FILES["archivo"]["type"][$i] == "image/png") {
            $cod = str_pad($id, 3, '0', STR_PAD_LEFT);
            $dirseparator = DIRECTORY_SEPARATOR;
            $file_temporal = $_FILES['archivo']['tmp_name'][$i];
            $directorio = "../upload/" . $empresa . "/capacitaciones/" . $anio . $cod . "/imagenes/";
            $imagen = basename($_FILES["archivo"]["name"][$i]);
            $temporary = explode(".", $_FILES["archivo"]["name"][$i]);
            $file_extension = end($temporary);
            $cadena_aleatoria = substr(md5(time() . rand()), 0, 8);
            $nuevo_nombre = $cadena_aleatoria . '.' . $file_extension;
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            if (move_uploaded_file($file_temporal, $directorio . $nuevo_nombre)) {
                echo "se guardo la imagen, ahora se insertara a la base de datos";
                $add_img = "INSERT INTO imagenes_capacitacion VALUES ('" . $id . "', '" . $anio . "', '" . $empresa . "', '" . $usuario . "', '" . $nuevo_nombre . "', now())";

                // echo $add_img;

                $insertado = $conn->query($add_img);
                if (!$insertado) {
                    die('Could not enter data: ' . mysqli_error($conn));
                    print ("error al ingresar los datos");
                }
            } else {
                echo "NO SE PUEDE GUARDAR LA IMAGEN";
            }

            // # CONFIGURACION #############################
            // ruta de la imagen a redimensionar

            $imagen = $nuevo_nombre;

            // ruta de la imagen final, si se pone el mismo nombre que la imagen, esta se sobreescribe

            $imagen_final = $nuevo_nombre;
            $ancho_nuevo = 2048;
            $alto_nuevo = 1360;

            // # FIN CONFIGURACION #############################

            redim($imagen, $imagen_final, $ancho_nuevo, $alto_nuevo, $directorio);
        } else {
            echo "no cumple con las caracteristicas " . $_FILES["archivo"]["name"][$i];
        }
    }

    header("Location: ../detalle_capacitacion.php?id=" . $id . "&anio=" . $anio);
} else {
    echo "ningun archivo seleccionado";
}
?>


