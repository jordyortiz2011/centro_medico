$(document).ready(function(){

    //deshabilitar envio de formularios  con ENTER
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });

    //activar busqueda al presionar ENTER cuando se escribe en el campo de DNI titular
    $('#text_dni_titular').on('keyup',  '' , function (event) {
        if(event.which == 13){//Enter key pressed
            $('#btn_buscar_titular').click();//Trigger search button click event
        }
    });

    //activar busqueda al presionar ENTER cuando se escribe en el campo de DNI CONYUGE
    $('#text_dni_conyugue').on('keyup',  '' , function (event) {
        if(event.which == 13){//Enter key pressed
            $('#btn_buscar_conyuge').click();//Trigger search button click event
        }
    });

    $('#select_registra_deuda_titular, #select_registra_deuda_conyuge').select2({
        //placeholder: 'Select an option',
        minimumResultsForSearch: 7,
        width: '100%',
        allowClear: false
    });

    //para llenar campo oculto de registra deuda
    $('#select_registra_deuda_titular').on('change',  '' , function (event) {
        $('#hidden_registra_deuda_titular').val(this.value);

        if(this.value == 'SI') {
            $('#select2-select_registra_deuda_titular-container').css('background-color' , 'red');
            $('#select2-select_registra_deuda_titular-container').css('font-weight' , 'bold');
            $('#select2-select_registra_deuda_titular-container').css('color' , 'white');
        } else {
            $('#select2-select_registra_deuda_titular-container').css('background-color' , '');
            $('#select2-select_registra_deuda_titular-container').css('font-weight' , '');
            $('#select2-select_registra_deuda_titular-container').css('color' , 'black');
        }

    });

    //para llenar campo oculto de registra deuda
    $('#select_registra_deuda_conyuge').on('change',  '' , function (event) {
        $('#hidden_registra_deuda_conyuge').val(this.value);

        if(this.value == 'SI') {
            $('#select2-select_registra_deuda_conyuge-container').css('background-color' , 'red');
            $('#select2-select_registra_deuda_conyuge-container').css('font-weight' , 'bold');
            $('#select2-select_registra_deuda_conyuge-container').css('color' , 'white');
        } else {
            $('#select2-select_registra_deuda_conyuge-container').css('background-color' , '');
            $('#select2-select_registra_deuda_conyuge-container').css('font-weight' , '');
            $('#select2-select_registra_deuda_conyuge-container').css('color' , 'black');
        }
    });


    //Buscar Títular //
    $('#btn_buscar_titular').on('click',  '' , function () {


        if( $('#text_dni_titular').valid() ) {

            var dni =  $('#text_dni_titular').val();
            var dataString =  'text_dni=' +  dni ;

            //alert('Buscar estudiante');
            //exit;

            //deshabilitar boton, para BUSCAR sólo una vez
            $('#btn_buscar_titular').attr('disabled','disabled');

            //agregar animacion , SPIN
            /*var target = document.getElementById("bloque_titular");
            var spinner = new Spinner(SPIN_OPT1).spin(target); */

            $('#btn_buscar_titular').after('<i  class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

            $.ajax({
                type: "POST",
                url: BASE_URL + "solicitud/Consultas_webservice/buscar_dni_titular",
                data: dataString,
                cache: false,
                success: function(respuesta)
                {
                    console.log(respuesta);
                    let respt = JSON.parse(respuesta);
                    console.log(respt);

                    if(respt.cod_estado == 0) {
                        console.log('encontrado');
                        //ocultar btn de busqueda
                        $('#btn_buscar_titular').addClass('d-none');


                        //mostrar notificación
                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'success',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Datos cargados </center><h3>',

                        }).show();

                        //Hacer sólo de lectura el DNI del titular
                        $('#text_dni_titular').attr('readonly','readonly');
                        $('#text_dni_titular').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_dni_titular]').css({'top' : '-15px'});

                        //rellenar los campos del estudiante encontrado y agregar clase activa al label
                        // y borrar sobreposición de  mensajes de validación
                        $('#text_nombres_titular').val(respt.nombres_titular);
                        $('label[for=text_nombres_titular]').toggleClass('active');
                        $('#text_nombres_titular').attr('readonly','readonly');
                        $('#text_nombres_titular').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_nombres_titular]').css({'top' : '-15px'});
                        $('#text_nombres_titular').trigger('focusout'); //EVITA LABEL DUPLICADOS


                        $('#text_apellido_pat_titular').val(respt.ape_paterno_titular);
                        $('label[for=text_apellido_pat_titular]').toggleClass('active');
                        $('#text_apellido_pat_titular').attr('readonly','readonly');
                        $('#text_apellido_pat_titular').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_apellido_pat_titular]').css({'top' : '-15px'});
                        $('#text_apellido_pat_titular').trigger('focusout');

                        $('#text_apellido_mat_titular').val(respt.ape_materno_titular);
                        $('label[for=text_apellido_mat_titular]').toggleClass('active');
                        $('#text_apellido_mat_titular').attr('readonly','readonly');
                        $('#text_apellido_mat_titular').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_apellido_mat_titular]').css({'top' : '-15px'});
                        $('#text_apellido_mat_titular').trigger('focusout');

                        $('#text_fecha_naci_titular').val(respt.fecha_naci_titular);
                        $('label[for=text_fecha_naci_titular]').toggleClass('active');
                        $('#text_fecha_naci_titular').trigger('dp.change');
                        $('#text_fecha_naci_titular').attr('readonly','readonly');
                        $('#text_fecha_naci_titular').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_fecha_naci_titular]').css({'top' : '-15px'});
                        $('#text_fecha_naci_titular').trigger('focusout');

                        //DOCUMENTOS IMPAGOS
                        $('#text_impagos_titular').val(respt.impagos_monto_titular);
                        $('#text_impagos_titular').attr('readonly','readonly');
                        //PROTESTOS
                        $('#text_protestos_titular').val(respt.protestos_monto_titular);
                        $('#text_protestos_titular').attr('readonly','readonly');


                        $("#select_registra_deuda_titular").val(respt.calificacion_titular).trigger('change');
                        $("#select_registra_deuda_titular").select2('enable',false);
                        $("#hidden_registra_deuda_titular").val(respt.calificacion_titular);

                        //Aplicar estilo ROJO a las deudas de 24 meses
                        if(respt.calificacion_titular == 'SI') {
                            $('#select2-select_registra_deuda_titular-container').css('background-color' , 'red');
                            $('#select2-select_registra_deuda_titular-container').css('font-weight' , 'bold');
                            $('#select2-select_registra_deuda_titular-container').css('color' , 'white');
                        } else {
                            $('#select2-select_registra_deuda_titular-container').css('background-color' , '');
                            $('#select2-select_registra_deuda_titular-container').css('font-weight' , '');
                            $('#select2-select_registra_deuda_titular-container').css('color' , 'black');
                        }

                         // === PARA VERIFICAR SI TIENE DEUDA CON ENTIDADES
                        if(respt.estado_entidades  == true ) {

                             //ocultar botón para agregar más entidades
                            //$('#addrow_deuda_titular').addClass('d-none');

                            var mis_entidades = respt.mis_entidades.SDT_InfCopacEnt;
                            //recorrer entidades

                            //si es array, tiene más de una entidad
                            if( $.isArray(mis_entidades) ) {
                                console.log('soy array');

                                $("#tabla_deuda_titular tbody").html('');

                                $.each( mis_entidades, function( key, value ) {
                                    console.log( key + ": " + value );
                                    //console.log(key);
                                    //console.log(value);

                                    var html = '<tr>';
                                    //var cols = "";

                                    html += '<td><input type="text" class="form-control form-control-sm "             required readonly      style="width: 15em;" autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][entidad]"            value="'+ value.Entidad +'" /></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_fechas_nuevo" required readonly style="width: 8em;"  autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][fecha_consulta]" value="'+ value.EntiFechaInf +'" /></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required readonly      style="width: 8em;"  autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][saldo_deuda_consulta]" value="'+ value.EntiSaldo +'" /></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm "             required readonly      style="width: 5em;"  autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][ultima_calificacion]" value="'+ value.EntiUltCal +'"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm "             required readonly      style="width: 5em;"  autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][peor_calificacion]" value="'+ value.EntiPerCal12M +'"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required               style="width: 10em;" autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][saldo_deuda_evaluacion]"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required               style="width: 10em;" autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][cuota_pendiente]"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required               style="width: 5em;"  autocomplete="off"    name="text_tabla_deuda_titular[' + key + '][num_cuotas_pendiente]"/></td>';
                                    //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                                    //html += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#/"> <i class="fa fa-trash-o bigger-150"></i> </a>'
                                    html += '<td></td>';
                                    html += '</tr>';
                                    //newRow.append(cols);

                                    $("#tabla_deuda_titular").append(html);
                                });

                                calculateTotal_sumatoria_deuda_titular();

                            }else {
                                console.log('NO soy array');
                                //No es array, entonces sólo tiene una entidad
                                //Nombre entidad
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][entidad]']").val(mis_entidades.Entidad);
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][entidad]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][entidad]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_titular["+ 0 +"][fecha_consulta]']").val(mis_entidades.EntiFechaInf);
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][fecha_consulta]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][fecha_consulta]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_titular["+ 0 +"][saldo_deuda_consulta]']").val(mis_entidades.EntiSaldo);
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][saldo_deuda_consulta]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][saldo_deuda_consulta]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_titular["+ 0 +"][ultima_calificacion]']").val(mis_entidades.EntiUltCal);
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][ultima_calificacion]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][ultima_calificacion]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_titular["+ 0 +"][peor_calificacion]']").val(mis_entidades.EntiPerCal12M);
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][peor_calificacion]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_titular["+ 0 +"][peor_calificacion]']").css({'background-color' : '#DFD8D1'});


                                calculateTotal_sumatoria_deuda_titular();

                            }
                        }






                    }else if (respt.cod_estado == 3) {
                        console.log('no_encontrado')

                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'error',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Documento inválido(No existe)</center><h3>',
                        }).show();

                        //Volver a habilitar btn buscar
                        $('#btn_buscar_titular').removeAttr('disabled');

                    } else if (respt.cod_estado == 501) {
                        //COD ESTADO PROPIO: Solicitud inconclusa
                        swal( 'Solicitud inconlusa','No se puede registrar una nueva solicitud, ya que el DNI ingresado posee una solicitud que no ha sido verificada aún', "info");

                        //Volver a habilitar btn buscar
                        $('#btn_buscar_titular').removeAttr('disabled');

                    }else {
                        console.log('error al buscar');

                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'error',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Error al consultar WebService COD: ' + respt.cod_estado + ' </center><h3>',
                        }).show();

                        //Volver a habilitar btn buscar
                        $('#btn_buscar_titular').removeAttr('disabled');
                    }

                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    $('.fa-spin').remove();
                    $('#btn_buscar_titular').removeAttr('disabled');
                },
                complete: function(xhr, ajaxOptions, thrownError) {
                    $('.fa-spin').remove();
                    $('#btn_buscar_titular').removeAttr('disabled');
                },

            });
        }//Fin valicación formulario
        else {
            swal("¡Error!", "Verifique DNI de titular", "warning");
        }

    }); //Fin evento boton buscar TÍTULAR


    // ============ Buscar CONYUGE ========================== //
    $('#btn_buscar_conyuge').on('click',  '' , function () {


        if( $('#text_dni_conyugue').valid() && $('#text_dni_conyugue').val() != ''   ) {

            var dni =  $('#text_dni_conyugue').val();
            var dataString =  'text_dni=' +  dni ;

            //alert('Buscar estudiante');
            //exit;

            //deshabilitar boton, para BUSCAR sólo una vez
            $('#btn_buscar_conyuge').attr('disabled','disabled');

            $('#btn_buscar_conyuge').after('<i  class="fa fa-spinner fa-spin fa-3x fa-fw"></i>');

            $.ajax({
                type: "POST",
                url: BASE_URL + "solicitud/Consultas_webservice/buscar_dni_conyuge",
                data: dataString,
                cache: false,
                success: function(respuesta)
                {
                    console.log(respuesta);
                    let respt = JSON.parse(respuesta);
                    console.log(respt);

                    if(respt.cod_estado == 0) {
                        console.log('encontrado');
                        //ocultar btn de busqueda
                        $('#btn_buscar_conyuge').addClass('d-none');


                        //mostrar notificación
                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'success',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Datos cargados </center><h3>',

                        }).show();

                        //Hacer sólo de lectura el DNI del conyuge
                        $('#text_dni_conyugue').attr('readonly','readonly');
                        $('#text_dni_conyugue').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_dni_conyugue]').css({'top' : '-15px'});

                        //rellenar los campos del estudiante encontrado y agregar clase activa al label
                        // y borrar sobreposición de  mensajes de validación
                        $('#text_nombres_conyugue').val(respt.nombres_titular);
                        $('label[for=text_nombres_conyugue]').toggleClass('active');
                        $('#text_nombres_conyugue').attr('readonly','readonly');
                        $('#text_nombres_conyugue').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_nombres_conyugue]').css({'top' : '-15px'});
                        $('#text_nombres_conyugue').trigger('focusout'); //EVITA LABEL DUPLICADOS


                        $('#text_apellido_pat_conyugue').val(respt.ape_paterno_titular);
                        $('label[for=text_apellido_pat_conyugue]').toggleClass('active');
                        $('#text_apellido_pat_conyugue').attr('readonly','readonly');
                        $('#text_apellido_pat_conyugue').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_apellido_pat_conyugue]').css({'top' : '-15px'});
                        $('#text_apellido_pat_conyugue').trigger('focusout');

                        $('#text_apellido_mat_conyugue').val(respt.ape_materno_titular);
                        $('label[for=text_apellido_mat_conyugue]').toggleClass('active');
                        $('#text_apellido_mat_conyugue').attr('readonly','readonly');
                        $('#text_apellido_mat_conyugue').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_apellido_mat_conyugue]').css({'top' : '-15px'});
                        $('#text_apellido_mat_conyugue').trigger('focusout');

                        $('#text_fecha_naci_conyugue').val(respt.fecha_naci_titular);
                        $('label[for=text_fecha_naci_conyugue]').toggleClass('active');
                        $('#text_fecha_naci_conyugue').trigger('dp.change');
                        $('#text_fecha_naci_conyugue').attr('readonly','readonly');
                        $('#text_fecha_naci_conyugue').css({'background-color' : '#DFD8D1'});
                        $('label[for=text_fecha_naci_conyugue]').css({'top' : '-15px'});
                        $('#text_fecha_naci_conyugue').trigger('focusout');

                        //DOCUMENTOS IMPAGOS
                        $('#text_impagos_conyuge').val(respt.impagos_monto_titular);
                        $('#text_impagos_conyuge').attr('readonly','readonly');
                        //PROTESTOS
                        $('#text_protestos_conyuge').val(respt.protestos_monto_titular);
                        $('#text_protestos_conyuge').attr('readonly','readonly');


                        $("#select_registra_deuda_conyuge").val(respt.calificacion_titular).trigger('change');
                        $("#select_registra_deuda_conyuge").select2('enable',false);
                        $("#select_registra_deuda_conyuge").val(respt.calificacion_titular);

                        //Aplicar estilos a las deudas de 24 meses
                        if(respt.calificacion_titular == 'SI') {
                            $('#select2-select_registra_deuda_conyuge-container').css('background-color' , 'red');
                            $('#select2-select_registra_deuda_conyuge-container').css('font-weight' , 'bold');
                            $('#select2-select_registra_deuda_conyuge-container').css('color' , 'white');
                        } else {
                            $('#select2-select_registra_deuda_conyuge-container').css('background-color' , '');
                            $('#select2-select_registra_deuda_conyuge-container').css('font-weight' , '');
                            $('#select2-select_registra_deuda_conyuge-container').css('color' , 'black');
                        }


                        // === PARA VERIFICAR SI TIENE DEUDA CON ENTIDADES
                        if(respt.estado_entidades  == true ) {

                            //ocultar botón para agregar más entidades
                            //$('#addrow_deuda_conyuge').addClass('d-none');

                            var mis_entidades = respt.mis_entidades.SDT_InfCopacEnt;
                            //recorrer entidades

                            //si es array, tiene más de una entidad
                            if( $.isArray(mis_entidades) ) {
                                console.log('soy array');

                                $("#tabla_deuda_conyuge tbody").html('');

                                $.each( mis_entidades, function( key, value ) {
                                    console.log( key + ": " + value );
                                    //console.log(key);
                                    //console.log(value);

                                    var html = '<tr>';
                                    //var cols = "";

                                    html += '<td><input type="text" class="form-control form-control-sm "             required readonly      style="width: 15em;" autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][entidad]"            value="'+ value.Entidad +'" /></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_fechas_nuevo" required readonly style="width: 8em;"  autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][fecha_consulta]" value="'+ value.EntiFechaInf +'" /></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required readonly      style="width: 8em;"  autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][saldo_deuda_consulta]" value="'+ value.EntiSaldo +'" /></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm "             required readonly      style="width: 5em;"  autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][ultima_calificacion]" value="'+ value.EntiUltCal +'"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm "             required readonly      style="width: 5em;"  autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][peor_calificacion]" value="'+ value.EntiPerCal12M +'"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required               style="width: 10em;" autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][saldo_deuda_evaluacion]"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required               style="width: 10em;" autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][cuota_pendiente]"/></td>';
                                    html += '<td><input type="text" class="form-control form-control-sm solo_numeros" required               style="width: 5em;"  autocomplete="off"    name="text_tabla_deuda_conyuge[' + key + '][num_cuotas_pendiente]"/></td>';
                                    //cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                                    //html += '<td> <a class="btn btn-outline-danger  ibtnDel" data-toggle="tooltip" title="Eliminar" href="#/"> <i class="fa fa-trash-o bigger-150"></i> </a>'
                                    html += '<td></td>';
                                    html += '</tr>';
                                    //newRow.append(cols);

                                    $("#tabla_deuda_conyuge").append(html);
                                    //counter++;
                                });

                                calculateTotal_sumatoria_deuda_conyuge();

                            }else {
                                console.log('NO soy array');
                                //No es array, entonces sólo tiene una entidad
                                //Nombre entidad
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][entidad]']").val(mis_entidades.Entidad);
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][entidad]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][entidad]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][fecha_consulta]']").val(mis_entidades.EntiFechaInf);
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][fecha_consulta]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][fecha_consulta]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][saldo_deuda_consulta]']").val(mis_entidades.EntiSaldo);
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][saldo_deuda_consulta]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][saldo_deuda_consulta]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][ultima_calificacion]']").val(mis_entidades.EntiUltCal);
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][ultima_calificacion]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][ultima_calificacion]']").css({'background-color' : '#DFD8D1'});

                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][peor_calificacion]']").val(mis_entidades.EntiPerCal12M);
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][peor_calificacion]']").attr('readonly','readonly');
                                $("input[name='text_tabla_deuda_conyuge["+ 0 +"][peor_calificacion]']").css({'background-color' : '#DFD8D1'});

                                calculateTotal_sumatoria_deuda_conyuge();

                            }
                        }

                    }else if (respt.cod_estado == 3) {
                        console.log('no_encontrado')

                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'error',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Documento inválido(No existe)</center><h3>',
                        }).show();

                        //Volver a habilitar btn buscar
                        $('#btn_buscar_conyuge').removeAttr('disabled');

                    }else {
                        console.log('error al buscar');

                        new Noty({
                            theme: 'bootstrap-v3',
                            type: 'error',
                            progressBar: true,
                            closeWith: ['click', 'button'],
                            layout: 'topCenter',
                            timeout: 3000,
                            text: '<h3><center>Error al consultar WebService COD: ' + respt.cod_estado + ' </center><h3>',
                        }).show();

                        //Volver a habilitar btn buscar
                        $('#btn_buscar_conyuger').removeAttr('disabled');
                    }

                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    //spinner.stop();//detener spin
                },
                complete: function(xhr, ajaxOptions, thrownError) {
                    $('.fa-spin').remove();
                    $('#btn_buscar_conyuge').removeAttr('disabled');
                },

            });
        }//Fin valicación formulario
        else {
            swal("¡Error!", "Verifique DNI de Conyuge", "warning");
        }

    }); //Fin evento boton buscar CONYUGE


    //=== CALCULAR SUMATORIA DE LA TABLA DEUDA SISTEMA FINACIERO (TITULAR) ========

    //Sumatoria de todos los subtotales  de CULTIVO
    function calculateTotal_sumatoria_deuda_titular() {
        var grandTotal = 0;
        $("table#tabla_deuda_titular").find('input[name$="[saldo_deuda_consulta]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_deuda_consulta_titular").html(grandTotal.toFixed(2));
    }

    $("table#tabla_deuda_titular").on("keyup change", 'input[name$="[saldo_deuda_consulta]"] ', function (event) {

        //calcular la sumatoria de todos los subtotales de las filas
        calculateTotal_sumatoria_deudaconsulta_titular();
    });

    $("table#tabla_deuda_titular").on("keyup change", 'input[name$="[saldo_deuda_evaluacion]"] ', function (event) {

        //calcular la sumatoria de todos los subtotales de las filas
        calculateTotal_sumatoria_deudaevaluacion_titular();
    });

    $("table#tabla_deuda_titular").on("keyup change", 'input[name$="[cuota_pendiente]"] ', function (event) {

        //calcular la sumatoria de todos los subtotales de las filas
        calculateTotal_sumatoria_cuotapendiente_titular();
    });

    function calculateTotal_sumatoria_deudaconsulta_titular() {
        var grandTotal = 0;
        $("table#tabla_deuda_titular").find('input[name$="[saldo_deuda_consulta]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_deuda_consulta_titular").html(grandTotal.toFixed(2));
    }

    function calculateTotal_sumatoria_deudaevaluacion_titular() {
        var grandTotal = 0;
        $("table#tabla_deuda_titular").find('input[name$="[saldo_deuda_evaluacion]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_deuda_evaluacion_titular").html(grandTotal.toFixed(2));
    }

    function calculateTotal_sumatoria_cuotapendiente_titular() {
        var grandTotal = 0;
        $("table#tabla_deuda_titular").find('input[name$="[cuota_pendiente]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_cuota_pendiente_titular").html(grandTotal.toFixed(2));
    }


    //=== CALCULAR SUMATORIA DE LA TABLA DEUDA SISTEMA FINACIERO (CONYUGE) ========

    //Sumatoria de todos los subtotales  de CULTIVO
    function calculateTotal_sumatoria_deuda_conyuge() {
        var grandTotal = 0;
        $("table#tabla_deuda_conyuge").find('input[name$="[saldo_deuda_consulta]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_deuda_consulta_conyuge").html(grandTotal.toFixed(2));
    }


    $("table#tabla_deuda_conyuge").on("keyup change", 'input[name$="[saldo_deuda_evaluacion]"] ', function (event) {

        //calcular la sumatoria de todos los subtotales de las filas
        calculateTotal_sumatoria_deudaevaluacion_conyuge();
    });

    $("table#tabla_deuda_conyuge").on("keyup change", 'input[name$="[cuota_pendiente]"] ', function (event) {

        //calcular la sumatoria de todos los subtotales de las filas
        calculateTotal_sumatoria_cuotapendiente_conyuge();
    });


    function calculateTotal_sumatoria_deudaevaluacion_conyuge() {
        var grandTotal = 0;
        $("table#tabla_deuda_conyuge").find('input[name$="[saldo_deuda_evaluacion]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_deuda_evaluacion_conyuge").html(grandTotal.toFixed(2));
    }

    function calculateTotal_sumatoria_cuotapendiente_conyuge() {
        var grandTotal = 0;
        $("table#tabla_deuda_conyuge").find('input[name$="[cuota_pendiente]"]').each(function () {
            grandTotal += +$(this).val();
        });
        console.log(grandTotal);
        $("#sumatoria_cuota_pendiente_conyuge").html(grandTotal.toFixed(2));
    }



});
