<?php
include '../fixed/iniciaSession.php';

require '../models/Compra.php';
require '../tools/varios.php';

$compra = new Compra();
$varios = new Varios();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras | Software Gestion de Seguridad Industrial</title>


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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>



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
                        <h3 class="panel-title"><b>Listar documentos de Compras</b></h3>
                    </div>
                    <!--Data Table-->
                    <!--===================================================-->
                    <div class="panel-body">
                        <div class="pad-btm form-inline">
                            <div class="row">
                                <div class="col-sm-6 table-toolbar-left">
                                    <a href="registra_compra.php" id="demo-btn-addrow"
                                       class="btn btn-purple btn-labeled fa fa-plus">Agregar</a>
                                    <button type="button" id="demo-btn-addrow" onclick="exportTableToExcel('demo-dt-basic', 'compras')"
                                       class="btn btn-info btn-labeled fa fa-file-excel-o">Exportar a Excel</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <table id="demo-dt-basic" class="table table-striped table-condensed" cellspacing="0"
                                   data-page-length='50' width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">Facturado para</th>
                                    <th class="text-center">Fecha Emision</th>
                                    <th class="text-center">Documento</th>
                                    <th class="text-center">Proveedor</th>
                                    <th class="text-center">SUBTotal</th>
                                    <th class="text-center">IGV</th>
                                    <th class="text-center">Total</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $a_compras = $compra->verTodas();
                                foreach ($a_compras as $fila) {
                                    $documento = "";
                                    $id_documento = $fila['id_documento'];
                                    if ($id_documento == 35) {
                                        $documento = "FT";
                                    }
                                    if ($id_documento == 34) {
                                        $documento = "BL";
                                    }
                                    if ($id_documento == 36) {
                                        $documento = "NC";
                                    }
                                    $doc = $documento . " | " . $fila['serie'] . " - " . $varios->zerofill($fila['numero'], 6);
                                    $total = $fila['total'];
                                    ?>
                                    <tr>
                                        <td><?php echo $fila['empresa'] ?></td>
                                        <td class="text-center"><?php echo $fila['fecha'] ?></td>
                                        <td class="text-center"><?php echo $doc ?></td>
                                        <td><?php echo $fila['ruc'] . " | " . $fila['razon_social'] ?></td>
                                        <td class="text-right"><?php echo number_format($total / 1.18, 2) ?></td>
                                        <td class="text-right"><?php echo number_format($total / 1.18 * 0.18, 2) ?></td>
                                        <td class="text-right"><?php echo number_format($total, 2) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-icon fa fa-trash" onclick="eliminar('<?php echo $fila['id_compra']?>')"></button>
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


<!--DataTables Sample [ SAMPLE ]
<script src="../public/js/demo/tables-datatables.js"></script>-->
<script>
    $(window).on('load', function () {
        $('#demo-dt-basic').dataTable({
            "responsive": true,
            "lengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
            "order": [[2, "asc"], [1, "asc"]],
            "language": {
                "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
                }
            }
        });
    })

    function eliminar(codigo) {
        Swal.fire({
            title: 'Estas Seguro?',
            text: "No podras deshacer esta accion!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, Eliminar Documento de Compra!'
        }).then((result) => {
            if (result.value) {
                window.location.href = "../controller/del_compra.php?codigo=" + codigo;
                /*
                Swal.fire(
                    'Eliminado!',
                    'Este empleado ha sido eliminado',
                    'success'
                )
                 */
            }
        })
    }

    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename?filename+'.xls':'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob( blob, filename);
        }else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
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

