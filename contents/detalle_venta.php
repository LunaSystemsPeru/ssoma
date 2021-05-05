<?php
include '../fixed/iniciaSession.php';

require '../models/Cliente.php';
require '../models/Empresa.php';
require '../models/Venta.php';
require '../models/Banco.php';
require '../models/Usuario.php';
require '../models/ParametrosDetalle.php';
require '../models/VentaCobro.php';
require '../models/VentaCobroTemporal.php';

$cliente = new Cliente();
$empresa = new Empresa();
$venta = new Venta();
$banco = new Banco();
$usuario = new Usuario();
$cobro = new VentaCobro();
$temporal = new VentaCobroTemporal();
$detalle = new ParametrosDetalle();

$venta->setIdVenta(filter_input(INPUT_GET, 'idventa'));
$venta->obtenerDatos();

$detalle->setIdDetalle($venta->getIdDocumento());
$detalle->obtenerDatos();

$empresa->setIdEmpresa($venta->getIdEmpresa());
$empresa->obtenerDatos();

$cliente->setId($venta->getIdCliente());
$cliente->obtenerDatos();

$usuario->setIdUsuario($venta->getIdUsuario());
$usuario->obtenerDatos();

$banco->setIdEmpresa($venta->getIdEmpresa());

$cobro->setIdVenta($venta->getIdVenta());

$temporal->setIdventa($venta->getIdVenta());
$temporal->obtenerDatos();

$detraccion = $venta->getTotal() * $venta->getDetraccion() / 100;
$deuda = $venta->getTotal() - $venta->getPagado();

