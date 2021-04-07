<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require_once '../models/Inicio.php';
$inicio = new Inicio();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:38:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Software Gestion de Seguridad Industrial</title>


    <!--STYLESHEET-->
    <!--=================================================-->


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="../public/css/nifty.min.css" rel="stylesheet">


    <!--Font Awesome [ OPTIONAL ]-->
    <link href="../public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <!--Animate.css [ OPTIONAL ]-->
    <link href="../public/plugins/animate-css/animate.min.css" rel="stylesheet">


    <!--Morris.js [ OPTIONAL ]-->
    <link href="../public/plugins/morris-js/morris.min.css" rel="stylesheet">


    <!--Switchery [ OPTIONAL ]-->
    <link href="../public/plugins/switchery/switchery.min.css" rel="stylesheet">


    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="../public/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


    <!--Demo script [ DEMONSTRATION ]-->
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

    <!--INICIO DE CONTENIDO DE LA PAGINA-->
    <div class="boxed">

        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">

            <!--Page Title-->
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <div id="page-title">
                <h1 class="page-header text-overflow">Dashboard</h1>

                <!--Searchbox-->
                <div class="searchbox">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search..">
                        <span class="input-group-btn">
									<button class="text-muted" type="button"><i class="fa fa-search"></i></button>
								</span>
                    </div>
                </div>
            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->


            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <div class="row">
                    <div class="col-sm-7">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>por Cobrar por Cliente</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Item.</th>
                                            <th class="text-center">Empresa</th>
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Nro Docs</th>
                                            <th class="text-center">Antiguedad</th>
                                            <th class="text-center">Deuda</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $item = 1;
                                        $total_deuda = 0;
                                        $total_venta = 0;
                                        foreach ($inicio->totalCobroCliente() as $fila) {
                                            $total_deuda += $fila['deuda'];
                                            $total_venta += $fila['total'];
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $item ?></td>
                                                <td><?php echo $fila['empresa'] ?></td>
                                                <td><?php echo $fila['cliente'] ?></td>
                                                <td class="text-center"><?php echo $fila['nrodocumentos'] ?></td>
                                                <td class="text-center"><?php echo $fila['nrodias'] ?></td>
                                                <td class="text-right"><?php echo number_format($fila['deuda'], 2) ?></td>
                                            </tr>
                                            <?php
                                            $item++;
                                        }
                                        ?>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="5">TOTALES</td>
                                            <td class="text-right"><?php echo number_format($total_deuda, 2) ?></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!--===================================================-->
                            <!--End Data Table-->
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>por Cobrar por empresas</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Item.</th>
                                            <th class="text-center">Empresa</th>
                                            <th class="text-center">Nro. Docs.</th>
                                            <th class="text-center">Antig. (dias)</th>
                                            <th class="text-center">Deuda</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $item = 1;
                                        $total_deuda = 0;
                                        foreach ($inicio->totalDeudas() as $fila) {
                                            $total_deuda += $fila['deuda'];
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $item ?></td>
                                                <td><?php echo $fila['razon_social'] ?></td>
                                                <td class="text-center"><?php echo $fila['nrodocumentos'] ?></td>
                                                <td class="text-center"><?php echo $fila['nrodias'] ?></td>
                                                <td class="text-right"><?php echo number_format($fila['deuda'], 2) ?></td>
                                            </tr>
                                            <?php
                                            $item++;
                                        }
                                        ?>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="4">TOTALES</td>
                                            <td class="text-right"><?php echo number_format($total_deuda, 2) ?></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!--===================================================-->
                            <!--End Data Table-->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>IGV Compras y Ventas x empresas - Mes Anterior</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Item.</th>
                                            <th class="text-center">Empresa</th>
                                            <th class="text-center">Total Venta</th>
                                            <th class="text-center">IGV Venta</th>
                                            <th class="text-center">IGV Compra</th>
                                            <th class="text-center">DIF IGV</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $item = 1;
                                        $total_venta = 0;
                                        $total_igv = 0;
                                        $total_igvcompra = 0;
                                        $total_difigv = 0;
                                        foreach ($inicio->totalIGVPasado() as $fila) {
                                            $tcompra = $fila['total_compra'];
                                            $tventa = $fila['total_venta'];
                                            $total_venta += $tventa;
                                            $igvcompra = ($tcompra / 1.18 * 0.18);
                                            $igvventa = ($tventa / 1.18 * 0.18);
                                            $total_igv += ($tventa / 1.18 * 0.18);
                                            $total_igvcompra += ($tcompra/ 1.18 * 0.18);
                                            $total_difigv += ($igvventa - $igvcompra);
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $item ?></td>
                                                <td><?php echo $fila['razon_social'] ?></td>
                                                <td class="text-right"><?php echo number_format($tventa, 2) ?></td>
                                                <td class="text-right"><?php echo number_format($igvventa, 2) ?></td>
                                                <td class="text-right"><?php echo number_format($igvcompra, 2) ?></td>
                                                <td class="text-right"><?php echo number_format($igvventa - $igvcompra, 2) ?></td>
                                            </tr>
                                            <?php
                                            $item++;
                                        }
                                        ?>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td class="text-right" colspan="2">TOTALES</td>
                                            <td class="text-right"><?php echo number_format($total_venta, 2) ?></td>
                                            <td class="text-right"><?php echo number_format($total_igv, 2) ?></td>
                                            <td class="text-right"><?php echo number_format($total_igvcompra, 2) ?></td>
                                            <td class="text-right"><?php echo number_format($total_difigv, 2) ?></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <!--===================================================-->
                            <!--End Data Table-->
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Colaboradores por Empresa</b></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Item.</th>
                                            <th class="text-center">Empresa</th>
                                            <th class="text-center">Nro Trabajadores</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        $item = 1;
                                        foreach ($inicio->trabajadoresPorEmpresa() as $fila) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo $item ?></td>
                                                <td><?php echo $fila['empresa'] ?></td>
                                                <td class="text-right"><?php echo number_format($fila['ctrabajadores'], 0) ?></td>
                                            </tr>
                                            <?php
                                            $item++;
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <!--===================================================-->
                            <!--End Data Table-->
                        </div>
                    </div>
                </div>


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


<!--Morris.js [ OPTIONAL ]-->
<script src="../public/plugins/morris-js/morris.min.js"></script>
<script src="../public/plugins/morris-js/raphael-js/raphael.min.js"></script>


<!--Sparkline [ OPTIONAL ]-->
<script src="../public/plugins/sparkline/jquery.sparkline.min.js"></script>


<!--Skycons [ OPTIONAL ]-->
<script src="../public/plugins/skycons/skycons.min.js"></script>


<!--Switchery [ OPTIONAL ]-->
<script src="../public/plugins/switchery/switchery.min.js"></script>


<!--Bootstrap Select [ OPTIONAL ]-->
<script src="../public/plugins/bootstrap-select/bootstrap-select.min.js"></script>


<!--Demo script [ DEMONSTRATION ]-->
<script src="../public/js/demo/nifty-demo.min.js"></script>


<!--Specify page [ SAMPLE ]-->
<script src="../public/js/demo/dashboard.js"></script>


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

<!-- Mirrored from www.themeon.net/nifty/v2.3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:40:18 GMT -->
</html>
