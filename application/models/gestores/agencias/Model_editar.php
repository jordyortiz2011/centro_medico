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

    public function obtener_agencia($id_registro)
    {            
        $query = $this
	            ->db	          
	            ->from('tbl_agencias')
				->where('id_agen  =',  $id_registro);
		
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
	
	public function editar_agencia($id_registro,$post)
    {
    	
		//print_r($post); exit;
		       
       	
		  $data = array(
         		'nombre_agen'       => $post['txt_nombre'],
                
        );
		
				        
        $query = $this->db->where('id_agen' , $id_registro)
        				  ->update('tbl_agencias',$data ) ;
						  
		//echo $this->db->get_compiled_select(); exit;
         
       	if (!$query) {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo  $error[message] . 'Error! al ejecutar consulta';
            $result =  FALSE ;
		} else {
            $result =  $this->db->affected_rows() == 1 ?  TRUE : FALSE;
		}
		
		return $result;	            
    } 
	
   

}