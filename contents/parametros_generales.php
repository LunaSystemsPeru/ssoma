<?php
include '../fixed/iniciaSession.php';

require '../models/ParametrosGenerale.php';
require '../models/ParametrosDetalle.php';

$parametros = new ParametrosGenerale();
$detalle = new ParametrosDetalle();

if (filter_input(INPUT_GET, 'id')) {
    $detalle->setIdParametro(filter_input(INPUT_GET, 'id'));
    $parametros->setIdParametro($detalle->getIdParametro());
    $parametros->obtenerDatos();
}
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parametros Generales | Software Gestion de Seguridad Industrial</title>


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
        This is to be removed, used for�demonstration purposes only.�This category must not be included in your project.

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

            <!--Page Title-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--div id="page-title">
                <h1 class="page-header text-overflow">Empleados</h1>
            </div-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">


                <!-- Basic Data Tables -->
                <!--===================================================-->
                <div class="col-sm-5">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Listar Parametros Generales</b></h3>
                        </div>
                        <!--Data Table-->
                        <!--===================================================-->
                        <div class="panel-body">
                            <div class="pad-btm form-inline">
                                <div class="row">
                                    <div class="col-sm-6 table-toolbar-left">
                                        <button data-target="#add_tipo_documento" data-toggle="modal" class="btn btn-primary btn-m">Agregar</button>
                                        <button class="btn btn-default"><i class="fa fa-print"></i></button>
                                        <div class="btn-group">
                                            <button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Cod.</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    foreach ($parametros->verFilas() as $fila) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $fila['id_parametro'] ?></a></td>
                                            <td><a href="parametros_generales.php?id=<?php echo $fila['id_parametro'] ?>"><?php echo $fila['nombre'] ?></a></td>
                                            <td class="text-center">
                                                <a href="parametros_generales.php?id=<?php echo $fila['id_parametro'] ?>" class="btn btn-info"><i class="fa fa-search"></i></a>
                                                <button onclick="editar('<?php echo $fila['id_parametro'] ?>'')" class="btn btn-info btn-icon icon-lg fa fa-edit"></button>
                                                <button class="btn btn-danger btn-icon icon-lg fa fa-trash"></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--===================================================-->
                        <!--End Data Table-->
                    </div>
                </div>

                <div class="col-sm-7">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><b>Detalle de Parametro <?php echo " de " . $parametros->getNombre() ?></b></h3>
                        </div>
                        <!--Data Table-->
                        <!--===================================================-->
                        <div class="panel-body">
                            <div class="pad-btm form-inline">
                                <div class="row">
                                    <div class="col-sm-6 table-toolbar-left">
                                        <?php
                                        if ($detalle->getIdParametro()) {
                                            ?>
                                            <button data-target="#add_detalle" data-toggle="modal" class="btn btn-success">Agregar</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Cod.</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Valor</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    foreach ($detalle->verFilas() as $fila) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $fila['id_detalle'] ?></a></td>
                                            <td><?php echo $fila['nombre'] ?></td>
                                            <td><?php echo $fila['valor'] ?></td>
                                            <td class="text-center">
                                                <button onclick="editarDetalle('<?php echo $fila['id_detalle'] ?>'')" class="btn btn-info btn-icon icon-lg fa fa-edit"></button>
                                                <button class="btn btn-danger btn-icon icon-lg fa fa-trash"></button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--===================================================-->
                        <!--End Data Table-->
                    </div>
                </div>
                <!--===================================================-->
                <!-- End Striped Table -->

            </div>
            <!--===================================================-->
            <!--End page content-->


        </div>
        <!--===================================================-->
        <!--END CONTENT CONTAINER-->

        <!--Default Bootstrap Modal-->
        <!--===================================================-->
        <div class="modal" id="add_tipo_documento" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Crear Parametro General</h4>
                    </div>
                    <form class="form-horizontal" id="frm_registra_clase" action="../controller/reg_parametrosGenerale.php" method="post">
                        <!--Modal body-->
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Codigo</label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Nombre" name="input_codigo" id="input_codigo" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Nombre</label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Nombre" name="input_nombre" id="input_nombre" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!--Modal footer-->
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                            <input type="submit" class="btn btn-primary" name="graba_documento">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal" id="add_detalle" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Crear Parametro General</h4>
                    </div>
                    <form class="form-horizontal" action="../controller/reg_parametrosDetalle.php" method="post">
                        <!--Modal body-->
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Id Parametro</label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Nombre" name="input_codigo" id="input_codigo" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Id Parametro</label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Nombre" name="input_idParametro" id="input_idParametro" value="<?php echo $parametros->getIdParametro() ?>" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Nombre</label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Nombre" name="input_nombre" id="input_nombre" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Valor</label>
                                <div class="col-lg-7">
                                    <input type="text" placeholder="Nombre" name="input_valor" id="input_valor" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!--Modal footer-->
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                            <input type="submit" class="btn btn-primary" name="graba_documento">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="edita_clase" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div name="contenido_edita_clase" class="modal-content" id="contenido_edita_clase">

                </div>
            </div>
        </div>
        <!--===================================================-->
        <!--End Default Bootstrap Modal-->


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

<!--Bootstrap Validator [ OPTIONAL ]-->
<script src="../public/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>


<!--DataTables [ OPTIONAL ]-->
<script src="../public/plugins/datatables/media/js/jquery.dataTables.js"></script>
<script src="../public/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="../public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>


<!--Demo script [ DEMONSTRATION ]-->
<script src="../public/js/demo/nifty-demo.min.js"></script>


<!--Masked Input [ OPTIONAL ]-->
<script src="../public/plugins/masked-input/jquery.maskedinput.min.js"></script>


<!--Form validation [ SAMPLE ]-->
<script src="../public/js/demo/form-validation.js"></script>


<!--DataTables Sample [ SAMPLE ]-->
<script src="../public/js/demo/tables-datatables.js"></script>

<script type="text/javascript">
    function editar(id) {
        var parametros = {
            "codigo": id,
        };
        $.ajax({
            data: parametros,
            url: 'modificar_clase_documento.php',
            type: 'post',
            beforeSend: function () {
                $("#contenido_edita_clase").html("Procesando, espere por favor...");
            },
            success: function (response) {
                $("#contenido_edita_clase").html(response);
            }
        });
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
    This is to be removed, used for�demonstration purposes only.�This category must not be included in your project.

    SAMPLE
    Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


    Detailed information and more samples can be found in the document.

-->


</body>

<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

