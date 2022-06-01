<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_editar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene un registro , de acuerdo a su id     
     * @param  (int)id_registro
     * @return (Objeto) todos los datos correspondientes al registro
     *  */     

    public function obtener_portada($id_registro)
    {            
        $query = $this
	            ->db	
	            //->select("")          
	            ->from('tbl_portadas')
				->where('id_porta =',  $id_registro);
		
		//ejectua la consulta
		$query = $this->db->get();	
					        
        if (!$query)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
           return $query->row();
        }          
    }  
    

	
	
   /**
 * Actualiza datos del registro
 * @param  $id_registro: Id del registro  $post(array): datos de la membresia
 * @return (bool) estado de la actualizacion
 *  */ 	
	
	public function editar_empleado($id_registro,$datos)
    {
    	
		//print_r($post); exit;   
       	
		  $data = array(
         		'dni_emplea'    		=> $datos['txt_dni'], 
                'nombres_emplea'   		=> $datos['txt_nombres'], 
                'apellido_pat_emplea'  	=> $datos['txt_apellido_pat'], 
                'apellido_mat_emplea'  	=> $datos['txt_apellido_mat'], 
                'fecha_naci_emplea'  	=> $datos['txt_fecha_naci'],                 
				'sexo_emplea'  			=> $datos['radio_sexo'], 
				'foto_emplea'   		=> $datos['nombre_foto'],//Sólo nombre de la foto
				'correo_emplea'   		=> $datos['txt_correo'], 
				'telefono_emplea'  		=> $datos['txt_telefono'], 
				'celular_emplea'  		=> $datos['txt_celular'], 
				'direccion_emplea'  	=> $datos['txt_direccion'],
				'id_tipo_emplea'  		=> $datos['select_tipo_emplea'],//1=Regular | 2=intensivo
				'fecha_inicio_emplea'  	=> $datos['txt_fecha_inicio'], 
				'mostrar_emplea'  		=> $datos['checkbox_estado'], //Si se debe mostrar en el FrontOffice 			                
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