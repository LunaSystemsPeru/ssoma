<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
require '../models/Colaborador.php';
require '../models/Empresa.php';
require '../models/ColaboradoresAdjunto.php';
require '../models/ColaboradoresContrato.php';
require '../models/Ubigeo.php';
require '../models/ParametrosDetalle.php';
require '../models/ColaboradorDocumentacion.php';
require '../tools/varios.php';


$colaborador = new Colaborador();
$empresa = new Empresa();
$archivo = new ColaboradoresAdjunto();
$documento = new ColaboradorDocumentacion();
$contrato = new ColaboradoresContrato();
$ubigeo = new Ubigeo();
$detalle = new ParametrosDetalle();
$varios = new Varios();

$colaborador->setIdColaborador(filter_input(INPUT_GET, 'id'));
$colaborador->obtenerDatos();

if ($colaborador->getDomicilio() == "") {
    $colaborador->setDomicilio("-");
}
if ($colaborador->getTelefono() == "") {
    $colaborador->setTelefono("-");
}

$empresa->setIdEmpresa($colaborador->getIdEmpresa());
$empresa->obtenerDatos();

$archivo->setIdColaborador($colaborador->getIdColaborador());

$ubigeo->setIdUbigeo($colaborador->getIdUbigeo());
$ubigeo->obtenerDatos();


if ($colaborador->getFoto() == "noimage.png" || $colaborador->getFoto() == "") {
    $url_perfil = "../upload/av1.png";
} else {
    $url_perfil = "../upload/" . $empresa->getRuc() . "/empleados/perfil/" . $colaborador->getFoto();

    if (!file_exists($url_perfil)) {
        $url_perfil = "../upload/noimage.png";
    }
}

$contrato->setIdColaborador($colaborador->getIdColaborador());
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados | Software Gestion de Seguridad Industrial</title>


    <!--STYLESHEET-->
    <!--=================================================-->


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="../public/css/nifty.min.css" rel="stylesheet">


    <!--Font Awesome [ OPTIONAL ]-->
    <link href="../public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <!--Switchery [ OPTIONAL ]-->
    <link href="../public/plugins/switchery/switchery.min.css" rel="stylesheet">


    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="../public/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


    <!--Bootstrap Table [ OPTIONAL ]-->
    <link href="../public/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="../public/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">


    <!--Demo [ DEMONSTRATION ]-->
    <link href="../public/css/demo/nifty-demo.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


    <script type="text/javascript">
        function add_empleado() {
            document.location.href = "registra_empleado.php";
        }

        function ver_galeria() {
            document.location.href = "galeria_empleados.php";
        }
    </script>


    <!--SCRIPT-->
    <!--=================================================-->

    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="../public/plugins/pace/pace.min.js"></script>


    <!--

            REQUIRED
            You must include this in your project.

            RECOMMENDED
            This category must be included but you may modify which plugins or components which should be included in your project.

            OPTIONAL
            Optional plugins. You may choose whether to include it in your project or not.

            DEMONSTRATION
            This is to be removed, used for demonstration purposes only. This category must not be included in your project.

            SAMPLE
            Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


            Detailed information and more samples can be found in the document.

    -->


