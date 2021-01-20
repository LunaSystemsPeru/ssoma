<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}

require '../models/Ubigeo.php';
require '../models/ParametrosDetalle.php';
require '../models/Colaborador.php';
require '../models/Empresa.php';
require '../models/ColaboradoresAdjunto.php';
require '../models/ColaboradorDocumentacion.php';

$ubigeo = new Ubigeo();
$parametro = new ParametrosDetalle();


$colaborador = new Colaborador();
$empresa = new Empresa();
$archivo = new ColaboradoresAdjunto();
$documento = new ColaboradorDocumentacion();

$colaborador->setIdColaborador(filter_input(INPUT_GET, 'empleado'));
$colaborador->obtenerDatos();
$codigo = $colaborador->getIdColaborador();

$ubigeo->setIdUbigeo($colaborador->getIdUbigeo());
$ubigeo->obtenerDatos();

$empresa->setIdEmpresa($colaborador->getIdEmpresa());
$empresa->obtenerDatos();

$archivo->setIdColaborador($colaborador->getIdColaborador());


if ($colaborador->getFoto() == "noimage.png") {
    $url_perfil = "../upload/noimage.png";
    $url_dni = "../public/images/dni.jpg";
} else {
    $url_perfil = "../upload/" . $empresa->getRuc() . "/empleados/perfil/" . $colaborador->getFoto();
    $url_dni = "../upload/" . $empresa->getRuc() . "/empleados/documento/" . $colaborador->getFoto();

    if (!file_exists($url_dni)) {
        $url_dni = "../public/images/dni.jpg";
    }
    if (!file_exists($url_perfil)) {
        $url_perfil = "../upload/noimage.png";
    }
}
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
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

    <!--Demo [ DEMONSTRATION ]-->
    <link href="../public/css/demo/nifty-demo.min.css" rel="stylesheet">

    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link>
    <script src=" https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

    <!--SCRIPT-->
    <!--=================================================-->

    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
    <script src="../public/plugins/pace/pace.min.js"></script>

    <link rel="stylesheet" href="../public/plugins/croppie/croppie.css"/>
    <script src="../public/plugins/croppie/croppie.js"></script>
    <!-- IMPORTANTE: este fichero contiene el código de los pasos 1 y 2 que expliqué en el e-mail -->
    <script src="../public/plugins/croppie/cropie.handler.js"></script>

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
                <h1 class="page-header text-overflow">Modificar Empleado</h1>

            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <div class="row">
                    <form class="form-horizontal" enctype="multipart/form-data" id="graba_empleado" action="../controller/mod_colaboradore.php" method="post">
                        <div class="col-lg-4">

                            <div class="panel ">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Elejir imagen (Foto)</h3>
                                </div>
                                <div class="panel-body">
                                    <a href="javascript:cargar_foto_modal()">
                                        <img class="original-image" src="<?php echo $url_perfil?>"/>
                                        <input type="hidden" id="hidden_perfil" name="hidden_perfil" required>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="panel ">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Elejir imagen (Lado 1 Documento Identidad)</h3>
                                </div>
                                <div class="panel-body">
                                    <div id="image_preview_lado1" >
                                        <img id="previewing_lado1" src="<?php echo $url_dni?>" class="col-lg-12"/>
                                    </div>
                                    <hr id="line">
                                    <div id="selectImage_lado1" class="row">
                                        <input class="btn btn-default" type="file" name="file_lado1" id="file_lado1"/>
                                    </div>
                                    <div id="message"></div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <!-- GENERAL -->
                            <!--===================================================-->

                            <div class="panel ">
                                <div class="panel-body">
                                    <h3 class="bord-btm text-thin">Datos Generales</h3>
                                    <div id="error_documento"></div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="codigo">Codigo</label>
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="Codigo" name="codigo" id="codigo" value="<?php echo $colaborador->getIdColaborador()?>" class="form-control">
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_nacionalidad">Nacionalidad</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="input_nacionalidad">
                                                <option value="1" <?php if ($colaborador->getNacionalidad() == 1) { echo "selected";} ?> >Peruano</option>
                                                <option value="2" <?php if ($colaborador->getNacionalidad() == 2) { echo "selected";} ?> >Venezolano</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_tipo_documento">Tipo Doc.</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="select_tipo_documento" id="select_tipo_documento">
                                                <option value="1" <?php if ($colaborador->getTipoDocumento() == 1) { echo "selected";} ?>>DNI</option>
                                                <option value="2" <?php if ($colaborador->getTipoDocumento() == 2) { echo "selected";} ?>>PASAPORTE</option>
                                                <option value="3" <?php if ($colaborador->getTipoDocumento() == 3) { echo "selected";} ?>>PTP</option>
                                                <option value="4" <?php if ($colaborador->getTipoDocumento() == 4) { echo "selected";} ?>>CIV</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-1 control-label" for="input_documento">Nro Doc</label>
                                        <div class="col-sm-2">
                                            <input type="text" placeholder="Nro DNI" name="input_documento" id="input_documento" value="<?php echo $colaborador->getDocumento()?>" class="form-control" maxlength="10" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-info" onclick="enviar_documento()"><i class="fa fa-check"></i> Validar Documento</button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_dato">Apellidos y Nombres</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Apellidos y Nombres" name="input_dato" id="input_dato" class="form-control" value="<?php echo $colaborador->getDato()?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_fechaNacimiento">Fecha de Nacimiento</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="input_fechaNacimiento" name="input_fechaNacimiento" class="form-control" value="<?php echo $colaborador->getFechaNacimiento()?>" required>
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_idEstadoCivil">Estado Civil</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="input_idEstadoCivil" name="input_idEstadoCivil" class="selectpicker">
                                                <?php
                                                $parametro->setIdParametro(3);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option <?php if ($colaborador->getIdEstadoCivil() == $fila['id_detalle']) { echo "selected";} ?> value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
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
                                            <select id="categoria" name="categoria" class="selectpicker">
                                                <?php
                                                $parametro->setIdParametro(4);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option <?php if ($colaborador->getIdCargo() == $fila['id_detalle']) { echo "selected";} ?> value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_idCargo">Cargo</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="input_idCargo" name="input_idCargo" class="selectpicker">
                                                <?php
                                                $parametro->setIdParametro(5);
                                                foreach ($parametro->verFilas() as $fila) {
                                                    ?>
                                                    <option <?php if ($colaborador->getIdCargo() == $fila['id_detalle']) { echo "selected";} ?> value="<?php echo $fila['id_detalle'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_domicilio">Direccion</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Direccion" name="input_domicilio" id="input_domicilio" value="<?php echo $colaborador->getDomicilio()?>" class="form-control" >
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
                                                    <option <?php echo ($fila['departamento'] == $ubigeo->getDepartamento() ? "selected" : "")?> value="<?php echo $fila['departamento'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="id_provincia">Provincia</label>
                                        <div class="col-sm-4">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="id_provincia" name="id_provincia" class="form-control">
                                                <?php
                                                foreach ($ubigeo->verProvincias() as $fila) {
                                                    ?>
                                                    <option <?php echo ($fila['provincia'] == $ubigeo->getProvincia() ? "selected" : "")?> value="<?php echo $fila['provincia'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="id_distrito">Distrito</label>
                                        <div class="col-sm-4">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="id_distrito" name="id_distrito" class="form-control">
                                                <?php
                                                foreach ($ubigeo->verDistritos() as $fila) {
                                                    ?>
                                                    <option <?php echo ($fila['distrito'] == $ubigeo->getDistrito() ? "selected" : "")?> value="<?php echo $fila['distrito'] ?>"><?php echo $fila['nombre'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <!--===================================================-->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_telefono">Telefono / Celular</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="input_telefono" name="input_telefono" class="form-control" value="<?php echo $colaborador->getTelefono()?>" placeholder="Nro Celular" maxlength="9" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_profesion">Profesion</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="input_profesion" name="input_profesion" value="<?php echo $colaborador->getProfesion()?>" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_idGrupoSanguineo">Grupo Sanguineo</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="input_idGrupoSanguineo" name="input_idGrupoSanguineo" class="selectpicker">
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
                                        <label class="col-sm-2 control-label" for="input_idFactorSanguineo">Factor Sanguineo</label>
                                        <div class="col-sm-3">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="input_idFactorSanguineo" name="input_idFactorSanguineo" class="selectpicker">
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
                                        <label class="col-sm-3 control-label" for="jornal">Jornal</label>
                                        <div class="col-sm-3">
                                            <input type="text" placeholder="Jornal" name="jornal" id="jornal" class="form-control" >
                                        </div>
                                        <label class="col-sm-2 control-label" for="input_ultimoIngreso">Fecha de Ingreso</label>
                                        <div class="col-sm-3">
                                            <input type="date" id="input_ultimoIngreso" name="input_ultimoIngreso" class="form-control" placeholder="dd/mm/aaaa" value="<?php echo $colaborador->getUltimoIngreso()?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="especializacion">Especializacion</label>
                                        <div class="col-sm-8">
                                            <!-- Default Bootstrap Select -->
                                            <!--===================================================-->
                                            <select id="especializacion" name="especializacion" class="selectpicker">
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
                                            <select id="select_sbn" name="select_sbn" class="selectpicker">
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
                                            <input type="date" name="fecha_afiliacion" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="cuspp">CUSPP</label>
                                        <div class="col-sm-3">
                                            <input type="text" id="cuspp" name="cuspp" class="form-control" placeholder="cuspp" >
                                        </div>
                                        <label class="col-sm-2 control-label" for="select_comision">Tipo de Comision</label>
                                        <div class="col-sm-3">
                                            <select id="select_comision" name="select_comision" class="selectpicker">
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
                                    <input type="hidden" name="hidden_id_empleado" value="<?php echo $colaborador->getIdColaborador()?>">
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

        <!--Default Bootstrap Modal-->
        <!--===================================================-->
        <div class="modal" id="add_foto" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--Modal header-->
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Seleccionar Foto Perfil</h4>
                    </div>
                    <!--Modal body-->
                    <div class="modal-body">
                        <form>
                        <div class="form-group">
                            <input class="form-control btn btn-success" type="file" id="upload" value="Choose a file" accept="image/*"/>
                        </div>
                        <div class="col-lg-12">
                            <div class="upload-demo-wrap">
                                <div id="upload-demo"></div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <!--Modal footer-->
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
                        <button class="btn btn-primary upload-result">Cortar Foto</button>
                    </div>
                </div>
            </div>
        </div>


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

<script src="../public/js/js_cliente.js"></script>


<script language="javascript">

    function cargar_provincias() {
        var id_departamento = $("#id_departamento").val();
        $.post(
            "../controller/consultas_ajax/provincias.php",
            {id_departamento: id_departamento},
            function (data) {
                $("#id_provincia").html(data);
                cargar_distritos();
            }
        );
    }

    function cargar_distritos() {
        var id_provincia = $("#id_provincia").val();
        var id_departamento = $("#id_departamento").val();
        $.post(
            "../controller/consultas_ajax/distritos.php",
            {id_provincia: id_provincia, id_departamento: id_departamento},
            function (data) {
                $("#id_distrito").html(data);
            }
        );
    }

    function cargar_foto_modal() {
        $("#add_foto").modal("toggle");
    }

    $(document).ready(function () {

       // cargar_provincias();

        $('#id_departamento').on('change', function () {
            cargar_provincias();
        });

        $('#id_provincia').on('change', function () {
            cargar_distritos()
        });

    });

    $(document).ready(function (e) {

        // Function to preview image after validation
        $(function () {
            $("#file_lado1").change(function () {
                $("#message").empty(); // To remove the previous error message
                var file = this.files[0];
                var imagefile = file.type;
                var match = ["image/jpeg", "image/png", "image/jpg"];
                if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                    $('#previewing_lado1').attr('src', 'noimage.png');
                    $("#message").html("<p id='error'>Please Select A valid Image File</p>" + "<h4>Nota</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
                    return false;
                } else {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded_lado1;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        function imageIsLoaded_lado1(e) {
            $("#file_lado1").css("color", "green");
            $('#image_preview_lado1').css("display", "block");
            $('#previewing_lado1').attr('src', e.target.result);
            $('#previewing_lado1').attr('width', '100%');
            //$('#previewing').attr('height', '300px');
        }
    });
</script>

<script>

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

