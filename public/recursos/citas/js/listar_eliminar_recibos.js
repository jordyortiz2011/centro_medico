$( document ).on( "focus",  "#filtrado_tipo_cole", function() {
    
     alert('hola');
});

$(document).ready(function () {
    
   //registrar los select2        
  $('#filtrado_tipo_cole').select2({
             //placeholder: 'Select an option',
             theme: "bootstrap4",
             minimumResultsForSearch: 7, 
   });    
   $('.select2-container > span').css('width', '100%'); 
    // $('span.select2-selection span.select2-selection__arrow').addClass('hola');
    // $('span.select2-selection span.select2-selection__arrow').css({display: ''}); 
     
     
  
   // $('#controlID').select2({ theme: 'bootstrap' }); 
  //$('#filtrado_tipo_cole').parent().find('.select2-container').css('width', ''); 
   
   
    
	
    // ================== IMPORTANTE =========================================== 
    //llamar a la funcion listar tabla
     listar_tabla();


   function listar_tabla () { 
       $('#listado_recibos').DataTable({
               destroy : true,   //destruir la tabla y volver a crearla al hacer cambios
                language: lenguajeDatatable, 
                lengthChange : true,  //deshabilita select , para mostrar cantidad de resultados
               // processing: true, 
                serverSide: true,                              
                
        	     ajax:{
        		            url : BASE_URL + "pagos/listar_recibos/listar_recibos_ajax", // json datasource
        		            type: "post",  // type of method  , by default would be get
                            data: {
                             "ciclo_defecto" : $('#filtrado_ciclo option:selected').val() //para filtrado por defecto
                            },
        		            error: function(xhr, ajaxOptions, thrownError){  // error handling code
        		             		 $("#listado_recibos").css("display","none");
        		             		 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        	            	 		}		
                    	 } , 
                
                order: [[ 0, "desc" ]] , //ordenar por defecto columna 4 (fecha registro)
        	     
        		 columns: [
                                { data: 'id_registro' ,orderable: false , bVisible: false } ,
                                { data: 'cod_matricula' } ,
                                { data: 'estudiante' } ,
                                { data: 'dni' } ,
        						{ data: 'num_recibo' } ,
                                { data: 'monto_recibo' } ,
                                { data: 'fecha_recibo' } ,

        						{ data: {
                                        _:    "fecha_registro.mostrar_fecha",
                                        sort: "fecha_registro.ordenar_fecha"
                                        }       
                                } ,    
                                    					
        	                    { data: null, orderable: false ,render: function ( data, type, row ) {
        				                
        				                 // Opciones de la tabla                                                
                                            return "<div class='action-buttons' id='" + data.id_registro  + "' + > "+                                                  

                                                    "&nbsp;<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>"+
                                                        "<i class='fa fa-trash-o bigger-150'></i>"+
                                                    "</a>"+
                                               
                                            "</div>" ;                 			
        				                },
        	                   },

                                //campos ocultos para filtrado
                                { data: 'id_ciclo' , orderable: false , bVisible: false} ,

        		          ] ,
        		          
        		fnDrawCallback: function( oSettings ) {     		          
            		          
                                $('div.dataTables_length select').removeClass("form-control-sm");
                            }
        	 }); //fin de datatable
        	 
        	 //remover select 
        	 
                            	 
     }; //fin de funcion listar tabla;
	 
          //PARA LOS FILTRADOS DE LA TABLA
// ================== Filtrado ==================================    
     

        
      //Columna no visible  
      $('#filtrado_ciclo').on('change', function (evt) {
          console.log( this.value );    
           oTable = $('#listado_recibos').DataTable();
           oTable.columns(8).search(this.value);
           oTable.draw();
        });
        
   

	 
	    //PARA ELIMINAR DESDE LA TABLA
    /***********--DELETE--***************/
    $("#listado_recibos").on('click', 'a.delete',function(e)
    {
      e.preventDefault();

       id =  $(this).parent().attr('id'); 
       dataString = 'id='+ id;
       var b=$(this).parent().parent().parent();
        
       //alert(id); exit;
        
       swal({
              title: "¿Estás seguro que deseas eliminar este registro?",
              text: "Se eliminará de forma permanente",
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
                    url: BASE_URL + "pagos/listar_recibos/eliminar_matricula_fisico/"+id ,
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
                        
                                             
                        
                         listar_tabla();
                      
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
    }); //Fin eliminar

    //PARA Exportar a Excel con parametros actuales
// ================== EXPORTAR  ==================================
    $("#btn_exportar_excel").on("click", function (e) {
        e.preventDefault();

        search      =   $('input[aria-controls^=listado_recibos]').val() ;//cadena de busqueda
        search      =  search == '' ? "_vacio_" : search; //si es vacio asiganar string, para pasar por URL

        id_ciclo    =   $('#filtrado_ciclo option:selected').val(); //filtro select



        oTable = $('#listado_recibos').DataTable();

        order = oTable.order(); //ordenamiento actual de la tabla

        console.log(typeof(order));
        console.log(order);

        ord_col = order[0][0] ; //columna del ordenamiento
        ord_dir = order[0][1] ; //dirección del ordenamiento

        //console.log(check_cena);

        let parametros  = search + '/' + id_ciclo+ '/'+ ord_col+ '/'+ord_dir ;
        console.log(parametros);

        window.open(BASE_URL + 'pagos/Exportar_recibos/exportar_listado_recibos_excel/' + parametros  , '_blank');


    }) ;

    $("#btn_exportar_pdf").on("click", function (e) {
        e.preventDefault();

        search      =   $('input[aria-controls^=listado_recibos]').val() ;//cadena de busqueda
        search      =  search == '' ? "_vacio_" : search; //si es vacio asiganar string, para pasar por URL

        id_ciclo    =   $('#filtrado_ciclo option:selected').val(); //filtro select



        oTable = $('#listado_recibos').DataTable();

        order = oTable.order(); //ordenamiento actual de la tabla

        console.log(typeof(order));
        console.log(order);

        ord_col = order[0][0] ; //columna del ordenamiento
        ord_dir = order[0][1] ; //dirección del ordenamiento

        //console.log(check_cena);

        let parametros  = search + '/' + id_ciclo+ '/'+ ord_col+ '/'+ord_dir ;
        console.log(parametros);

        window.open(BASE_URL + 'pagos/Exportar_recibos/exportar_listado_recibos_pdf/' + parametros  , '_blank');


    }) ;



});//fin document
