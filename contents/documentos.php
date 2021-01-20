<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require '../models/Documentacion.php';
require '../models/ParametrosDetalle.php';
require '../tools/varios.php';

$parametros = new ParametrosDetalle();
$documento = new Documentacion();
$varios = new Varios();

$documento->setIdEmpresa($_SESSION['empresa']);
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Documentos | Software Gestion de Seguridad Industrial</title>


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
        function add_documento() {
            document.location.href = "registra_documentos.php";
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
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><b>Lista Maestra de Documentos</b></h3>
                    </div>
                    <!--Data Table-->
                    <!--===================================================-->
                    <div class="panel-body">
                        <div class="pad-btm form-inline">
                            <div class="row">
                                <div class="col-sm-6 table-toolbar-left">
                                    <button data-target="#add_documento" data-toggle="modal" class="btn btn-primary btn-m">Agregar</button>
                                    <button class="btn btn-default"><i class="fa fa-print"></i></button>
                                    <div class="btn-group">
                                        <button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsivzxzxe">
                            <table id="tabla-documentos" class="table table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">Documento</th>
                                    <th class="text-center">Nombre</th>
                                    <th>Vr.</th>
                                    <th class="text-center">Fec. Creacion</th>
                                    <th class="text-center">Fec. Modif.</th>
                                    <th class="text-center">Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $a_documentos = $documento->verFilas();
                                foreach ($a_documentos as $fila) {
                                    $nom_documento = $fila['area'] . "-" . $fila['tipo'] . "-". $varios->zerofill($fila['nro_documento'], 3). ".". $fila['extension'];
                                    $nom_archivo = $fila['area_documento'] . $fila['tipo_documento'] . $fila['nro_documento']. ".". $fila['extension'];
                                    $url_archivo = "../upload/" . $_SESSION['ruc_empresa']. "/documentos/" . $nom_archivo;
                                    $estado = $fila['estado'];
                                    $label_estado = "<span class='label label-success'> Activo</span>";
                                    if ($estado == 0) {
                                        $label_estado = "<span class='label label-dark'> OBSOLETO</span>";
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center"><a class="btn-link" href="" onclick="ver_detalles(<?php echo $fila['id_documento']?>)" data-target="#ver_detalles" data-toggle="modal"><?php echo $nom_documento?></a></td>
                                        <td class="text-rigth"><?php echo $fila['nombre']?></td>
                                        <td class="text-center"><?php echo $fila['version']?></td>
                                        <td class="text-center"><?php echo $fila['fecha_creacion']?></td>
                                        <td class="text-center"><?php echo $fila['fecha_modificacion']?></td>
                                        <td class="text-center"><?php echo $label_estado?></td>
                                        <td>
                                            <a href="<?php echo $url_archivo ?>"  class="btn btn-info btn-icon icon-lg fa fa-print"></a>
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
        <div class="modal" id="add_documento" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Registro de Documento</h4>
                    </div>
                    <form class="form-horizontal" id="frm_add_documento" action="../controller/reg_documentacion.php" enctype="multipart/form-data" method="post">
                        <!--Modal body-->
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Area</label>
                                <div class="col-sm-8">
                                    <!-- Default Bootstrap Select -->
                                    <!--===================================================-->
                                    <select id="select_areaDocumento" name="select_areaDocumento" class="form-control">
                                        <?php
                                        $parametros->setIdParametro(9);
                                        $a_areas = $parametros->verFilas();
                                        foreach ($a_areas as $fila) {
                                            ?>
                                            <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--===================================================-->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Tipo</label>
                                <div class="col-sm-8">
                                    <select id="select_tipoDocumento" name="select_tipoDocumento" class="form-control">
                                        <?php
                                        $parametros->setIdParametro(10);
                                        $a_areas = $parametros->verFilas();
                                        foreach ($a_areas as $fila) {
                                            ?>
                                            <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Codigo</label>
                                <div class="col-lg-8">
                                    <input type="number" placeholder="Ingrese Codigo" id="input_nroDocumento" name="input_nroDocumento" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Nombre Documento</label>
                                <div class="col-lg-8">
                                    <input type="text" placeholder="Ingrese Nombre" name="input_nombre" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Fecha Creacion</label>
                                <div class="col-lg-8">
                                    <input type="date" placeholder="dd/mm/aaaa" name="input_fechaCreacion" id="input_fechaCreacion" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Version</label>
                                <div class="col-lg-8">
                                    <input type="text" name="input_version" value="1" class="form-control" readonly="true" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Archivo</label>
                                <div class="col-lg-8">
                                    <input class="form-control" type="file" name="file" id="file"/>
                                    <div id="message"></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                        <!--Modal footer-->
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                            <input type="submit" class="btn btn-primary" name="graba_documento">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="ver_detalles" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div name="contenido_detalle" class="modal-content contenido_detalle" id="contenido_detalle">

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


<!--DataTables [ OPTIONAL ]-->
<script src="../public/plugins/datatables/media/js/jquery.dataTables.js"></script>
<script src="../public/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script src="../public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>


<!--Demo script [ DEMONSTRATION ]-->
<script src="../public/js/demo/nifty-demo.min.js"></script>


<script type="text/javascript">

    function ver_detalles(tipo, clase, id) {
        var parametros = {
            "id_tipo": tipo,
            "id_clase": clase,
            "id": id,
        };
        $.ajax({
            data: parametros,
            url: 'frm_modificar/detalle_documento.php',
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

        $('#tabla-documentos').dataTable( {
            "responsive": true,
            "order": [[0,"asc"]],
            "language": {
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        } );

        // Function to preview image after validation
        $(function () {
            $("#file").change(function () {
                $("#message").empty(); // To remove the previous error message
                var ext = $("#file").val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['pdf', 'doc', 'docx']) == -1) {
                    $("#message").html("<p id='error'>Por Favor Seleccione un archivo valido</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Solamente *.pdf, *.doc, *.docx esta permitidos</span>");
                    return false;
                } else {
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

