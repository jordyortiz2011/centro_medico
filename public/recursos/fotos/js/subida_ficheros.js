$(document).ready(function() {
		
	
	mostrarArchivos();

    $("#boton_subir_imagen").on('click', function() {    	
        subirArchivos();
    });


	
   function subirArchivos() {
                $("#archivo").upload(BASE_URL + 'fotos/subida_ficheros/subir_archivo',
                {
                    //nombre_archivo: $("#nombre_archivo").val(),
                    //descripcion: $("#descripcion_documento").val(),
                     id_solicitud : $("#hidden_id_solicitud").val()
                     
                },
                function(respuesta) {
                    console.log(respuesta);
                    //Subida finalizada.
                    $("#barra_de_progreso").val(0);
                    if (respuesta == 'subida_correcta') {
                        mostrarRespuesta('El archivo ha sido subido correctamente.', true);
                        $("#descripcion_documento, #archivo").val('');
                        console.log('subida exitosa');
                        swal( 'Foto subida','', "success");
                    } else {
                        //mostrarRespuesta('El archivo NO se ha podido subir.', false);
                        console.log('Error al subir');
                         mostrarRespuesta( respuesta, false);
                    }
                    mostrarArchivos();
                }, function(progreso, valor) {
                    //Barra de progreso.
                    $("#barra_de_progreso").val(valor);
                });
            }


        function mostrarArchivos() {
        	
        	id_solicitud =  $("#hidden_id_solicitud").val();
        	dataString =  'id_solicitud=' + id_solicitud ;
        	
        	
            $.ajax({
            	type: "POST",
                url: BASE_URL + 'fotos/subida_ficheros/mostrar_archivos',
                data: dataString,
                dataType: 'JSON',
                success: function(respuesta) {
            	    console.log(respuesta);
                    if (respuesta) {
                        var html = '';
                        for (var i = 0; i < respuesta.length; i++) {
                            if (respuesta[i] != undefined) {

                                // Opciones de la tabla
                                html += "<tr>";
                                html +=   "<td>"
                                html +=      respuesta[i]['nombre_foto'] ;
                                html +=   "</td>";
                                html +=   "<td>";
                                html +=      respuesta[i]['latitud_foto'] + " ;  " + respuesta[i]['longitud_foto'] ;
                                html +=   "</td>";
                                html +=   "<td>";
                                html +=      respuesta[i]['fecha_registro_foto']  ;
                                html +=   "</td>";
                                html +=   "<td>";
                                html +=      respuesta[i]['user_registro_foto']  ;
                                html +=   "</td>";
                                html +=   "<td id_foto='" + respuesta[i]['id_foto'] +"'>";
                                html +=     "<a class='btn btn-outline-info' href='" + BASE_URL + "public/img/fotos_campo/" +respuesta[i]['nombre_foto'] + "' target='_blank'";
                                html +=     " data-toggle='tooltip' title='Ver'>";
                                html +=         "<i class=' fa fa-eye bigger-150'></i>";
                                html +=     "</a> &nbsp;";
                                html +=     "<a class='btn btn-outline-success' href='http://maps.google.com/maps?q=" + respuesta[i]['latitud_foto'] + ',' + respuesta[i]['longitud_foto'] +   "' target='_blank'";
                                html +=     " data-toggle='tooltip' title='Ir a Google Maps'>";
                                html +=         "<i class=' fa fa-podcast bigger-150'></i>";
                                html +=     "</a> &nbsp;";
                                //Si es analista de credito, no mostrar borrar
                                if(AUTH_LEVEL != 4) {
                                    html +=     "<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>";
                                    html +=         "<i class='fa fa-trash-o bigger-150'></i>";
                                    html +=     "</a>";
                                }

                                html +=   "</td>";
                                html += "</tr>";

                            }
                        }
                        $("#listado_imagenes tbody").html(html);
                    }
                }, 
               error: function(xhr, ajaxOptions, thrownError) {			
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}   
            });
        }

    /***********--DELETE--***************/
    $("#listado_imagenes").on('click', 'a.delete',function(e)
    {
        e.preventDefault();

        id =  $(this).parent().attr('id_foto');
        dataString = 'id='+ id;
        //var b=$(this).parent().parent().parent();
        //alert(id); exit;

        swal({
                title: "¿Estás seguro que deseas eliminar esta Foto?",
                text: "No podrá recuperar la foto",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Eliminar",
                cancelButtonText: "No, Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    //proceder a eliminar:
                    $.ajax({
                        type: "POST",
                        url: BASE_URL + "fotos/subida_ficheros/eliminar_archivo/"+id ,
                        data: dataString,
                        cache: false,
                        success: function(e)
                        {
                            console.log(e);

                            switch (String(e) ) {

                                case 'eliminar_ok':
                                    swal("¡Eliminado!", "Registro Eliminado.", "success"); break;
                                case 'registro_usado' :
                                    swal("¡Cancelado!", "El registro está siendo usado.", "error");break;
                                case 'eliminar_error' :
                                    swal("¡Cancelado!", "Error al eliminar", "error"); break;
                                default:
                                    swal("¡Cancelado!", "Error al eliminar", "error"); break;
                            }

                            mostrarArchivos()

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            swal("¡Cancelado!", "Registro no fue eliminado", "error");

                        }
                    });
                    //return false;

                } else {
                    swal("¡Cancelado!", "Registro no fue eliminado", "error");
                }
            });
    });
            
            
    function mostrarRespuesta(mensaje, ok){
        $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);              
       
        if(ok){
            $("#respuesta").addClass('alert-success alert-dismissible fade in');
        }else{
            $("#respuesta").addClass('alert-danger');
        }
    }          
               
});