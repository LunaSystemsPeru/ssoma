<?php
include '../fixed/iniciaSession.php';

require '../models/Proveedor.php';
require '../models/Empresa.php';
require '../models/ParametrosDetalle.php';
require '../tools/varios.php';

$proveedor = new Proveedor();
$empresa = new Empresa();
$parametros = new ParametrosDetalle();
$varios = new Varios();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Documento de Compra | Software Gestion de Seguridad Industrial</title>


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
                <h1 class="page-header text-overflow">Registrar Documento Compra</h1>

            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <div class="row">
                    <form class="form-horizontal" enctype="multipart/form-data" id="graba_empleado" action="../controller/reg_compra.php" method="post">
                        <div class="col-lg-12">
                            <!-- GENERAL -->
                            <!--===================================================-->

                            <div class="panel ">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="select_empresas">Empresa que Recibe</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="select_empresas" id="select_empresas">
                                                <?php
                                                $a_empresas = $empresa->verTodas();
                                                foreach ($a_empresas as $fila) {
                                                    $selected = "";
                                                    $selected = ($fila['id_empresas'] == $_SESSION['empresa'] ? "selected" : "") ;
                                                    ?>
                                                    <option <?php echo $selected ?> value="<?php echo $fila['id_empresas']?>"><?php echo $fila['razon_social']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_periodo"> Periodo</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_periodo" id="input_periodo" class="form-control" value="<?php echo date("Ym")?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="select_documento"> Tipo Documento</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="select_documento" id="select_documento">
                                                <?php
                                                $parametros->setIdParametro(12);
                                                $a_documentos =$parametros->verFilas();
                                                foreach ($a_documentos as $fila) {
                                                    $selected = "";
                                                    $selected = ($fila['id_detalle'] == 35? "selected" : "") ;
                                                    ?>
                                                    <option <?php echo $selected?> value="<?php echo $fila['id_detalle']?>"><?php echo $fila['nombre']?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 control-label" for="input_fecha">Fecha</label>
                                        <div class="col-sm-2">
                                            <input type="date" name="input_fecha" id="input_fecha" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_serie"> Serie</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_serie" id="input_serie" class="form-control" required>
                                        </div>
                                        <label class="col-sm-1 control-label" for="input_numero">Numero</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_numero" id="input_numero" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input_buscar_proveedor">Proveedor</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="input_buscar_proveedor" id="input_buscar_proveedor" class="form-control" >
                                            <input type="hidden" name="hidden_idproveedor" id="hidden_idproveedor">
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="proveedores.php" target="_blank" class="btn btn-info"><i class="fa fa-plus"></i> Agregar Proveedor</a>
                                        </div>
                                        <label class="col-sm-1 control-label" for="input_ruc">RUC</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_ruc" id="input_ruc" class="form-control" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="select_cliente">Razon Social</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="input_razon_social" id="input_razon_social" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label" for="select_afecto"> Afecto IGV</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="select_afecto" id="select_afecto">
                                                <option value="1">SI</option>
                                                <option value="2">NO</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 control-label" for="input_total">Total Factura</label>
                                        <div class="col-sm-2">
                                            <input type="text" name="input_total" id="input_total" class="form-control text-right" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <a href="compras.php" class="btn btn-warning" ><i class="fa fa-arrow-left"></i> Regresar a lista</a>
                                    <button class="btn btn-success" type="submit">Aceptar</button>
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

<script src="../public/js/js_cliente.js"></script>

<script>
    // esta rutina se ejecuta cuando jquery esta listo para trabajar
    $(function()
    {
        // configuramos el control que hemos de utilizar para la busqueda de productos
        $("#input_buscar_proveedor").autocomplete({
            source: "../controller/consultas_ajax/proveedores.php", /* este es el script que realiza la busqueda */
            minLength: 4, /* le decimos que espere hasta que haya 2 caracteres escritos */
            select: function (event, ui) {
                console.log(ui);
                $("#input_razon_social").val("");
                $("#input_razon_social").val(ui.item.razon);
                $("#input_ruc").val("");
                $("#input_ruc").val(ui.item.ruc);
                $("#hidden_idproveedor").val(ui.item.id);
                $("#input_total").focus();
            }
        });
    });
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

