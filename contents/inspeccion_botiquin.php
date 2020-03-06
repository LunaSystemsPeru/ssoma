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

$id = $_GET['id'];
$anio = $_GET['anio'];
$tipo = "BOTIQUIN";
$empresa = $_SESSION['empresa'];

$inspecciones = "select id, anio, frecuencia, fecha_programa, fecha_inspeccion, pagina_web from programa_inspecciones where empresa = '" . $empresa . "' and id = '" . $id . "' and anio = '" . $anio . "' and tipo = '" . $tipo . "'";
$r_inspecciones = $conn->query($inspecciones);
if ($r_inspecciones->num_rows > 0) {
    while ($fila = $r_inspecciones->fetch_assoc()) {
        $frecuencia = $fila['frecuencia'];
        if ($fila['fecha_inspeccion'] == "7000-01-01") {
            $estado = '<div class="label label-table label-warning">Pendiente</div>';
            $activo = "";
            $inactivo = "disabled";
            $fecha = $varios->fecha_tabla($fila['fecha_programa']);
        } else {
            $estado = '<div class="label label-table label-success">Realizado</div>';
            $activo = "disabled";
            $inactivo = "";
            $fecha = $varios->fecha_tabla($fila['fecha_inspeccion']);
        }
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
        <title>Inspeccion de Botiquin| Software Gestion de Seguridad Industrial</title>


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
        <script src="../public/plugins/pace/pace.min.js"></script>


        <script type="text/javascript">
            function add_inspeccion(id, anio, tipo) {
                document.location.href = "registra_inspeccion.php?id=" + id + "&anio=" + anio + "&tipo=" + tipo;
            }
            function ver_archivo(archivo) {
                direccion = "upload/" +<?php echo $empresa; ?> + "/inspecciones/BOTIQUIN/" + archivo;
                document.location.href = direccion;
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
                                <h3 class="panel-title"><a href="programa_inspecciones.php">Programa de Inspecciones</a> / <b>Programa de Inspeccion de Botiquin</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button onclick="add_inspeccion('<?php echo $id ?>', '<?php echo $anio ?>', '<?php echo $tipo ?>')" class="btn btn-primary btn-m" <?php echo $activo ?>>Agregar</button>
                                            <button data-target="#finalizar_inspeccion" data-toggle="modal" class="btn btn-danger btn-m" <?php echo $activo ?>>Finalizar</button>
                                            <button class="btn btn-success btn-m">Ver Inspecciones</button>
                                        </div>
                                    </div>
                                    <h4>Informacion General</h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <dl class="dl-horizontal">
                                                <dt>Fecha:</dt>
                                                <dd><?php echo $fecha; ?></dd>
                                                <dt>Frecuencia:</dt>
                                                <dd><?php echo $frecuencia; ?></a></dd>
                                                <dt>Codigo:</dt>
                                                <dd><?php echo $id . '-' . $anio; ?></dd>
                                                <dt>Estado:</dt>
                                                <dd><?php echo $estado; ?></dd>

                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Cod.</th>
                                                <th class="text-center">Fecha</th>
                                                <th class="text-center">Area</th>
                                                <th class="text-center">Lugar</th>
                                                <th class="text-center">Inspector</th>
                                                <th class="text-center">Estado</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $epp = "select ie.id, ie.item, ie.anio, ie.inspector, e.nombres, e.ape_pat, e.ape_mat, ie.fecha, ie.area, ie.local, ie.archivo, ie.estado from inspeccion_botiquin as ie inner join empleado as e on ie.empresa = e.empresa and ie.inspector = e.codigo where ie.id = '" . $id . "' and ie.anio = '" . $anio . "' and ie.empresa = '" . $empresa . "'";
                                            //echo $epp;
                                            $resultado = $conn->query($epp);
                                            $idc = 0;
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    //si fecha de programa es mayor a 3 dias de fecha actual = prioridad alta, mayor a 5 dias = no hay de que asustarse
                                                    $idc++;
                                                    if ($fila['estado'] == "0") {
                                                        $estado = '<div class="label label-table label-warning">Pendiente</div>';
                                                        $activo = "";
                                                        $inactivo = "disabled";
                                                        $programado = $varios->fecha_tabla($fila['fecha']);
                                                    } else {
                                                        $estado = '<div class="label label-table label-success">Realizado</div>';
                                                        $activo = "disabled";
                                                        $inactivo = "";
                                                        $programado = $varios->fecha_tabla($fila['fecha']);
                                                    }
                                                    echo '<tr>
                                                    <td class="text-center">' . $fila['item'] . '</td>
                                                    <td class="text-center">' . $programado . '</td>
                                                    <td class="text-center">' . $fila['area'] . '</td>
                                                    <td class="text-center">' . $fila['local'] . '</td>
                                                    <td class="text-center">' . $fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat'] . '</td>
                                                    <td class="text-center">' . $estado . '</td>
                                                    <td class="text-center">
                                                    <button onclick="ModificaInspeccion(\'' . $fila['id'] . '\', \'' . $fila['anio'] . '\')" data-target="#edita_capacitacion" data-toggle="modal" class="btn btn-success btn-icon icon-lg fa fa-edit" ' . $activo . '></button>
                                                    <button onclick="GrabaInspeccion(\'' . $fila['id'] . '\', \'' . $fila['anio'] . '\', \'' . $tipo . '\', \'' . $fila['item'] . '\')" data-target="#finaliza_inspeccion" data-toggle="modal" class="btn btn-pink btn-icon icon-lg fa fa-save" ' . $activo . '></button>
                                                    <button onclick="ver_archivo(\'' . $fila['archivo'] . '\')" class="btn btn-warning btn-icon icon-lg fa fa-print" ' . $inactivo . '></button>
                                                    <button onclick="Reporte(\'' . $fila['id'] . '\', \'' . $fila['anio'] . '\', \'' . $fila['item'] . '\')" class="btn btn-danger btn-icon icon-lg fa fa-file" ' . $activo . '></button>
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
                <div class="modal" id="finaliza_inspeccion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_fin" class="modal-content" id="contenido_fin">

                        </div>
                    </div>
                </div>

                <div class="modal" id="modificar_inspeccion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_modifica" class="modal-content" id="contenido_modifica">

                        </div>
                    </div>
                </div>

                <div class="modal" id="finalizar_inspeccion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Finalizar Inspeccion</h4>
                            </div>
                            <form class="form-horizontal" id="frm_cierre_inspeccion" action="inserts/finalizar_inspeccion.php" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-8 control-label">Esta Seguro de Cerrar la Inspeccion??</label>
                                    </div>
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <input type="hidden" value="<?php echo $id ?>" name="id">
                                    <input type="hidden" value="<?php echo $anio ?>" name="anio">
                                    <input type="hidden" value="<?php echo $tipo ?>" name="tipo">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                                    <input type="submit" class="btn btn-primary" name="graba_cierre">
                                </div>
                            </form>
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

        <!--Chosen [ OPTIONAL ]-->
        <script src="../public/plugins/chosen/chosen.jquery.min.js"></script>


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

        <!--Form Component [ SAMPLE ]-->
        <script src="../public/js/demo/form-component.js"></script>


        <script type="text/javascript">
                                                function GrabaInspeccion(id, anio, tipo, item) {
                                                    var parametros = {
                                                        "id": id,
                                                        "anio": anio,
                                                        "tipo": tipo,
                                                        "item": item,
                                                    };
                                                    $.ajax({
                                                        data: parametros,
                                                        url: 'frm_modificar/graba_inspeccion.php',
                                                        type: 'post',
                                                        beforeSend: function () {
                                                            $("#contenido_fin").html("Procesando, espere por favor...");
                                                        },
                                                        success: function (response) {
                                                            $("#contenido_fin").html(response);
                                                        }
                                                    });
                                                }

                                                function Reporte(id, anio, item) {
                                                    document.location.href = "reportes/inspeccion_botiquin.php?id=" + id + "&anio=" + anio + "&item=" + item;
                                                }

                                                function ModificaInspeccion(id, anio, item) {
                                                    var parametros = {
                                                        "id": id,
                                                        "anio": anio,
                                                        "item": item,
                                                    };
                                                    $.ajax({
                                                        data: parametros,
                                                        url: 'frm_modificar/modificar_item_inspeccion.php',
                                                        type: 'post',
                                                        beforeSend: function () {
                                                            $("#contenido_modifica").html("Procesando, espere por favor...");
                                                        },
                                                        success: function (response) {
                                                            $("#contenido_modifica").html(response);
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

