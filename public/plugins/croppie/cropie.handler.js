(function() {
    var $ = jQuery;
    $(document).ready(function() {
/*
        // Paso 1: inicializamos Croppie especificando el tag img de donde
        // se sacarán los datos binarios de la imagen original.
        window.$croppieComponent = $('.original-image').croppie({
            viewport: {
                width: 125,
                height: 150
            },
            boundary: {
                width: 416,
                height: 233
            }
        });

        // Paso 2: definimos las funciones que guardarán los resultados del componente
        // Croopie a los tags input hidden, los cuales se enviaran por un HTML form
        // que tiene como action la URL "upload.php" (que ejecutará el paso 3).
        $('#cropImagesBtn').on('click', function (ev) {
            ev.preventDefault();

            // Llenar input ID image400x400Base64 con el valor base64 de la imagen
            // cortada originalmente con el componente.
            $croppieComponent.croppie('result', {
                type: 'base64',
                size: {width: 400, height: 400}
            }).then(function (resp) {
                $('#image400x400Base64').val(resp);
            });

            // Llenar input ID image100x100Base64 con el valor base64 de la imagen
            // miniatura ya cortada (100x100).
            $croppieComponent.croppie('result', {
                type: 'base64',
                size: {width: 100, height: 100}
            }).then(function (resp) {
                $('#image100x100Base64').val(resp);
            });

            // Esto es sólo por motivos demo, no es necesario ya que los input tienen los
            // valores que necesitamos, mostrar el contenido de las imágenes en el HTML
            // no es requerido para realizar la subida con el archivo upload.php
            setTimeout(function() {
           //     $('#demoImage100x100').attr('src', $('#image100x100Base64').val());
                $('#demoImage400x400').attr('src', $('#image400x400Base64').val());
            }, 1000); // esperar un segundo antes de ver las imágenes en el cliente
        });
*/
            var $uploadCrop;

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.upload-demo').addClass('ready');
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        }).then(function(){
                            console.log('jQuery bind complete');
                        });

                    }

                    reader.readAsDataURL(input.files[0]);
                }
                else {
                    alert("Sorry - you're browser doesn't support the FileReader API");
                }
            }


            $uploadCrop = $('#upload-demo').croppie({
                viewport: {
                    width: 145,
                    height: 195
                },
                boundary: {
                    width: 540,
                    height: 302
                },
                setZoom: 1
            });

            $('#upload').on('change', function () { readFile(this); });
            $('.upload-result').on('click', function (ev) {
                $uploadCrop.croppie('result', {
                    type: 'base64',
                    size: {width: 375, height: 500}
                }).then(function (resp) {
                    console.log(resp)
                    $('.original-image').prop("src", resp);
                    $('#hidden_perfil').val(resp);
                    $("#add_foto").modal("toggle")
                });
            });
    });
})();
