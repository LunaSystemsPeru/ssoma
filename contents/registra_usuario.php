<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
require '../models/Empresa.php';
require '../models/Usuario.php';

$usuario = new Usuario();
$empresa = new Empresa();

if (filter_input(INPUT_GET, 'id')) {
    $usuario->setIdUsuario(filter_input(INPUT_GET, 'id'));
    $usuario->obtenerDatos();
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
    <title>Registrar Usuario | Software Gestion de Seguridad Industrial</title>


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
                <h1 class="page-header text-overflow">Registrar Usuario</h1>

            </div>
            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
            <!--End page title-->

            <!--Page content-->
            <!--===================================================-->
            <div id="page-content">

                <div class="row">
                    <form class="form-horizontal" enctype="multipart/form-data" id="graba_empleado"
                          action="../controller/reg_usuario.php" method="post">
                        <div class="col-lg-12">
                            <!-- GENERAL -->
                            <!--===================================================-->

                            <div class="panel ">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="select_empresas">Empresa</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="select_empresas" id="select_empresas">
                                                <?php
                                                $a_empresas = $empresa->verTodas();
                                                foreach ($a_empresas as $fila) {
                                                    ?>
                                                    <option value="<?php echo $fila['id_empresas'] ?>" <?php echo ($usuario->getIdEmpresa() == $fila['id_empresas']) ? "selected" : ""?> >
                                                        <?php echo $fila['razon_social'] ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_datos">Apellidos y Nombres
                                            (datos)</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="Datos del Usuario" name="input_datos"
                                                   id="input_datos" class="form-control"
                                                   value="<?php echo $usuario->getDato() ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_email">Email:</label>
                                        <div class="col-sm-8">
                                            <input type="email" placeholder="Correo" name="input_email" id="input_email"
                                                   class="form-control" value="<?php echo $usuario->getEmail() ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_celular">Telefono
                                            Celular:</label>
                                        <div class="col-sm-3">
                                            <input type="text" placeholder="Nro de celular" name="input_celular"
                                                   id="input_celular" class="form-control" value="<?php echo $usuario->getCelular() ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_usuario">Usuario:</label>
                                        <div class="col-sm-8">
                                            <input type="text" placeholder="usuario para el sistema"
                                                   name="input_usuario" id="input_usuario" class="form-control" value="<?php echo $usuario->getUsername() ?>"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label" for="input_contra">Contraseña:</label>
                                        <div class="col-sm-8">
                                            <input type="password" placeholder="Contraseña" name="input_contra" value="<?php echo $usuario->getPassword() ?>"
                                                   id="input_contra" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer text-right">
                                    <input type="hidden" name="hidden_id" value="<?php echo $usuario->getIdUsuario() ?>">
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


<!--Demo script [ DEMONSTRATION ]-->
<script src="../public/js/demo/nifty-demo.min.js"></script>

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

