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
$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
$anio = $_GET['anio'];
$tipo = $_GET['tipo'];

$empresa = $_SESSION['empresa'];

$consulta = "select * from programa_monitoreo where empresa = '" . $empresa . "' and id = '" . $id . "' and anio = '" . $anio . "'";

$r_consulta = $conn->query($consulta);
if ($r_consulta->num_rows > 0) {
    while ($fila = $r_consulta->fetch_assoc()) {
        $tipo = $fila['tipo'];
        $proveedor = $fila['proveedor'];
        if ($fila['estado'] == "0") {
            $estado = '<div class="label label-table label-warning">Pendiente</div>';
            $fecha = $varios->fecha_tabla($fila['fecha_programado']);
            $activo = "";
            $inactivo = "disabled";
        } else {
            $estado = '<div class="label label-table label-success">Realizado</div>';
            $fecha = $varios->fecha_tabla($fila['fecha_ejecutado']);
            $activo = "disabled";
            $inactivo = "";
        }
    }
} else {
    echo "0 resultados";
}
//$conn->close();
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle Programa Monitoreo | Software Gestion de Seguridad Industrial</title>


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

        <!--Dropzone [ OPTIONAL ]-->
        <link href="../public/plugins/dropzone/dropzone.css" rel="stylesheet">
        <!--SCRIPT-->
        <!--=================================================-->

        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
        <script src="plugins/pace/pace.min.js"></script>

        <script type="text/javascript">
            function abrir(id, anio, archivo) {
                    url ="upload/"+<?php echo $empresa?>+"/monitoreo/"+anio+id+"/" + archivo;
                    window.open(url, "Ver Archivo de Monitoreo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800");
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
                                <h2 class="panel-title"><a href="programa_monitoreo.php">Programa de Monitoreos</a> / <b>MONITOREO: <?php echo $tipo; ?></b></h2>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-12 table-toolbar-left">
                                            <button onclick="EditarMonitoreo(<?php echo $id; ?>, <?php echo $anio; ?>, 'AGENTES')" data-target="#editar_monitoreo" data-toggle="modal" class="btn btn-primary btn-m" <?php echo $activo ?>>Editar</button>
                                            <button data-target="#finalizar_monitoreo" data-toggle="modal" class="btn btn-success btn-m" <?php echo $activo ?>>Finalizar</button>
                                            <button class="btn btn-default"><i class="fa fa-print" <?php echo $inactivo ?>></i></button>
                                            <div class="btn-group">
                                                <button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">

                                    <h4>Informacion General</h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <dl class="dl-horizontal">
                                                <dt>Fecha:</dt>
                                                <dd><?php echo $fecha; ?></dd>
                                                <br>
                                                <dt>Empresa:</dt>
                                                <dd><?php echo $proveedor; ?></a></dd>
                                                <br>
                                                <dt>Tipo:</dt>
                                                <dd><?php echo $tipo; ?></dd>
                                                <br>
                                                <dt>Estado:</dt>
                                                <dd><?php echo $estado; ?></dd>

                                            </dl>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <!--===================================================-->
                            <!--End Data Table-->
                        </div>
                        <!--===================================================-->
                        <!-- End Striped Table -->

                        <div class="panel">
                            <div class="panel-heading">
                                <h2 class="panel-title"><b>AREAS DEL MONITOREO</b></h2>
                            </div>
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button data-target="#agregar_area" data-toggle="modal" class="btn btn-success btn-m" <?php echo $activo ?>>Agregar Area</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Id.</th>
                                                    <th class="text-center">Area</th>
                                                    <th class="text-center">Fecha</th>
                                                    <th class="text-center">Cant. Colaboradores</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Acciones</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $areas = "select * from area_monitoreo where id = '" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "' and tipo = '" . $tipo . "'";
                                                //echo $areas;
                                                $r_areas = $conn->query($areas);
                                                $nro_fila = 1;
                                                if ($r_areas->num_rows > 0) {
                                                    while ($fila = $r_areas->fetch_assoc()) {
                                                        echo '<tr>
                                                        <td class="text-center">' . $nro_fila . '</a></td>
                                                        <td>' . $fila['area'] . '</td>
                                                        <td class="text-center">' . $fila['fecha'] . '</td>
                                                        <td class="text-center">' . number_format($fila['colaboradores'], '2', '.', '') . '</td>
                                                        <td class="text-center">BUEN AMBIENTE LABORAL</td>
                                                        <td  class="text-center">
                                                        <button onclick="EditarMoni111toreo(\'' . $fila['id'] . '\', \'' . $fila['anio'] . '\', \'' . $fila['tipo'] . '\')" data-target="#editar_monitoreo" data-toggle="modal"class="btn btn-success btn-icon icon-lg fa fa-edit" ' . $activo . '></button>
                                                        <button onclick="abrir(\'' . $cod . '\', \'' . $fila['anio'] . '\', \'' . $fila['informe'] . '\')" class="btn btn-pink btn-icon icon-lg fa fa-print"></button>
                                                        <button class="btn btn-info btn-icon icon-lg fa fa-trash" ' . $activo . '></button>
                                                        </td>
                                                        </tr>';
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
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
                <div class="modal" id="finalizar_monitoreo" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Finalizar Monitoreo</h4>
                            </div>
                            <form class="form-horizontal" id="frm_cierre_monitoreo" action="inserts/finalizar_monitoreo.php" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-8 control-label">Esta Seguro de Cerrar el Monitoreo??</label>
                                    </div>
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <input type="hidden" value="<?php echo $id ?>" name="id">
                                    <input type="hidden" value="<?php echo $anio ?>" name="anio">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                                    <input type="submit" class="btn btn-primary" name="graba_cierre">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal" id="agregar_area" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Agregar Resultado de Area Monitoreada</h4>
                            </div>
                            <form class="form-horizontal" id="frm_area_monitoreo" action="inserts/add_area_monitoreo.php" enctype="multipart/form-data" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Tipo</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="Tipo" name="tipo" value="<?php echo $tipo ?>" class="form-control" readonly="true">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Area</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="Area" name="area" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Cant. Colaboradores</label>
                                        <div class="col-lg-8">
                                            <input type="number" value="1" name="cantidad" min-value="1" min="1" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fecha Monitoreo</label>
                                        <div class="col-lg-8">
                                            <input type="text"class="form-control" id="fecha_registro" name="fecha_inicio" placeholder="dd/mm/aaaa" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Recomendaciones</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" cols="50" rows="5" name="causas_basicas" required></textarea> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Conclusiones</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control" cols="50" rows="5" name="causas_basicas" required></textarea> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Archivo informe</label>
                                        <div class="col-lg-8">
                                            <input type="file" class="form-control" name="informe" id="archivo" required >
                                            <div id="message"></div>
                                        </div>								
                                    </div>
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <input type="hidden" name="id" value="<?php echo $id ?>" >
                                    <input type="hidden" name="anio" value="<?php echo $anio ?>">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                                    <input type="submit" class="btn btn-primary" name="graba_area">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal" id="editar_monitoreo" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_editar" class="modal-content" id="contenido_editar">

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

        <!--Dropzone [ OPTIONAL ]-->
        <script src="plugins/dropzone/dropzone.min.js"></script>

        <script type="text/javascript">
                        function EditarMonitoreo(id, anio, tipo) {
                            var parametros = {
                                "id": id,
                                "anio": anio,
                                "tipo": tipo
                            };
                            $.ajax({
                                data: parametros,
                                url: 'frm_modificar/modificar_monitoreo.php',
                                type: 'post',
                                beforeSend: function () {
                                    $("#contenido_editar").html("Procesando, espere por favor...");
                                },
                                success: function (response) {
                                    $("#contenido_editar").html(response);
                                }
                            });
                        }
                                                
                        $(document).ready(function (e) {
				// Function to preview image after validation
				$(function() {
					$("#archivo").change(function() {
						$("#message").empty(); // To remove the previous error message
						var ext = $("#archivo").val().split('.').pop().toLowerCase();
						if($.inArray(ext, ['pdf','doc','docx', 'ppt', 'pptx']) == -1) 
						{
							$("#message").html("<p id='error'>Por Favor Seleccione un archivo valido</p>"+"<h4>Nota</h4>"+"<span id='error_message'>Solamente *.pdf, *.doc, *.docx, *.ppt, *.pptx esta permitidos</span>");
							$("#archivo")
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
					$("#archivo").css("color","green");
					//$('#previewing').attr('height', '300px');
				};
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

