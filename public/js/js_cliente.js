function enviar_documento() {
    $("#input_dato").val("");
    if (document.getElementById("select_tipo_documento").value == "1") {
        enviar_documento_reniec();
        //enviar_documento_sbs();
    }
    if (document.getElementById("select_tipo_documento").value == "4") {
        enviar_documento_venezuela();
    }
}
function enviar_documento_reniec() {
    var parametros = {
        "documento": $("#input_documento").val()
    };

    if ($("#input_documento").val().length === 8) {
        $.ajax({
            data: parametros,
            url: '../old_controller/ajax_post/validar_reniec.php',
            type: 'post',
            beforeSend: function () {
                $("#error_documento").html("<div class=\"alert alert-success\"><strong> Espere! </strong> Estamos procesando su peticion.</div>");
            },
            success: function (response) {
                $("#error_documento").html("");
                var json = response;
                var json_ruc = JSON.parse(json);
                var success = json_ruc.success;
                if (success === false) {
                    $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> El Documento es incorrecto.</div>");
                }

                if (success === "reniec") {
                    $("#error_documento").prop('readonly', true);
                    $("#input_dato").prop('readonly', false);
                    $("#input_dato").val(json_ruc.entity.nombre);
                    $("#direccion").focus();
                }

            },
            error: function () {
                $("#error_documento").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                $("#input_documento").prop('readonly', false);
                $("#input_dato").val("");
                $("#input_domicilio").val("");
            }
        });
    } else {
        $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de RUC incompleto.</div>");
    }
}

function enviar_documento_sunat() {
    var parametros = {
        "documento": $("#input_documento").val()
    };

    if ($("#input_documento").val().length === 11) {
        $.ajax({
            data: parametros,
            url: '../old_controller/ajax_post/validar_ruc.php',
            type: 'post',
            beforeSend: function () {
                $("#error_documento").html("<div class=\"alert alert-success\"><strong> Espere! </strong> Estamos procesando su peticion.</div>");
            },
            success: function (response) {
                $("#error_documento").html("");
                var json = response;
                var json_ruc = JSON.parse(json);
                var success = json_ruc.success;
                if (success === false) {
                    $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> El Documento es incorrecto.</div>");
                }

                if (success === "sunat") {
                    $("#error_documento").prop('readonly', true);
                    $("#input_direccion").prop('readonly', false);
                    $("#input_direccion").val(json_ruc.entity.Direccion);
                    $("#input_razon_social").prop('readonly', false);
                    $("#input_razon_social").val(json_ruc.entity.RazonSocial);
                    $("#direccion").focus();
                }

            },
            error: function () {
                $("#error_documento").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                $("#input_documento").prop('readonly', false);
                $("#input_direccion").val("");
                $("#input_razon_social").val("");
            }
        });
    } else {
        $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de RUC incompleto.</div>");
    }
}

function enviar_documento_venezuela() {
    var parametros = {
        "documento": $("#input_documento").val()
    };

    if ($("#input_documento").val().length > 6) {
        $.ajax({
            data: parametros,
            url: '../old_controller/ajax_post/validar_venezuela.php',
            type: 'post',
            beforeSend: function () {
                $("#error_documento").html("<div class=\"alert alert-success\"><strong> Espere! </strong> Estamos procesando su peticion.</div>");
            },
            success: function (response) {
                $("#error_documento").html("");
                var json = response;
                console.log(response);
                var json_ruc = JSON.parse(json);
                var success = json_ruc.success;
                if (success === false) {
                    $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> El Documento es incorrecto.</div>");
                }

                if (success === "venezuela") {
                    $("#error_documento").prop('readonly', true);
                    $("#input_dato").prop('readonly', false);
                    $("#input_dato").val(json_ruc.entity.nombre);
                    $("#direccion").focus();
                }

            },
            error: function () {
                $("#error_documento").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                $("#input_documento").prop('readonly', false);
                $("#input_dato").val("");
                $("#input_domicilio").val("");
            }
        });
    } else {
        $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de RUC incompleto.</div>");
    }
}

function enviar_documento_sbs() {
    var parametros = {
        documento: $("#nro_dni").val()
    };

    if ($("#input_documento").val().length === 8) {
        $.ajax({
            data: parametros,
            url: 'ajax_post/validar_sbs.php',
            type: 'post',
            beforeSend: function () {
                $("#error_documento").html("<div class=\"alert alert-success\"><strong> Espere! </strong> Estamos procesando su peticion.</div>");
            },
            success: function (response) {
                $("#error_documento").html("");
                var json = response;
                console.log(json);
                var json_ruc = JSON.parse(json);
                var success = json_ruc.success;
                if (success === false) {
                    $("#fecha_afiliacion").val("");
                    $("#fecha_afiliacion").prop('readonly', false);
                    $("#cuspp").val("");
                    $("#cuspp").prop('readonly', false);
                    $("#input_seguro").val("");
                    $("#input_seguro").prop('readonly', false);
                    $("#input_id_seguro").val(0);
                    $("#input_comision").val("");
                    $("#input_comision").prop('readonly', false);
                    $("#input_id_comision").val(1);
                    $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> NO SE ENCONTRO DATOS.</div>");
                    alert("No se encontro en la base de datos de la SBS, o es incorrecto");
                }

                if (success === "sbs") {
                    var id_seguro = 0;
                    var id_comision = 1;
                    if (json_ruc.entity.NombAFP === 'Prima') {
                        id_seguro = 5;
                    }
                    
                    if (json_ruc.entity.TipoComision === 'Com.Mixta/Saldo') {
                        id_comision = 3;
                    }
                    
                    $("#nombres").prop('readonly', true);
                    $("#fecha_afiliacion").val(json_ruc.entity.FechaSPP);
                    $("#fecha_afiliacion").prop('readonly', true);
                    $("#cuspp").val(json_ruc.entity.CUSPP);
                    $("#cuspp").prop('readonly', true);
                    $("#input_seguro").val(json_ruc.entity.NombAFP);
                    $("#input_id_seguro").val(id_seguro);
                    $("#input_seguro").prop('readonly', true);
                    $("#input_comision").val(json_ruc.entity.TipoComision);
                    $("#input_id_comision").val(id_comision);
                    $("#input_comision").prop('readonly', true);
                }
            },
            error: function () {
                $("#error_documento").html("<div class=\"alert alert-warning\"><strong> Error! </strong> Ocurrio un error al procesar.</div>");
                $("#nro_dni").prop('readonly', false);
                $("#input_cliente").val("");
                $("#input_direccion").val("");
            }
        });
    } else {
        $("#error_documento").html("<div class=\"alert alert-danger\"><strong> Error! </strong> Numero de RUC incompleto.</div>");
    }
}