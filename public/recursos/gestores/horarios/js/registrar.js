$(document).ready(function(){

    //var para la vista de SPINNER
    var BANDERA = 1;

    //Agregar librería select2
    $('.select2').select2({
        //placeholder: 'Select an option',
        minimumResultsForSearch: 4,
        width: '100%'
    });





    //Al cambiar select CONSULTORIOS, renderizar el fullCalendar
    $('#select_consultorios').on('change', function (evt) {

        BANDERA = 1;

        console.log( 'consultorio ID: ' + this.value );

        //capturar valores del select CICLOS
        var id_consultorio    =  this.value;

        var dataString  = 'id_consultorio='+ id_consultorio ;

        if(id_consultorio == '' ) {
            //Destruir  fullCalendar
            $("#cronograma").fullCalendar( 'destroy' );

        }else {

            $("#cronograma").fullCalendar( 'destroy' );

            //Cargar los parametros para el FullCalendar de Acuerdo al aula seleccionada
            $.ajax({
                type: "POST",
                url: BASE_URL + "gestores/horarios/consultas_ajax/combobox_fullCalendar" ,
                data: dataString,
                dataType : 'json',
                cache: false,
                success: function(respt)
                {
                      console.log(respt);

                    //Colocar título al fullCalendar
                    $('#span_titulo_fullCalendar').html(respt.titulo_fullcalendar);

                      //Informar minutos de la jornada de clases
                    $('#span_jornada_minutos').html(10);
                    //detener spin
                    //spinner2.stop();

                     renderizar_fullCalendar(respt);

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });



        }





    });//Fin función "Cambiar SELECT AULA"




    //renderizar_fullCalendar();

 function renderizar_fullCalendar( respt ) {

     //console.log('funcion' + parametros);
     console.log(respt);

     var HORA_INICIO    = respt.parametros.hora_inicio;
     var HORA_FIN       = respt.parametros.hora_fin;
     var JORNADA_CLASE      =  10; //parseInt(respt.parametros.jornada_clase);

     //var HORA_INICIO    =  '07:00:00';
     //var HORA_FIN       = '14:00:00';
     //var JORNADA_CLASE  =  parseInt(50);

     $("#cronograma").fullCalendar({
         header: {
             //left   : 'prev,next',
             //center : 'title',
             //right:  'today prev,next',
             left    : '',
             center : '',
             right   : '',


         },

         defaultView: 'agendaWeek',
         locale: 'es',
         contentHeight: 'auto',       //auto
         height: 'auto',

         firstDay: 1 , //Día de inicio 0 = Domingo
         hiddenDays: [0] , //Ocultar días
         columnFormat: 'dddd', //Formato para mostrar columnas de Día(dddd=sólo nombre del día)
         //slotLabelFormat: 'h(:mm)a' , //formato de la hora , AM y PM
         slotLabelFormat:"HH:mm", // 24 Hrs

         allDaySlot: false,
         minTime: HORA_INICIO , //"7:00:00",
         maxTime: HORA_FIN, //"16:00:00",
         slotDuration: "00:30:00",

         selectable: true, //Permite selecionar un día del calendario

         //Limitar Selección sólo a un día
         selectConstraint:{
             start: '00:01',
             end: '23:59',
         },

         selectOverlap: true, //False = no permite seleccionar horas donde ya haya eventos

         //al seleccionar rango de días/horas
         select: function(start, end)
         {

             var start = moment(start).format('YYYY-MM-DD HH:mm:ss');
             var end = moment(end).format('YYYY-MM-DD HH:mm:ss');

             $('#hidden_fecha_inicio').val(start);
             $('#hidden_fecha_fin').val(end);
             console.log(start);
             console.log( end);

             var fecha_inicio =  moment(start).format('YYYY-MM-DD');
             var fecha_fin   =  moment(end).format('YYYY-MM-DD');
             var hora_inicio = moment(start).format('HH:mm');
             var hora_fin    = moment(end).format('HH:mm');

             //asignamos la fecha de inicio y fin a los campos del modal
             $('#text_hora_inicio').val(hora_inicio);
             $('#text_hora_fin').val(hora_fin);
             //var  end   =  $('#end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
             //hora_fin = moment(start).add(50, 'minutes').format('HH:mm');
             //$('#text_hora_fin').val(hora_fin);


             //crear Reloj para las horas (HORA inicio/fin)
             $('.reloj1').datetimepicker({
                 format: 'HH:mm',
                 locale: 'es',
                 //viewMode: '',
                 useCurrent: false , //rellenar input con la fecha actual
                 stepping: 5 , //intervalo de minutos
                 icons: {
                     time: "fa fa-clock-o",
                     date: "fa fa-calendar",
                     up: "fa fa-arrow-up",
                     down: "fa fa-arrow-down",
                     previous: 'fa fa-arrow-left',
                     next: 'fa fa-arrow-right',
                 }
             });

             $('.reloj2').datetimepicker({
                 format: 'HH:mm',
                 locale: 'es',
                 //viewMode: '',
                 useCurrent: false , //rellenar input con la fecha actual
                 stepping: 5 , //intervalo de minutos
                 icons: {
                     time: "fa fa-clock-o",
                     date: "fa fa-calendar",
                     up: "fa fa-arrow-up",
                     down: "fa fa-arrow-down",
                     previous: 'fa fa-arrow-left',
                     next: 'fa fa-arrow-right',
                 },

                 // minDate:  fecha_inicio + ' ' +  $('#text_hora_inicio').val() + ':00' //Fecha mínima

             });
                 // Validación de limite de hora
             $('#text_hora_inicio').datetimepicker();
             $('#text_hora_fin').datetimepicker({
                 useCurrent: false //Important! See issue #1075
             });
             $("#text_hora_inicio").on("dp.change", function (e) {
                 $('#text_hora_fin').data("DateTimePicker").minDate(e.date);
                 console.log(e.date);
             });
             $("#text_hora_fin").on("dp.change", function (e) {
                 $('#text_hora_inicio').data("DateTimePicker").maxDate(e.date);
             });

             //Llamar a función Modal creada
             modal({
                 // Available buttons when adding
                 buttons: {
                     add: {
                         id: 'add-event', // Buttons id
                         css: 'btn-success', // Buttons class
                         label: 'Agregar'  // Buttons label
                     }
                 },
                 title: 'Agregar Horario' // Modal title
             });


         },//Fin select (al seleccionar un día)

         // carga de eventos via AJAX, de acuerdo a los Selects
         events:
             function(start, end, timezone, callback) {
                 $.ajax({
                     url : BASE_URL +'gestores/horarios/full_calendar_ajax/obtener_horarios', // json datasource
                     type: 'POST',
                     dataType: 'json',
                     data: {
                         start:         start.format(),
                         end:           end.format(),
                         id_consultorio:      $('#select_consultorios option:selected').val() ,
                     },

                     error: function(xhr, ajaxOptions, thrownError){  // error handling code
                         alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                     }		,
                     success: function(obj) {

                         //console.log(obj);
                         var events = [];

                         $.each( obj, function( key, value ) {

                             events.push({
                                 id: value.id, //para el eliminado
                                 title: value.title,
                                 description: value.description,
                                 //start: value.start,
                                 //end: value.end,
                                 start: value.startTime,
                                 end: value.endTime,
                                 dow:  value.dow,
                                 color:  value.color,
                                 allDay: false,

                                 id_especialidad: value.id_especialidad,
                                 hora_inicio: value.startTime,
                                 hora_fin: value.endTime,
                                 select_profesionales: value.dropdown_profesionales,
                                 especialidad: value.especialidad,
                             });
                         });





                         console.log(events);
                         callback(events);
                     }
                 });
             } , //fin carga de eventos

         //Agregar efecto al cargar eventos
         loading: function (bool) {
             //alert('events are being rendered'); // Add your script to show loading
             var target = document.getElementById("cronograma");
             if (BANDERA == 1) {
                 SPINNER_CRONOGRAMA = new Spinner(SPIN_OPT1).spin(target);
                 BANDERA++;
             }
         },

         //finalizar efecto al terminar de cargar  eventos
         eventAfterAllRender: function (view) {
             //alert('all events are rendered'); // remove your loading
             //console.log(SPINNER_CRONOGRAMA);
             SPINNER_CRONOGRAMA.stop();
         },

         //Renderizado de eventos
         eventRender: function (event, element) {
              element.find('.fc-title').html(event.title); //mostrar etiquedas HTML de titulos
              element.find('.fc-title').after("<span>"+event.description+"</span>");

              //Si es 8 (CURSO RECRESO) Modificar hora para que se muestre bien en la impresión
              if(event.id_curso == 8) {
                  //element.find('.fc-time').removeData("data-start").removeAttr("data-start");
                  element.find('.fc-time').removeData("data-full").removeAttr("data-full");
              }
             //$evento->nombres_user
             SPINNER_CRONOGRAMA.stop();
         } ,

         // Handle Existing Event Click
         eventClick: function(calEvent, jsEvent, view) {
             // Set currentEvent variable according to the event clicked in the calendar
             currentEvent = calEvent;

             //Si se selecciona el 8 (CURSO RECREO) no mostrar modal
             if(currentEvent.id_curso == 8)
                 return false;

             // Open modal to edit or delete event
             modal({
                 // Available buttons when editing
                 buttons: {
                     delete: {
                         id: 'delete-event',
                         css: 'btn-danger',
                         label: 'Eliminar'
                     },
                     update: {
                         id: 'update-event',
                         css: 'btn-success',
                         label: 'Actualizar'
                     }
                 },
                 title: 'Curso: '   + calEvent.title ,
                 event: calEvent
             });
         }



         //eventConstraint: "businessHours"

     }); //Fin función Full Calendar

     // Prepares the modal window according to data passed
     function modal(data) {
         // Set modal title

         $('.modal-title').html(data.title);

         $('#errores_validacion').html(''); //limpiar errores modal
         // Clear buttons except Cancel
         $('.modal-footer button:not(".btn-default")').remove();

         //validaciones de que cada horario dure una jornada de clase
         $.validator.addMethod(
             "jornadaClase",
             function(value, element) {

                 let hora_inicio    = moment( $('#text_hora_inicio').val() , 'HH:mm' ) ;
                 let hora_fin       = moment ( $('#text_hora_fin').val() ,  'HH:mm' );
                 let jornada_clase  =  parseInt(JORNADA_CLASE) ;

                 let diferencia_minutos = moment.duration(hora_fin - hora_inicio).asMinutes();

                 //que hora de inicio no sea igual a hora fin


                 //Verificar que la jornada de clase sea igual que la diferencia de Hora Inicio/Fin
                 if( jornada_clase === diferencia_minutos) {
                     response = true;
                 }
                 else{
                     response = false;
                 }

                 return response;
             },
             "Hora no valida"
         );

         $.validator.addMethod(
             "horaInicio",
             function(value, element) {

                 let hora_inicio    = $('#text_hora_inicio').val()  ;
                 let hora_fin       =  $('#text_hora_fin').val() ;

                 console.log(hora_inicio);
                 console.log(hora_fin);

                 //que hora de inicio no sea igual a hora fin
                 console.log('me llaman')

                 //Verificar que la jornada de clase sea igual que la diferencia de Hora Inicio/Fin
                 if( hora_inicio == hora_fin) {
                     return false;
                 }else {
                     return true;
                 }

             },
             "Hora no valida"
         );

         //Si hay eventos colocar los valores correspondientes en las horas
         if (data.event){

             console.log(data.event);

             // Set input values
             $('#text_hora_inicio').val(data.event.hora_inicio); //.attr("readonly", "readonly");
             $('#text_hora_fin').val(data.event.hora_fin);//.attr("readonly", "readonly");;

             $('#contenedor_select_profesionales').html( data.event.select_profesionales);
             $('#contenedor_select_especialidad').html( data.event.especialidad);
             $('#hidden_id_especialidad').val( data.event.id_especialidad);


             //Trigger para volver a hacer validaciones
             $('#text_hora_inicio').trigger('focusout');
             $('#text_hora_fin').trigger('focusout');
             $('#select_profesores,  #select_cursos').trigger('blur');

         }
         //Si No hay eventos seleccionados abrir un modal con valores por defecto
         else {

             //$('#text_hora_inicio').removeAttr("readonly");
             //$('#text_hora_fin').removeAttr("readonly");


             //para los select
             $('#contenedor_select_profesionales').html(SELECT_PROFESIONALES );
             //para los select
             $('#contenedor_select_especialidad').html('');
             $('#hidden_id_especialidad').val('');

         } //Fin Else de verificación de Eventos para poblar el formulario



         //Validaciones
         /* Activar validación al cambiar select
         $(' #select_profesionales').on('change', function() {
             $(this).trigger('blur');
         });*/
         /*regla de validación para selects (no permite agregar en grupo) */
         $('#select_profesionales').rules('add', {
             required: true,
             messages: {
                 required: "Seleccione opción"
             }
         });




         $.each(data.buttons, function(index, button){
             $('.modal-footer').prepend('<button type="button" id="' + button.id  + '" class="btn ' + button.css + '">' + button.label + '</button>');
         });
         //Show Modal
         $('.modal').modal('show');

         //Agregar librería select2
         $('.select2').select2({
             //placeholder: 'Select an option',
             minimumResultsForSearch: 4,
             width: '100%'
         });
     }



     /* ===============  validación FORMULARIO " ============== */

     /* Activar validación al cambiar select  */
     /*$(' #select_profesores,  #select_cursos').on('change', function() {
         $(this).trigger('blur');
     });*/
     //validación de formulario de menú
     $('#form_horario').validate({
         onsubmit: false, //deshabilitar subida  al presionar un boton submit del formulario
         onfocusout: function(element) {
             this.element(element);
         },
         ignore: '.select2-input, .select2-focusser, .no_validar',
         rules: {
             text_hora_inicio: {
                 required: true,

             },
             text_hora_fin: {
                 required: true,
                 horaInicio : true
             },

         },
         messages: {
             text_hora_inicio: {
                 required: 'Campo requerido',
                 required: 'Hora no valida'
             },
             text_hora_fin: {
                 required: 'Campo requerido',
                 jornadaClase: 'Hora no valida'
             }
         },

         highlight: function (element) {
             //console.log(element);
             $(element).parent().parent().addClass('has-danger');
         },
         unhighlight: function (element, errorClass, validClass) {
             $(element).parent().parent().removeClass('has-danger');
         },
         success: function (element) {
             $(element).parent().parent().removeClass('has-danger');
         },
         errorPlacement: function (error, element) {
             error.insertAfter(element.parent());
         },
     });






 }//Fin función renderizar calendario

    // Handle Click on Add Button
    $('.modal').on('click', '#add-event',  function(e){

        //verificar si el formulario es válido
        if($('#form_horario').valid()) {

            //deshabilitar boton, para subir sólo una vez
            $('#add-event').val('Please wait ...')
                .attr('disabled','disabled');

            let id_consultorio           =   $('#select_consultorios option:selected').val() ;

            let hidden_fecha_inicio =   $('#hidden_fecha_inicio').val() ;
            let hidden_fecha_fin   =    $('#hidden_fecha_fin').val() ;

            let text_hora_inicio   =    $('#text_hora_inicio').val();
            let text_hora_fin      =    $('#text_hora_fin').val() ;

            let id_profesional        =    $('#select_profesionales option:selected').val() ;
            let id_especialidad       =    $('#hidden_id_especialidad').val() ;


            var dataString  = 'id_consultorio='+ id_consultorio ;
            dataString  += '&hidden_fecha_inicio='+ hidden_fecha_inicio + '&hidden_fecha_fin=' + hidden_fecha_fin + '&text_hora_inicio=' + text_hora_inicio ;
            dataString  += '&text_hora_fin='+ text_hora_fin + '&id_profesional=' + id_profesional + '&id_especialidad=' + id_especialidad  ;

            //agregar animacion , SPIN
            var target = document.getElementById("exampleModal");
            var spinner = new Spinner(SPIN_OPT1).spin(target);

            console.log('llamar a add boton');

            $.ajax({
                type: "POST", //tipo de dato de envio
                url: BASE_URL + "gestores/horarios/full_calendar_ajax/agregar_horario" ,
                data: dataString,
                dataType : 'json', //tipo de dato recibido
                cache: false,
                success: function(respt)
                {
                    spinner.stop();//detener spin
                    console.log(respt); //viene parseado JSON

                    switch (respt.estado) {

                        case 'error_validacion':
                            //swal("¡Eliminado!", "Registro Eliminado.", "success");
                            $('#errores_validacion').html(respt.errores);
                            break;

                        case 'registro_correcto' :
                            //swal("¡Cancelado!", "El registro está siendo usado.", "error");
                            $('#exampleModal').modal('hide');
                            $('#cronograma').fullCalendar("refetchEvents");
                            break;

                        case 'registro_error' :
                            swal("¡Cancelado!", "Error al registrar.", "error");
                            break;

                        default:
                            swal("¡Erro al registrar!", "Error al procesar", "error"); break;
                    }



                },
                error: function(xhr, ajaxOptions, thrownError) {
                    spinner.stop();//detener spin
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

            $('#add-event').removeAttr('disabled');


        }
        else {
            //error al validar formulario
            swal("¡Atención!", "Revisar los campos  del formulario", "warning");
        }
    });

    // Handle click on Update Button
    $('.modal').on('click', '#update-event',  function(e){
        console.log( currentEvent);
        //exit;
        // if($('#crud-form').valid()) {
        //verificar si el formulario es válido
        if($('#form_horario').valid()) {

            //deshabilitar boton, para subir sólo una vez
            $('#add-event').val('Please wait ...')
                .attr('disabled','disabled');

            let id_registro           =   currentEvent.id;

            let id_consultorio           =   $('#select_consultorios option:selected').val() ;


            let hidden_fecha_inicio =   $('#hidden_fecha_inicio').val() ;
            let hidden_fecha_fin   =    $('#hidden_fecha_fin').val() ;

            let text_hora_inicio   =    $('#text_hora_inicio').val();
            let text_hora_fin      =    $('#text_hora_fin').val() ;

            let id_profesional     =    $('#select_profesionales option:selected').val() ;
            let id_especialidad    =    $('#hidden_id_especialidad').val() ;

            var dataString  =  'id_registro='+ id_registro +'&id_consultorio='+ id_consultorio ;
            dataString  += '&hidden_fecha_inicio='+ hidden_fecha_inicio + '&hidden_fecha_fin=' + hidden_fecha_fin + '&text_hora_inicio=' + text_hora_inicio ;
            dataString  += '&text_hora_fin='+ text_hora_fin + '&id_profesional=' + id_profesional + '&id_especialidad=' + id_especialidad ;

            //agregar animacion , SPIN
            var target = document.getElementById("exampleModal");
            var spinner = new Spinner(SPIN_OPT1).spin(target);

            $.ajax({
                type: "POST", //tipo de dato de envio
                url: BASE_URL + "gestores/horarios/full_calendar_ajax/actualizar_horario" ,
                data: dataString,
                dataType : 'json', //tipo de dato recibido
                cache: false,
                success: function(respt)
                {
                    spinner.stop();//detener spin
                    console.log(respt); //viene parseado JSON

                    $('#exampleModal').modal('hide');

                    $('#cronograma').fullCalendar("refetchEvents");

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    spinner.stop();//detener spin
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
        else {
            //error al validar formulario
            swal("¡Atención!", "Revisar los campos  del formulario", "warning");
        }
    });

    // Handle Click on Delete Button
    $('.modal').on('click', '#delete-event',  function(e){

        currentEvent.id;

        //deshabilitar boton, para subir sólo una vez
        $('#delete-event').val('Please wait ...')
            .attr('disabled','disabled');

        let id_registro           =   currentEvent.id;

        var dataString  =  'id_registro='+ id_registro

        //agregar animacion , SPIN
        var target = document.getElementById("exampleModal");
        var spinner = new Spinner(SPIN_OPT1).spin(target);

        $.ajax({
            type: "POST", //tipo de dato de envio
            url: BASE_URL + "gestores/horarios/full_calendar_ajax/eliminar_horario" ,
            data: dataString,
            dataType : 'json', //tipo de dato recibido
            cache: false,
            success: function(respt)
            {
                spinner.stop();//detener spin
                console.log(respt); //viene parseado JSON

                switch (String(respt.estado) ) {

                    case 'eliminar_correcto':
                        swal("¡Eliminado!", "Registro Eliminado.", "success"); break;
                    case 'registro_usado' :
                        swal("¡Cancelado!", "El registro está siendo usado.", "error");break;
                    case 'eliminar_error' :
                        swal("¡Cancelado!", "Error al eliminar", "error"); break;
                    default:
                        swal("¡Cancelado!", "Error al eliminar", "error"); break;
                }

                $('#exampleModal').modal('hide');
                $('#cronograma').fullCalendar("refetchEvents");



            },
            error: function(xhr, ajaxOptions, thrownError) {
                spinner.stop();//detener spin
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });



});

//fuera del ready principal, para que funcione en el modal
$(document).on('change','#select_profesionales',function(){

    console.log( 'profesional ID: ' + this.value );
    //capturar valores del select CICLOS
    var id_profesional   =  this.value;

    var dataString  = 'id_profesional='+ id_profesional ;

    if(id_profesional != '' ) {

        //Cargar los parametros para el FullCalendar de Acuerdo al aula seleccionada
        $.ajax({
            type: "POST",
            url: BASE_URL + "gestores/horarios/consultas_ajax/mostrar_especialidad" ,
            data: dataString,
            dataType : 'json',
            cache: false,
            success: function(respt)
            {
                console.log(respt);
                //Colocar los valores
                $('#contenedor_select_especialidad').html(respt.especialidad);
                $('#hidden_id_especialidad').val(respt.id_especialidad);


            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });



    }


})


