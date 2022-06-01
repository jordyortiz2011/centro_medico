$(document).ready(function () {
    
   //registrar los select2        
  $('.select2').select2({
      //placeholder: 'Select an option',
      // theme: "bootstrap4",
      minimumResultsForSearch: 7,
   });    

	
    // ================== IMPORTANTE =========================================== 
    //llamar a la funcion listar tabla
     listar_tabla();

  
   function listar_tabla () { 
       $('#listado_portadas').DataTable({
                destroy : true,   //destruir la tabla y volver a crearla al hacer cambios
                language: lenguajeDatatable, 
                lengthChange : true,  //para mostrar <SELECT> cantidad de resultados
                processing: true, 
                serverSide: true,                              
                
        	     ajax:{
        		            url : BASE_URL + "sistema/pag_inicio/portada/listar/listar_portadas_ajax", // json datasource
        		            type: "post",  // type of method  , by default would be get
        		            error: function(xhr, ajaxOptions, thrownError){  // error handling code
        		             		 $("#listado_portadas").css("display","none");
        		             		 console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        	            	 		}		
                    	 } , 
                
                  order: [[ 0, "asc" ]] , //ordenar por defecto columna 4 (fecha registro)   	 
        	     
        		 columns: [
        						{ data: 'prioridad' } ,	
        						{ data: 'tipo' } ,        						
        					    { data: 'titulo' , orderable: false    } ,
                                //PARA LA CELDA DE IMAGEN
        					    { data: null, orderable: false   ,render: function ( data, type, row ) {
                                                                              
                                            if(data.id_tipo == 1 ) {
                                                return '<img src="' + BASE_URL + 'public/img/fotos_portada/'+ data.imagen  +'" width="70px" height="50px" />';  
                                            } else {
                                                return ' ';
                                            }                                           
                                                                               
                                        },
                                },   						                          
                                { data: {
                                        _:    "fecha_registro.mostrar_fecha",
                                        sort: "fecha_registro.ordenar_fecha"
                                        }       
                                } ,       					    
        					    { data: null, orderable: false   ,render: function ( data, type, row ) {
                                                                                 
                                               if(data.estado == 1) {
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
                                                     "<a class='btn btn-outline-info' href='"+  BASE_URL+ "sistema/pag_inicio/portada/editar/form_editar/" + data.id_registro +"'"+
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
      $('#filtrado_tipo_portada').on('change', function (evt) {
           console.log( this.value );    
           oTable = $('#listado_portadas').DataTable();            
           oTable.columns(1).search(this.value);
           oTable.draw();
        });
        
   

	 
	    //PARA ELIMINAR DESDE LA TABLA
    /***********--DELETE--***************/
    $("#listado_portadas").on('click', 'a.delete',function(e)
    {
      e.preventDefault();

       id =  $(this).parent().attr('id'); 
       dataString = 'id='+ id;
       var b=$(this).parent().parent().parent();
        
       //alert(id); exit;
        
       swal({
              title: "¿Estás seguro que deseas eliminar esta Portada?",
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
                    url: BASE_URL + "sistema/pag_inicio/portada/listar/eliminar_portada/"+id ,
                    data: dataString,
                    cache: false,
                    success: function(e)
                    {
                        console.log(e);
                        
                         switch (String(e) ) {  
                             
                             case 'ok_eliminado':                                   
                                   swal("¡Eliminado!", "Registro Eliminado.", "success"); break;                           
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
