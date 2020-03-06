<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include("includes/conectar.php");

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

function ver_id_estudios($empleado, $empresa) {
    $id = 1;
    global $conn;
    $ver_empleado = "select id from estudios "
            . "where empleado = '" . $empleado . "' and empresa = '" . $empresa . "' "
            . "order by id desc limit 1";
    $resultado = $conn->query($ver_empleado);
    if ($resultado->num_rows > 0) {
        if ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'] + 1;
        }
    }
    //$conn->close();
    return $id;
}

function ver_id_cursos($empleado, $empresa) {
    $id = 1;
    global $conn;
    $ver_empleado = "select id "
            . "from cursos "
            . "where empleado = '" . $empleado . "' and empresa = '" . $empresa . "' "
            . "order by id desc limit 1";
    $resultado = $conn->query($ver_empleado);
    if ($resultado->num_rows > 0) {
        if ($fila = $resultado->fetch_assoc()) {
            $id = $fila['id'] + 1;
        }
    }
    //$conn->close();
    return $id;
}

if (isset($_POST['graba_estudios'])) {
    $empleado = $_POST['empleado'];
    $institucion = strtoupper($_POST['institucion']);
    $tipo = strtoupper($_POST['tipo']);
    $grado = strtoupper($_POST['grado']);

    $id = ver_id_estudios($empleado, $empresa);
    global $conn;
    $ins_estudios = "insert into estudios "
            . "Values ('" . $id . "', '" . $empleado . "', '" . $institucion . "', '" . $tipo . "', '" . $grado . "')";
    //echo $ins_estudios;
    $resultado = $conn->query($ins_estudios);
    if (!$resultado) {
        /* echo '<script type="text/javascript">
          alert("'.mysqli_error().'");
          </script>'; */
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        header('Location: academico_empleado.php?id=' . $empleado);
    }
}

