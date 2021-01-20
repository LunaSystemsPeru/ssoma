<?php
session_start();
require '../models/Colaborador.php';
require '../models/Empresa.php';

$empresa = new Empresa();
$colaborador = new Colaborador();

$empresa->setRuc(filter_input(INPUT_POST, 'ruc'));
$empresa->validarRuc();

$colaborador->setIdEmpresa($empresa->getIdEmpresa());
$colaborador->setDocumento(filter_input(INPUT_POST, 'documento'));
$colaborador->setNacionalidad(filter_input(INPUT_POST, 'nacionalidad'));

$_SESSION['ruc_empresa'] = $empresa->getRuc();
$_SESSION['empresa'] = $empresa->getIdEmpresa();

$existe = $colaborador->validarCarnet();

if ($existe) {
    $colaborador->obtenerDatos();
    ?>

    <iframe src="../reportes/carnet_horizontal.php?colaborador=<?php echo $colaborador->getIdColaborador() ?>" width="100%" height="300"
           type="application/pdf">

    <?php
} else {
    ?>
    <h2 class="text-danger">NO SE ENCONTRARON DATOS, VERIFIQUE!</h2>
    <?php
}
?>