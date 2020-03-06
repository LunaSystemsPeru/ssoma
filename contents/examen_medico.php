<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

include ("includes/conectar.php");
require("includes/varios.php");

$varios = new Varios();
$empleado = $_GET['id'];
$empresa = $_SESSION['empresa'];

$ver_empleado = "select e.codigo, e.dni, e.nombres from empleado as e where e.codigo = '" . $empleado . "'";
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
        <title>Examen Medico -- Empleados | Software Gestion de Seguridad Industrial</title>


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
        <script src="plugins/pace/pace.min.js"></script>



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
                                <h3 class="panel-title"><b>Examen Medico</b> --- <?php echo $nombres; ?></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button data-target="#add_estudios" data-toggle="modal" class="btn btn-primary btn-m">Agregar</button>
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
                                                <th class="text-center">Evaluador</th>
                                                <th class="text-center">Resultado</th>
                                                <th class="text-center">Fec. Evaluacion</th>
                                                <th class="text-center">Fec. Renovacion</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ver_examenes = "select id, current_date() as fecha_actual, fecha_evaluacion, date_add(fecha_evaluacion, INTERVAL 2 YEAR) as fecha_renovacion, resultado, evaluador from examen_medico where empleado = '" . $empleado . "' and empresa = '" . $empresa . "' order by id asc";
                                            $resultado = $conn->query($ver_examenes);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    $fecha_renovacion_larga = strtotime($varios->fecha_larga($fila['fecha_renovacion']));
                                                    $fecha_actual_larga = strtotime($varios->fecha_larga($fila['fecha_actual']));
                                                    if ($fecha_renovacion_larga > $fecha_actual_larga) {
                                                        $estado = '<span class="label label-success">VIGENTE</span>';
                                                    } else {
                                                        $estado = '<span class="label label-danger">POR RENOVAR</span>';
                                                    }
                                                    echo '<tr>
														<td>' . $fila['id'] . '</a></td>
														<td class="text-center">' . $fila['evaluador'] . '</td>
                                                        <td class="text-center">' . $fila['resultado'] . '</td>
														<td class="text-center">' . $varios->fecha_tabla($fila['fecha_evaluacion']) . '</td>
														<td class="text-center">' . $varios->fecha_tabla($fila['fecha_renovacion']) . '</td>
														<td class="text-center">' . $estado . '</td>
														<td>
														<button onclick="ver_detalles(\'' . $fila['id'] . '\',\'' . $empleado . '\')" data-target="#ver_detalles" data-toggle="modal"  class="btn btn-success btn-icon icon-lg fa fa-print"></button>
														<button class="btn btn-info btn-icon icon-lg fa fa-trash"></button>
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
                <div class="modal" id="add_estudios" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Registro de Examen</h4>
                            </div>
                            <form class="form-horizontal" action="inserts/add_examen.php" enctype="multipart/form-data" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Evaluadora</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="Empresa Evaluadora" name="evaluadora" id="evaluador" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fecha Evaluacion</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="dd/mm/aaaa" name="fecha" id="fecha" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Resultados</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="Ingrese Resultados" name="resultados" id="resultados" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Observaciones</label>
                                        <div class="col-lg-8">
                                            <textarea name="observaciones" placeholder="Ingrese Observaciones" class="form-control"  rows="8" cols="30"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Documento</label>
                                        <div class="col-lg-8">
                                            <input class="btn btn-default" type="file" name="file" id="file"/>
                                            <div id="message"></div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                    <input type="submit" class="btn btn-primary" name="graba_examen">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

        <!--Default Bootstrap Modal-->
        <!--===================================================-->
        <div class="modal" id="ver_detalles" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div name="contenido_detalle" class="modal-content contenido_detalle" id="contenido_detalle">

                </div>
            </div>
        </div>
        <!--===================================================-->
        <!--End Default Bootstrap Modal-->


        <!--JAVASCRIPT-->
        <!--=================================================-->

        <!--jQuery [ REQUIRED ]-->
        <script src="js/jquery-2.1.1.min.js"></script>


        <!--BootstrapJS [ RECOMMENDED ]-->
        <script src="js/bootstrap.min.js"></script>


        <!--Fast Click [ OPTIONAL ]-->
        <script src="plugins/fast-click/fastclick.min.js"></script>


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

        <script type="text/javascript">

            function ver_detalles(id, empleado) {
                var parametros = {
                    "id_examen": id,
                    "id_empleado": empleado,
                };
                $.ajax({
                    data: parametros,
                    url: 'frm_modificar/detalle_examen.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_detalle").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_detalle").html(response);
                    }
                });
            }

            $(document).ready(function (e) {
                // Function to preview image after validation
                $(function () {
                    $("#file").change(function () {
                        $("#message").empty(); // To remove the previous error message
                        var ext = $("#file").val().split('.').pop().toLowerCase();
                        if ($.inArray(ext, ['pdf', 'doc', 'docx']) == -1)
                        {
                            $("#message").html("<p id='error'>Por Favor Seleccione un archivo valido</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Solamente *.pdf, *.doc, *.docx esta permitidos</span>");
                            return false;
                        }
                        else
                        {
                            var reader = new FileReader();
                            reader.onload = imageIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                });
                function imageIsLoaded(e) {
                    $("#file").css("color", "green");
                    //$('#previewing').attr('height', '300px');
                }
                ;
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

    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

