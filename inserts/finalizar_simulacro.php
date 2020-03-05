<?php

ob_start();
session_start();
include ("../includes/conectar.php");
include ("../includes/varios.php");

$varios = new Varios();
$empresa = $_SESSION['empresa'];
$id = $_POST['id'];
$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
$anio = $_POST['anio'];

$fecha_ejecutado = $varios->fecha_mysql($_POST['fecha_simulacro']) . ' ' . $_POST['hora_inicio'];
$fecha_fin = $varios->fecha_mysql($_POST['fecha_simulacro']) . ' ' . $_POST['hora_fin'];
$observaciones = strtoupper($_POST['observaciones']);
$recomendaciones = strtoupper($_POST['recomendaciones']);
$conclusiones = strtoupper($_POST['conclusiones']);

if (isset($_FILES["informe"])) {


    $file = $_FILES['informe']['name'];
    $file_temporal = $_FILES['informe']['tmp_name'];

    $validextensions = array("pdf", "PDF");
    $temporary = explode(".", $_FILES["informe"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["informe"]["type"] == "application/pdf")) && ($_FILES["informe"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["informe"]["error"] > 0) {
            echo "Return Code: " . $_FILES["informe"]["error"] . "<br/><br/>";
        } else {
            $directorio = "../upload/" . $empresa . "/simulacros/". $anio.$cod."/archivos/";
            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            $documento_nuevo = $cod . '_' . $anio;
            $new_name = $documento_nuevo . '.' . $file_extension;

            if (move_uploaded_file($file_temporal, $directorio . $new_name)) {
                print "El archivo fue subido con éxito.";
                $fin_simulacro = "update programa_simulacros set fecha_ejecutado = '" . $fecha_ejecutado . "', fecha_fin_ejecutado = '" . $fecha_fin . "', observaciones = '" . $observaciones . "', recomendaciones = '" . $recomendaciones . "', conclusiones = '" . $conclusiones. "', informe = '" . $new_name . "', estado = '1' where id='" . $id . "' and  anio='" . $anio . "' and empresa ='" . $empresa . "'";
                echo $fin_simulacro;
                $resultado = $conn->query($fin_simulacro);
                if (!$resultado) {
                    die('Could not enter data: ' . mysqli_error($conn));
                } else {
                    echo "Entered data successfully";
                    //header("Location: ../inspeccion_epp.php?id=" . $id . "&anio=" . $anio);
                    //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
                }
            } else {
                print "Error al intentar subir el archivo.";
                $new_name = "";
            }
        }
    } else {
        echo "el archivo no cumple con las caracteristicas";
        echo $_FILES["informe"]["type"];
        echo $file_extension;
    }
} else {
    echo "no se ha seleccionado ningun documento";
}
ob_end_flush();
?>			
