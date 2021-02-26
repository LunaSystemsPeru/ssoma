<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="es">


<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Reniec | Software Gestion de Seguridad Industrial</title>


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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


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
            <div id="page-content">

                <div class="row">
                    <form class="form-horizontal" id="graba_familiar" action="#" method="post">
                        <div class="form-group">
                            <label class="col-lg-1 control-label text-left">Nro DNI</label>
                            <div class="col-lg-3 ">
                                <input type="text" class="form-control" pattern=".{8,}" maxlength="8" id="inputdni" placeholder="Nro DNI">
                            </div>
                            <div class="col-lg-3">
                                <button type="button" class="btn btn-info" onclick="enviarDatosReniec()"><i class="fa fa-search"></i>Buscar</button>
                            </div>
                        </div>
                        <div id="error_documento"></div>
                    </form>
                </div>
                <div class="row">
                    <div class="row col-lg-3">
                        <div class="panel">

                            <!-- Simple profile -->
                            <div class="text-center pad-all">
                                <div class="pad-ver">
                                    <img src="../public/images/noimage.png" class="img-lg img-border img-lg" id="resultadocara" alt="Profile Picture">
                                </div>
                            </div>
                            <hr>
                            <div class="text-center pad-all">
                                <p>Firma</p>
                                <div class="pad-ver">
                                    <img src="../public/images/noimage.png" class="img-lg img-border img-lg" id="resultadofirma" alt="Profile Picture">
                                </div>
                            </div>
                            <hr>
                            <hr>
                        </div>

                        <!--Page content-->
                        <!--===================================================-->


                        <!--Page content-->
                        <!--===================================================-->
                    </div>

                    <div class="row col-lg-9">
                        <div class="panel ">
                            <div class="panel-heading">
                                <div class="panel-control">

                                </div>
                                <h3 class="panel-title">Datos Generales</h3>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="graba_familiar" action="#" method="post">
                                    <!--Modal body-->
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label text-left">Nro DNI</label>
                                            <div class="col-lg-2">
                                                <input type="text" class="form-control" id="resultadodni" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label text-left">Apellidos</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="resultadoapellidos" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label text-left">Nombres</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadonombres" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label text-left">Apellidos y Nombres</label>
                                            <div class="col-lg-7">
                                                <input type="text" class="form-control" id="resultadoapellidosnombres" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Departamento Nac</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadodepartamentonac" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Provincia Nac</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadoprovincianac" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Distrito Nac</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadodistritonac" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Fec. Nac.</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadofecnacimiento" readonly>
                                            </div>
                                            <label class="col-lg-2 control-label">Ubigeo Nac</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadoubigeo" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Departamento</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadodepartamento" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Provincia</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadoprovincia" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Distrito</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadodistrito" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Domilicio</label>
                                            <div class="col-lg-7">
                                                <input type="text" class="form-control" id="resultadodomicilio" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-lg-1 control-label">Padre.</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="resultadopadre" readonly>
                                            </div>
                                            <label class="col-lg-1 control-label">Madre</label>
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="resultadomadre" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">Fec. Emision.</label>
                                            <div class="col-lg-3">
                                                <input type="text" class="form-control" id="resultadofecemision" readonly>
                                            </div>
                                        </div>

                                </form>
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


    <!--Switchery [ OPTIONAL ]-->
    <script src="../public/plugins/switchery/switchery.min.js"></script>


    <!--Bootstrap Select [ OPTIONAL ]-->
    <script src="../public/plugins/bootstrap-select/bootstrap-select.min.js"></script>


    <!--DataTables [ OPTIONAL ]-->
    <script src="../public/plugins/datatables/media/js/jquery.dataTables.js"></script>
    <script src="../public/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
    <script src="../public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>


    <!--Demo script [ DEMONSTRATION ]-->
    <script src="../public/js/demo/nifty-demo.min.js"></script>


    <!--DataTables Sample [ SAMPLE ]-->
    <script src="../public/js/demo/tables-datatables.js"></script>

    <script>
        function enviarDatosReniec() {
            var parametros = {
                "dni": $("#inputdni").val()
            };

            if ($("#inputdni").val().length === 8) {
                $.ajax({
                    data: parametros,
                    url: '../old_controller/ajax_post/datos_reniec.php',
                    type: 'get',
                    beforeSend: function () {
                        $("#error_documento").html("<div class=\"alert alert-success\"><strong> Espere! </strong> Estamos procesando su peticion.</div>");
                    },
                    success: function (response) {
                        $("#error_documento").html("");
                        var json = response;
                        var json_ruc = JSON.parse(json);
                        $("#resultadodni").val(json_ruc[2]);
                        $("#resultadoapellidos").val(json_ruc[4] + " " + json_ruc[5]);
                        $("#resultadonombres").val(json_ruc[7]);
                        $("#resultadoapellidosnombres").val(json_ruc[4] + " " + json_ruc[5] + " " + json_ruc[7]);
                        $("#resultadofecnacimiento").val(json_ruc[29]);
                        $("#resultadoubigeo").val(json_ruc[23] + json_ruc[24] + json_ruc[25]);
                        $("#resultadodepartamentonac").val(json_ruc[26]);
                        $("#resultadoprovincianac").val(json_ruc[27]);
                        $("#resultadodistritonac").val(json_ruc[28]);
                        $("#resultadopadre").val(json_ruc[30]);
                        $("#resultadomadre").val(json_ruc[31]);
                        $("#resultadodepartamento").val(json_ruc[16]);
                        $("#resultadoprovincia").val(json_ruc[17]);
                        $("#resultadodistrito").val(json_ruc[18]);
                        var textito = "";
                        for (let step = 35; step < 47; step++) {
                            var temporal = json_ruc[step];
                            if (temporal == "SIN DATOS") {
                                temporal = "";
                            }
                            textito += temporal + " ";
                        }
                        //console.log(textito);
                        $("#resultadodomicilio").val(textito.trim());
                        $("#resultadofecemision").val(json_ruc[33]);
                        $("#resultadocara").prop("src", "data:image/png;base64," + json_ruc[47]);
                        $("#resultadofirma").prop("src", "data:image/png;base64," + json_ruc[48]);


                        //console.log(json_ruc[0]);
                    },
                    error: function () {
                        $("#error_documento").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                    }
                });
            } else {
                $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de DNI incompleto.</div>");
            }
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

