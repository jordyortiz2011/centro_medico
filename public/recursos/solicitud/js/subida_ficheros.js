$(document).ready(function() {

    $("#image-holder").on('click', function () {

        $("#archivo").trigger('click');
    });

    // == Mostrar preview de la imagen cargada  ===
    $("#archivo").on('change', function () {

        //Get count of selected files
        var countFiles = $(this)[0].files.length;

        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#image-holder");
        image_holder.empty();

        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {

                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) {

                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("<img  />", {
                            "src": e.target.result,
                            "class": "thumb-image thumb"
                        }).appendTo(image_holder);
                    }

                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }

            } else {
                alert("This browser does not support FileReader.");
            }
        } else {
            alert("Seleccione sólo imagenes");
        }
    });


    $("#boton_subir_imagen").on('click', function() {


        subirArchivos();
    });

	
   function subirArchivos() {
       //Mostrar barra de progreso
       $("#bloque_barraProgreso_foto").removeClass('d-none');

                $("#archivo").upload(BASE_URL + 'solicitud/consultas_ajax/subir_archivo',
                {
                    //nombre_archivo: $("#nombre_archivo").val(),
                    //descripcion: $("#descripcion_documento").val(),
                     //id_solicitud : $("#hidden_id_solicitud").val()
                     
                },
                function(respuesta) {
                    console.log(respuesta);
                    //Subida finalizada.
                    $("#barra_de_progreso").val(0);
                    if (respuesta == 'subida_correcta') {
                        mostrarRespuesta('Imagen con coordenadas adjuntada correctamente.', true);
                        //$("#descripcion_documento, #archivo").val('');
                        $("#boton_subir_imagen").addClass('d-none');
                        console.log('subida exitosa');
                        swal( 'Foto adjuntada','', "success");
                    } else {
                        //mostrarRespuesta('El archivo NO se ha podido subir.', false);
                        console.log('Error al subir');
                         mostrarRespuesta( respuesta, false);
                         var imagen = '<img class="card-img-top img-thumbnail" src="' + BASE_URL + 'public/img/fotos_solicitud/solicitud_defecto_icono.png" alt="Foto" width="200px" height="300px" style=" margin: 0px auto;">';
                        $("#image-holder").html(imagen);
                    }
                    //mostrarArchivos();
                    $("#bloque_barraProgreso_foto").addClass('d-none');
                }, function(progreso, valor) {
                    //Barra de progreso.
                    $("#barra_de_progreso").val(valor);
                });
            }



            
            
    function mostrarRespuesta(mensaje, ok){
        $("#bloque_respuesta_foto").removeClass('alert-success').removeClass('alert-danger');
        $("#mensaje_respuesta_foto").html(mensaje);

        if(ok){
            $("#bloque_respuesta_foto").addClass('alert alert-success alert-dismissible fade show ');
        }else{
            $("#bloque_respuesta_foto").addClass('alert alert-danger alert-dismissible fade show');
        }
    }          
               
});