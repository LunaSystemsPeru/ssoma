<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include("includes/conectar.php");
$codigo = $_GET['id'];

$ver_empleado = "select e.codigo, e.dni, e.nombres "
        . "from empleado as e "
        . "where e.codigo = '" . $codigo . "'";
$resultado = $conn->query($ver_empleado);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $nombres = $fila['nombres'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Entrega de EPPs | Software Gestion de Seguridad Industrial</title>


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


        <script type="text/javascript">
            function add_epp(empleado) {
                document.location.href = "registra_epp.php?id=" + empleado;
            }
            function ver_nota_salida(entrega, empleado) {
                document.location.href = "reportes/nota_salida_epp.php?entrega=" + entrega + "&empleado=" + empleado;
            }
            function ver_historial(empleado) {
                document.location.href = "reportes/historial_epp.php?empleado=" + empleado;
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
                        <div class="panel col-sm-12">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Entrega de EPPs</b> -- <?php echo $nombres; ?></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button onclick="add_epp(<?php echo '\'' . $codigo . '\''; ?>)" id="demo-btn-addrow" class="btn btn-purple btn-labeled fa fa-plus">Entregar EPP</button>
                                            <button class="btn btn-default" onclick="ver_historial(<?php echo $codigo?>)"><i class="fa fa-print"></i></button>
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
                                                <th class="text-center">Cod. Entrega</th>
                                                <th class="text-center">Cod. EPP</th>
                                                <th>Nombre</th>
                                                <th class="text-center">Fecha Entrega</th>
                                                <th class="text-center">Fec. Cambio Aprox.</th>
                                                <th class="text-center">Fec. Cambio</th>
                                                <th class="text-center">Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $empresa = $_SESSION['empresa'];

                                            function fecha_tabla($date) {
                                                $to_format = 'd/m/Y';
                                                $from_format = 'Y-m-d';
                                                $date_aux = date_create_from_format($from_format, $date);
                                                return date_format($date_aux, $to_format);
                                            }

                                            //buscar empleados en esta empresa
                                            $historial = "select he.id as id_entrega, e.nombre, e.id, e.duracion, he.fecha_entrega, ADDDATE(he.fecha_entrega, INTERVAL e.duracion DAY) as fecha_retorno, dhe.fecha_devolucion, dhe.estado from detalle_historial_epp as dhe inner join historial_epp as he on dhe.id = he.id and dhe.empresa = he.empresa and dhe.empleado = he.empleado inner join epp as e on dhe.epp = e.id where he.empleado = '" . $codigo . "' and he.empresa = '" . $empresa . "' order by dhe.estado asc, fecha_retorno desc";
                                            $resultado = $conn->query($historial);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    if ($fila['estado'] == "0") {
                                                        $estado = '<span class="label label-success">EN USO</span>';
                                                    } else {
                                                        $estado = '<span class="label label-danger">DEVUELTO</span>';
                                                    }
                                                    if ($fila['fecha_devolucion'] == "7000-01-01") {
                                                        $fecha_devolucion = "-";
                                                        $fecha_cambio = fecha_tabla($fila['fecha_retorno']);
                                                    } else {
                                                        $fecha_devolucion = fecha_tabla($fila['fecha_devolucion']);
                                                        $fecha_cambio = " - ";
                                                    }
                                                    echo '<tr>
														<td>' . $fila['id_entrega'] . '</a></td>
														<td>' . $fila['id'] . '</a></td>
														<td>' . $fila['nombre'] . '</td>
														<td class="text-center">' . fecha_tabla($fila['fecha_entrega']) . '</td>
														<td class="text-center">' . $fecha_cambio . '</td>
														<td class="text-center">' . $fecha_devolucion . '</td>
														<td class="text-center">' . $estado . '</td>
														<td>
														<button onclick="ver_nota_salida(\'' . $fila['id_entrega'] . '\', \'' . $codigo . '\')" class="btn btn-success btn-icon icon-lg fa fa-file-text-o"></button>
														<button onclick="DevolverEPP(\'' . $fila['id_entrega'] . '\', \'' . $fila['id'] . '\', \'' . $codigo . '\', \'' . $empresa . '\')" data-target="#devolver_epp" data-toggle="modal" class="btn btn-warning btn-icon icon-lg fa fa-undo"></button>
														<button onclick="eliminar(\'' . $fila['id_entrega'] . '\', \'' . $fila['id'] . '\')" class="btn btn-info btn-icon icon-lg fa fa-trash"></button>
														</td>
														</tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
                <div class="modal" id="devolver_epp" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_devuelve_epp" class="modal-content contenido_devuelve_epp" id="contenido_devuelve_epp">

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

            function DevolverEPP(entrega, epp, empleado, empresa) {
                var parametros = {
                    "id_entrega": entrega,
                    "id_epp": epp,
                    "id_empleado": empleado,
                    "id_empresa": empresa,
                };
                $.ajax({
                    data: parametros,
                    url: 'devolver_epp.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_devuelve_epp").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_devuelve_epp").html(response);
                    }
                });
            }

            function devolver(entrega, empleado) {
                document.location.href = "accion_epp.php?epp=" + empleado + "&entrega=" + entrega + "&accion=devolver";
            }
            function eliminar(entrega, empleado) {
                document.location.href = "accion_epp.php?epp=" + empleado + "&entrega=" + entrega + "&accion=eliminar";
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

