<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include ("includes/conectar.php");
require ("includes/varios.php");

$varios = new Varios();

$mes_actual = date("m");
$anio_actual = date("Y");

$empresa = $_SESSION['empresa'];
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Programa de Inspecciones | Software Gestion de Seguridad Industrial</title>


        <!--STYLESHEET-->
        <!--=================================================-->



        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="css/bootstrap.min.css" rel="stylesheet">


        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="css/nifty.min.css" rel="stylesheet">


        <!--Font Awesome [ OPTIONAL ]-->
        <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


        <!--Switchery [ OPTIONAL ]-->
        <link href="plugins/switchery/switchery.min.css" rel="stylesheet">


        <!--Bootstrap Select [ OPTIONAL ]-->
        <link href="plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


        <!--Bootstrap Table [ OPTIONAL ]-->
        <link href="plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
        <link href="plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">


        <!--Demo [ DEMONSTRATION ]-->
        <link href="css/demo/nifty-demo.min.css" rel="stylesheet">


        <!--SCRIPT-->
        <!--=================================================-->

        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="plugins/pace/pace.min.css" rel="stylesheet">
        <script src="plugins/pace/pace.min.js"></script>

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
            <?php include ("includes/header.php"); ?>
            <!--===================================================-->
            <!--END NAVBAR-->

            <div class="boxed">

                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">

                    <!--Page Title-->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Programa de Inspecciones</h1>
                        <div class="searchbox">
                            <div class="input-group custom-search-form">
                                <label class="control-label">Opciones de Visualizacion</label>
                                <select name="ver_inspecciones" class="selectpicker">
                                    <option value="PENDIENTES">PENDIENTES</option>
                                    <option value="EJECUTADOS">EJECUTADOS</option>
                                    <option value="TODOS">TODOS</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    -->
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">



                        <!-- Basic Data Tables -->
                        <!--===================================================-->
                        <div class="panel">
                            <div class="panel-heading">
                                <!--
                                <div class="panel-control">
                                    <label class="control-label">Opciones de Visualizacion</label>
                                <select name="ver_inspecciones" class="selectpicker">
                                    <option value="PENDIENTES">PENDIENTES</option>
                                    <option value="EJECUTADOS">EJECUTADOS</option>
                                    <option value="TODOS">TODOS</option>
                                </select>
                                </div>
                                -->
                                <h3 class="panel-title"><b>Programa de Inspecciones</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="table-responsiv111e">
                                    <table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cod.</th>
                                                <th class="text-center">A&ntilde;o</th>
                                                <th class="text-center">Tipo</th>
                                                <th class="text-center">Fecha Programado</th>
                                                <th class="text-center">Frecuencia</th>
                                                <th class="text-center">Fecha Ejecutado</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $inspecciones = "select id, anio, tipo, frecuencia, fecha_programa, fecha_inspeccion, pagina_web from programa_inspecciones where empresa = '" . $empresa . "' and estado = '0' order by estado asc, id asc";
                                            //echo $capacitaciones;
                                            $r_inspecciones = $conn->query($inspecciones);
                                            if ($r_inspecciones->num_rows > 0) {
                                                while ($fila = $r_inspecciones->fetch_assoc()) {
                                                    //si fecha de programa es mayor a 3 dias de fecha actual = prioridad alta, mayor a 5 dias = no hay de que asustarse
                                                    if ($fila['fecha_inspeccion'] == "7000-01-01") {
                                                        $estado = '<div class="label label-table label-warning">Prioridad Alta</div>';
                                                        $programado = $varios->fecha_tabla($fila['fecha_programa']);
                                                        $ejecutado = '-';
                                                    } else {
                                                        $estado = '<div class="label label-table label-success">Realizado</div>';
                                                        $programado = '-';
                                                        $ejecutado = $varios->fecha_tabla($fila['fecha_inspeccion']);
                                                    }
                                                    echo '<tr>
                                                    <td class="text-center">' . $fila['id'] . '</td>
                                                    <td class="text-center">' . $fila['anio'] . '</td>
                                                    <td><a class="btn-link" href="#" onclick="verpagina(\'' . $fila['id'] . '\', \'' . $fila['anio'] . '\', \'' . $fila['pagina_web'] . '\')">' . $fila['tipo'] . '</a></td>
                                                    <td class="text-center">' . $programado . '</td>
                                                    <td class="text-center">' . $fila['frecuencia'] . '</td>
                                                    <td class="text-center">' . $ejecutado . '</td>
                                                    <td class="text-center">' . $estado . '</td>
                                                    <td class="text-center">
                                                    <button onclick="EditaInspeccion(\'' . $fila['id'] . '\', \'' . $fila['anio'] . '\', \'' . $fila['tipo'] . '\')" data-target="#edita_inspeccion" data-toggle="modal"class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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
                <div class="modal" id="edita_inspeccion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_edita" class="modal-content" id="contenido_edita">

                        </div>
                    </div>
                </div>
                <div class="modal" id="ver_detalle" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_detalle" class="modal-content" id="contenido_detalle">

                        </div>
                    </div>
                </div>
                <!--===================================================-->
                <!--End Default Bootstrap Modal-->



                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <?php include ("includes/main_navigation.php"); ?>
                <!--===================================================-->
                <!--END MAIN NAVIGATION-->

                <!-- TAB DE LA DERECHA -->
                <!--ASIDE-->
                <!--===================================================-->
                <?php include ("includes/aside_rigth.php"); ?>
                <!--===================================================-->
                <!--END ASIDE-->
            </div>



            <!-- FOOTER -->
            <!--===================================================-->
            <?php include ("includes/footer.php"); ?>
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
            function verpagina(id, anio, pagina) {
                document.location.href = pagina + ".php?id=" + id + "&anio=" + anio;
            }
            function EditaInspeccion(id, anio, tipo) {
                    var parametros = {
                            "id" : id,
                            "anio" : anio,
                            "tipo" : tipo,
                    };
                    $.ajax({
                            data:  parametros,
                            url:   'frm_modificar/modificar_inspeccion.php',
                            type:  'post',
                            beforeSend: function () {
                                $("#contenido_edita").html("Procesando, espere por favor...");
                            },
                            success:  function (response) {
                                $("#contenido_edita").html(response);
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

