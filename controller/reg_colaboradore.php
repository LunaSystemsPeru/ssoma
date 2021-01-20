<?php
session_start();

require '../models/Colaborador.php';
require '../tools/varios.php';
$colaboradore = new Colaborador();
$varios = new Varios();

$ruc_empresa = $_SESSION['ruc_empresa'];

$colaboradore->setIdColaborador(filter_input(INPUT_POST, 'hidden_id_empleado'));
$colaboradore->setDocumento(filter_input(INPUT_POST, 'input_documento'));
$colaboradore->setTipoDocumento(filter_input(INPUT_POST, 'select_tipo_documento'));
$colaboradore->setDato(filter_input(INPUT_POST, 'input_dato'));
$colaboradore->setDomicilio(filter_input(INPUT_POST, 'input_domicilio'));
$colaboradore->setIdUbigeo(filter_input(INPUT_POST, 'id_distrito'));
$colaboradore->setFechaNacimiento(filter_input(INPUT_POST, 'input_fechaNacimiento'));
//email
$colaboradore->setTelefono(filter_input(INPUT_POST, 'input_telefono'));
$colaboradore->setIdEstadoCivil(filter_input(INPUT_POST, 'input_idEstadoCivil'));
$colaboradore->setIdGrupoSanguineo(filter_input(INPUT_POST, 'input_idGrupoSanguineo'));
$colaboradore->setIdFactorSanguineo(filter_input(INPUT_POST, 'input_idFactorSanguineo'));
//categoria
$colaboradore->setIdCargo(filter_input(INPUT_POST, 'input_idCargo'));
//jornal o pago diario
$colaboradore->setUltimoIngreso(filter_input(INPUT_POST, 'input_ultimoIngreso'));
//especializacion
//seguro
//afiliacion seguro
//cuspp
//tipo comision
//renta 5ta

$colaboradore->setFoto("noimage.png");
$colaboradore->setEstado(1);
$colaboradore->setIdEmpresa($_SESSION['empresa']);

$colaboradore->setNacionalidad(filter_input(INPUT_POST, 'input_nacionalidad'));
$colaboradore->setProfesion(filter_input(INPUT_POST, 'input_profesion'));
$colaboradore->setFichaPersonalScan(filter_input(INPUT_POST, 'input_fichaPersonalScan'));

$colaboradore->generarCodigo();

$colaboradore->setFoto($colaboradore->getDocumento() . '.' . "jpg");

//function genera foto perfil
$imageBase64Data = filter_input(INPUT_POST, "hidden_perfil");
if ($imageBase64Data) {
    $imageName = $colaboradore->getDocumento();

// Por ahora guardaremos imagen en la carpeta uploads de este proyecto
    $dir_subida = '../upload/' . $ruc_empresa . '/empleados/perfil/';
    if (!file_exists($dir_subida)) {
        if (!mkdir($dir_subida, 0777, true)) {
            die('Fallo al crear las carpetas...');
        }
    }
    $uploadDirectory = __DIR__ . DIRECTORY_SEPARATOR . $dir_subida;

// Dividir cadena base64 por delimitador ";", el tipo está al inicio (MIME),
// los datos binarios de la imagen en código base64 están después.
    list($type, $imageBase64) = explode(';', $imageBase64Data);

// Necesitamos la variable $type (image/png, image/jpeg, etc) para sacar
// la extensión debido a que no tenemos el nombre original de la imagen,
// en el caso de Joomla como la imagen original ya está subida, se puede
// inferir el tipo de imagen del nombre de la imagen original.
    $extension = explode('/', $type)[1];

// Para el ejemplo estoy generando un nombre de imagen aleatorio, en Joomla
// se debería obtener el nombre original de la imagen y agregarle un sufijo
// como "_100x100", "_400x400" o algo así, y finalmente pasarlo como
// parámetro a esta función para que no se genere este nombre aleatorio.
    if (empty($imageName)) {
        $imageName = uniqid('cropped_image_');
    }

// Para los datos binarios de la imagen solo nos interesa el código base64,
// el prefijo antes de ',' sólo especifica la codificación utilizada,
// información que ya conocemos (base64).
    list(, $croppedImageBase64) = explode(',', $imageBase64);

// Convertir el código base64 de la imagen a código binario
// (utilizado para guardar en el sistema de ficheros).
    $croppedImageBinary = base64_decode($croppedImageBase64);

    $source = imagecreatefromstring($croppedImageBinary);
    $rotate = imagerotate($source, 0, 0); // if want to rotate the image
    $imageSave = imagejpeg($rotate, $dir_subida . $imageName . ".jpg", 70);
    imagedestroy($source);

// Concatenar nombre completo de imagen donde será guardado el
// contenido binario de ésta.
//$fullImageName = $uploadDirectory . $imageName . '.' . $extension;

// Finalmente guardar el contenido binario en un fichero específico.
//file_put_contents($fullImageName, $croppedImageBinary);

    $colaboradore->setFoto($imageName . '.' . "jpg");
// return $fullImageName;

//$varios->compressImage($fullImageName, $dir_subida . $imageName . '.jpg' , 70);
}

//subir foto perfil
if (!empty($_FILES["file_lado1"])) {
    $file = $_FILES["file_lado1"];
    $filename = $file['name'];
    $file_temporal = $file['tmp_name'];

    $temporary = explode(".", $filename);
    $file_extension = end($temporary);
    if ($file["error"] > 0) {
        //die("Return Code: " . $file["error"] . "<br/><br/>");
    } else {
        //establecer directorio de subida
        $dir_subida = '../upload/' . $ruc_empresa . '/empleados/documento/';
        if (!file_exists($dir_subida)) {
            if (!mkdir($dir_subida, 0777, true)) {
                die('Fallo al crear las carpetas...');
            }
        }

        //establecer nombre de archivo
        $nombre_archivo = $colaboradore->getDocumento() . "." . $file_extension;

        if (move_uploaded_file($file_temporal, $dir_subida . $nombre_archivo)) {
            //print "El archivo fue subido con éxito.";
        } else {
            print "Error al intentar subir el archivo.";
        }
    }
} else {
    print "no hay archivo seleccionado";
}

$colaboradore->insertar();
header("Location: ../contents/empleados.php");
