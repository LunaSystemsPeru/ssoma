<?php
include '../fixed/iniciaSession.php';

require '../models/Orden_Interna.php';
require '../models/Cliente.php';
require '../models/Empresa.php';

$cliente= new Cliente();
$empresa = new Empresa();
$orden = new Orden_Interna();

$orden->generarNroOrden();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Orden de Servicio Interna | Software Gestion de Seguridad Industrial</title>


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
                <h1 class="page-header text-overflow">Registrar Orden de Servicio Interna</h1>

            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <div class="row">
                    <form class="form-horizontal" enctype="multipart/form-data" id="graba_empleado" action="../controller/reg_orden_interna.php" method="post">
                        <div class="col-lg-12">
                            <!-- GENERAL -->
                            <!--===================================================-->

                            <div class="panel ">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_fecha_generado">Fecha</label>
                                        <div class="col-sm-2">
                                            <input type="date" name="input_fecha_generado" id="input_fecha_generado" class="form-control" value="<?php echo date('Y-m-d') ?>">
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_codigo">Nro de Orden</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_codigo" id="input_codigo" class="form-control text-center" value="<?php echo $orden->getCodigo()?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_empresas">Empresa que factura</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" name="select_empresas" id="select_empresas">
                                                <?php
                                                $a_empresas = $empresa->verTodas();
                                                foreach ($a_empresas as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_empresas']?>"><?php echo $fila['razon_social']?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_cliente">Cliente</label>
                                        <div class="col-sm-8">
                                            <select class="selectpicker" name="select_cliente" id="select_cliente">
                                                <?php
                                                $a_clientes = $cliente->verFilas();
                                                foreach ($a_clientes as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_clientes']?>"><?php echo $fila['razon_social']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_sucursal">Sucursal</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Direccion corta de Cliente" name="input_sucursal" id="input_sucursal" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_servico">Servicio:</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Servicio" name="input_servico" id="input_servico" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_solicitud">Solicitado por:</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Nombre del Solicitante" name="input_solicitud" id="input_solicitud" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_servicio">Tipo de Servicio</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="select_servicio" name="select_servicio" class="selectpicker">
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_responsable">Reponsable Servicio:</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Nombre del Responsable del Servicio" name="input_responsable" id="input_responsable" class="form-control" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_descripcion">Descripcion del Servicio</label>
                                        <div class="col-sm-8">
                                           <textarea class="form-control" name="input_descripcion"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_fecha_inicio">Fecha Inicio</label>
                                        <div class="col-sm-2">
                                            <input type="date" name="input_fecha_inicio" id="input_fecha_inicio" class="form-control" required>
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_duracion">Duracion (dias)</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_duracion" id="input_duracion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_moneda">Moneda</label>
                                        <div class="col-sm-2">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="select_moneda" name="select_moneda" class="selectpicker">
                                                <option value="1">SOL PERUANO S/</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_monto">Monto a Facturar (sin IGV)</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" name="input_monto" id="input_monto" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button class="btn btn-info" type="submit">Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </form>
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

