<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

$idempresa = $_SESSION['empresa'];

require '../models/Empresa.php';
require '../models/Banco.php';
require '../models/Venta.php';

$empresa = new Empresa();
$banco = new Banco();
$venta = new Venta();

$empresa->setIdEmpresa($idempresa);
$empresa->obtenerDatos();

$banco->setIdEmpresa($idempresa);
$venta->setIdEmpresa($idempresa);

?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Cobro con Cheque o Deposito | Software Gestion de Seguridad Industrial</title>


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

    <link rel="stylesheet" href="../public/plugins/croppie/croppie.css"/>
    <script src="../public/plugins/croppie/croppie.js"></script>
    <!-- IMPORTANTE: este fichero contiene el código de los pasos 1 y 2 que expliqué en el e-mail -->
    <script src="../public/plugins/croppie/cropie.handler.js"></script>

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
                <h1 class="page-header text-overflow">Registrar Cobro Bancario</h1>

            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">
                <form class="form-horizontal" enctype="multipart/form-data" id="graba_cobro" action="../controller/reg_cobro_banco.php" method="post">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="panel ">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_empresa">Empresa</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="input_empresa" id="input_empresa" class="form-control" value="<?php echo $empresa->getRuc() . " | " . $empresa->getRazon() ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_fecha">Fecha</label>
                                        <div class="col-sm-5">
                                            <input type="date" name="input_fecha" id="input_fecha" class="form-control" value="<?php echo date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="select_banco">Banco</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="select_banco" id="select_banco">
                                                <?php
                                                $abanco = $banco->verMisBancos();
                                                foreach ($abanco as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_banco'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="select_cliente">Cliente</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="select_cliente" id="select_cliente">
                                                <?php
                                                $acliente = $venta->verMisClientes();
                                                foreach ($acliente as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_clientes'] ?>"><?php echo $fila['razon_social'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_observacion">Observacion</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" name="input_observacion" id="input_observacion">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_monto">Monto total</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="input_monto" id="input_monto" class="form-control">
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-info" onclick="cargarPendientes()"><i class="fa fa-recycle"></i> Obtener Docs.</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_monto">Monto Acumulado</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="input_monto" id="input_monto" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_monto">Monto Pendiente</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="input_monto" id="input_monto" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="panel">
                                <!--<div class="panel-body ">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_serie">Serie</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_serie" id="input_serie" class="form-control" value="<?php echo "E001" ?>">
                                        </div>
                                        <label class="col-sm-1 control-label" for="select_nro">Nro</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="select_nro" id="select_nro">
                                                <option value="-">SELECCIONAR CLIENTE Y VALIDAR DOC</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-info" type="button" onclick="obtenerVenta()"><i class="fa fa-search"></i> Validar Doc</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_fecha_doc">Fecha Docu.</label>
                                        <div class="col-sm-3">
                                            <input type="date" name="input_fecha_doc" id="input_fecha_doc" class="form-control" readonly>
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_monto_factura">S/ total</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="input_monto_factura" id="input_monto_factura" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_monto_pendiente">S/ Pendiente</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="input_monto_pendiente" id="input_monto_pendiente" class="form-control" readonly>
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_monto">S/ a Pagar</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="input_monto" id="input_monto" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2">

                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-success" type="button"><i class="fa fa-search"></i> Agregar Doc</button>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="panel-body ">
                                    <table id="demo-dt-basic" class="table table-striped table-condensed" cellspacing="0"
                                           data-page-length='50' width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Item</th>
                                            <th class="text-center">Doc</th>
                                            <th class="text-center">Fecha Emision</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Pendiente</th>
                                            <th class="text-center" width="15%">Por Pagar</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody id="bodytabla">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
    function cargarPendientes() {
        var select_cliente = $("#select_cliente").val();
        $.post(
            "../controller/consultas_ajax/miventaspendientes.php",
            {select_cliente: select_cliente},
            function (data) {
                $("#bodytabla").html("");
                $("#bodytabla").html(data);
                /*
                $("#select_nro").html("");
                //para leer un json y pasarlos a select
                var dato = JSON.parse(data);
                var datito = JSON.parse(dato);
                $.each(datito, function (id, value) {
                    $("#select_nro").append('<option value="' + value.id_venta + '">' + value.numero + '</option>');
                });
                 */
            }
        );
    }

    function obtenerVenta() {
        var select_nro = $("#select_nro").val();
        $.post(
            "../controller/consultas_ajax/obtenerVenta.php",
            {idventa: select_nro},
            function (data) {
                var dato = JSON.parse(data);
                var pendiente = dato.monto_total - dato.monto_pagado;
                $("#input_fecha_doc").val(dato.fecha);
                $("#input_monto_factura").val(dato.monto_total);
                $("#input_monto_pendiente").val(pendiente);
            }
        );
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

