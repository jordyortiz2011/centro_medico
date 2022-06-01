$(document).ready(function(){

    // ------------------------------------------------------- //
    // Transition Placeholders
    // ------------------------------------------------------ //
    $('input.input-material').on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    $('input.input-material').on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });

    //crear calendario para fecha de nacimiento
    $('#text_fecha_naci_titular, #text_fecha_naci_conyugue, #text_fecha_solicitud, #text_fecha_naci_aval , .solo_fechas').datetimepicker({
        format: 'YYYY-MM-DD',
        locale: 'es',
        viewMode: 'years',
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

        maxDate: $.now()
    });

    //crear calendario para fecha de nacimiento
    $('.solo_fechas_mes').datetimepicker({
        format: 'M',
        locale: 'es',
        viewMode: 'months',
        useCurrent: false , //rellenar el input con la fecha actual
        //defaultDate: false,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
            previous: 'fa fa-arrow-left',
            next: 'fa fa-arrow-right',
        }
    });

    //.numeric = Para ingresar sólo números en un input
    $( "#text_dni_titular" ).numeric();
    $( "#text_celular_titular" ).numeric();

    $( "#text_dni_conyugue" ).numeric();
    $( "#text_celular_conyugue" ).numeric();

    $( "#text_num_hijos" ).numeric();

    $( "#text_ha_terreno" ).numeric();

    //NUMERIC PARA TABLA DEUDA FINANCIERA
    $( ".solo_numeros" ).numeric();

    //agregar función dínamica "numeric()"
    $('#tabla_deuda, #tabla_cultivo, #tabla_pecuaria, #tabla_derivados, #tabla_otras').on('focus', '.solo_numeros', function(){
        // do something here
        $(this).numeric();
    });

    //agregar función dínamica "datetimepicker()  a la tabla CULTIVO"
    $('#tabla_cultivo').on('focus', '.solo_fechas_mes', function(){
        // do something here
        $(this).datetimepicker({
            format: 'M',
            locale: 'es',
            viewMode: 'months',
            useCurrent: false , //rellenar el input con la fecha actual
            //defaultDate: false,
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down",
                previous: 'fa fa-arrow-left',
                next: 'fa fa-arrow-right',
            }
        });
    });

    //agregar función dínamica "datetimepicker() a la tabla PECUARIA"
    $('#tabla_pecuaria, #tabla_derivados').on('focus', '.solo_fechas', function(){
        // do something here
        $(this).datetimepicker({
            format: 'YYYY-MM-DD',
            locale: 'es',
            viewMode: 'years',
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

            maxDate: $.now()
        });
    });


          
   //registrar tooltip (btn agregar colegio)
    $('#btn_agregar_colegio').tooltip();

    //registrar los select2
    $('#select_estado_civil, #select_tenencia_terreno, #select_sbs_titular,#select_grado_instru_titular, #select_sbs_conyugue, #select_grado_instru_conyugue,#select_grado_instru_aval').select2({
        //placeholder: 'Select an option',
        minimumResultsForSearch: 7,
        width: '100%',
        allowClear: true
    });

    $('#select_agencias, #select_terreno_principal_titular, #select_terreno_secundaria_titular, #select_tipo_socio,  #select_servicios_basicos').select2({
        //placeholder: 'Select an option',
        minimumResultsForSearch: 7,
        width: '100%',
        allowClear: false
    });


  // === agregar/remover filas de la  tabla Deuda sistema financiero  =====
    var counter = 1;

    $("#addrow_deuda").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm "             required name="text_tabla_deuda[' + counter + '][entidad]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_deuda[' + counter + '][monto]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_deuda[' + counter + '][pago_mes]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_deuda[' + counter + '][plazos]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_deuda[' + counter + '][cuotas]"/></td>';

       //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#tabla_deuda"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_deuda").append(newRow);
        counter++;
    });

    $("#tabla_deuda").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    // ====== agregar/remover filas de la  tabla "DIVERSIFICACIÓN DE CULTIVO"  =======
    var counter = 1;

    $("#addrow_cultivo").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_cultivo[' + counter + '][cultivo]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter + '][ha_prod]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter + '][ha_crec]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm " required name="text_tabla_cultivo[' + counter + '][unidad]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter + '][produccion]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter + '][autoconsumo]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_fechas_mes" required name="text_tabla_cultivo[' + counter + '][mes]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter + '][precio]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter + '][total]"/></td>';

        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#tabla_cultivo"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_cultivo").append(newRow);
        counter++;
    });

    $("#tabla_cultivo").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    // ====== agregar/remover filas de la  tabla "DIVERSIFICACIÓN PECUARIA"  =======
    var counter = 1;

    $("#addrow_pecuaria").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_pecuaria[' + counter + '][nombre]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter + '][num_animales]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter + '][autoconsumo]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter + '][num_animales_venta] " style="width: 5em;"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_fechas"  required name="text_tabla_pecuaria[' + counter + '][fecha_venta]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter + '][precio]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter + '][total]"/></td>';


        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#addrow_pecuaria"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_pecuaria").append(newRow);
        counter++;
    });

    $("#tabla_pecuaria").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    // ====== agregar/remover filas de la  tabla "DIVERSIFICACIÓN PECUARIA"  =======
    var counter = 1;

    $("#addrow_derivados").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_derivados[' + counter + '][derivados]" style="width: 8em;"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_derivados[' + counter + '][unidad]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_derivados[' + counter + '][produccion]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_derivados[' + counter + '][precio] " style="width: 6em;"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_fechas"  required name="text_tabla_derivados[' + counter + '][fecha]" style="width: 8em;"/></td>';


        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#addrow_derivados"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_derivados").append(newRow);
        counter++;
    });

    $("#tabla_derivados").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    // ====== agregar/remover filas de la  tabla "DIVERSIFICACIÓN PECUARIA"  =======
    var counter = 1;

    $("#addrow_otras").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_otras[' + counter + '][actividades]" style="width: 8em;"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_otras[' + counter + '][ingreso]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_otras[' + counter + '][antiguedad]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm         "     required name="text_tabla_otras[' + counter + '][empresa] " style="width: 6em;"/></td>';



        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#addrow_otras"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_otras").append(newRow);
        counter++;
    });

    $("#tabla_otras+").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });


    /*==================== VALIDACIONES ================================= */
    //validar select al cambiar ,
    $('#select_estado_civil, #select_tenencia_terreno').on('change', function() {
        $(this).trigger('blur');
    });

    //mensaje por defecto para campos required
    $.validator.messages.required = "Campo requerido";

    /* validación Modal-Formulario "registrar Colegio" */
    $('#form_registrar_solicitud').validate({
        
         onfocusout: function(element) {
                                    this.element(element);
                            },
                                          
          //ignore: '.select2-input, .select2-focusser',
          
          rules: {
                text_nombres_titular: {
                    required: true,
                    maxlength: 200,
                },
              text_apellido_pat_titular: {
                    required: true ,
                    maxlength: 100,
              },
              text_apellido_mat_titular: {
                  required: true ,
                  maxlength: 100,
              },
              text_dni_titular: {
                  required: true ,
                  minlength: 8
              },
              text_celular_titular: {
                  required: true ,
                  minlength: 9
              },

              text_nombres_conyugue: {
                  required: true,
                  maxlength: 200,
              },
              text_apellido_pat_conyugue: {
                  required: true ,
                  maxlength: 100,
              },
              text_apellido_mat_conyugue: {
                  required: true ,
                  maxlength: 100,
              },
              text_dni_conyugue: {
                  required: true ,
                  minlength: 8
              },
              text_celular_conyugue: {
                  required: true ,
                  minlength: 9
              },
              select_estado_civil: {
                  required: true
              },
              select_tenencia_terreno: {
                    required: true
              }

          },
        messages: {
            text_nombres_titular: {
                required: 'Campo requerido',
                maxlength: '200 caracteres máximo',
                    },
            text_apellido_pat_titular: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_apellido_mat_titular: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_dni_titular: {
                required: 'Campo requerido',
                minlength: 'Ingrese 8 dígitos',
            },
            text_celular_titular: {
                required: 'Campo requerido',
                minlength: 'Ingrese 9 dígitos',
            },

            text_nombres_conyugue: {
                required: 'Campo requerido',
                maxlength: '200 caracteres máximo',
            },
            text_apellido_pat_conyugue: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_apellido_mat_conyugue: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_dni_conyugue: {
                required: 'Campo requerido',
                minlength: 'Ingrese 8 dígitos',
            },
            text_celular_conyugue: {
                required: 'Campo requerido',
                minlength: 'Ingrese 9 dígitos',
            },
            select_estado_civil: {
                required: 'Seleccione una opción'
            },
            select_tenencia_terreno: {
                required: 'Seleccione una opción'
            }
                                         
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

    $('#select_estado_civil').on('change', function() {
        console.log( 'mi valor es: '  + $(this).val() ) ;
    });
    
      /*regla de validación */
      /*$('#select_estado_civil').rules('add', {
        required: true,
        messages: {
          required: "Seleccione una opción"
        }
      });*/



    /***********--APROBAR--***************/
    $("#btn_aprobar").on('click', '',function(e)
    {
        e.preventDefault();

        swal({
                title: "¿Estás seguro que deseas marcar como APTA esta Solicitud?",
                text: "Una vez marcada como APTA, no podrá rechazar ni eliminar esta solicitud",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, APTO",
                cancelButtonText: "No, CANCELAR",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    //proceder a aprobar el formulario:
                    var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "btn_verificar").val("2"); //aprobar
                    $('#form_editar_solicitud').append(input);

                    $('#form_editar_solicitud').submit();

                } else {
                    swal("¡Cancelado!", "Acción cancelada", "error");
                }
            });
    });

    /***********--Rechazar--***************/
    $("#btn_rechazar").on('click', '',function(e)
    {
        e.preventDefault();

        swal({
                title: "¿Estás seguro que deseas RECHAZAR esta Solicitud?",
                text: "Una vez rechazada, no podrá marcar apta ni eliminar esta solicitud",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, RECHAZAR",
                cancelButtonText: "No, CANCELAR",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    //proceder a aprobar el formulario:
                    var input = $("<input>")
                        .attr("type", "hidden")
                        .attr("name", "btn_verificar").val("3"); //rechazar
                    $('#form_editar_solicitud').append(input);

                    $('#form_editar_solicitud').submit();

                } else {
                    swal("¡Cancelado!", "Acción cancelada", "error");
                }
            });
    });

    /* ===== Calcular Edad Automaticamente  */
    $('#text_fecha_naci_titular_edad').ager({
        birth: $('#text_fecha_naci_titular').val(),
        years_text: "",
        output: "%a %Y ",
        day_first_suffixes: ["st", "nd", "rd"],
        day_global_suffixes: "th",
        text_months: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        output_type: "html" // or text or html
    });
    /* ===== Calcular Edad Automaticamente  */
    $('#text_fecha_naci_conyugue_edad').ager({
        birth: $('#text_fecha_naci_conyugue').val(),
        years_text: "",
        output: "%a %Y ",
        day_first_suffixes: ["st", "nd", "rd"],
        day_global_suffixes: "th",
        text_months: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        output_type: "html" // or text or html
    });
    /* ===== Calcular Edad Automaticamente  */
    $('#text_fecha_naci_aval_edad').ager({
        birth: $('#text_fecha_naci_aval').val(),
        years_text: "",
        output: "%a %Y ",
        day_first_suffixes: ["st", "nd", "rd"],
        day_global_suffixes: "th",
        text_months: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        output_type: "html" // or text or html
    });

    //Si no se registró fecha de naci. de Cónyugue y Aval, establecer string vacio
    if ( $('#text_fecha_naci_conyugue').val() == '') {
        $('#text_fecha_naci_conyugue_edad').html('');
    }
    if ( $('#text_fecha_naci_aval').val() == '') {
        $('#text_fecha_naci_aval_edad').html('');
    }
       
            

});