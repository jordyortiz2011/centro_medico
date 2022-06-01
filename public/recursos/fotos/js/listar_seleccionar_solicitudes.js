$(document).ready(function () {
    
   //registrar los select2        
  $('#filtrado_agencias').select2({
             //placeholder: 'Select an option',
            // theme: "bootstrap4",
             minimumResultsForSearch: 7, 
   });    
   // $('.select2-container > span').css('width', '100%'); 
    // $('span.select2-selection span.select2-selection__arrow').addClass('hola');
    // $('span.select2-selection span.select2-selection__arrow').css({display: ''}); 
     
     
  
   // $('#controlID').select2({ theme: 'bootstrap' }); 
  //$('#filtrado_tipo_cole').parent().find('.select2-container').css('width', ''); 
   
   
    
	
    // ================== IMPORTANTE =========================================== 
    //llamar a la funcion listar tabla
     listar_tabla();
     
     
  
  
   function listar_tabla () { 
       $('#listado_solicitudes').DataTable({
               destroy : true,   //destruir la tabla y volver a crearla al hacer cambios
                language: lenguajeDatatable, 
                lengthChange : true,  //deshabilita select , para mostrar cantidad de resultados
                processing: true, 
                serverSide: true,                              
                
        	     ajax:{
        		            url : BASE_URL + "fotos/seleccionar/listar_solicitudes_ajax", // json datasource
                             data: {
                                 "id_agencia"   : $('#filtrado_agencias option:selected').val() //para filtrado por defecto
                             },
                            type: "post",  // type of method  , by default would be get
        		            error: function(xhr, ajaxOptions, thrownError){  // error handling code
        		             		 $("#listado_solicitudes").css("display","none");
        		             		 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        	            	 		}		
                    	 } , 
                
                order: [[ 0, "desc" ]] , //ordenar por defecto columna 4 (fecha registro)
        	     
        		 columns: [
                                 { data: 'id_registro' } ,
                                 { data: 'dni' } ,
        						{ data: 'nombres' } ,  
        						{ data: 'apellidos' } ,
                                //estado
                                 { data: null, orderable: false   ,render: function ( data, type, row ) {

                                         if(data.estado == 1) {
                                             // return 'en proceso';
                                             return  '<a href="#" class="badge  badge-warning">En proceso</a>';
                                         }else if (data.estado == 2){
                                             return '<span class="badge badge-success">Apta</span>';
                                         }else if (data.estado == 3){
                                             return '<span class="badge badge-danger">Rechazada</span>';
                                         }else{
                                             return 'Solicitud sin estado';
                                         }
                                     },
                                 },

                            { data: 'agencia' } ,


                             {
                                 data: null, orderable: false, render: function (data, type, row) {

                                     // Opciones de la tabla
                                     options = "<div class='action-buttons' id='" + data.id_registro + "' + > ";
                                     options += "<a class='btn btn-outline-info' href='" + BASE_URL + "fotos/nueva/form_nueva/" + data.id_registro + "'";
                                     options += " data-toggle='tooltip' title='Seleccionar'>";
                                     options += "<i class=' fa fa-share bigger-150'></i>";
                                     options += "</a> &nbsp;";

                                     if (data.id_estado == 1) {
                                         options += "<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>";
                                         options += "<i class='fa fa-trash-o bigger-150'></i>";
                                         options += "</a>";
                                     }


                                     options += "</div>";

                                     return options;
                                 }
                             },
                             //Columnas ocultas
                             { data: 'id_estado' , bVisible: false,}

        		          ] ,//fin columnas
        		          
        		fnDrawCallback: function( oSettings ) {     		          
            		          
                                $('div.dataTables_length select').removeClass("form-control-sm");
                            }
        	 }); //fin de datatable
        	 
        	 //remover select 
        	 
                            	 
     }; //fin de funcion listar tabla;
	 
          //PARA LOS FILTRADOS DE LA TABLA
// ================== Filtrado ==================================    
     
     //configuraciones para el filtrado 
     
          
        
      //Columna no visible  
      $('#filtrado_agencias').on('change', function (evt) {
           console.log( this.value );    
           /*oTable = $('#listado_solicitudes').DataTable();
           oTable.columns(7).search(this.value);
           oTable.draw(); */
           listar_tabla();
        });
        
   

	 
	    //PARA ELIMINAR DESDE LA TABLA
    /***********--DELETE--***************/
    $("#listado_solicitudes").on('click', 'a.delete',function(e)
    {
      e.preventDefault();

       id =  $(this).parent().attr('id'); 
       dataString = 'id='+ id;
       var b=$(this).parent().parent().parent();
        
       //alert(id); exit;
        
       swal({
              title: "¿Estás seguro que deseas eliminar esta Solicitud?",
              text: "No podrá recuperar el registro",
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
                    url: BASE_URL + "solicitud/listar/eliminar_solicitud_fisico/"+id ,
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
    });
	 

	
});//fin document
