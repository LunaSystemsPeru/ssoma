<?php

session_start();
ob_start();
include ("../includes/conectar.php");
require ("../includes/varios.php");
$varios = new Varios();

$empresa = $_SESSION['empresa'];
$empleado = $_SESSION['usuario'];
$tipo = strtoupper($_POST['tipo']);
$clase = strtoupper($_POST['clase']);
$codigo = $_POST['codigo'];
$id_documento = 1;
$documento = strtoupper($_POST['documento']);
$version = $_POST['version'];
$abreviado_clase = "";

$fecha_creacion = $varios->fecha_mysql($_POST['fecha_creacion']);
$fecha_larga = $varios->fecha_larga($fecha_creacion);
$new_name = "";

$consultar_clase = "select abreviado from clase_documentos where id = '" . $clase . "'";
echo $consultar_clase;
$resultado = $conn->query($consultar_clase);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $abreviado_clase = $fila['abreviado'];
    }
}

if (isset($_FILES["file"])) {


    $file = $_FILES['file']['name'];
    $file_temporal = $_FILES['file']['tmp_name'];

    $validextensions = array("doc", "docx", "pdf", "DOC", "DOCX", "PDF");
    $temporary = explode(".", $_FILES["file"]["name"]);
    $file_extension = end($temporary);

    if ((($_FILES["file"]["type"] == "application/msword") || ($_FILES["file"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || ($_FILES["file"]["type"] == "application/pdf")) && ($_FILES["file"]["size"] < 50000000) && in_array($file_extension, $validextensions)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
        } else {
            $estructura = "../upload/" . $empresa . "/documentos/";
            if (!mkdir($estructura, 0777, true)) {
                //die('Fallo al crear las carpetas...');
            }
            $directorio = "../upload/" . $empresa . "/documentos/";
            $documento_nuevo = str_replace(' ', '_', $documento);
            $new_name = $tipo . '-' . $abreviado_clase . '-' . str_pad($codigo, 3, "0", STR_PAD_LEFT) . '_' . $documento_nuevo . '.' . $file_extension;

            if (move_uploaded_file($file_temporal, $directorio . $new_name)) {
                print "El archivo fue subido con éxito.";
                global $conn;
                $id_examen = 1;
                $consultar_id = "select id from documentos where tipo = '" . $tipo . "' and clase = '" . $clase . "' and id = '" . $codigo . "' order by id desc limit 1";
                echo $consultar_id;
                $resultado = $conn->query($consultar_id);
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        
                    }
                } else {
                    $ins_examen = 'insert into documentos Values ("' . $codigo . '", "' . $clase . '", "' . $tipo . '", "' . $documento . '", "' . $fecha_larga . '", "' . $fecha_larga . '", "' . $empleado . '", "' . $file_extension . '", "' . $version . '", "' . $new_name . '", "' . $empresa . '", "1")';
                    echo $ins_examen;
                    $resultado = $conn->query($ins_examen);
                    if (!$resultado) {
                        die('Could not enter data: ' . mysqli_error($conn));
                    } else {
                        echo "Entered data successfully\n";
                        header("Location: ../documentos.php");
                        //echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
                    }
                }
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
ob_end_flush();
?>			
