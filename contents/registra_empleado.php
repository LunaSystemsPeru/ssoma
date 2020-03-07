<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require '../models/Ubigeo.php';
require '../models/ParametrosDetalle.php';

$ubigeo = new Ubigeo();
$parametro = new ParametrosDetalle();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Empleado | Software Gestion de Seguridad Industrial</title>


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

    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src="../public/js/jquery-2.1.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    <!--SCRIPT-->
    <!--=================================================-->

    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="../public/plugins/pace/pace.min.js"></script>

    <script>
        $(document).ready(function () {

            //autocomplete
            $("#input_seguro").autocomplete({
                source: "ajax_post/buscar_seguros.php",
                minLength: 1,
                select: function (event, ui) {
                    event.preventDefault();
                    $('#input_seguro').val(ui.item.nombre);
                    $('#input_id_seguro').val(ui.item.id);
                    $('#fecha_afiliacion').focus();
                }
            });

            //autocomplete
            $("#input_comision").autocomplete({
                source: "ajax_post/buscar_comision.php",
                minLength: 1,
                select: function (event, ui) {
                    event.preventDefault();
                    $('#input_comision').val(ui.item.nombre);
                    $('#input_id_comision').val(ui.item.id);
                    $('#renta_5ta').focus();
                }
            });


        });
    </script>

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
            <div id="page-title">
                <h1 class="page-header text-overflow">Registrar Empleado</h1>

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
                    <form class="form-horizontal" enctype="multipart/form-data" id="graba_empleado" action="inserts/add_empleado.php" method="post">
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
                                <div id="image_preview"><img id="previewing" src="../public/images/noimage.png"/></div>
                                <hr id="line">
                                <div id="selectImage" class="row">
                                    <input class="btn btn-default" type="file" name="file" id="file"/>
                                </div>
                                <div id="message"></div>
                            </div>
                            <!--===================================================-->

                        </div>
                        <div class="col-lg-9">
                            <!-- GENERAL -->
                            <!--===================================================-->

                            <div class="panel ">
                                <div class="panel-body">
                                    <h3 class="bord-btm text-thin">Datos Generales</h3>
                                    <div id="error_documento"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="codigo">Codigo</label>
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="Codigo" name="codigo" id="codigo" class="form-control" required>
                                        </div>
                                        <label class="col-sm-1 control-label" for="nro_dni">DNI</label>
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="Nro DNI" name="nro_dni" id="nro_dni" class="form-control" maxlength="10" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-info" onclick="enviar_documento()"><i class="fa fa-check"></i> Validar DNI</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="nombres">Apellidos y Nombres</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Apellidos y Nombres" name="nombres" id="nombres" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="direccion">Direccion</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Direccion" name="direccion" id="direccion" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="id_departamento">Departamento</label>
                                        <div class="col-sm-4">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="id_departamento" name="id_departamento" class="form-control">
                                                <?php
                                                foreach ($ubigeo->verDepartamentos() as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['departamento'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="id2_provincia">Provincia</label>
                                        <div class="col-sm-4">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="id_provincia" name="id_provincia" class="form-control">
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="id2_distrito">Distrito</label>
                                        <div class="col-sm-4">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="id_distrito" name="id_distrito" class="form-control">
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="email">Email</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="E-mail" name="email" id="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="celular">Telefono / Celular</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="celular" name="celular" class="form-control" placeholder="Nro Celular" maxlength="9" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="fecha_nacimiento">Fecha de Nacimiento</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                                        </div>
                                        <label class="col-sm-2 control-label" for="estado_civil">Estado Civil</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="estado_civil" name="estado_civil" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(3);
                                                foreach ($parametro->verFilas() as $fila) {
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
                                        <label class="col-sm-3 control-label" for="grupo_sanguineo">Grupo Sanguineo</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="grupo_sanguineo" name="grupo_sanguineo" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(1);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                        <label class="col-sm-2 control-label" for="factor_sanguineo">Factor Sanguineo</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="factor_sanguineo" name="factor_sanguineo" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(2);
                                                foreach ($parametro->verFilas() as $fila) {
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
                                        <label class="col-sm-3 control-label" for="categoria">Categoria</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="categoria" name="categoria" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(4);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                        <label class="col-sm-2 control-label" for="cargo">Cargo</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="cargo" name="cargo" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(5);
                                                foreach ($parametro->verFilas() as $fila) {
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
                                        <label class="col-sm-3 control-label" for="jornal">Jornal</label>
                                        <div class="col-sm-3">
                                            <input type="text" placeholder="Jornal" name="jornal" id="jornal" class="form-control" required>
                                        </div>
                                        <label class="col-sm-2 control-label" for="fecha_ingreso">Fecha de Ingreso</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control" placeholder="dd/mm/aaaa" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="especializacion">Especializacion</label>
                                        <div class="col-sm-8">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="especializacion" name="especializacion" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(6);
                                                foreach ($parametro->verFilas() as $fila) {
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
                                        <label class="col-sm-3 control-label" for="input_seguro">Seguro de Pensiones</label>
                                        <div class="col-sm-3">
                                            <select id="select_sbn" name="select_sbn" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(7);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 control-label" for="fecha_afiliacion">Fecha de Afiliacion</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="fecha_afiliacion" name="fecha_afiliacion" class="form-control" placeholder="dd/mm/aaaa" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="cuspp">CUSPP</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="cuspp" name="cuspp" class="form-control" placeholder="cuspp">
                                        </div>
                                        <label class="col-sm-2 control-label" for="select_comision">Tipo de Comision</label>
                                        <div class="col-sm-3">
                                            <select id="select_comision" name="select_comision" class="form-control">
                                                <?php
                                                $parametro->setIdParametro(8);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="renta_5ta">Renta de 5ta Categoria</label>
                                        <div class="col-sm-6">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="renta_5ta" name="renta_5ta" class="selectpicker">
                                                <option value="1">SI</option>
                                                <option value="0">NO</option>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <button class="btn btn-info" type="submit">Aceptar</button>
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


<!--Demo script [ DEMONSTRATION ]-->
<script src="../public/js/demo/nifty-demo.min.js"></script>


<!--Masked Input [ OPTIONAL ]-->
<script src="../public/plugins/masked-input/jquery.maskedinput.min.js"></script>


<!--Form validation [ SAMPLE ]-->
<script src="../public/js/demo/form-validation.js"></script>
<script src="../public/js/js_cliente.js"></script>


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
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                    $('#previewing').attr('src', 'noimage.png');
                    $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
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

