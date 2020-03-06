<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

include ('includes/conectar.php');
$codigo = $_GET['empleado'];
$empresa = $_GET['empresa'];

function fecha_tabla($date) {
    $to_format = 'd/m/Y';
    $from_format = 'Y-m-d';
    $date_aux = date_create_from_format($from_format, $date);
    return date_format($date_aux, $to_format);
}

$ver_empleado = "select * from empleado where empresa = '" . $empresa . "' and codigo = '" . $codigo . "'";
$resultado = $conn->query($ver_empleado);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $codigo_empleado = $fila['codigo'];
        $dni = $fila['dni'];
        $nombres = $fila['nombres'];
        $cargo = $fila['cargo'];
        $id_departamento = $fila['departamento'];
        $estado_civil = $fila['estado_civil'];
        $id_provincia = $fila['provincia'];
        $id_distrito = $fila['distrito'];
        $imagen = $fila['imagen'];
        $direccion = $fila['direccion'];
        $email = $fila['email'];
        $fecha_nacimiento = fecha_tabla($fila['fecha_nacimiento']);
        $fecha_ingreso = fecha_tabla($fila['fecha_ingreso']);
        $grupo_sanguineo = $fila['grupo_sanguineo'];
        $factor_sanguineo = $fila['factor_sanguineo'];
        $categoria = $fila['categoria'];
        $telefono = $fila['telefono'];
        $cuspp = $fila['cuspp'];
        $fecha_afiliacion = fecha_tabla($fila['fecha_afiliacion']);
        $jornal = $fila['jornal'];
        $seguro_pension = $fila['seguro_pension'];
        $renta_5ta = $fila['renta_5ta'];
        $especializacion = $fila['especializacion'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">


    <!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar Empleado | Software Gestion de Seguridad Industrial</title>


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


        <!--Bootstrap Validator [ OPTIONAL ]-->
        <link href="../public/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">


        <!--Demo [ DEMONSTRATION ]-->
        <link href="../public/css/demo/nifty-demo.min.css" rel="stylesheet">




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
                    <div id="page-title">
                        <h1 class="page-header text-overflow">Modificar Empleado</h1>

                        <!--Searchbox-->
                    </div>
                    <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                    <!--End page title-->

                    <!--Page content-->
                    <!--===================================================-->
                    <div id="page-content">

                        <div class="row">
                            <form class="form-horizontal" enctype="multipart/form-data" id="modificar_empleado" action="inserts/modificar_empleado.php" method="post">
                                <div class="col-lg-3">

                                    <!-- Tips Widget -->
                                    <!--===================================================-->
                                    <div class="mar-btm">
                                        <h4 class="text-thin"><i class="fa fa-lightbulb-o fa-lg fa-fw text-warning"></i> Elejir imagen</h4>

                                    </div>
                                    <!--===================================================-->

                                    <hr>

                                    <!-- Contact us widget -->
                                    <!--===================================================-->
                                    <div class="mar-btm">
                                        <div id="image_preview"><img id="previewing" src="<?php echo 'upload/' . $empresa . '/perfil/' . $imagen ?>" class="img-lg img-border img-lg"/></div>
                                        <hr id="line">
                                        <div id="selectImage">
                                            <input class="btn btn-default" type="file" name="file" id="file"/>
                                        </div>
                                        <div id="message"></div>
                                    </div>
                                    <!--===================================================-->

                                </div>
                                <div class="col-lg-9">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <!-- GENERAL -->
                                            <!--===================================================-->
                                            <h3 class="pad-all bord-btm text-thin">Datos Generales</h3>
                                            <div id="demo-gen-faq" class="panel-group accordion">
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="codigo">Codigo</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" placeholder="Codigo" name="codigo" id="codigo" value="<?php echo $codigo; ?>" class="form-control" readonly="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="nro_placa">DNI</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" placeholder="Nro DNI" name="nro_dni" id="nro_dni" value="<?php echo $dni; ?>" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="nombres">Nombres</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" placeholder="Nombres" name="nombres" id="nombres" value="<?php echo $nombres; ?>" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="direccion">Direccion</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" placeholder="Direccion" name="direccion" id="direccion" value="<?php echo $direccion; ?>" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="id_departamento">Departamento</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="id_departamento" name="id_departamento" class="form-control">
<?php
global $conn;
$consulta = 'select id, nombre from departamento order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $id_departamento) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="id2_provincia">Provincia</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="id_provincia" name="id_provincia" class="form-control">
<?php
global $conn;
$consulta = 'select id, nombre from provincia where departamento = "' . $id_departamento . '" order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $id_provincia) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="id2_distrito">Distrito</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="id_distrito" name="id_distrito" class="form-control">
<?php
global $conn;
$consulta = 'select id, nombre from distrito where departamento = "' . $id_departamento . '" and provincia = "' . $id_provincia . '" order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $id_distrito) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="email">Email</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" placeholder="E-mail" name="email" id="email" value="<?php echo $email; ?>" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" class="form-control" placeholder="dd/mm/aaaa" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="estado_civil">Grupo Sanguineo</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="grupo_sanguineo" name="grupo_sanguineo" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from grupo_sanguineo order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $grupo_sanguineo) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="estado_civil">Factor Sanguineo</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="factor_sanguineo" name="factor_sanguineo" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from factor_sanguineo order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $factor_sanguineo) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="celular">Telefono / Celular</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="celular" name="celular" class="form-control" value="<?php echo $telefono; ?>" placeholder="Nro Celular" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="estado_civil">Estado Civil</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="estado_civil" name="estado_civil" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from estado_civil order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $estado_civil) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="categoria">Categoria</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="categoria" name="categoria" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from categoria order by nombres asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $categoria) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombres']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="cargo">Cargo</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="cargo" name="cargo" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from cargo order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $cargo) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="jornal">Jornal</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" placeholder="Jornal" name="jornal" id="jornal" value="<?php echo $jornal; ?>"  class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="fecha_ingreso">Fecha de Ingreso</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="fecha_ingreso" name="fecha_ingreso" class="form-control" value="<?php echo $fecha_ingreso; ?>"  placeholder="dd/mm/aaaa" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="especializacion">Especializacion</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="especializacion" name="especializacion" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from especializacion order by descripcion asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $especializacion) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['descripcion']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="seguro_pension">Seguro de Pensiones</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="seguro_pension" name="seguro_pension" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from seguro_pension order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $seguro_pension) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="fecha_afiliacion">Fecha de Afiliacion</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="fecha_afiliacion" name="fecha_afiliacion" class="form-control" value="<?php echo $fecha_afiliacion; ?>"  placeholder="dd/mm/aaaa" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="cuspp">CUSPP</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" id="cuspp" name="cuspp" class="form-control" value="<?php echo $cuspp; ?>"  placeholder="cuspp">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="tipo_seguro">Tipo de Seguro Afiliado</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="tipo_seguro" name="tipo_seguro" class="selectpicker">
<?php
global $conn;
$consulta = 'select * from tipo_seguro order by nombre asc';
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        if ($fila['id'] == $seguro_pension) {
            $seleccion = "selected='selected'";
        } else {
            $seleccion = "";
        }
        echo '<option value=' . $fila['id'] . ' ' . $seleccion . '>' . strtoupper($fila['nombre']) . '</option>';
    }
}
?>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label" for="renta_5ta">Renta de 5ta Categoria</label>
                                                        <div class="col-sm-6">
                                                            <!-- Default Bootstrap Select -->
                                                            <!--===================================================-->
                                                            <select id="renta_5ta" name="renta_5ta" class="selectpicker">
                                                                <option value="1" <?php if ($renta_5ta == 1) {
                                                                    echo "selected='selected'";
                                                                } ?>>SI</option>
                                                                <option value="0" <?php if ($renta_5ta == 0) {
                                                                    echo "selected='selected'";
                                                                } ?>>NO</option>
                                                            </select>
                                                            <!--===================================================-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="imagen" id="imagen" value="<?php echo $imagen ?>">
                                                <div class="panel-footer text-right">
                                                    <button class="btn btn-info" type="submit">Aceptar</button>
                                                </div>


                                            </div>

                                            <!--===================================================-->


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                    </div>
                    <!--===================================================-->
                    <!--End page content-->


                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->



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


        <!--Demo script [ DEMONSTRATION ]-->
        <script src="js/demo/nifty-demo.min.js"></script>


        <!--Masked Input [ OPTIONAL ]-->
        <script src="plugins/masked-input/jquery.maskedinput.min.js"></script>


        <!--Form validation [ SAMPLE ]-->
        <script src="js/demo/form-validation.js"></script>

        <script language="javascript">
            $(document).ready(function () {
                $("#id_departamento").change(function () {
                    $("#id_departamento option:selected").each(function () {
                        id_departamento = $("#id_departamento").val();
                        $.post("consultas/provincias.php", {id_departamento: id_departamento}, function (data) {
                            $("#id_provincia").html(data);
                        });
                    });
                })
            });

            $(document).ready(function () {
                $("#id_provincia").change(function () {
                    $("#id_provincia option:selected").each(function () {
                        id_provincia = $("#id_provincia").val();
                        id_departamento = $("#id_departamento").val();
                        $.post("consultas/distritos.php", {id_provincia: id_provincia, id_departamento: id_departamento}, function (data) {
                            $("#id_distrito").html(data);
                        });
                    });
                })
            });

            $(document).ready(function (e) {
                // Function to preview image after validation
                $(function () {
                    $("#file").change(function () {
                        $("#message").empty(); // To remove the previous error message
                        var file = this.files[0];
                        var imagefile = file.type;
                        var match = ["image/jpeg", "image/png", "image/jpg"];
                        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
                        {
                            $('#previewing').attr('src', 'noimage.png');
                            $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                            return false;
                        } else
                        {
                            var reader = new FileReader();
                            reader.onload = imageIsLoaded;
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                });
                function imageIsLoaded(e) {
                    $("#file").css("color", "green");
                    $('#image_preview').css("display", "block");
                    $('#previewing').attr('src', e.target.result);
                    $('#previewing').attr('width', '300px');
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

    <!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
</html>