</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
<div id="container" class="effect mainnav-lg">

    <!--NAVBAR-->
    <!--===================================================-->
    <?php include("../fixed/header.php"); ?>
    <!--===================================================-->
    <!--END NAVBAR-->

    <div class="boxed">

        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">
            <div id="page-content">
                <div class="row">
                    <div class="row col-lg-3">
                        <div class="panel">

                            <!-- Simple profile -->
                            <div class="text-center pad-all">
                                <div class="pad-ver">
                                    <img src="<?php echo $url_perfil ?>" class="img-lg img-border img-lg" alt="Profile Picture">
                                </div>
                            </div>
                            <hr>
                            <ul class="list-group bg-trans">
                                <div class="pad-hor">
                                    <h5>Generar Documento</h5>
                                </div>
                                <!-- Profile Details -->
                                <li class="list-group-item list-item-sm">
                                    <a href="reportes/ficha_personal.php?id=<?php echo $colaborador->getIdColaborador(); ?>"><i class="fa fa-file-text-o fa-fw"></i> Ficha Personal</a>
                                </li>
                                <li class="list-group-item list-item-sm">
                                    <a href="reportes/antecedentes.php?codigo="><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada Antecedentes</a>
                                </li>
                                <li class="list-group-item list-item-sm">
                                    <a href="reportes/domicilio.php?empleado=<?php echo $colaborador->getIdColaborador() ?>"><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada de Domiclio</a>
                                </li>
                                <?php if (0 == "0") { ?>
                                    <li class="list-group-item list-item-sm">
                                        <a href="reportes/renta_5ta.php?empleado=<?php echo $colaborador->getIdColaborador() ?>"><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada Renta de 5ta Categoria</a>
                                    </li>
                                <?php } ?>
                                <?php if ("onp" != "ONP") { ?>
                                    <li class="list-group-item list-item-sm">
                                        <a href="reportes/afp.php?empleado=<?php echo $colaborador->getIdColaborador() ?>"><i class="fa fa-file-text-o fa-fw"></i> Declaracion Jurada AFP</a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <hr>

                            <ul class="list-group bg-trans">
                                <div class="pad-hor">
                                    <h5>Documentos Asociados</h5>
                                </div>
                                <!-- Profile Details -->
                                <li class="list-group-item list-item-sm">
                                    <a href="reportes/historial_epp.php?empleado=<?php echo $colaborador->getIdColaborador() ?>" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> Historial de Entrega EPP</a>
                                </li>
                            </ul>
                            <hr>
                        </div>

                        <!--Page content-->
                        <!--===================================================-->

                        <div class="panel">

                            <!--Panel heading-->
                            <div class="panel-heading">
                                <div class="panel-control">
                                    <button data-toggle="modal" data-target="#modal_archivo" class="demo-panel-ref-btn btn btn-purple">
                                        <i class="fa fa-plus"></i> Agregar
                                    </button>
                                </div>
                                <h5 class="pad-all">Ver Documentos Adjuntos</h5>

                            </div>

                            <!--Panel body-->
                            <div class="panel-body">
                                <table class="table table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a_archivos = $archivo->ver_archivos();
                                    foreach ($a_archivos as $value) {
                                        $directorio = "../upload/" . $empresa->getRuc() . "/empleados/adjuntos/" . $value['archivo'];
                                        ?>
                                        <tr>
                                            <td><?php echo $value['nombre'] . " - " . $varios->fecha_tabla($value['fecha_firma']) ?></td>
                                            <td>
                                                <a href="<?php echo $directorio ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-print"></i> </a>
                                                <button class="btn btn-danger btn-sm" title="Eliminar Archivo" onclick="eliminar('<?php echo $value['id'] ?>')"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal fade" id="modal_archivo">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h4 class="modal-title">Agregar Archivo</h4>
                                    </div>
                                    <form class="form-horizontal" id="frm_registrar" method="post" action="../controller/reg_colaboradoresAdjunto.php" enctype="multipart/form-data">
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="col-md-2 control-label" for="input_idAdjunto">Descripcion</label>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="input_idAdjunto" id="input_idAdjunto">
                                                        <?php
                                                        $a_documentos = $documento->verFilas();
                                                        foreach ($a_documentos as $fila) {
                                                            ?>
                                                            <option value="<?php echo $fila['id_adjunto'] ?>"><?php echo $fila['nombre'] ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-info"><i class="fa fa-download"></i></button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Fecha Firma</label>
                                                <div class="col-md-4">
                                                    <input class="form-control" type="date" name="input_fechaFirma" id="input_fechaFirma" required/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Seleccionar Archivo</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="file" name="file" id="file" accept="application/pdf" required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="input_empleado" value="<?php echo $colaborador->getIdColaborador() ?>">
                                            <input type="hidden" name="input_empresa" value="<?php echo $empresa->getIdEmpresa() ?>">
                                            <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--Page content-->
                        <!--===================================================-->
                    </div>

                    <div class="row col-lg-9">
                        <div class="panel ">
                            <div class="panel-heading">
                                <div class="panel-control">
                                    <a href="modificar-empleado.php?empleado=<?php echo $colaborador->getIdColaborador() ?>" class="demo-panel-ref-btn btn btn-success" data-target="#demo-panel-ref"
                                       data-toggle="panel-overlay">
                                        <i class="demo-psi-repeat-2 icon-fw"></i> Editar
                                    </a>
                                </div>
                                <h3 class="panel-title">Datos Generales</h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="graba_familiar" action="inserts/add_familiar.php" method="post">
                                    <!--Modal body-->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Codigo</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $colaborador->getIdColaborador(); ?></label>
                                            </div>
                                            <label class="col-lg-3 control-label">DNI</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $colaborador->getDocumento(); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Apellidos y Nombres</label>
                                            <div class="col-lg-7">
                                                <label class="form-control"><?php echo $colaborador->getDato(); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Domilicio</label>
                                            <div class="col-lg-7">
                                                <label class="form-control"><?php echo $colaborador->getDomicilio(); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label"></label>
                                            <div class="col-lg-2">
                                                <label class="form-control">
                                                    <?php
                                                    $ubigeo->obtenerNombre($ubigeo->getDepartamento(), '00', '00');

                                                    echo $ubigeo->getNombre();
                                                    ?>
                                                </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-control">
                                                    <?php
                                                    $ubigeo->obtenerNombre($ubigeo->getDepartamento(), $ubigeo->getProvincia(), '00');

                                                    echo $ubigeo->getNombre();
                                                    ?>
                                                </label>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="form-control">
                                                    <?php
                                                    $ubigeo->obtenerNombre($ubigeo->getDepartamento(), $ubigeo->getProvincia(), $ubigeo->getDistrito());

                                                    echo $ubigeo->getNombre();
                                                    ?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            $detalle->setIdDetalle($colaborador->getIdEstadoCivil());
                                            $detalle->obtenerDatos();
                                            ?>
                                            <label class="col-lg-3 control-label">Estado Civil</label>
                                            <div class="col-lg-7">
                                                <label class="form-control"><?php echo $detalle->getNombre(); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            $detalle->setIdDetalle($colaborador->getIdGrupoSanguineo());
                                            $detalle->obtenerDatos();
                                            $gruposangre = $detalle->getNombre();
                                            $detalle->setIdDetalle($colaborador->getIdFactorSanguineo());
                                            $detalle->obtenerDatos();
                                            $factorsangre = $detalle->getNombre();
                                            ?>
                                            <label class="col-lg-3 control-label">Fecha Nacimiento</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $colaborador->getFechaNacimiento() ?></label>
                                            </div>
                                            <label class="col-lg-3 control-label">Tipo Sangre</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $gruposangre . " - " . $factorsangre ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Telefono</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $colaborador->getTelefono() ?></label>
                                            </div>
                                            <label class="col-lg-3 control-label">Fecha Ingreso</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $colaborador->getUltimoIngreso() ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php
                                            $detalle->setIdDetalle($colaborador->getIdCargo());
                                            $detalle->obtenerDatos();
                                            ?>
                                            <label class="col-lg-3 control-label">Categoria</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $detalle->getNombre() ?></label>
                                            </div>
                                            <label class="col-lg-3 control-label">Cargo</label>
                                            <div class="col-lg-2">
                                                <label class="form-control"><?php echo $detalle->getNombre(); ?></label>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="panel">

                        <div class="panel-heading">
                            <div class="panel-control">
                                <button class="demo-panel-ref-btn btn btn-purple" data-toggle="modal" data-target="#modal_contrato"><i class="fa fa-plus"></i> Agregar Contrato</button>
                            </div>
                            <h3 class="panel-title"><b>Contratos - Historia Laboral en la empresa</b></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Cod.</th>
                                        <th class="text-center">Fecha Inicio</th>
                                        <th class="text-center">Fecha Fin</th>
                                        <th class="text-center">Tipo Contrato</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($contrato->verFilas() as $item) {
                                        $fecha_fin = $item['fecha_fin'];
                                        $label = '<label class="label label-dark">Finalizado</label>';
                                        $boton = "";
                                        if ($fecha_fin == "1001-01-01") {
                                            $fecha_fin = "-";
                                            $label = '<label class="label label-success">Activo</label>';
                                            $boton = '<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#modal_fin_contrato"><i class="fa fa-flag"></i></button>';
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $item['id_contrato'] ?></td>
                                            <td class="text-center"><?php echo $item['fecha_inicio'] ?></td>
                                            <td class="text-center"><?php echo $fecha_fin ?></td>
                                            <td class="text-center"><?php echo $item['nombre'] ?></td>
                                            <td class="text-center"><?php echo $label ?></td>
                                            <td class="text-center">
                                                <?php echo $boton ?>
                                                <button class="btn btn-warning btn-xs" type="button" ><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td class="text-center">2020-05-01</td>
                                        <td class="text-center">2020-07-15</td>
                                        <td class="text-center">SIN CONTRATO</td>
                                        <td class="text-center"><label class="label label-warning">Finalizado</label></td>
                                        <td class="text-center">
                                            <!--<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#modal_fin_contrato"><i class="fa fa-flag"></i></button>-->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td class="text-center">2020-08-01</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">SIN CONTRATO</td>
                                        <td class="text-center"><label class="label label-success">Activo</label></td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#modal_fin_contrato"><i class="fa fa-flag"></i></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal_contrato">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Agregar Contrato</h4>
                                </div>
                                <form class="form-horizontal" id="frm_registrar" method="post" action="../controller/reg_colaboradoresContrato.php" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="input_tipoContrato">Tipo Contrato</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="input_tipoContrato" id="input_tipoContrato">
                                                    <?php
                                                    $detalle->setIdParametro(13);
                                                    $a_tipo = $detalle->verFilas();
                                                    foreach ($a_tipo as $fila) {
                                                        ?>
                                                        <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="input_fechaInicio">Fecha Inicio</label>
                                            <div class="col-md-4">
                                                <input class="form-control" type="date" name="input_fechaInicio" id="input_fechaInicio" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="input_idColaborador" value="<?php echo $colaborador->getIdColaborador() ?>">
                                        <input type="hidden" name="input_empresa" value="<?php echo $empresa->getIdEmpresa() ?>">
                                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modal_fin_contrato">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Finalizar Contrato</h4>
                                </div>
                                <form class="form-horizontal" id="frm_registrar" method="post" action="../controller/reg_colaboradoresAdjunto.php" enctype="multipart/form-data">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label class="col-md-2 control-label" for="input_idAdjunto">Tipo Contrato</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" readonly value="SIN CONTRATO">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Fecha Inicio</label>
                                            <div class="col-md-4">
                                                <input class="form-control" type="date" name="input_fechaFirma" id="input_fechaFirma" readonly/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Fecha Fin</label>
                                            <div class="col-md-4">
                                                <input class="form-control" type="date" name="input_fechaFirma" id="input_fechaFirma" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="input_empleado" value="<?php echo $colaborador->getIdColaborador() ?>">
                                        <input type="hidden" name="input_empresa" value="<?php echo $empresa->getIdEmpresa() ?>">
                                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cerrar</a>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="panel">

                        <div class="panel-heading">
                            <div class="panel-control">
                                <button class="demo-panel-ref-btn btn btn-purple"><i class="fa fa-plus"></i> Agregar Examen</button>
                            </div>
                            <a href="laboral_empleado.php?id=<?php echo $colaborador->getIdColaborador(); ?>"><h3 class="panel-title"><b>Examen Medico</b></h3></a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Cod.</th>
                                        <th class="text-center">Evaluador</th>
                                        <th class="text-center">Resultado</th>
                                        <th class="text-center">Fec. Evaluacion</th>
                                        <th class="text-center">Fec. Renovacion</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></a></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
                <!--===================================================-->
                <!--End page content-->


            </div>
            <!--===================================================-->
            <!--END CONTENT CONTAINER-->


            <!--MAIN NAVIGATION-->
            <!--===================================================-->
            <?php include("../fixed/main_navigation.php"); ?>
            <!--===================================================-->
            <!--END MAIN NAVIGATION-->


            <!-- TAB DE LA DERECHA -->
            <!--ASIDE-->
            <!--===================================================-->
            <?php include("../fixed/aside_rigth.php"); ?>
            <!--===================================================-->
            <!--END ASIDE-->
        </div>


        <!-- FOOTER -->
        <!--===================================================-->
        <?php include("../fixed/footer.php"); ?>
        <!--===================================================-->
        <!-- END FOOTER -->


        <!-- SCROLL TOP BUTTON -->
        <!--===================================================-->
        <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
        <!--===================================================-->


    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->


    <!--JAVASCRIPT-->
    <!--=================================================-->

    <!--jQuery [ REQUIRED ]-->
    <script src="../public/js/jquery-2.1.1.min.js"></script>


    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="../public/js/bootstrap.min.js"></script>


    <!--Fast Click [ OPTIONAL ]-->
    <script src="../public/plugins/fast-click/fastclick.min.js"></script>


    <!--Nifty Admin [ RECOMMENDED ]-->
    <script src="../public/js/nifty.min.js"></script>


    <!--Switchery [ OPTIONAL ]-->
    <script src="../public/plugins/switchery/switchery.min.js"></script>


    <!--Bootstrap Select [ OPTIONAL ]-->
    <script src="../public/plugins/bootstrap-select/bootstrap-select.min.js"></script>


    <!--DataTables [ OPTIONAL ]-->
    <script src="../public/plugins/datatables/media/js/jquery.dataTables.js"></script>
    <script src="../public/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="../public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>


    <!--Demo script [ DEMONSTRATION ]-->
    <script src="../public/js/demo/nifty-demo.min.js"></script>


    <!--DataTables Sample [ SAMPLE ]-->
    <script src="../public/js/demo/tables-datatables.js"></script>

    <script type="text/javascript">
        function agregar_documento() {
            $('#modal_archivo').modal('show');
        }

        function eliminar(codigo) {
            Swal.fire({
                title: 'Estas Seguro?',
                text: "No podras deshacer esta accion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'si, Eliminar Adjunto!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = "../controller/del_colaboradorAdjunto.php?codigo=" + codigo;
                    /*
                    Swal.fire(
                        'Eliminado!',
                        'Este empleado ha sido eliminado',
                        'success'
                    )
                     */
                }
            })
        }


    </script>


    <!--

            REQUIRED
            You must include this in your project.

            RECOMMENDED
            This category must be included but you may modify which plugins or components which should be included in your project.

            OPTIONAL
            Optional plugins. You may choose whether to include it in your project or not.

            DEMONSTRATION
            This is to be removed, used for demonstration purposes only. This category must not be included in your project.

            SAMPLE
            Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


            Detailed information and more samples can be found in the document.

    -->


</body>

<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

