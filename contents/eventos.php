<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include("includes/conectar.php");
require("includes/varios.php");

$varios = new Varios();

$mes_actual = date("m");
$anio_actual = date("Y");

$empresa = $_SESSION['empresa'];

if (isset($_POST['graba_evento'])) {
    
}
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Eventos | Software Gestion de Seguridad Industrial</title>


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
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Listar Eventos</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button data-target="#add_evento" data-toggle="modal" class="btn btn-primary btn-m">Agregar</button>
                                            <button class="btn btn-default"><i class="fa fa-print"></i></button>
                                            <div class="btn-group">
                                                <button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tasasable-responsive">
                                    <table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cod.</th>
                                                <th class="text-center">A&ntilde;o</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Tipo Evento</th>
                                                <th class="text-center">Fecha Inicio</th>
                                                <th class="text-center">Fecha Fin</th>
                                                <th class="text-center">Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $busca_epp = "select ev.*, te.nombre as tipo_evento from evento as ev inner join tipo_evento as te on ev.tipo_evento = te.id where ev.empresa = '" . $empresa . "'";
//echo $busca_epp;
                                            $resultado = $conn->query($busca_epp);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    if ($fila['estado'] == "0") {
                                                        $estado = "ACTIVO";
                                                    } else {
                                                        $estado = "NO DISPONIBLE";
                                                    }
                                                    echo '<tr>
														<td class="text-center">' . $fila['id'] . '</a></td>
														<td class="text-center">' . $fila['anio'] . '</a></td>
														<td>' . $fila['descripcion'] . '</td>
														<td class="text-center">' . $fila['tipo_evento'] . '</td>
														<td class="text-center">' . $varios->fecha_tabla_hora($fila['fecha_inicio']) . '</td>
														<td class="text-center">' . $varios->fecha_tabla_hora($fila['fecha_fin']) . '</td>
														<td class="text-center">' . $estado . '</td>
														<td>
														<button onclick="EditaEpp(\'' . $fila['id'] . '\')" data-target="#edita_epp" data-toggle="modal"class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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
                <div class="modal" id="add_evento" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Registro de Eventos</h4>
                            </div>
                            <form class="form-horizontal" id="frm_registra_evento" action="" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Descripcion</label>
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Nombre" name="nombre" id="nombre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="tipo_evento">Tipo de Evento</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="tipo_evento" name="tipo_evento" class="selectpicker">
                                                <?php
                                                global $conn;
                                                $consulta = 'select id, nombre from tipo_evento order by nombre asc';
                                                $resultado = $conn->query($consulta);
                                                if ($resultado->num_rows > 0) {
                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        echo '<option value=' . $fila['id'] . '>' . strtoupper($fila['nombre']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fecha Inicio</label>
                                        <div class="col-lg-3">
                                            <input type="text"class="form-control" name="fecha_inicio" placeholder="dd/mm/aaaa" required >
                                        </div>
                                        <label class="col-lg-2 control-label">Hora Inicio</label>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control" name="hora_inicio" placeholder="hh:mm:ss" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fecha Fin</label>
                                        <div class="col-lg-3">
                                            <input type="text"class="form-control" name="fecha_fin" placeholder="dd/mm/aaaa" required >
                                        </div>
                                        <label class="col-lg-2 control-label">Hora Fin</label>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control" name="hora_fin" placeholder="hh:mm:ss" required >
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

        <script type="text/javascript">
            function EditaEpp(id_epp) {
                var parametros = {
                    "codigo": id_epp,
                };
                $.ajax({
                    data: parametros,
                    url: 'inserts/modifica_epp.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_edita_epp").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_edita_epp").html(response);
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

