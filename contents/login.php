<?php
session_start();
if (isset($_SESSION["usuario"])) {
    header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:40:57 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Software Gestion de Seguridad Industrial</title>


    <!--STYLESHEET-->
    <!--=================================================-->


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="../public/css/bootstrap.min.css" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="../public/css/nifty.min.css" rel="stylesheet">


    <!--Font Awesome [ OPTIONAL ]-->
    <link href="../public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


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
<div id="container" class="cls-container">

    <!-- BACKGROUND IMAGE -->
    <!--===================================================-->
    <div id="bg-overlay" class="bg-img img-balloon"></div>


    <!-- HEADER -->
    <!--===================================================-->
    <div class="cls-header cls-header-lg">
        <div class="cls-brand">
            <a class="box-inline" href="login.php">
                <!-- <img alt="Nifty Admin" src="img/logo.png" class="brand-icon"> -->
                <span class="brand-title">Gestion de Seguridad Industrial <span class="text-thin"></span></span>
            </a>
        </div>
    </div>
    <!--===================================================-->


    <!-- LOGIN FORM -->
    <!--===================================================-->
    <div class="cls-content">
        <div class="cls-content-sm panel">
            <div class="panel-body">
                <p class="pad-btm">Acceda al Sistema</p>
                <form action="../controller/logeo.php" method="post">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <?php if (isset($_GET['error'])) {
                                $id_error = $_GET["error"];
                                if ($id_error == 1) {
                                    $label_error = "Empresa no existe!!";
                                }
                                if ($id_error == 2) {
                                    $label_error = "Usuario no existe!!";
                                }
                                if ($id_error == 3) {
                                    $label_error = "Contraseña incorrecta!!";
                                }
                                if ($id_error == 4) {
                                    $label_error = "Usuario bloqueado!!";
                                }
                                ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $label_error ?></strong>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-building"></i></div>
                            <input type="text" maxlength="11" name="empresa" class="form-control" placeholder="Empresa">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="text" name="usuario" class="form-control" placeholder="Usuario">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                            <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 text-left checkbox">
                            <label class="form-checkbox form-icon">
                                <input type="checkbox"> Recuerdame
                            </label>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group text-right">
                                <button class="btn btn-success text-uppercase" type="submit">Ingresar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="pad-ver">
            <a href="recupera_contrasena.php" class="btn-link mar-rgt">Olvisdaste tu contraseña?</a>
        </div>
    </div>
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


<!--Background Image [ DEMONSTRATION ]-->
<script src="../public/js/demo/bg-images.js"></script>


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

<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:01 GMT -->
</html>
