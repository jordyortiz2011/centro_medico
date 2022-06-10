$(document).ready(function(){
    //solo numeros para codigo universitario
    $('#text_dni').numeric();

    $('.select2').select2({
        //theme: "bootstrap4",
        minimumResultsForSearch: 20,
    });

    /* ===============  validación FORMULARIO PRINCIPAL " ============== */
    /* Activar validación al cambiar select  */
    $(' #select_tipo').on('change', function() {
        $(this).trigger('blur');
    });

    var form = $("#form_buscar_paciente");

    $(form).validate({

        onsubmit: false, //deshabilitar subida  al presionar un boton submit del formulario
        onfocusout: function(element) {
            this.element(element);
        },
        ignore: '.select2-input, .select2-focusser, .no_validar',
        rules: {
            text_buscar: {
                required: true,
                minlength: 2,
                maxlength: 20,
            },
        },
        messages: {
            text_buscar: {
                required: 'Campo requerido',
                minlength: '2 caracteres cómo mínimo requeridos',
                maxlength: '20 caracteres como máximo requeridos',
            },
        },
        /*errorPlacement: function(error, element) {
             console.log(element);
            if (element.hasClass("posicion_validacion_deuda") ) {
                console.log('tengo la clase');
                error.insertAfter(element);
            }
            else {
                console.log('NO tengo la clase');
                error.insertAfter(element);
            }
         },*/
        highlight: function (element) {
            //console.log(element);
            $(element).parent().parent().addClass('has-danger');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parent().parent().removeClass('has-danger');
        },

    });

    /*regla de validación para selects (no permite agregar en grupo) */
    $('#select_tipo').rules('add', {
        required: true,
        messages: {
            required: "Seleccione opción"
        }
    });

    //para buscar presionando ENTER
    $('#text_buscar').keypress(function(e){
        if(e.which == 13){//Enter key pressed

            $('#btn_buscar_paciente').trigger("click");//Trigger search button click event
            e.preventDefault();
        }
    });

    //Buscar comensal //
    $('#btn_buscar_paciente').on('click',  '' , function (e) {

        if( $('#form_buscar_paciente').valid() ) {

            var text_buscar =  $('#text_buscar').val();
            var id_tipo =  $('#select_tipo').val();
            var dataString =  'text_buscar=' +  text_buscar + '&id_tipo=' + id_tipo ;

            //deshabilitar boton, para BUSCAR sólo una vez
            $('#btn_buscar_estudiante').attr('disabled','disabled');

            //agregar animacion , SPIN
            var target = document.getElementById("form_buscar_paciente");
            var spinner = new Spinner(SPIN_OPT1).spin(target);

            $.ajax({
                type: "POST",
                url: BASE_URL + "citas/consultas_ajax/buscar_paciente_ajax",
                data: dataString,
                cache: false,
                success: function(respuesta)
                {
                    spinner.stop();//detener spin
                    console.log(respuesta);
                    //console.log(respuesta);
                    let respt = JSON.parse(respuesta);
                    console.log(respt);
                    //exit;

                    if(respt.estado == 'encontrado') {
                        console.log('encontrado');
                        //Ocultar btn buscar
                        $('#btn_buscar_estudiante').hide();


                        $('.seccion_citas').removeClass('d-none');//Mostrar datos de la cita
                        $('#btn_buscar_paciente').addClass('d-none'); //Ocultar boton

                        //$('#bloque_estudiante').removeClass('d-none');

                        //mostrar notificación
                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'success',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Paciente encontrado</center><h3>',

                        }).show();

                        //rellenar los campos del registro encontrado
                        $('#hidden_id_paciente').val(respt.paciente.id_paciente);

                        $('#span_apellidos').html(respt.paciente.excel_asegurado_paci);
                        $('#span_sexo').html(respt.paciente.sexo_string  );
                        $('#span_fecha_naci').html(respt.paciente.fecha_naci_string  );
                        $('#span_edad').html(respt.paciente.edad_string  );
                        $('#span_historia').html(respt.paciente.codHistorial_paci  );
                        $('#span_eess').html(respt.paciente.eess_string);
                        $('#span_posee_sis').html(respt.paciente.posee_sis);


                        //Id de matricula para registrar PAGO
                        $('#hidden_id_matricula').val(respt.estudiante.id_matri);

                        //Listar pagos
                        let num_pago = 1;
                        let acumulador_montos = 0;
                        let total_pagar = parseFloat( respt.total_pagar);

                        $.each(respt.lst_pagos , function(clave, valor) {
                           //console.log('clave: ' + clave + ' -  Valor: '+valor + ' pago:' + valor.id_pago  );


                        });

                    }else if (respt.estado == 'no_encontrado') {
                        console.log('no_encontrado')

                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'error',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Paciente no registrado</center><h3>',
                        }).show();

                        //rellenar los campos del registro encontrado
                        $('#span_apellidos').html('');
                        $('#span_sexo').html('' );
                        $('#span_fecha_naci').html(''  );
                        $('#span_provincia').html('');
                        $('#span_posee_sis').html('');

                        //Volver a habilitar btn buscar
                        $('#btn_buscar_paciente').removeAttr('disabled');

                    }else {
                        console.log('error al buscar');
                    }

                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    spinner.stop();//detener spin
                }

            });
        }//Fin valicación formulario
        else {
            swal("¡Error!", "Verifique Campos", "error");
        }

    }); //Fin evento boton buscar estudiante


    //Al cambiar la especialidad, poblar el selec de profesionales de la salud //
    $('#select_especialidad').on('change',  '' , function (e) {

        let id_especial =  $('#select_especialidad').val();
        console.log('id_espacial', id_especial);
        if( id_especial != '' ) {

            var dataString =  'id_especialidad=' + id_especial ;
            //alert(dataString);
            //exit;

            //agregar animacion , SPIN
            var target = document.getElementById("bloque_citas");
            var spinner = new Spinner(SPIN_OPT1).spin(target);


            //limpiar selects

            $('#select_profesionales').html("<option>Seleccione</option>");
            //Mostrar los horarios de cada profesional:
            $('#bloque_horarios_profesionales').html('');

            $.ajax({
                type: "POST",
                url: BASE_URL + "citas/consultas_ajax/poblar_profesionales_ajax",
                data: dataString,
                cache: false,
                success: function(respuesta)
                {
                    spinner.stop();//detener spin
                    console.log(respuesta);
                    //console.log(respuesta);
                    let respt = JSON.parse(respuesta);
                    console.log(respt);
                    //exit;

                    let html = "";

                    //SELECT PROFESIONALES: Comprobar si hay datos
                    if(!$.isEmptyObject(respt.select_profesionales)) {
                        html += "<option> -- Seleccione -- </option>";
                        $.each(respt.select_profesionales , function(clave, valor) {
                            console.log('clave: ' + clave + ' -  Valor: '+valor   );
                            console.log(valor);
                            html += "<option value='" + valor.id_user + "'>" +  valor.nombres  + "</option>";
                        });
                    } else {
                        html += "<option value=''>Sin Datos</option>";
                    }

                    //console.log(html);

                    $('#select_profesionales').html(html);

                    //Mostrar los horarios de cada profesional:
                    $('#bloque_horarios_profesionales').html('');

                    if(!$.isEmptyObject(respt.listado_horarios)) {
                        $.each(respt.listado_horarios , function(clave, valor) {
                            //console.log('clave: ' + clave + ' -  Valor: '+valor   );
                            //console.log(valor);
                            let html_div = '';
                            html_div = "<div class='form-group horario_flotante' >";
                            html_div +=     "<h5>"+ valor.profesional +"</h5>";

                            $.each(valor.horarios , function(clave, valor) {
                                html_div +=     "+" +  valor.horario_consultorio + "<br>";
                            });
                            //+ Mie 07:00 a 13:00hrs : Consultorio 1<br>
                            html_div += "</div>";

                            $('#bloque_horarios_profesionales').append(html_div);
                        });
                    }else {
                        $('#bloque_horarios_profesionales').append('<h4>No hay profesionales para la especialidad</h4>');
                    }

                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    spinner.stop();//detener spin
                }
            });
        }//Fin valicación formulario
        else {
            swal("¡Error!", "Verifique Campos", "error");
        }

    }); //Fin evento boton seleccionar especialidad


    //Al cambiar profesionales, poblar el selec de horarios//
    $('#select_profesionales').on('change',  '' , function (e) {

        var id_profesional =  $('#select_profesionales').val();
        var id_especialidad =  $('#select_especialidad').val();


        if( id_profesional != '' &&  id_especialidad != '' ) {

            //limpiar imput
            $('#text_fechacita').val('') ;

            var dataString =  'id_profesional=' + id_profesional +  '&id_especialidad=' + id_especialidad  ;
            //alert(dataString);
            //exit;

            //agregar animacion , SPIN
            var target = document.getElementById("bloque_citas");
            var spinner = new Spinner(SPIN_OPT1).spin(target);

            //limpiar selects

            //$('#select_profesionales').html("<option>Seleccione</option>");
            //Mostrar los horarios de cada profesional:
            //$('#bloque_horarios_profesionales').html('');

            $.ajax({
                type: "POST",
                url: BASE_URL + "citas/consultas_ajax/poblar_datepicker_ajax",
                data: dataString,
                cache: false,
                success: function(respuesta)
                {
                    spinner.stop();//detener spin
                    console.log('Respuesta poblar datepicker');
                    console.log(respuesta);
                    //console.log(respuesta);
                    let respt = JSON.parse(respuesta);
                    console.log(respt);

                    //Mostrar los horarios de cada profesional:
                    $('#bloque_horarios_profesionales').html('');

                    if(!$.isEmptyObject(respt.listado_horarios)) {
                        $.each(respt.listado_horarios , function(clave, valor) {
                            //console.log('clave: ' + clave + ' -  Valor: '+valor   );
                            //console.log(valor);
                            let html_div = '';
                            html_div = "<div class='form-group horario_flotante' >";
                            html_div +=     "<h5>"+ valor.profesional +"</h5>";

                            $.each(valor.horarios , function(clave, valor) {
                                html_div +=     "+" +  valor.horario_consultorio + "<br>";
                            });
                            //+ Mie 07:00 a 13:00hrs : Consultorio 1<br>
                            html_div += "</div>";

                            $('#bloque_horarios_profesionales').append(html_div);
                        });
                    }else {
                        $('#bloque_horarios_profesionales').append('<h4>No hay profesionales para la especialidad</h4>');
                    }

                    let html = "";
                    let dias_no_laborables = Object.keys(respt.dias_atencion);
                    $('#text_fechacita').datetimepicker();
                    $('#text_fechacita').data("DateTimePicker").destroy();

                    $('#text_fechacita').datetimepicker({
                        format: 'YYYY-MM-DD',
                        locale: 'es',
                        //viewMode: 'years',
                        useCurrent: false , //rellenar el input con la fecha actual
                        //defaultDate: false,
                        icons: {
                            time: "fa fa-clock-o",
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down",
                            previous: 'fa fa-arrow-left',
                            next: 'fa fa-arrow-right',
                        } ,
                        minDate: FECHA_HOY,
                        daysOfWeekDisabled: dias_no_laborables
                    });

                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    spinner.stop();//detener spin
                }
            });
        }//Fin valicación campo
        else {
            swal("¡Error!", "Verifique Campos", "error");
        }

    }); //Fin evento boton seleccionar especialidad


    //GUARDAR CITA
    //VALIDACIÓN
    /* Activar validación al cambiar select  */
    $(' #select_especialidad').on('change', function() {
        $(this).trigger('blur');
    });
    $(' #select_profesionales').on('change', function() {
        $(this).trigger('blur');
    });

    var form_cita = $("#form_cita");
    $(form_cita).validate({
        onsubmit: false, //deshabilitar subida  al presionar un boton submit del formulario

        onfocusout: function(element) {
            this.element(element);
        },

        ignore: '.select2-input, .select2-focusser, .no_validar',

        rules: {
            hidden_id_paciente: {
                required: true,
            },
            select_especialidad: {
                required: true,
            },
            select_profesionales: {
                required: true,
            },
            text_fechacita: {
                required: true,
            },
        },
        messages: {
            //PARA EL RECIBO DE PAGO
            hidden_id_paciente: {
                required: 'Campo requerido',
            },
            select_especialidad: {
                required: 'Campo requerido',
            },
            select_profesionales: {
                required: 'Campo requerido',
            },
            text_fechacita: {
                required: 'Campo requerido',
            },
        },
        highlight: function (element) {
            //console.log(element);
            $(element).parent().parent().addClass('has-danger');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parent().parent().removeClass('has-danger');
        },
    }); //Fin función validar

    /*regla de validación para selects (no permite agregar en grupo) */
    $('#select_especialidad').rules('add', {
        required: true,
        messages: {
            required: "Seleccione opción"
        }
    });
    $('#select_profesionales').rules('add', {
        required: true,
        messages: {
            required: "Seleccione opción"
        }
    });


    $('#btn_form_cita').on('click',  '' , function (event) {

        event.preventDefault();
        //valor = $('div[name=btn_subir]');
        //console.log();
        $('<input>', {
            type: 'hidden',
            name: 'btn_subir',
            value: 'permanecer' //para saber a dónde redireccionar
        }).appendTo(form_cita);

        if (form_cita.valid()) {
            form_cita.submit();
        }
        else {
            form_cita.validate().form();
            swal("¡Atención!", "Revisar los campos  del formulario", "warning");
            console.log('validar');
        }

    })












});
