<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include ("includes/conectar.php");
$codigo = $_GET['id'];
$empresa = $_SESSION['empresa'];
$ver_empleado = "select e.codigo, e.dni, e.nombres "
        . "from empleado as e "
        . "where e.codigo = '" . $codigo . "' and empresa = '" . $empresa . "'";
$resultado = $conn->query($ver_empleado);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $nombres = $fila['nombres'];
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
        <title>Familia / Contacto -- Empleados | Software Gestion de Seguridad Industrial</title>


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
            function add_empleado() {
                document.location.href = "registra_empleado.php";
            }
            function ver_galeria() {
                document.location.href = "galeria_empleados.php";
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
                                <h3 class="panel-title"><b>Datos Familiares</b> --- <?php echo $nombres; ?></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button data-target="#add_familiar" data-toggle="modal" class="btn btn-primary btn-m">Agregar</button>
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
                                                <th class="text-center">Nro DNI.</th>
                                                <th>Apellidos y Nombres</th>
                                                <th class="text-center">Edad</th>
                                                <th class="text-center">Sexo</th>
                                                <th class="text-center">Parentesco</th>
                                                <th>Direccion</th>
                                                <th class="text-center">Telefono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //buscar empleados en esta empresa
                                            $familia = "select dni, nombre_completo,  YEAR(CURDATE())-YEAR(fecha_nacimiento) as edad, fecha_nacimiento, direccion, telefono, sexo, parentesco from datos_familiares where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                            $resultado = $conn->query($familia);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    if ($fila['sexo'] == "F") {
                                                        $sexo = "FEMENINO";
                                                    } else {
                                                        $sexo = "MASCULINO";
                                                    }
                                                    echo '<tr>
														<td class="text-center">' . $fila['dni'] . '</a></td>
														<td>' . $fila['nombre_completo'] . '</td>
														<td>' . $fila['edad'] . ' años</td>
														<td class="text-center">' . $sexo . '</td>
														<td class="text-center">' . strtoupper($fila['parentesco']) . '</td>
														<td>' . strtoupper($fila['direccion']) . '</td>
														<td class="text-center">' . $fila['telefono'] . '</td>
														<td>
														<button onclick="EditaFamilia(\'' . $codigo . '\', \'' . $fila['dni'] . '\')" data-target="#edita_familia" data-toggle="modal" class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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

                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title"><b>Contacto de Emergencia</b> --- <?php echo $nombres; ?></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button data-target="#add_contacto" data-toggle="modal" class="btn btn-success btn-m">Agregar</button>
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
                                                <th>Apellidos y Nombres</th>
                                                <th class="text-center">Sexo</th>
                                                <th class="text-center">Parentesco / Relacion</th>
                                                <th>Direccion</th>
                                                <th class="text-center">Telefono</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //buscar datos_de emergencia de este empleado
                                            $familia = "select id, nombre_completo, direccion, telefono, sexo, parentesco from contacto_emergencia where empleado = '" . $codigo . "'  and empresa = '" . $empresa . "'";
                                            $resultado = $conn->query($familia);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    if ($fila['sexo'] == "F") {
                                                        $sexo = "FEMENINO";
                                                    } else {
                                                        $sexo = "MASCULINO";
                                                    }
                                                    echo '<tr>
																<td class="text-center">' . $fila['id'] . '</a></td>
																<td>' . $fila['nombre_completo'] . '</td>
																<td class="text-center">' . $sexo . '</td>
																<td class="text-center">' . strtoupper($fila['parentesco']) . '</td>
																<td>' . strtoupper($fila['direccion']) . '</td>
																<td class="text-center">' . $fila['telefono'] . '</td>
																<td>
														<button onclick="EditaContacto(\'' . $codigo . '\', \'' . $fila['id'] . '\')" data-target="#edita_contacto" data-toggle="modal" class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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
                <div class="modal" id="add_familiar" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Registro de Familiar / Contacto</h4>
                            </div>
                            <form class="form-horizontal" id="graba_familiar" action="inserts/add_familiar.php" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Nro DNI</label>
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Nro DNI" name="nro_dni" id="nro_dni" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Nombres</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="nombres" placeholder="Nombres" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Apellido Paterno</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="ape_pat" placeholder="Apellido Paterno" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Apellido Matenro</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="ape_mat" placeholder="Apellido Materno" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Direccion</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="direccion" placeholder="Direccion" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Telefono / Celular</label>
                                        <div class="col-lg-7">
                                            <input type="text" id="celular" name="celular" class="form-control" placeholder="Nro Celular" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Sexo</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="sexo" name="sexo" class="selectpicker">
                                                <option value="F">FEMENINO</option>
                                                <option value="M">MASCULINO</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Parentesco</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="parentesco" placeholder="Parentesco" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Fecha Nacimiento</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" placeholder="dd/mm/aaaa" required>
                                        </div>
                                    </div>
                                    <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $codigo; ?>">
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                    <button class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--===================================================-->
                <!--End Default Bootstrap Modal-->

                <!--Default Bootstrap Modal-->
                <!--===================================================-->
                <div class="modal" id="add_contacto" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Registro de Contacto de Emergencia</h4>
                            </div>
                            <form class="form-horizontal" id="graba_contacto" action="inserts/add_contacto.php" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Nombres</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="nombres" placeholder="Nombres" required >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Apellido Paterno</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="ape_pat" placeholder="Apellido Paterno" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Apellido Materno</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="ape_mat" placeholder="Apellido Materno" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Direccion</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="direccion" placeholder="Direccion">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Telefono / Celular</label>
                                        <div class="col-lg-7">
                                            <input type="text" id="celular" name="celular" class="form-control" placeholder="Nro Celular" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Sexo</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="sexo" name="sexo" class="selectpicker">
                                                <option value="F">FEMENINO</option>
                                                <option value="M">MASCULINO</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Parentesco</label>
                                        <div class="col-lg-7">
                                            <input type="text" class="form-control" name="parentesco" placeholder="Parentesco" required>
                                        </div>
                                    </div>
                                    <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $codigo; ?>">
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                    <button class="btn btn-primary">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal" id="edita_familia" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_edita_familia" class="modal-content contenido_edita_familia" id="contenido_edita_familia">

                        </div>
                    </div>
                </div>

                <div class="modal" id="edita_contacto" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_edita_contacto" class="modal-content contenido_edita_contacto" id="contenido_edita_contacto">

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
            function EditaFamilia(empleado, familiar) {
                var parametros = {
                    "empleado": empleado,
                    "familiar": familiar,
                };
                $.ajax({
                    data: parametros,
                    url: 'frm_modificar/modificar_familia.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_edita_familia").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_edita_familia").html(response);
                    }
                });
            }

            function EditaContacto(empleado, contacto) {
                var parametros = {
                    "empleado": empleado,
                    "contacto": contacto,
                };
                $.ajax({
                    data: parametros,
                    url: 'frm_modificar/modificar_contacto.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_edita_contacto").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_edita_contacto").html(response);
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
                This is to be removed, used for demonstration purposes only. This category must not be included in your project.
                
                SAMPLE
                Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
                
                
                Detailed information and more samples can be found in the document.
                
        -->


    </body>

    <!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

