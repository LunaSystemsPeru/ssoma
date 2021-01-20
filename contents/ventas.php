<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
require '../models/Venta.php';
require '../models/Empresa.php';
require '../tools/varios.php';

$venta = new Venta();
$varios = new Varios();
$empresa = new Empresa();

$periodo = "";
$a_venta = $venta->verTodas();
if (filter_input(INPUT_GET, 'id_empresa')) {
    $venta->setIdEmpresa(filter_input(INPUT_GET, 'id_empresa'));
    $periodo = filter_input(INPUT_GET, 'periodo');
    $a_venta= $venta->verPorEmpresa($periodo);
}
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas | Software Gestion de Seguridad Industrial</title>


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
                        <h3 class="panel-title"><b>Listar documentos de Ventas</b></h3>
                    </div>
                    <!--Data Table-->
                    <!--===================================================-->
                    <div class="panel-body">
                        <div class="pad-btm form-inline">
                            <div class="row">
                                <div class="col-sm-12 table-toolbar-left">
                                    <a href="registra_venta.php" id="demo-btn-addrow"
                                       class="btn btn-purple btn-labeled fa fa-plus">Agregar</a>
                                    <a href="ventas.php" id="demo-btn-addrow"
                                       class="btn btn-info btn-labeled fa fa-plus">Solo por Cobrar</a>
                                    <button class="btn btn-success btn-labeled fa fa-search" data-target="#modal_filtrar"
                                            data-toggle="modal">Filtrar</button>
                                    <button type="button" id="demo-btn-addrow"
                                            onclick="exportTableToExcel('demo-dt-basic', 'ventas')"
                                            class="btn btn-info btn-labeled fa fa-file-excel-o">Exportar a Excel
                                    </button>
                                    <button class="btn btn-success btn-labeled fa fa-subscript" onclick="sumar_resultados()">Sumar Deuda</button>
                                    <?php
                                    if ($periodo != "") {
                                        ?>
                                        <a href="../reportes/txt_libro_ventas.php?input_periodo=<?php echo $periodo?>&input_empresa=<?php echo $venta->getIdEmpresa()?>" type="button" id="demo-btn-addrow"
                                           class="btn btn-success btn-labeled fa fa-file-excel-o">Generar L.E. Periodo
                                        </a>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <div>
                            <table id="demo-dt-basic" class="table table-striped table-condensed" cellspacing="0"
                                   data-page-length='50' width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">Facturado por</th>
                                    <th class="text-center">Fecha Emision</th>
                                    <th class="text-center">Documento</th>
                                    <th class="text-center">Cliente</th>
                                    <th>Descripcion</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Deuda DETRACCION</th>
                                    <th class="text-center">Deuda BASE</th>
                                    <th class="text-center">% Deuda</th>
                                    <th class="text-center">Estado</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total_venta = 0;
                                $total_cobro = 0;
                                $total_detraccion = 0;
                                $total_base = 0;
                                foreach ($a_venta as $fila) {
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

                                    $doc = $documento . " | " . $fila['serie'] . " - " . $varios->zerofill($fila['numero'], 3);
                                    $total = $fila['total'];
                                    $pagado = $fila['pagado'];
                                    $deuda = $total - $pagado;
                                    $valor_porcentaje = $deuda / $total;
                                    $porcentaje_deuda = $deuda / $total * 100;
                                    $detraccion = $fila['detraccion'] / 100;
                                    $valor_detraccion = round($detraccion * $total, 0);
                                    $valor_base = $total - $valor_detraccion;

                                    $deuda_detraccion = 0;

                                    if ($pagado == 0) {
                                        $deuda_detraccion = $valor_detraccion;
                                    }

                                    if ($valor_detraccion >= $deuda  & $deuda > 0) {
                                        $deuda_detraccion = $valor_detraccion;
                                    }



                                    $deuda_base = $deuda - $deuda_detraccion;


                                    $total_venta += $total;
                                    $total_cobro += $deuda;
                                    $total_base += $deuda_base;
                                    $total_detraccion += $deuda_detraccion;

                                    $estado = $fila['estado'];
                                    $label_deuda = "";
                                    if ($estado == 0) {
                                        $label_deuda = '<label class="label label-warning"> por Cobrar</label>';

                                    }
                                    if ($deuda == 0) {
                                        $label_deuda = '<label class="label label-success"> Pagado</label>';
                                    }
                                    if ($estado == 2) {
                                        $label_deuda = '<label class="label label-dark"> Anulado</label>';

                                    }


                                    ?>
                                    <tr>
                                        <td><?php echo $fila['empresa'] ?></td>
                                        <td class="text-center"><?php echo $fila['fecha'] ?></td>
                                        <td class="text-center"><?php echo $doc ?></td>
                                        <td><?php echo $fila['cliente'] ?></td>
                                        <td><?php echo $fila['descripcion'] . " - " . $fila['anexo'] ?></td>
                                        <td class="text-right"><?php echo number_format($total, 2) ?></td>
                                        <td class="text-right"><?php echo number_format($deuda_detraccion, 2, ".", "") ?></td>
                                        <td class="text-right"><?php echo number_format($deuda_base, 2, ".", "") ?></td>
                                        <td class="text-right"><label
                                                    class="label label-info"><?php echo number_format($porcentaje_deuda, 0) ?></label>
                                        </td>
                                        <td class="text-center"><?php echo $label_deuda ?></td>
                                        <td>
                                            <a href="detalle_venta.php?idventa=<?php echo $fila['id_venta'] ?>"
                                               class="btn btn-success btn-icon fa fa-bars"
                                               title="Ver Detalle"></a>
                                            <button class="btn btn-danger btn-icon fa fa-trash"
                                                    onclick="eliminar('<?php echo $fila['id_venta'] ?>')"></button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">TOTALES</td>
                                    <td class="text-right"><?php echo number_format($total_venta, 2) ?></td>
                                    <td class="text-right"><?php echo number_format($total_detraccion, 2) ?></td>
                                    <td class="text-right"><?php echo number_format($total_base, 2) ?></td>
                                    <td colspan="3"></td>
                                </tr>
                                </tfoot>
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

            <div class="modal" id="modal_filtrar" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!--Modal header-->
                        <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">Filtrar por</h4>
                        </div>
                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >
                            <!--Modal body-->
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Seleccionar Empresa</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="id_empresa">
                                            <?php
                                            $a_empresa = $empresa->verTodas();
                                            foreach ($a_empresa as $item) {
                                                ?>
                                                <option value="<?php echo $item['id_empresas'] ?>"> <?php echo $item['razon_social']  ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Año</label>
                                    <div class="col-lg-4">
                                        <select class="form-control">
                                            <option>2020</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Mes</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="periodo">
                                            <?php
                                            $a_periodo = $venta->verPeriodosEmpresa();
                                            foreach ($a_periodo as $item) {
                                                ?>
                                                <option value="<?php echo $item['periodo'] ?>"> <?php echo $item['periodo']  ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!--Modal footer-->
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

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
            "order": [[1, "asc"], [2, "asc"]],
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
            confirmButtonText: 'si, Eliminar Documento de Venta!'
        }).then((result) => {
            if (result.value) {
                window.location.href = "../controller/del_venta.php?codigo=" + codigo;
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

    function exportTableToExcel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

        // Specify file name
        filename = filename ? filename + '.xls' : 'excel_data.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['ufeff', tableHTML], {
                type: dataType
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }

    function sumar_resultados () {
        //Defino los totales de mis 2 columnas en 0
        var total_col1 = 0;
        var total_col2 = 0;
        //Recorro todos los tr ubicados en el tbody
        $('#demo-dt-basic tbody').find('tr').each(function (i, el) {

            //Voy incrementando las variables segun la fila ( .eq(0) representa la fila 1 )
            total_col1 += parseFloat($(this).find('td').eq(6).text());
            total_col2 += parseFloat($(this).find('td').eq(7).text());

        });
        //Muestro el resultado en el th correspondiente a la columna
        alert("El Resultado es: \nTotal Detraccion = " + total_col1 + "\nTotal Base = " + total_col2 + "\nTotal General = " + (total_col1 + total_col2));
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

