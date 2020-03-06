<?php

ob_start();
session_start();
include ("../includes/conectar.php");
include("../includes/varios.php");

$varios = new Varios();

$empresa = $_SESSION['empresa'];
$id = $_POST['id'];
$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];
$cantidad = $_POST['cantidad'];
$area = strtoupper($_POST['area']);
$recomendaciones = strtoupper($_POST['recomendaciones']);
$conclusiones = strtoupper($_POST['conclusiones']);
$fecha = $varios->fecha_mysql($_POST['fecha_inicio']);

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
            $directorio = "../upload/" . $empresa . "/monitoreo/" . $anio . $cod . "/";
            if (!mkdir($directorio, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            $documento_nuevo = $cod . '_' . $anio;
            $new_name = $documento_nuevo . '.' . $file_extension;

            if (move_uploaded_file($file_temporal, $directorio . $new_name)) {
                print "El archivo fue subido con éxito.";
                $ins_area = "insert into area_monitoreo values ('" . $id . "', '" . $anio . "', '" . $empresa . "', '" . $tipo . "', '" . $area . "', '" . $cantidad . "', '" . $fecha . "', '" . $new_name . "', '" . $conclusiones . "', '" . $recomendaciones . "')";
                $resultado = $conn->query($ins_area);
                if (!$resultado) {
                    die('Could not enter data: ' . mysqli_error($conn));
                } else {
                    echo "Entered data successfully\n";
                    header("Location: ../detalle_monitoreo.php?id=" . $id . "&anio=" . $anio . "&tipo=" . $tipo);
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
