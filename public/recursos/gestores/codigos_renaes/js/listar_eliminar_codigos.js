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
       $('#listado_codigos').DataTable({
               destroy : true,   //destruir la tabla y volver a crearla al hacer cambios
                language: lenguajeDatatable, 
                lengthChange : true,  //deshabilita select , para mostrar cantidad de resultados
               // processing: true, 
                serverSide: true,                              
                
        	     ajax:{
        		            url : BASE_URL + "gestores/codigos_renaes/listar/listar_codigos_ajax", // json datasource
        		            type: "post",  // type of method  , by default would be get
        		            error: function(xhr, ajaxOptions, thrownError){  // error handling code
        		             		 $("#listado_codigos").css("display","none");
        		             		 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        	            	 		}		
                    	 } , 
                
                order: [[ 0, "asc" ]] , //ordenar por defecto columna 4 (fecha registro)   	 
        	     
        		 columns: [
        						{ data: 'cod_renaes_codren' } ,
                                { data: 'micro_red_codren' } ,
        						{ data: {
                                        _:    "fecha_registro.mostrar_fecha",
                                        sort: "fecha_registro.ordenar_fecha"
                                        }       
                                } ,    
                                    					
        	                    { data: null, orderable: false ,render: function ( data, type, row ) {
        				                
        				                 // Opciones de la tabla                                                
                                            return "<div class='action-buttons' id='" + data.id_registro  + "' + > "+                                                    
                                                     "<a class='btn btn-outline-info' href='"+  BASE_URL+ "gestores/codigos_renaes/editar/form_editar/" + data.id_registro +"'"+
                                                      " data-toggle='tooltip' title='Editar'>"+
                                                         "<i class=' fa fa-pencil bigger-150'></i>"+
                                                    "</a> &nbsp;"+                                                                                          
                                                    "<a class='btn btn-outline-danger  delete ' data-toggle='tooltip' title='Eliminar' href='#'>"+
                                                        "<i class='fa fa-trash-o bigger-150'></i>"+
                                                    "</a>"+
                                               
                                            "</div>" ;                 			
        				                },
        	                   }
        		          ] ,
        		          
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
      $('#filtrado_tipo_cole').on('change', function (evt) {
          console.log( this.value );    
           oTable = $('#listado_colegios').DataTable();            
           oTable.columns(1).search(this.value);
           oTable.draw();
        });
        
   

	 
	    //PARA ELIMINAR DESDE LA TABLA
    /***********--DELETE--***************/
    $("#listado_codigos").on('click', 'a.delete',function(e)
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
                    url: BASE_URL + "gestores/codigos_renaes/listar/eliminar_registro_fisico/"+id ,
                    data: dataString,
                    cache: false,
                    success: function(e)
                    {
                        console.log(e);
                        
                         switch (String(e) ) {  
                             
                             case 'eliminar_ok':                                   
                                   swal("¡Eliminado!", "Registro Eliminado.", "success"); break;
                             case 'registro_usado' :
                                    swal("¡No se puede eliminar!", "El registro está siendo usado.", "error");break;
                             case 'eliminar_error' : 
                                    swal("¡Cancelado!", "Error al eliminar", "error"); break;
                             default:
                                    swal("¡Cancelado!", "Error al eliminar", "error"); break;
                          } 
                        
                                             
                        
                         listar_tabla();
                      
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            swal("¡Cancelado!", "registro no fue eliminado", "error");
                            
                    }
                   });
          //return false;
               
              } else {
                     swal("¡Cancelado!", "registro no fue eliminado", "error");
              }
            });
    });
	 

	
});//fin document
