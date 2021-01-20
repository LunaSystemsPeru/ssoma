<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:40:57 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiero mi Carnet | Software Gestion de Seguridad Industrial</title>


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
                <div class="panel-heading">
                    <h3 class="panel-title">Buscar mi carnet</h3>
                </div>
                <form action="../controller/buscarCarnet.php" method="post">
                    <div class="panel-body">
                        <div class="row">
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"> <i class="fa fa-building"></i> RUC Empresa</label>
                                    <input type="text" name="ruc" class="form-control text-center" id="ruc" maxlength="11">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"> <i class="fa fa-flag"></i> Nacionalidad</label>
                                    <select class="form-control" name="nacionalidad" id="nacionalidad">
                                        <option value="1">Peruano</option>
                                        <option value="2">Venezolano</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"> <i class="fa fa-user"></i> DNI</label>
                                    <input type="text" name="documento" class="form-control text-center" id="documento" maxlength="12">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button class="btn btn-success" type="button" onclick="buscarDatos()">Buscar</button>
                    </div>
                </form>
        </div>
        <div class="pad-ver">
            <a href="login.php" class="btn-link mar-rgt">Ingresar al Sistema</a>
        </div>
    </div>
    <!--===================================================-->

    <div class="modal" id="modalbusqueda" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <!--Modal header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
                    <h4 class="modal-title text-success">Buscando mi carnet..</h4>
                </div>


                <!--Modal body-->
                <div class="modal-body" id="html_resultado">
                    <h2 class="text-danger">NO SE HAN ENCONTRADO DATOS!!</h2>
                </div>


                <!--Modal footer-->
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--===================================================-->
    <!--End Bootstrap Modal without Animation-->

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

<script lang="javascript">
    function buscarDatos () {
        $.ajax({
            type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
            url:"../controller/buscarCarnet.php", //url guarda la ruta hacia donde se hace la peticion
            data:{
                ruc:$('#ruc').val(),
                nacionalidad:$('#nacionalidad').val(),
                documento: $('#documento').val()
            }, // data recive un objeto con la informacion que se enviara al servidor
            success:function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
                $('#modalbusqueda').modal('toggle');
                $('#html_resultado').html(datos);
                //console.log(datos)
            }
        })
    }
</script>

<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:01 GMT -->
</html>
