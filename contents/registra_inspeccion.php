<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include ("includes/conectar.php");
require("includes/varios.php");

$varios = new Varios();

$mes_actual = date("m");
$anio_actual = date("Y");
$tipo = $_GET['tipo'];
$id = $_GET['id'];
$anio = $_GET['anio'];
$empresa = $_SESSION['empresa'];
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inspecciones de <?php echo strtoupper($tipo) ?> | Software Gestion de Seguridad Industrial</title>


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


        <!--Chosen [ OPTIONAL ]-->
        <link href="../public/plugins/chosen/chosen.min.css" rel="stylesheet">


        <!--Bootstrap Validator [ OPTIONAL ]-->
        <link href="../public/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">



        <!--SCRIPT-->
        <!--=================================================-->

        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
        <script src="plugins/pace/pace.min.js"></script>


        <script type="text/javascript">
            function regresar() {
                history.back();
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


    </head>

    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

    <body>
        <div id="container" class="effect mainnav-lg">

            <!--NAVBAR-->
            <!--===================================================-->
            <?php include("includes/header.php"); ?>
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
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Agregar Inspeccion de <?php echo strtoupper($tipo) ?></b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <form class="form-horizontal" id="frm_registra_inspeccion" action="inserts/add_inspeccion.php" method="post">
                                    <!--Modal body-->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Tipo</label>
                                            <div class="col-lg-7">
                                                <input type="text" name="tipo" class="form-control" value="<?php echo $tipo ?>" readonly="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Fecha</label>
                                            <div class="col-lg-7">
                                                <input type="text" placeholder="dd/mm/aaa" name="fecha" id="fecha_registro" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Area</label>
                                            <div class="col-lg-7">
                                                <input type="text" placeholder="Area" name="area" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Local</label>
                                            <div class="col-lg-7">
                                                <input type="text" placeholder="Local" name="local" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label" for="inspector">Inspector</label>
                                            <div class="col-lg-7">
                                                <select data-placeholder="Buscar Inspector" id="demo-chosen-select" name="inspector" class="form-control" required>
                                                    <?php
                                                    global $conn;
                                                    $consulta = "select * from empleado where empresa = '" . $empresa . "' order by nombres asc";
                                                    $resultado1 = $conn->query($consulta);
                                                    if ($resultado1->num_rows > 0) {
                                                        while ($fila = $resultado1->fetch_assoc()) {
                                                            echo '<option value=' . $fila['codigo'] . '>' . strtoupper($fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat']) . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Modal footer-->
                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <input type="hidden" name="anio" value="<?php echo $anio ?>">
                                        <input type="hidden" name="tipo" value="<?php echo $tipo ?>">
                                        <button onclick="regresar()" type="button" class="btn btn-default">Regresar</button>
                                        <input type="submit" class="btn btn-primary" name="graba_inspeccion">
                                    </div>
                                </form>
                            </div>
                            <!--===================================================-->
                            <!--End Data Table-->
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
                <!--===================================================-->
                <!--End Default Bootstrap Modal-->



                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <?php include("includes/main_navigation.php"); ?>
                <!--===================================================-->
                <!--END MAIN NAVIGATION-->

                <!-- TAB DE LA DERECHA -->
                <!--ASIDE-->
                <!--===================================================-->
                <?php include("includes/aside_rigth.php"); ?>
                <!--===================================================-->
                <!--END ASIDE-->
            </div>



            <!-- FOOTER -->
            <!--===================================================-->
            <?php include("includes/footer.php"); ?>
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
        <script src="js/jquery-2.1.1.min.js"></script>


        <!--BootstrapJS [ RECOMMENDED ]-->
        <script src="js/bootstrap.min.js"></script>


        <!--Fast Click [ OPTIONAL ]-->
        <script src="plugins/fast-click/fastclick.min.js"></script>

        <!--Chosen [ OPTIONAL ]-->
        <script src="plugins/chosen/chosen.jquery.min.js"></script>


        <!--Nifty Admin [ RECOMMENDED ]-->
        <script src="js/nifty.min.js"></script>


        <!--Switchery [ OPTIONAL ]-->
        <script src="plugins/switchery/switchery.min.js"></script>


        <!--Bootstrap Select [ OPTIONAL ]-->
        <script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>

        <!--Bootstrap Validator [ OPTIONAL ]-->
        <script src="plugins/bootstrap-validator/bootstrapValidator.min.js"></script>


        <!--DataTables [ OPTIONAL ]-->
        <script src="plugins/datatables/media/js/jquery.dataTables.js"></script>
        <script src="plugins/datatables/media/js/dataTables.bootstrap.js"></script>
        <script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>


        <!--Demo script [ DEMONSTRATION ]-->
        <script src="js/demo/nifty-demo.min.js"></script>


        <!--Masked Input [ OPTIONAL ]-->
        <script src="plugins/masked-input/jquery.maskedinput.min.js"></script>


        <!--Form validation [ SAMPLE ]-->
        <script src="js/demo/form-validation.js"></script>


        <!--DataTables Sample [ SAMPLE ]-->
        <script src="js/demo/tables-datatables.js"></script>

        <!--Form Component [ SAMPLE ]-->
        <script src="js/demo/form-component.js"></script>

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

