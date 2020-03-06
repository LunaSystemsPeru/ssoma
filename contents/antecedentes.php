<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include ("includes/conectar.php");
$codigo = $_GET['id'];
$empresa = $_SESSION['empresa'];

function fecha_db($date) {
    $from_format = 'd/m/Y';
    $to_format = 'Y-m-d';
    $date_aux = date_create_from_format($from_format, $date);
    return date_format($date_aux, $to_format);
}

$ver_empleado = "select e.codigo, e.dni, e.nombres "
        . "from empleado as e "
        . "where e.codigo = '" . $codigo . "'";
$resultado = $conn->query($ver_empleado);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $nombres = $fila['nombres'];
    }
}

function ver_id($empleado, $empresa) {
    $id = 1;
    global $conn;
    $ver_empleado = "select id from antecedentes where empleado= '" . $empleado . "' and empresa = '" . $empresa . "' order by id desc limit 1";
    echo $ver_empleado;
    $resultado = $conn->query($ver_empleado);
    if ($resultado->num_rows > 0) {
        if ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'] + 1;
        } else {
            $id = 1;
        }
    }
    //$conn->close();
    return $id;
}

if (isset($_POST['graba_antecedentes'])) {
    $empleado = $_POST['empleado'];
    $fecha = $_POST['fecha_afiliacion'];
    $medio = strtoupper($_POST['medio']);
    $tipo = strtoupper($_POST['tipo']);
    $antecedentes = strtoupper($_POST['antecedentes']);

    $id = ver_id($empleado, $empresa);
    global $conn;
    $ins_antecedentes = "insert into antecedentes Values ('" . $id . "', '" . $empleado . "', '" . $empresa . "', '" . fecha_db($fecha) . "', '" . $medio . "', '" . $antecedentes . "', '" . $tipo . "')";
    //echo $ins_estudios;
    $resultado = $conn->query($ins_antecedentes);
    if (!$resultado) {
        /* echo '<script type="text/javascript">
          alert("'.mysqli_error().'");
          </script>'; */
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        header('Location: antecedentes.php?id=' . $empleado);
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
        <title>Antecedentes -- Empleados | Software Gestion de Seguridad Industrial</title>


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
            function ver_antecedentes(codigo, empleado, empresa) {
                //alert("reportes/antecedentes.php?codigo="+codigo+"&empleado=" + empleado + "&empresa=" + empresa);
                document.location.href = "reportes/antecedentes.php?codigo=" + codigo + "&empleado=" + empleado + "&empresa=" + empresa;
            }
            function ver_galeria() {
                document.location.href = "galeria_empleados.php";
            }
        </script>


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
                                <h3 class="panel-title"><b>Antecedentes</b> --- <?php echo $nombres; ?></h3>
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
                                                <th class="text-center">Fecha.</th>
                                                <th class="text-center">Medio Probatorio</th>
                                                <th class="text-center">Antecedentes</th>
                                                <th class="text-center">tipo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $empresa = $_SESSION['empresa'];

                                            function fecha_tabla($date) {
                                                $to_format = 'd/m/Y';
                                                $from_format = 'Y-m-d';
                                                $date_aux = date_create_from_format($from_format, $date);
                                                return date_format($date_aux, $to_format);
                                            }

//buscar empleados en esta empresa
                                            $familia = "select id, fecha, medio, antecedentes, tipo from antecedentes where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                            $resultado = $conn->query($familia);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    echo '<tr>
														<td>' . $fila['id'] . '</a></td>
														<td class="text-center">' . fecha_tabla($fila['fecha']) . '</td>
														<td class="text-center">' . $fila['medio'] . '</td>
														<td class="text-center">' . $fila['antecedentes'] . '</td>
														<td class="text-center">' . $fila['tipo'] . '</td>
														<td>
														<button onclick="ver_antecedentes(\'' . $fila['id'] . '\',\'' . $codigo . '\',\'' . $empresa . '\')" class="btn btn-success btn-icon icon-lg fa fa-print"></button>
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
                                <h4 class="modal-title">Registro de Antecedentes</h4>
                            </div>
                            <form class="form-horizontal" action="" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fecha</label>
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="dd/mm/aaaa" name="fecha_afiliacion" id="fecha_afiliacion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Tipo Antecedentes</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="tipo" name="tipo" class="selectpicker">
                                                <option value="POLICIALES">POLICIALES</option>
                                                <option value="PENALES">PENALES</option>
                                                <option value="JUDICIALES">JUDICIALES</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Medio</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="medio" name="medio" class="selectpicker">
                                                <option value="DECLARACION">DECLARACION JURADA</option>
                                                <option value="CERTIFICADO">CERTIFICADO</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Presenta Antecedentes?</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="antecedentes" name="antecedentes" class="selectpicker">
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>

                                    <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $codigo; ?>">
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                    <input type="submit" class="btn btn-primary" name="graba_antecedentes">
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

