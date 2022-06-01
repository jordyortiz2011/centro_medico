<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_nueva extends CI_Model {
   
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

    public function guardar_estimacion($post )
    {
        //fecha del registro
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');
	   
	    //usuario que está realizando el registro               
        $this->load->model('reutilizables/Model_usuarios');
		$usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador($this->auth_user_id);					
		
        
        $datos = array(
         		'id_solicitud_esti'    	=> $post['id_solicitud'],
                'id_matriz_esti'    	=> $post['id_matriz'],
                'variedad'        		=> $post['select_variedad'],
                'a_area_cultivada'  	=> $post['a_area_cultivada'], 
                'b_densidad_siembra'  	=> $post['b_densidad_siembra'], 
                'c_num_plantas'  	    => $post['c_num_plantas'], 
                'd_num_mazorcas'  	    => $post['d_num_mazorcas'],                 
				'e_num_semillas'  		=> $post['e_num_semillas'], 
				'f_peso_semilla'   		=> $post['f_peso_semilla'], 
				'g_kg_plantas'   		=> $post['g_kg_plantas'], 
				'h_conversion_baba'     => $post['h_conversion_baba'], 
				'i_kg_xplanta'  		=> $post['i_kg_xplanta'], 
				'j_kg_hectarea'  	    => $post['j_kg_hectarea'],
				'k_porcentaje_pe'  		=> $post['k_porcentaje_pe'],
				'l_precio_kg'  	        => $post['l_precio_kg'], 
		     	'venta'   		        => $post['venta'], 
				'costo_produccion'   	=> $post['costo_produccion'], 
				'utilidad_bruta'        => $post['utilidad_bruta'], 
				'canasta_basica'  		=> $post['canasta_basica'],
                'canasta_basica_alimentacion'  		=> $post['txt_canasta_alimentacion'],
                'canasta_basica_educacion'  		=> $post['txt_canasta_educación'],
                'canasta_basica_servicios'  		=> $post['txt_canasta_servicios'],
                'canasta_basica_imprevistos'  		=> $post['txt_canasta_imprevistos'],


                'utilidad_neta'  	    => $post['utilidad_neta'],
				'rendimiento_historico' => $post['rendimiento_historico'],
				'analisis_comparativo'  => $post['analisis_comparativo'],
				
							              
                
				//meta datos
                'fecha_registro_esti'   	=> $fecha_registro,               
				'user_registro_esti'	    => $usuario_registrador,
                
        );
        
                    
        $res = $this->db->insert('tbl_estimaciones' , $datos);         
        if (!$res)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           if( $this->db->affected_rows() == 1 )
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