if (isset($_POST['graba_cursos'])) {
    $empleado = $_POST['empleado'];
    $institucion = strtoupper($_POST['institucion']);
    $descripcion = strtoupper($_POST['descripcion']);
    $duracion = $_POST['duracion'];
    $tipo_duracion = $_POST['tipo_duracion'];

    $id = ver_id_cursos($empleado, $empresa);
    global $conn;
    $ins_cursos = "insert into cursos "
            . "Values ('" . $id . "', '" . $empleado . "', '" . $empresa . "', '" . $institucion . "', '" . $descripcion . "', '" . $duracion . "', '" . $tipo_duracion . "')";
    //echo $ins_estudios;
    $resultado = $conn->query($ins_cursos);
    if (!$resultado) {
        /* echo '<script type="text/javascript">
          alert("'.mysqli_error().'");
          </script>'; */
        die('Could not enter data: ' . mysqli_error($conn));
    } else {
        header('Location: academico_empleado.php?id=' . $empleado);
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
        <title>Vida Academica -- Empleados | Software Gestion de Seguridad Industrial</title>


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
            <?php
            include("../fixed/header.php");
            ?>
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
                                <h3 class="panel-title"><b>Vida Academica</b> --- <?php
                                    echo $nombres;
                                    ?></h3>
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
                                                <th>Institucion</th>
                                                <th class="text-center">Tipo</th>
                                                <th class="text-center">Grado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
//buscar empleados en esta empresa
                                            $familia = "select id, institucion, tipo, grado from estudios where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                            $resultado = $conn->query($familia);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    echo '<tr>
                                                    <td>' . $fila['id'] . '</a></td>
                                                    <td>' . $fila['institucion'] . '</td>
                                                    <td>' . $fila['tipo'] . '</td>
                                                    <td>' . $fila['grado'] . '</td>
                                                    <td>
                                                    <button onclick="EditaEstudios(\'' . $codigo . '\', \'' . $fila['id'] . '\')" data-target="#edita_estudios" data-toggle="modal" class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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
                                <h3 class="panel-title"><b>Cursos y Especializaciones</b> --- <?php
                                    echo $nombres;
                                    ?></h3>
                            </div>
                            <!--Data Table-->
                            <!--===================================================-->
                            <div class="panel-body">
                                <div class="pad-btm form-inline">
                                    <div class="row">
                                        <div class="col-sm-6 table-toolbar-left">
                                            <button data-target="#add_cursos" data-toggle="modal" class="btn btn-success btn-m">Agregar</button>
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
                                                <th>Institucion</th>
                                                <th class="text-center">Descripcion</th>
                                                <th class="text-center">Duracion</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
//buscar empleados en esta empresa
                                            $familia = "select id, institucion, descripcion, duracion, tipo_duracion from cursos where empleado = '" . $codigo . "' and empresa = '" . $empresa . "'";
                                            $resultado = $conn->query($familia);
                                            if ($resultado->num_rows > 0) {
                                                while ($fila = $resultado->fetch_assoc()) {
                                                    echo '<tr>
                                                    <td>' . $fila['id'] . '</a></td>
                                                    <td>' . $fila['institucion'] . '</a></td>
                                                    <td>' . $fila['descripcion'] . '</td>
                                                    <td>' . $fila['duracion'] . ' ' . $fila['tipo_duracion'] . '</td>
                                                    <td>
                                                    <button onclick="EditaCursos(\'' . $codigo . '\', \'' . $fila['id'] . '\')" data-target="#edita_cursos" data-toggle="modal" class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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
                                <h4 class="modal-title">Registro Academico</h4>
                            </div>
                            <form class="form-horizontal" id="graba_estudios" action="" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Institucion</label>
                                        <div class="col-lg-7">
                                            <input type="text" placeholder="Institucion" name="institucion" id="institucion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Tipo</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="tipo" name="tipo" class="selectpicker">
                                                <option value="PRIMARIA">PRIMARIA</option>
                                                <option value="SECUNDARIA">SECUNDARIA</option>
                                                <option value="TECNICO SUPERIOR">TECNICO SUPERIOR</option>
                                                <option value="SUPERIOR">SUPERIOR</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Grado</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="grado" name="grado" class="selectpicker">
                                                <option value="COMPLETO">COMPLETO</option>
                                                <option value="INCOMPLETO">INCOMPLETO</option>
                                                <option value="BACHILER">BACHILER</option>
                                                <option value="TITULADO">TITULADO</option>
                                                <option value="EGRESADO">EGRESADO</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php
                                    echo $codigo;
                                    ?>">
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                    <input type="submit" class="btn btn-primary" name="graba_estudios">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="modal" id="add_cursos" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <!--Modal header-->
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Registro Cursos</h4>
                            </div>
                            <form class="form-horizontal" id="graba_estudios" action="" method="post">
                                <!--Modal body-->
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Institucion</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="Institucion" name="institucion" id="institucion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Descripcion</label>
                                        <div class="col-lg-8">
                                            <input type="text" placeholder="Descripcion" name="descripcion" id="descripcion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-3 control-label">Duracion</label>
                                        <div class="col-lg-3">
                                            <input type="number" placeholder="Duracion" name="duracion" id="duracion" class="form-control" required>
                                        </div>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="tipo_duracion" name="tipo_duracion" class="selectpicker">
                                                <option value="HORAS">HORAS</option>
                                                <option value="DIAS">DIAS</option>
                                                <option value="SEMANAS">SEMANAS</option>
                                                <option value="MESES">MESES</option>
                                                <option value="AÑOS">AÑOS</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php
                                    echo $codigo;
                                    ?>">
                                </div>

                                <!--Modal footer-->
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                    <input type="submit" class="btn btn-primary" name="graba_cursos">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal" id="edita_estudios" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_edita_estudios" class="modal-content contenido_edita_estudios" id="contenido_edita_estudios">

                        </div>
                    </div>
                </div>

                <div class="modal" id="edita_cursos" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div name="contenido_edita_cursos" class="modal-content contenido_edita_cursos" id="contenido_edita_cursos">

                        </div>
                    </div>
                </div>

                <!--===================================================-->
                <!--End Default Bootstrap Modal-->



                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <?php
                include("../fixed/main_navigation.php");
                ?>
                <!--===================================================-->
                <!--END MAIN NAVIGATION-->

                <!-- TAB DE LA DERECHA -->
                <!--ASIDE-->
                <!--===================================================-->
                <?php
                include("../fixed/aside_rigth.php");
                ?>
                <!--===================================================-->
                <!--END ASIDE-->
            </div>



            <!-- FOOTER -->
            <!--===================================================-->
            <?php
            include("../fixed/footer.php");
            ?>
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
            function EditaEstudios(empleado, estudio) {
                var parametros = {
                    "empleado": empleado,
                    "estudio": estudio,
                };
                $.ajax({
                    data: parametros,
                    url: 'frm_modificar/modificar_estudios.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_edita_estudios").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_edita_estudios").html(response);
                    }
                });
            }

            function EditaCursos(empleado, curso) {
                var parametros = {
                    "empleado": empleado,
                    "curso": curso,
                };
                $.ajax({
                    data: parametros,
                    url: 'frm_modificar/modificar_cursos.php',
                    type: 'post',
                    beforeSend: function () {
                        $("#contenido_edita_cursos").html("Procesando, espere por favor...");
                    },
                    success: function (response) {
                        $("#contenido_edita_cursos").html(response);
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

