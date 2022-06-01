$(document).ready(function () {
    
   //registrar los select2        
  $('#filtrado_tipo_cole').select2({
             //placeholder: 'Select an option',
             theme: "bootstrap4",
             minimumResultsForSearch: 7, 
   });    
   $('.select2-container > span').css('width', '100%');


    // ====== Al cambiar select CICLOS, poblar select TURNO ==================
    $('#filtrado_ciclo').on('change', function (evt) {
        console.log( this.value );

        //capturar valores del select CICLOS
        var id_ciclo    =  this.value;
        var dataString  = 'id_ciclo='+ id_ciclo;

        //eliminar datos del select TURNOS y AULAS,  y colocar mensaje con valor Vacío
        let select_defecto = '<option value=""> Todos </option> ';
        $('#filtrado_turno').html(select_defecto);
        $('#filtrado_aula').html(select_defecto);

        //agregar animacion , SPIN
        var target = document.getElementById("contenedor_select_turnos");
        var spinner = new Spinner(SPIN_OPT2).spin(target);
        //agregar animacion , SPIN
        var target2 = document.getElementById("contenedor_select_aulas");
        var spinner2 = new Spinner(SPIN_OPT2).spin(target2);

        $.ajax({
            type: "POST",
            url: BASE_URL + "matricula/consultas_ajax/combobox_turnos_ajax" ,
            data: dataString,
            dataType : 'json',
            cache: false,
            success: function(respt)
            {
                //console.log(respt);
                spinner.stop();//detener spin
                spinner2.stop();//detener spin

                let html = ''; //variable para el select
                html += '<option value=""> Todos </option> ';
                $.each(respt.turnos , function(clave, valor) {
                    //console.log('clave: ' + clave + ' -  Valor: '+valor + ' pago:' + valor.id_cicloturno  );
                    html += '<option value="' + valor.id_cicloturno + '">' +   valor.descripcion_cicloturno + '</option> ';
                });
                //console.log(html);

                $('#filtrado_turno').html(html);//poblar el select

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });

        spinner.stop();//detener spin
        spinner2.stop();//detener spin

    });


    //Al cambiar select TURNO, poblar select AULA
    $('#filtrado_turno').on('change', function (evt) {

        console.log( this.value );

        //capturar valores del select CICLOS
        var id_ciclo    =  $('#filtrado_ciclo option:selected').val() ;
        var id_turno    =  this.value;
        var dataString  = 'id_ciclo='+ id_ciclo + '&id_turno=' + id_turno ;
        //console.log(dataString) ;

        //eliminar datos del select  AULAS,  y colocar mensaje para seleccionar
        let select_defecto = '<option value=""> Seleccione </option> ';
        $('#filtrado_aula').html(select_defecto);

        //Spin para aulas
        var target2 = document.getElementById("contenedor_select_aulas");
        var spinner2 = new Spinner(SPIN_OPT2).spin(target2);


        $.ajax({
            type: "POST",
            url: BASE_URL + "matricula/consultas_ajax/combobox_aulas_ajax" ,
            data: dataString,
            dataType : 'json',
            cache: false,
            success: function(respt)
            {
                //console.log(respt);
                spinner2.stop();//detener spin

                let html = ''; //variable para el select
                html += '<option value=""> Seleccione </option> ';
                $.each(respt.aulas , function(clave, valor) {
                    //console.log('clave: ' + clave + ' -  Valor: '+valor + ' id:' + valor.id_cicloaula  );
                    html += '<option value="' + valor.id_cicloaula + '">' +   valor.nombre_aula_cicloaula + '</option> ';
                });
                //console.log(html);

                $('#filtrado_aula').html(html);//poblar el select

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
        spinner2.stop();

    });


   
   
    
	
    // ================== IMPORTANTE =========================================== 
    //llamar a la funcion listar tabla
     listar_tabla();

  
  
   function listar_tabla () { 
       $('#listado_matriculas').DataTable({
               destroy : true,   //destruir la tabla y volver a crearla al hacer cambios
                language: lenguajeDatatable, 
                lengthChange : true,  //deshabilita select , para mostrar cantidad de resultados
               // processing: true, 
                serverSide: true,                              
                
        	     ajax:{
        		            url : BASE_URL + "pagos/listar_situacion/listar_situacion_ajax", // json datasource
                             data: {
                                 "id_situacion"  : $('#filtrado_situacion option:selected').val(),
                                 "id_ciclo"  : $('#filtrado_ciclo option:selected').val(),
                                 "id_turno"  : $('#filtrado_turno option:selected').val(),
                                 "id_aula"   : $('#filtrado_aula option:selected').val()
                             },
        		            type: "post",  // type of method  , by default would be get
        		            error: function(xhr, ajaxOptions, thrownError){  // error handling code
        		             		 $("#listado_matriculas").css("display","none");
        		             		 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        	            	 		}		
                    	 } , 
                
                order: [[ 1, "asc" ]] , //ordenar por defecto columna 4 (fecha registro)
        	     
        		 columns: [
                                { data: 'id_registro' ,orderable: false , bVisible: false } ,
        						{ data: 'codigo' } ,
                                 //situacion
                                 { data: null, orderable: false   ,render: function ( data, type, row ) {

                                         if(data.total_pagar == data.total_importe) {
                                             // return 'Cancelado';
                                             return  '<a href="#" class="badge  badge-success">Cancelado</a>';
                                         }else if (data.total_pagar > data.total_importe){
                                             return '<span class="badge badge-danger">Debe</span>';
                                         }else{
                                             return 'Sin estado';
                                         }
                                     },
                                 },
                                { data: 'estudiante' } ,
                                { data: 'turno' } ,
        						{ data: 'aula' } ,
                                { data: 'modalidad_pago' } ,
                                { data: 'total_pagar' , orderable: false } ,
                                { data: 'total_importe' , orderable: false  } ,
                                { data: 'saldo' ,orderable: false  } ,



        		          ] ,
        		          
        		fnDrawCallback: function( oSettings ) {     		          
            		          
                                $('div.dataTables_length select').removeClass("form-control-sm");
                            }
        	 }); //fin de datatable
        	 
        	 //remover select 
        	 
                            	 
     }; //fin de funcion listar tabla;
	 
          //PARA LOS FILTRADOS DE LA TABLA
// ================== Filtrado ==================================
  // configuraciones para el filtrado
  //Columna no visible
  $('#filtrado_situacion, #filtrado_ciclo , #filtrado_turno , #filtrado_aula').on('change', function (evt) {
        //console.log( this.value );
        //oTable = $('#listado_matriculas').DataTable();
        // oTable.columns(7).search(this.value);
        //oTable.draw();
      listar_tabla();
    });


// ================== EXPORTAR  ==================================

    // Handle form submission event
    $('#btn_exportar_excel_situacion').on('click', function(e){

        //Capturar los parametros
        search      =   $('input[aria-controls^=listado_matriculas]').val() ;//cadena de busqueda de datatable

        id_situacion    =   $('#filtrado_situacion option:selected').val(); //filtro select
        id_ciclo        =   $('#filtrado_ciclo option:selected').val(); //filtro select
        id_turno        =   $('#filtrado_turno option:selected').val(); //filtro select
        id_cicloaula    =   $('#filtrado_aula option:selected').val(); //filtro select

        //si falta  algún filtro, mostrar mensaje y NO EXPORTAR
        /*if( id_ciclo == '' || id_turno == '' || id_cicloaula == '' ) {
            swal( 'Seleccione filtro para  exportar','', "info");
            return false;
        }*/

        //Crear formulario por Jquery
        form = $('<form></form>').attr('action',BASE_URL + "pagos/exportar_situacion/excel_situacion_estudiantes"  ).attr('method', 'post');

        // CREAR CAMPOS OCULTOS
        //para id ciclo
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'search')
            .val(search)
        );

        //para id ciclo
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'id_situacion')
            .val(id_situacion)
        );

        //para id ciclo
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'id_ciclo')
            .val(id_ciclo)
        );
        //para id turno
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'id_turno')
            .val(id_turno)
        );
        //para id cicloaula
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'id_cicloaula')
            .val(id_cicloaula)
        );

        //capturar los parametros de tipo de ordenamiento y columna del dataTable
        oTable = $('#listado_matriculas').DataTable();
        order = oTable.order(); //ordenamiento actual de la tabla

        ord_col = order[0][0] ; //columna del ordenamiento
        ord_dir = order[0][1] ; //dirección del ordenamiento

        //para la columna a aplicar el ordanamiento
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'order')
            .val(ord_col)
        );
        //para la direccion (ASC o DESC)
        $(form).append($('<input>').attr('type', 'text')
            .attr('name', 'dir')
            .val(ord_dir)
        );



        form.appendTo('body').submit().remove();
    });




	 

	
});//fin document