$url_pdf = '../upload/' . $empresa->getRuc() . '/ventas/' . $venta->getAdjunto();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Documento de Venta | Software Gestion de Seguridad Industrial</title>


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

    <!--Demo [ DEMONSTRATION ]-->
    <link href="../public/css/demo/nifty-demo.min.css" rel="stylesheet">

    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    <!--SCRIPT-->
    <!--=================================================-->

    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="../public/plugins/pace/pace.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


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

            <!--Page Title-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div id="page-title">
                <h1 class="page-header text-overflow">Detalle del Documento Venta</h1>

            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <div class="row">
                    <div class="col-lg-7">
                        <!-- GENERAL -->
                        <!--===================================================-->

                        <div class="panel ">
                            <div class="panel-body">
                                <a href="ventas.php" class="btn btn-info">
                                    <i class="fa fa-arrow-left"></i>
                                    regresar a la lista
                                </a>
                                <?php if ($venta->getEstado() != 2) { ?>
                                    <button type="button" class="btn btn-success" data-target="#editar_venta"
                                            data-toggle="modal">
                                        <i class="fa fa-edit"></i> Modificar
                                    </button>
                                <?php } ?>
                                <button type="button" class="btn btn-success" data-target="#ver_documento"
                                        data-toggle="modal">
                                    <i class="fa fa-file-pdf-o"></i> Ver Documento
                                </button>
                                <?php if ($venta->getEstado() != 2) { ?>
                                    <button type="button" class="btn btn-warning" data-target="#anular_documento"
                                            data-toggle="modal">
                                        <i class="fa fa-file-o"></i> Anular con NC
                                    </button>
                                    <button type="button" class="btn btn-danger">
                                        <i class="fa fa-trash"></i> Eliminar
                                    </button>
                                <?php } else { ?>
                                    <button type="button" class="btn btn-dark">
                                        <i class="fa fa-warning"></i> ANULADO
                                    </button>
                                <?php } ?>
                                <hr>
                                <div class="form-group">
                                    <p>Empresa que
                                        factura: <?php echo $empresa->getRuc() . " - " . $empresa->getRazon() ?></p>
                                    <p>Fecha Emision: <?php echo $venta->getFecha() ?></p>
                                    <p>Documento: <?php echo $detalle->getNombre() . " | " . $venta->getSerie() . " - " . $venta->getNumero() ?></p>
                                    <p>Cliente: <?php echo $cliente->getRuc() . " - " . $cliente->getRazon() ?></p>
                                    <p>Descripcion: <b><?php echo strtoupper($venta->getDescripcion()) ?></b></p>
                                    <p>observaciones: <?php echo $venta->getAnexo() ?></p>
                                    <p>Usuario: <?php echo $usuario->getUsername() ?></p>
                                    <hr>
                                </div>
                                <div class="form-group text-right">
                                    <p>IGV: <?php echo number_format($venta->getTotal() / 1.18 * 0.18, 2) ?></p>
                                    <p>Sub Total: <?php echo number_format($venta->getTotal() / 1.18, 2) ?></p>
                                    <p>Total: <?php echo number_format($venta->getTotal(), 2) ?></p>
                                    <p>Monto Detraccion: <?php echo number_format(round($detraccion, 0), 2) ?></p>
                                    <p>Monto Base: <?php echo number_format($venta->getTotal() - round($detraccion, 0), 2) ?></p>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <!-- GENERAL -->
                        <!--===================================================-->

                        <div class="panel ">
                            <div class="panel-heading">
                                <h4 class="panel-title">Detalle de Cobranzas de <?php echo $detalle->getNombre() . " | " . $venta->getSerie() . " - " . $venta->getNumero() ?></h4>
                            </div>
                            <div class="panel-body">
                                <?php if ($venta->getEstado() == 0) { ?>
                                    <button type="button" class="btn btn-success" data-target="#add_pago"
                                            data-toggle="modal">
                                        <i class="fa fa-plus"></i> Agregar
                                        Cobranza
                                    </button>
                                    <a class="btn btn-warning" href="../controller/finVenta.php?idventa=<?php echo $venta->getIdVenta() ?>">
                                        <i class="fa fa-close"></i> Cerrar Factura
                                    </a>
                                <?php } ?>
                                <hr>
                                <table id="demo-dt-basic" class="table table-striped table-condensed" cellspacing="0"
                                       data-page-length='50' width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Fecha.</th>
                                        <th>Banco</th>
                                        <th>Monto</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $a_cobros = $cobro->verTodas();
                                    foreach ($a_cobros as $item) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $item['fecha'] ?></td>
                                            <td><?php echo $item['nombre'] ?></td>
                                            <td><?php echo number_format($item['monto'], 2) ?></td>
                                            <td class="text-center">
                                                <button type="button"
                                                        onclick="eliminar(<?php echo $item['id_movimiento'] ?>)"
                                                        class="btn btn-danger btn-icon fa fa-trash"></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right">


                            </div>
                        </div>

                        <div class="panel ">
                            <div class="panel-heading">
                                <h4 class="panel-title">Pagos Temporales de <?php echo $detalle->getNombre() . " | " . $venta->getSerie() . " - " . $venta->getNumero() ?></h4>
                            </div>
                            <div class="panel-body">
                                <?php if ($venta->getEstado() == 0) { ?>
                                    <button type="button" class="btn btn-success" data-target="#add_pago_temporal"
                                            data-toggle="modal">
                                        <i class="fa fa-plus"></i> Agregar
                                        Cobro Temporal
                                    </button>
                                <?php } ?>
                                <hr>
                                <table id="demo-dt-basic" class="table table-striped table-condensed" cellspacing="0"
                                       data-page-length='50' width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Fecha.</th>
                                        <th>Banco</th>
                                        <th>Monto</th>
                                        <th>Nota</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $suma_temporales = 0;
                                    $a_temporales = $temporal->verPagos();
                                    foreach ($a_temporales as $item) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $item['fecha'] ?></td>
                                            <td><?php echo $item['nombre'] ?></td>
                                            <td><?php echo number_format($item['monto'], 2) ?></td>
                                            <td><?php echo $item['nota'] ?></td>
                                            <td class="text-center">
                                                <button type="button"
                                                        onclick="eliminar(<?php echo $item['id_venta'] ?>)"
                                                        class="btn btn-danger btn-icon fa fa-trash"></button>
                                            </td>
                                        </tr>
                                        <?php
                                        $suma_temporales += $item['monto'];
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right">
                                <p>Total: <?php echo number_format($venta->getTotal(), 2) ?></p>
                                <p>Pagado: <?php echo number_format($venta->getPagado() , 2) ?></p>
                                <p>Pago Temporal: <?php echo number_format($suma_temporales, 2) ?></p>
                                <p>Pendiente: <?php echo number_format($deuda - $suma_temporales, 2) ?></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>



        <!--===================================================-->
        <!--End page content-->


    </div>
    <!--===================================================-->
    <!--END CONTENT CONTAINER-->

    <div class="modal" id="editar_venta" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--Modal header-->
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Editar Documento</h4>
                </div>
                <form class="form-horizontal" action="../controller/reg_venta.php" method="post">
                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="select_empresas">Empresa que Factura</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="select_empresas" id="select_empresas">
                                    <?php
                                    $a_empresas = $empresa->verTodas();
                                    foreach ($a_empresas as $fila) {
                                        ?>
                                        <option <?php echo($venta->getIdEmpresa() == $fila['id_empresas'] ? "selected" : "") ?>
                                                value="<?php echo $fila['id_empresas'] ?>"><?php echo $fila['razon_social'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="select_documento"> Tipo Documento</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="select_documento" id="select_documento">
                                    <option <?php echo($venta->getIdDocumento() == 34 ? "selected" : "") ?> value="34">
                                        BOLETA
                                    </option>
                                    <option <?php echo($venta->getIdDocumento() == 35 ? "selected" : "") ?> value="35">
                                        FACTURA
                                    </option>
                                </select>
                            </div>
                            <label class="col-sm-1 control-label" for="input_fecha">Fecha</label>
                            <div class="col-sm-2">
                                <input type="date" name="input_fecha" id="input_fecha" class="form-control"
                                       value="<?php echo $venta->getFecha() ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="select_serie"> Serie</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="select_serie" id="select_serie">
                                    <option value="E001">E001</option>
                                </select>
                            </div>
                            <label class="col-sm-1 control-label" for="input_numero">Numero</label>
                            <div class="col-sm-2">
                                <input type="text" name="input_numero" id="input_numero" class="form-control"
                                       value="<?php echo $venta->getNumero() ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="select_cliente">Cliente</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="select_cliente" id="select_cliente">
                                    <?php
                                    $a_clientes = $cliente->verFilas();
                                    foreach ($a_clientes as $fila) {
                                        ?>
                                        <option <?php echo($venta->getIdCliente() == $fila['id_clientes'] ? "selected" : "") ?>
                                                value="<?php echo $fila['id_clientes'] ?>"><?php echo $fila['razon_social'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input_servico">Descripcion Corta:</label>
                            <div class="col-sm-9">
                                <input type="text" placeholder="Servicio" name="input_servico" id="input_servico"
                                       class="form-control" value="<?php echo $venta->getDescripcion() ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="select_afecto"> Afecto IGV</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="select_afecto" id="select_afecto">
                                    <option <?php echo($venta->getAfecto() == 1 ? "selected" : "") ?> value="1">SI
                                    </option>
                                    <option <?php echo($venta->getAfecto() == 2 ? "selected" : "") ?> value="2">NO
                                    </option>
                                </select>
                            </div>
                            <label class="col-sm-1 control-label" for="input_total">Total Factura</label>
                            <div class="col-sm-2">
                                <input type="text" name="input_total" id="input_total" class="form-control text-right"
                                       value="<?php echo $venta->getTotal() ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input_detraccion"> % Detraccion</label>
                            <div class="col-sm-2">
                                <select class="form-control" name="input_detraccion" id="input_detraccion">
                                    <option <?php echo($venta->getDetraccion() == 0 ? "selected" : "") ?> value="0">0%
                                    </option>
                                    <option <?php echo($venta->getDetraccion() == 10 ? "selected" : "") ?> value="10">
                                        10%
                                    </option>
                                    <option <?php echo($venta->getDetraccion() == 12 ? "selected" : "") ?> value="12">
                                        12%
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="input_observaciones"> Observaciones</label>
                            <div class="col-sm-9">
                                <input type="text" name="input_observaciones" id="input_observaciones"
                                       class="form-control" value="<?php echo $venta->getAnexo() ?>" required>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_idventa" value="<?php echo $venta->getIdVenta() ?>">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                        <input type="submit" class="btn btn-primary" name="graba_documento">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="add_pago" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--Modal header-->
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Pago</h4>
                </div>
                <form class="form-horizontal" action="../controller/reg_venta_cobro.php" method="post">
                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Seleccionar Banco</label>
                            <div class="col-lg-8">
                                <select class="form-control" name="select_banco">
                                    <?php
                                    $a_banco = $banco->verMisBancos();
                                    foreach ($a_banco as $item) {
                                        ?>
                                        <option value="<?php echo $item['id_banco'] ?>"> <?php echo $item['nombre'] . " | " . $item['cuenta'] . " | " . $item['monto'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Fecha</label>
                            <div class="col-lg-4">
                                <input type="date" name="input_fecha" id="input_fecha" class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Monto Total</label>
                            <div class="col-lg-4">
                                <input type="text" name="input_monto" id="input_monto"
                                       class="form-control text-right"
                                       value="<?php echo number_format($venta->getTotal(), 2) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Monto Pendiente</label>
                            <div class="col-lg-4">
                                <input type="text" name="input_pendiente" id="input_pendiente"
                                       class="form-control text-right" value="<?php echo number_format($deuda, 2) ?>"
                                       readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Monto a Pagar</label>
                            <div class="col-lg-4">
                                <input type="text" name="input_pagar" id="input_pagar"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_idventa" value="<?php echo $venta->getIdVenta() ?>">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                        <input type="submit" class="btn btn-primary" name="graba_documento">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="add_pago_temporal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!--Modal header-->
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Agregar Pago Temporal</h4>
                </div>
                <form class="form-horizontal" action="../controller/reg_venta_cobro_temporal.php" method="post">
                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Seleccionar Banco</label>
                            <div class="col-lg-8">
                                <select class="form-control" name="select_banco">
                                    <?php
                                    $a_banco = $banco->verMisBancos();
                                    foreach ($a_banco as $item) {
                                        ?>
                                        <option value="<?php echo $item['id_banco'] ?>"> <?php echo $item['nombre'] . " | " . $item['cuenta'] . " | " . $item['monto'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Fecha</label>
                            <div class="col-lg-4">
                                <input type="date" name="input_fecha" id="input_fecha" class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Monto Total</label>
                            <div class="col-lg-4">
                                <input type="text" name="input_monto" id="input_monto"
                                       class="form-control text-right"
                                       value="<?php echo number_format($venta->getTotal(), 2) ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Monto Pendiente</label>
                            <div class="col-lg-4">
                                <input type="text" name="input_pendiente" id="input_pendiente"
                                       class="form-control text-right" value="<?php echo number_format($deuda, 2) ?>"
                                       readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Monto a Pagar</label>
                            <div class="col-lg-4">
                                <input type="text" name="input_pagar" id="input_pagar"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Nota - Observaciones</label>
                            <div class="col-lg-7">
                                <input type="text" name="input_notas" id="input_notas"
                                       class="form-control">
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_idventa" value="<?php echo $venta->getIdVenta() ?>">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                        <input type="submit" class="btn btn-primary" name="graba_documento">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="ver_documento" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--Modal header-->
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Ver Documento de Venta en PDF</h4>
                </div>
                <!--Modal body-->
                <div class="modal-body">
                    <embed id="view_pdf" src="<?php echo $url_pdf ?>" type="application/pdf" class="col-sm-12"
                           height="500px">
                </div>
                <!--Modal footer-->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="anular_documento" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!--Modal header-->
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Anular con NOTA</h4>
                </div>
                <form class="form-horizontal" action="../controller/reg_venta_nota.php" method="post" enctype="multipart/form-data">
                    <!--Modal body-->
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Documento</label>
                            <div class="col-lg-8">
                                <select class="form-control">
                                    <option value="36">NOTA DE CREDITO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Fecha</label>
                            <div class="col-lg-3">
                                <input type="date" name="input_fecha" id="input_fecha" class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Serie</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="select_serie">
                                    <option value="E001">E001</option>
                                </select>
                            </div>
                            <label class="col-lg-2 control-label">Numero</label>
                            <div class="col-lg-2">
                                <input type="text" name="input_numero" id="input_numero"
                                       class="form-control text-right" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="input_archivo"> Adjuntar PDF</label>
                            <div class="col-sm-9">
                                <input type="file" name="input_archivo" id="input_archivo" class="form-control" required accept="application/pdf" onchange="ver_pdf()">
                            </div>
                        </div>
                    </div>

                    <!--Modal footer-->
                    <div class="modal-footer">
                        <input type="hidden" name="hidden_idventa" value="<?php echo $venta->getIdVenta() ?>">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                        <input type="submit" class="btn btn-primary" name="graba_documento" value="Grabar">
                    </div>
                </form>
            </div>
        </div>
    </div>


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


<!--Demo script [ DEMONSTRATION ]-->
<script src="../public/js/demo/nifty-demo.min.js"></script>

<script>
    function eliminar(codigo) {
        Swal.fire({
            title: 'Estas Seguro?',
            text: "No podras deshacer esta accion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, Eliminar Pago de documento!'
        }).then((result) => {
            if (result.value) {
                window.location.href = "../controller/del_cobro_venta.php?idmovimiento=" + codigo + "&idventa=" + <?php echo $venta->getIdVenta()?>;
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

<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
</html>

