$(document).ready(function () {
    
   //registrar los select2        
  $('.select2').select2({
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
       $('#listado_usuarios').DataTable({
               destroy : true,   //destruir la tabla y volver a crearla al hacer cambios
                language: lenguajeDatatable, 
                lengthChange : true,  //deshabilita select , para mostrar cantidad de resultados
                processing: true, 
                serverSide: true,                              
                
        	     ajax:{
        		            url : BASE_URL + "sistema/usuarios/listar/listar_usuarios_ajax", // json datasource
        		            type: "post",  // type of method  , by default would be get
        		            error: function(xhr, ajaxOptions, thrownError){  // error handling code
        		             		 $("#listado_empleados").css("display","none");
        		             		 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        	            	 		}		
                    	 } , 
                
                order: [[ 0, "asc" ]] , //ordenar por defecto columna 4 (fecha registro)   	 
        	     
        		 columns: [
        						{ data: 'usuario' } ,	        						
        						{ data: null, orderable: false   ,render: function ( data, type, row ) {
                                                                                 
                                                return  "<a onClick='javascript:window.open(\"mailto:"+ data.correo +"\", \"mail\");" + 
                                                "event.preventDefault()' href='mailto:"+ data.correo +"' > "+ data.correo +      
                                                " </a>";                                     
                                        },
                                },        						                          
                                { data: {
                                        _:    "ultimo_logeo.mostrar_fecha",
                                        sort: "ultimo_logeo.ordenar_fecha"
                                        }       
                                } ,        					
        					    { data: 'tipo' } , 
        					    
        					    { data: null, orderable: false   ,render: function ( data, type, row ) {
                                                                                 
                                               if(data.banned == 0) {
                                                  // return 'Activo';
                                                  return  '<a href="#" class="badge badge-primary">Activo</a>';
                                               }else{
                                                   return '<span class="badge badge-warning">Inactivo</span>';
                                               }                                    
                                        },
                                },   
                                    					
        	                    { data: null, orderable: false ,render: function ( data, type, row ) {
        				                
        				                 // Opciones de la tabla                                                
                                            return "<div class='action-buttons' id='" + data.id_registro  + "' + > "+                                                    
                                                     "<a class='btn btn-outline-info' href='"+  BASE_URL+ "sistema/usuarios/editar/form_editar/" + data.id_registro +"'"+ 
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
      $('#filtrado_tipo_usuario').on('change', function (evt) {
           console.log( this.value );    
           oTable = $('#listado_usuarios').DataTable();            
           oTable.columns(3).search(this.value);
           oTable.draw();
        });
        
   

	 
	    //PARA ELIMINAR DESDE LA TABLA
    /***********--DELETE--***************/
    $("#listado_usuarios").on('click', 'a.delete',function(e)
    {
      e.preventDefault();

       id =  $(this).parent().attr('id'); 
       dataString = 'id='+ id;
       var b=$(this).parent().parent().parent();
        
       //alert(id); exit;
        
       swal({
              title: "¿Estás seguro que deseas eliminar este Usuario?",
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
                    url: BASE_URL + "sistema/usuarios/listar/eliminar_usuario/"+id ,
                    data: dataString,
                    cache: false,
                    success: function(e)
                    {
                        console.log(e);
                        
                         switch (String(e) ) {  
                             
                             case 'ok_eliminado':                                   
                                   swal("¡Eliminado!", "Registro Eliminado.", "success"); break;
                             case 'auto_eliminado' :
                                    swal("¡Error!", "No puedes eliminarte a ti mismo ", "error");break;
                             case 'error_eliminado' : 
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
