<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_editar extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene  datos de contacto del sistema
     * @param  -_-  
     * @return objeto de registros
     *  */     
   public function obtener_contacto()
   {		  
       $query = $this
                ->db                
                ->from('tbl_contacto')	
				->order_by('id_contac',"desc")
				->limit(1);	
        //echo $this->db->get_compiled_select(); exit;        
        
        $query = $this->db->get();		
        if($query->num_rows()>0)
        {
            return $query->row(); 
            //print_r($query->result()); exit;
        }
        else
        {
            return null;
        }     
                 
    }  
    

	
	
   /**
 * Actualiza datos del registro
 * @param  $id_registro: Id del registro  $post(array): datos del formulario
 * @return (bool) estado de la actualizacion
 *  */ 	
	
	public function editar_contacto($id_registro,$post)
    {
    	
		//print_r($post); exit;   
       	
		  $data = array(
         		'telefono_contac'    	=> $post['txt_telefono'], 
                'direccion_contac'   	=> $post['txt_direccion'], 
                'correo_contac'  		=> $post['txt_correo']
        );
		
				        
        $query = $this->db->where('id_contac' , $id_registro)
        				  ->update('tbl_contacto',$data ) ;
						  
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