<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_agregar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Guarda registro en en la BD   
     * @param  $datos(array): datos POST del formulario, 	
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */     

    public function guardar_portada($post )
    {
        //fecha del registro
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');
	   
	    //usuario que está realizando el registro               
        $this->load->model('reutilizables/Model_usuarios');
		$usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);					
		
        
        $datos = array(
         		'tipo_porta'    		=> $post['select_tipo_portada'], 
                'titulo_porta'   		=> $post['txt_titulo'], 
                'descrip_porta'  		=> $post['txt_descripcion'], 
                'prioridad_porta'  		=> $post['txt_prioridad'], 
                'foto_porta'  			=> $post['nombre_foto'],   //nombre de la foto                 
                'color_texto'			=> $post['txt_color_texto'],
                'color_fondo'			=> $post['txt_color_fondo'],
                              
				'estado_porta'  		=> $post['checkbox_estado'], 
				    
                
				//meta datos
                'fecha_registro_porta' 	=> $fecha_registro,               
				'user_registro_porta'	=> $usuario_registrador,
                
        );
        
                    
        $res = $this->db->insert('tbl_portadas' , $datos);         
        if (!$res)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           if( $this->db->affected_rows() == 1 )
		   		 //$id_registro = $this->db->insert_id(); //el número de id insertado
                 //return $id_registro;
                 return true;
        }
        
        return false;            
    }  

  
  /**
 * Actualiza datos del registro
 * @param  $id_registro: Id del registro  $post(array): datos de la membresia
 * @return (bool) estado de la actualizacion
 *  */ 	
	
	public function insertar_nombre_foto($id_registro,$nombre_foto)
    {
    	
		//print_r($post); exit;      	
		  $data = array(
         				'foto_emplea'    		=> $nombre_foto,                		                
       			 		);
		
				        
        $query = $this->db->where('id_emplea' , $id_registro)
        				  ->update('tbl_empleados',$data ) ;
						  
		//echo $this->db->get_compiled_update(); exit;
		if (!$query)
		{
		  $error = $this->db->error(); // Has keys 'code' and 'message'
		  echo  $error[message] . 'Error! no se actualizó Registro';
		  return FALSE ;
		}else  {
			$res =  $this->db->affected_rows() == 1 ?  TRUE : FALSE;
			return $res;		
		} 
                
		
		return $result;	            
    } 
	   
        

}