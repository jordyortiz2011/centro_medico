$(document).ready(function(){

    //registrar los select2
    $('#select_departamentos, #select_provincias, #select_distritos').select2({
        //placeholder: 'Select an option',
        minimumResultsForSearch: 7,
        width: '100%',
        allowClear: true
    });

    // ====== Al cambiar select DEPARTAMENTOS, poblar select PROVINCIAS ==================
    $('#select_departamentos').on('change', function (evt) {

        console.log( this.value );

        //capturar valores del select CICLOS
        var id_departamento    =  this.value;
        var dataString  = 'id_departamento='+ id_departamento;

        //eliminar datos del select TURNOS y AULAS,  y colocar mensaje con valor Vacío
        let select_defecto = '<option value=""> Seleccione </option> ';
        $('#select_provincias').html(select_defecto);
        $('#select_distritos').html(select_defecto);

        //agregar animacion , SPIN
        var target = document.getElementById("contenedor_select_provincias");
        var spinner = new Spinner(SPIN_OPT2).spin(target);
        //agregar animacion , SPIN
        var target2 = document.getElementById("contenedor_select_distritos");
        var spinner2 = new Spinner(SPIN_OPT2).spin(target2);

        $.ajax({
            type: "POST",
            url: BASE_URL + "solicitud/consultas_ajax/combobox_provincias_ajax" ,
            data: dataString,
            dataType : 'json',
            cache: false,
            success: function(respt)
            {
                console.log(respt);


                let html = ''; //variable para el select
                html += '<option value=""> Seleccione </option> ';
                $.each(respt.lst_provincias , function(clave, valor) {
                    //console.log('clave: ' + clave + ' -  Valor: '+valor + ' pago:' + valor.id_cicloturno  );
                    html += '<option value="' + valor.idProv + '">' +   valor.provincia + '</option> ';
                });
                //console.log(html);

                $('#select_provincias').html(html);//poblar el select

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

        spinner.stop();//detener spin
        spinner2.stop();//detener spin

    });


    //Al cambiar select PROVINCIAS, poblar select DISTRITOS
    $('#select_provincias').on('change', function (evt) {

        console.log( this.value );

        //capturar valores del select CICLOS
        //var id_departamento    =  $('#select_departamentos option:selected').val() ;
        var id_provincia    =  this.value;
        var dataString  = 'id_provincia='+ id_provincia  ;
        //console.log(dataString) ;

        //eliminar datos del select  AULAS,  y colocar mensaje para seleccionar
        let select_defecto = '<option value=""> Seleccione </option> ';
        $('#select_distritos').html(select_defecto);

        //Spin para Distritos
        var target2 = document.getElementById("contenedor_select_distritos");
        var spinner2 = new Spinner(SPIN_OPT2).spin(target2);


        $.ajax({
            type: "POST",
            url: BASE_URL + "solicitud/consultas_ajax/combobox_distritos_ajax" ,
            data: dataString,
            dataType : 'json',
            cache: false,
            success: function(respt)
            {
                //console.log(respt);
                let html = ''; //variable para el select
                html += '<option value=""> Seleccione </option> ';
                $.each(respt.lst_distritos , function(clave, valor) {
                    //console.log('clave: ' + clave + ' -  Valor: '+valor + ' id:' + valor.id_cicloaula  );
                    html += '<option value="' + valor.idDist + '">' +   valor.distrito + '</option> ';
                });
                //console.log(html);

                $('#select_distritos').html(html);//poblar el select

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        //Detener Spin
        spinner2.stop();

    });

});