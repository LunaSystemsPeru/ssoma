<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include("includes/conectar.php");
require("includes/varios.php");

$sql = 'select e.descripcion, e.fecha_inicio, e.fecha_fin, te.nombre as tipo_evento from evento as e inner join tipo_evento as te on e.tipo_evento = te.id';
$result = $conn->query($sql);
$eventos = array();
while ($row = $result->fetch_assoc()) {
    $eventos[] = array("title" => $row['tipo_evento'] . ': ' . $row['descripcion'], "start" => $row['fecha_inicio'], "end" => $row['fecha_fin'], "className" => 'success');
}

?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendario de Eventos | Software Gestion de Seguridad Industrial</title>


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

        <!--Full Calendar [ OPTIONAL ]-->
        <link href="../public/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">



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



                        <div class="row">
                            <div class="col-md-4 col-lg-3">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Events</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <input type="text" id="event_title" placeholder="Event Title..." class="form-control" value="">
                                        </div>
                                        <button class="btn btn-block btn-purple">Add New Event</button>
                                        <hr>

                                        <!-- Draggable Events -->
                                        <!-- ============================================ -->
                                        <h4 class="text-thin">Draggable Events</h4>
                                        <div id="demo-external-events">
                                            <div class="fc-event fc-list" data-class="warning">All Day Event</div>
                                            <div class="fc-event fc-list" data-class="success">Meeting</div>
                                            <div class="fc-event fc-list" data-class="mint">Birthday Party</div>
                                            <div class="fc-event fc-list" data-class="purple">Happy Hour</div>
                                            <div class="fc-event fc-list">Lunch</div>
                                            <hr>
                                            <div>
                                                <label class="form-checkbox form-normal form-primary">
                                                    <input type="checkbox" id="drop-remove">
                                                    Remove after drop
                                                </label>
                                            </div>
                                            <hr>
                                            <div class="fc-event" data-class="warning">All Day Event</div>
                                            <div class="fc-event" data-class="success">Meeting</div>
                                            <div class="fc-event" data-class="mint">Birthday Party</div>
                                            <div class="fc-event" data-class="purple">Happy Hour</div>
                                            <div class="fc-event">Lunch</div>
                                        </div>
                                        <!-- ============================================ -->


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-9">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Calendar</h3>
                                    </div>
                                    <div class="panel-body">

                                        <!-- Calendar placeholder-->
                                        <!-- ============================================ -->
                                        <div id='demo-calendar'></div>
                                        <!-- ============================================ -->

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

                <!--Default Bootstrap Modal-->
                <!--===================================================-->
                <div class="modal" id="add_epp" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Registro de EPP</h4>
                            </div>
                            <form class="form-horizontal" id="frm_registra_epp" action="" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Nombre</label>
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Nombre" name="nombre" id="nombre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Duracion</label>
                                        <div class="col-lg-7">
                                            <input type="number" min="1" class="form-control" name="duracion" placeholder="Duracion" required >
                                        </div>
                                    </div>
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                                    <input type="submit" class="btn btn-primary" name="graba_epp">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal" id="edita_epp" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_edita_epp" class="modal-content contenido_edita_epp" id="contenido_edita_epp">

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

        <!--Full Calendar [ OPTIONAL ]-->
        <script src="../public/plugins/fullcalendar/lib/moment.min.js"></script>
        <script src="../public/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script>
        <script src="../public/plugins/fullcalendar/fullcalendar.min.js"></script>

        <!--Full Calendar [ SAMPLE ]-->
        <script src="../public/js/demo/misc-fullcalendar.js"></script>


        <script type="text/javascript">
            $('#demo-calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                drop: function () {
                    // is the "remove after drop" checkbox checked?
                    if ($('#drop-remove').is(':checked')) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },
                //defaultDate: '2015-01-12',
                eventLimit: true, // allow "more" link when too many events
                events: [
                    <?php
                    $longitud = count($eventos);

                    for ($i = 0; $i < $longitud; $i++) {
                        echo json_encode($eventos[$i], JSON_PRETTY_PRINT) . ', ';
                    }
                    ?>
                ]
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
                This is to be removed, used for�demonstration purposes only.�This category must not be included in your project.
                
                SAMPLE
                Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
                
                
                Detailed information and more samples can be found in the document.
                
        -->


    </body>

    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

