<?php

ob_start();
session_start();
include ("../includes/conectar.php");
include ("../includes/varios.php");

$varios = new Varios();
$empresa = $_SESSION['empresa'];
$id = $_POST['id'];
$cod_id = str_pad($id, 3, '0', STR_PAD_LEFT);
$anio = $_POST['anio'];
$item = $_POST['item'];
$tipo = $_POST['tipo'];
$cod_item = str_pad($item, 3, '0', STR_PAD_LEFT);
$fecha = $varios->fecha_mysql($_POST['fecha']);


if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("pdf", "PDF");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "application/pdf")) && ($_FILES["file"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            echo $tipo;
            switch ($tipo) {
                case "EPP":
                    $tabla = "inspeccion_epp";
                    $pagina = "inspeccion_epp";
                    break;
                case "ALMACEN":
                    $tabla = "inspeccion_almacen";
                    $pagina = "inspeccion_almacen";
                    break;
                case "BOTIQUIN":
                    $tabla = "inspeccion_botiquin";
                    $pagina = "inspeccion_botiquin";
                    break;
                case "EXTINTORES":
                    $tabla = "inspeccion_extintores";
                    $pagina = "inspeccion_extintor";
                    break;
                case "OFICINAS":
                    $tabla = "inspeccion_oficina";
                    $pagina = "inspeccion_oficina";
                    break;
                case "ORDEN Y LIMPIEZA":
                    $tabla = "inspeccion_limpieza";
                    $pagina = "inspeccion_limpieza";
                    break;
                case "TRABAJO":
                    $tabla = "inspeccion_trabajo";
                    $pagina = "inspeccion_trabajo";
                    break;
                case "SSHH":
                    $tabla = "inspeccion_sshh";
                    $pagina = "inspeccion_sshh";
                    break;
            }

            $directorio = "../upload/" . $empresa . "/inspecciones/" . $tipo . '/';
            $documento_nuevo = $anio . '_' . $cod_id . '_' . $cod_item;
            $new_name = $documento_nuevo . '.' . $file_extension;
            mkdir($directorio, 0777, true);
            if (move_uploaded_file($file_temporal, $directorio . $new_name)) {
                print "El archivo fue subido con éxito.";
                grabar_inspeccion($tabla, $pagina, $fecha, $new_name);
            } else {
                print "Error al intentar subir el archivo.";
                $new_name = "";
            }
        }
    } else {
        echo "el archivo no cumple con las caracteristicas";
        echo $_FILES["file"]["type"];
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ningun documento";
}

function grabar_inspeccion($tabla, $pagina, $fecha_inspeccion, $archivo) {
    global $id;
    global $anio;
    global $empresa;
    global $item;
    global $conn;
    $modificar_inspeccion = "update " . $tabla . " set fecha = '" . $fecha_inspeccion . "', archivo = '" . $archivo . "', estado = '1' "
            . "where id='" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "' and  item = '" . $item . "'";
    echo $modificar_inspeccion;
    $resultado = $conn->query($modificar_inspeccion);
    if (!$resultado) {
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        echo "Entered data successfully";
        header("Location: ../".$pagina.".php?id=" . $id . "&anio=" . $anio);
    }
}

ob_end_flush();
?>			
