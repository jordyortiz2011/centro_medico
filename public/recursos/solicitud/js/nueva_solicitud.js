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
    $(' #text_fecha_solicitud, #text_fecha_naci_aval, #text_fecha_naci_conyu_aval , .solo_fechas').datetimepicker({
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
    $('.solo_fechas_nuevo').datetimepicker({
        format: 'DD/MM/YYYY',
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

        maxDate: $.now()
    });

    //crear calendario para fecha de nacimiento
    $('.mayor_edad').datetimepicker({
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

        maxDate: FECHA_18_MENOS
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

    $( "#text_dni_aval" ).numeric();
    $( "#text_celular_aval" ).numeric();

    $( "#text_dni_conyu_aval" ).numeric();
    $( "#text_celular_conyu_aval" ).numeric();

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

    //PARA ESCRIBIR SÓLO EN MAYUSCULA
    $('.solo_mayusculas').keyup(function(){
        $(this).val($(this).val().toUpperCase());
    });


  // === agregar/remover filas de la  tabla Deuda sistema financiero  =====
    var counter_titular = 20; //50 para que no colisione con el agregado de entidades del webService

    $("#addrow_deuda_titular").on("click", function () {
        var html = '<tr>';
        //var cols = "";
        //alert(counter_titular);

        html += '<td><input type="text" class="form-control form-control-sm solo_mayusculas"    required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][entidad]"  /></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_fechas_nuevo"  required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][fecha_consulta]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][saldo_deuda_consulta]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_mayusculas"    required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][ultima_calificacion]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_mayusculas"    required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][peor_calificacion]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][saldo_deuda_evaluacion]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][cuota_pendiente]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required autocomplete="off" name="text_tabla_deuda_titular[' + counter_titular + '][num_cuotas_pendiente]"/></td>';
       //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        html += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#/"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        html += '</tr>';
        //newRow.append(cols);

        $("#tabla_deuda_titular tbody").append(html);
        counter_titular++;

        //crear calendario para fecha de nacimiento
        $('.solo_fechas_nuevo').datetimepicker({
            format: 'DD/MM/YYYY',
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

            //maxDate: $.now()
        });

        //PARA ESCRIBIR SÓLO EN MAYUSCULA
        $('.solo_mayusculas').keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });
    });

    $("#tabla_deuda_titular").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter_titular -= 1
    });

    // === agregar/remover filas de la  tabla Deuda sistema financiero  =====
    var counter_conyuge = 20; //50 para que no colisione con el agregado de entidades del webService

    $("#addrow_deuda_conyuge").on("click", function () {
        var html = '<tr>';
        //var cols = "";


        html += '<td><input type="text" class="form-control form-control-sm solo_mayusculas"    required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][entidad]"  /></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_fechas_nuevo"  required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][fecha_consulta]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][saldo_deuda_consulta]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_mayusculas"    required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][ultima_calificacion]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_mayusculas"    required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][peor_calificacion]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][saldo_deuda_evaluacion]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][cuota_pendiente]"/></td>';
        html += '<td><input type="text" class="form-control form-control-sm solo_numeros"       required name="text_tabla_deuda_conyuge[' + counter_conyuge + '][num_cuotas_pendiente]"/></td>';
        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        html += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#/"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        html += '</tr>';
        //newRow.append(cols);

        $("#tabla_deuda_conyuge tbody").append(html);
        counter_conyuge++;

        //crear calendario para fecha de nacimiento
        $('.solo_fechas_nuevo').datetimepicker({
            format: 'DD/MM/YYYY',
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

            //maxDate: $.now()
        });

        //PARA ESCRIBIR SÓLO EN MAYUSCULA
        $('.solo_mayusculas').keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });
    });

    $("#tabla_deuda_conyuge").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter_conyuge -= 1
    });

    // ====== agregar/remover filas de la  tabla "DIVERSIFICACIÓN DE CULTIVO"  =======
    var counter_cultivo = 1;

    $("#addrow_cultivo").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_cultivo[' + counter_cultivo + '][cultivo]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm " required name="text_tabla_cultivo[' + counter_cultivo + '][unidad]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_fechas_mes" required name="text_tabla_cultivo[' + counter + '][mes]"/></td>';

        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter_cultivo + '][ha_totales]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter_cultivo + '][ha_produccion]"/></td>';

        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter_cultivo + '][produccion]"/></td>';

        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter_cultivo + '][precio]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_cultivo[' + counter_cultivo + '][total]"/></td>';

        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#/"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_cultivo").append(newRow);
        counter_cultivo++;
    });

    $("#tabla_cultivo").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter_cultivo -= 1
    });

    // ====== agregar/remover filas de la  tabla "DIVERSIFICACIÓN PECUARIA"  =======
    var counter_pecuaria = 1;

    $("#addrow_pecuaria").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td><input type="text" class="form-control form-control-sm             " required name="text_tabla_pecuaria[' + counter_pecuaria + '][nombre]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter_pecuaria + '][num_animales]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter_pecuaria + '][autoconsumo]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter_pecuaria + '][num_animales_venta] " style="width: 5em;"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_fechas"  required name="text_tabla_pecuaria[' + counter_pecuaria + '][fecha_venta]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter_pecuaria + '][precio]"/></td>';
        cols += '<td><input type="text" class="form-control form-control-sm solo_numeros" required name="text_tabla_pecuaria[' + counter_pecuaria + '][total]"/></td>';


        //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
        cols += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#addrow_pecuaria"> <i class="fa fa-trash-o bigger-150"></i> </a>'
        newRow.append(cols);

        $("#tabla_pecuaria").append(newRow);
        counter_pecuaria++;
    });

    $("#tabla_pecuaria").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter_pecuaria -= 1
    });

    // ====== agregar/remover filas de la  tabla "derivados"  =======
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

    $("#tabla_otras").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });


    /*==================== VALIDACIONES ================================= */
    //validar select al cambiar ,
    $('#select_agencias, #select_grado_instru_titular, #select_estado_civil, #select_tenencia_terreno, #select_departamentos, #select_provincias, #select_distritos, #select_tipo_socio').on('change', function() {
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
                  text_asesor_credito: {
                    required: true,
                    maxlength: 200,
                },
                  text_sector: {
                    required: true,
                    maxlength: 200,
                },
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
              "checkbox_vende_produccion[]": {
                  required: true,
                  minlength: 1
              },
              text_nombres_conyugue: {
                  maxlength: 200,
              },
              text_apellido_pat_conyugue: {

                  maxlength: 100,
              },
              text_apellido_mat_conyugue: {

                  maxlength: 100,
              },
              text_dni_conyugue: {

                  minlength: 8
              },
              text_celular_conyugue: {

                  minlength: 9
              },
               text_nombres_aval: {

                  maxlength: 200,
              },
              text_apellido_pat_aval: {

                  maxlength: 100,
              },
              text_apellido_mat_aval: {

                  maxlength: 100,
              },
              text_dni_aval: {

                  minlength: 8
              },
              text_celular_aval: {

                  minlength: 9
              },

              text_nombres_conyu_aval: {

                  maxlength: 200,
              },
              text_apellido_pat_conyu_aval: {

                  maxlength: 100,
              },
              text_apellido_mat_conyu_aval: {

                  maxlength: 100,
              },
              text_dni_conyu_aval: {

                  minlength: 8
              },
              text_celular_conyu_aval: {

                  minlength: 9
              },

              select_agencias: {
                  required: true
              },
              select_estado_civil: {
                  required: true
              },
              select_tenencia_terreno: {
                    required: true
              },
               select_sbs_titular: {
                  required: true
              },
              select_grado_instru_titular: {
                    required: true
              },
              select_departamentos: {
                  required: true
              },
              select_provincias: {
                  required: true
              },
              select_distritos: {
                  required: true
              },
              select_tipo_socio: {
                  required: true
              }

          },
        messages: {

        	text_asesor_credito: {
                required: 'Campo requerido',
                maxlength: '200 caracteres máximo',
                    },
            text_sector: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
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
            "checkbox_vende_produccion[]": {
                required: 'Seleccione al menos una opción',
                minlength: 'Seleccione al menos una opción'
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
             text_nombres_aval: {
                required: 'Campo requerido',
                maxlength: '200 caracteres máximo',
            },
            text_apellido_pat_aval: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_apellido_mat_aval: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_dni_aval: {
                required: 'Campo requerido',
                minlength: 'Ingrese 8 dígitos',
            },
            text_celular_aval: {
                required: 'Campo requerido',
                minlength: 'Ingrese 9 dígitos',
            },
            text_nombres_conyu_aval: {
                required: 'Campo requerido',
                maxlength: '200 caracteres máximo',
            },
            text_apellido_pat_conyu_aval: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_apellido_mat_conyu_aval: {
                required: 'Campo requerido',
                maxlength: '100 caracteres máximo',
            },
            text_dni_aval: {
                required: 'Campo requerido',
                minlength: 'Ingrese 8 dígitos',
            },
            text_celular_conyu_aval: {
                required: 'Campo requerido',
                minlength: 'Ingrese 9 dígitos',
            },
            select_agencias: {
                required: 'Seleccione una opción'
            },
            select_estado_civil: {
                required: 'Seleccione una opción'
            },
            select_tenencia_terreno: {
                required: 'Seleccione una opción'
            },
            select_sbs_titular: {
                required: 'Seleccione una opción'
            },
            select_grado_instru_titular: {
                required: 'Seleccione una opción'
            },
            select_departamentos: {
                required: 'Seleccione una opción'
            },
            select_provincias: {
                required: 'Seleccione una opción'
            },
            select_distritos: {
                required: 'Seleccione una opción'
            },
            select_tipo_socio: {
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

        errorPlacement: function(error, element) {
        //console.log(element);

        if (element.attr("name") == "checkbox_vende_produccion[]" ) {
            $('#error_checkbox_vende_produccion').html(error);
        }
        else {
            error.insertAfter(element);
        }
    }

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
    
    
   /* ===== Calcular Edad Automaticamente  */
    $('#text_fecha_naci_titular').on('dp.change', function() {

        console.log(this.value);
        $('#text_fecha_naci_titular_edad').ager({
            birth: this.value,
            years_text: "",
            output: "%a %Y ",
            day_first_suffixes: ["st", "nd", "rd"],
            day_global_suffixes: "th",
            text_months: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            output_type: "html" // or text or html
        });
    });

    /* ===== Calcular Edad Automaticamente  */
    $('#text_fecha_naci_conyugue').on('dp.change', function() {

        console.log(this.value);
        $('#text_fecha_naci_conyugue_edad').ager({
            birth: this.value,
            years_text: "",
            output: "%a %Y ",
            day_first_suffixes: ["st", "nd", "rd"],
            day_global_suffixes: "th",
            text_months: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            output_type: "html" // or text or html
        });
    });

    /* ===== Calcular Edad Automaticamente  */
    $('#text_fecha_naci_aval').on('dp.change', function() {

        console.log(this.value);
        $('#text_fecha_naci_aval_edad').ager({
            birth: this.value,
            years_text: "",
            output: "%a %Y ",
            day_first_suffixes: ["st", "nd", "rd"],
            day_global_suffixes: "th",
            text_months: ["Jan", "Feb", "Mar", "Apr", "May", "jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            output_type: "html" // or text or html
        });
    });

    /* ===== TIPO DE SOCIO: Mostrar campo de # de créditos si es un socio recurrente  */
    $('#select_tipo_socio').on('change', function() {

        if(this.value == 1) {
            $('#bloque_numero_creditos').addClass('d-none');
            $('#text_numero_creditos').removeAttr('required');
        }else if (this.value == 2){
            $('#bloque_numero_creditos').removeClass('d-none');
            $('#text_numero_creditos').attr('required' , 'required');
        }
    });

    /* ===== COMBOBOX: al cambiar el select de agencia, mostrar listado de asesores  */
    //registrar los select2
    $('#select_asesores').select2({
        //placeholder: 'Select an option',
        minimumResultsForSearch: 7,
        width: '100%',
        allowClear: false
    });

    $('#select_agencias').on('change', function (evt) {

        console.log( this.value );

        //capturar valores del select CICLOS
        var id_agencia    =  this.value;
        var dataString  = 'id_agencia='+ id_agencia;

        //eliminar datos del select agentes (crédito)
        let select_defecto = '';
        $('#select_asesores').html(select_defecto);

        $('#select_agencias').after('<i  class="fa fa-spinner fa-spin fa-3x fa-fw" ></i>');


        $.ajax({
            type: "POST",
            url: BASE_URL + "solicitud/consultas_ajax/combobox_agencias_ajax" ,
            data: dataString,
            dataType : 'json',
            cache: false,
            success: function(respt)
            {
                console.log(respt);

                let html = ''; //variable para el select
                html += '<option value=""> Seleccione </option> ';
                $.each(respt.lst_asesores , function(clave, valor) {
                    //console.log('clave: ' + clave + ' -  Valor: '+valor + ' pago:' + valor.id_cicloturno  );
                    html += '<option value="' + valor.user_id + '">' +  valor.nombres_user + ', ' +  valor.apellido_pat_user + ' ' +  valor.apellido_mat_user +   '</option> ';
                });
                //console.log(html);

                $('#select_asesores').html(html);//poblar el select

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },
            complete: function(xhr, ajaxOptions, thrownError) {
                $('.fa-spinner').remove();
            },
        });


    });

    /* ===== MOSTRAR DATOS DEL CONYUGE, cuando el estado civil del titular es Conviviente o Casado  */
    $('#select_estado_civil').on('change', function (evt) {

        var id_estado = this.value;

        //2= Conviviente  ; 4=Casado
        if(id_estado == 2 || id_estado == 4) {
            $('.row_datos_conyuge').removeClass('d-none');
        }else {
            $('.row_datos_conyuge').addClass('d-none');
        }

    });

    /* ===== MOSTRAR DATOS DEL AVAL, cuando se marca el checkbox  */
    $('#checkbox_posee_aval').on('change', function (evt) {


        var estado = $('#checkbox_posee_aval').is(':checked'); ;
        console.log( typeof (estado));

        //2= Conviviente  ; 4=Casado
        if(estado == true) {
            console.log('remover');
            $('.row_datos_aval').removeClass('d-none');
            $('.row_datos_aval_conyuge').removeClass('d-none');
        }else {
            $('.row_datos_aval').addClass('d-none');
            $('.row_datos_aval_conyuge').addClass('d-none');
        }

    });

       
            

});