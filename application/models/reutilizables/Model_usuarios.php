<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_usuarios extends MY_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  
// --------------------------------------------------------------
    /**
     * Obtiene datos de un usuarios x su ID     
     * @param  $$id(int): id del usuario  
     * @return (Objeto) Lista los datos del usuario
     *  */     

    public function obtener_usuario_xID($id)
    {
    	$query = $this
	            ->db	          
	            ->from( $this->db_table('user_table') )
				->where('user_id =',  $id);
		
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
	
	// --------------------------------------------------------------
    /**
     * Obtiene el nombre y 1er apellido de un usuario   
     * @param  $$id(int): id del usuario  
     * @return (Objeto) Lista los datos del usuario
     *  */  
	public function obtener_usuario_registrador($id)
    {
    	$query = $this
	            ->db	          
	            ->from( $this->db_table('user_table') )
				->where('user_id =',  $id);
		
		//ejectua la consulta
		$query = $this->db->get();	
					        
        if (!$query)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          echo "$error[message]";
        }else 
        {                          
            $usuario =  $query->row();

			$usuario_registrador = ucwords(  $usuario->username);
			
			return $usuario_registrador;
        }
	         
    }

    // --------------------------------------------------------------
    /**
     * Obtiene el 1er nombre y apellidos del usuario que ha iniciado sesión
     * @param  $$id(int): id del usuario
     * @return (Objeto) Lista los datos del usuario
     *  */
    public function obtener_usuario_registrador_completo($id)
    {
        $query = $this
            ->db
            ->from( $this->db_table('user_table') )
            ->where('user_id =',  $id);

        //ejectua la consulta
        $query = $this->db->get();

        if (!$query)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        }else
        {
            $usuario =  $query->row();

            $nombres = explode(' ', $usuario->nombres_user);
            $usuario_registrador = $nombres[0] . ', ' . $usuario->apellido_pat_user . ' ' . $usuario->apellido_mat_user;	//1er nombre y apellido paterno
            //$usuario_registrador = ucwords( strtolower($usuario_registrador)); //1ra letra en mayuscula
            $usuario_registrador = mb_convert_case($usuario_registrador, MB_CASE_TITLE, "UTF-8"); //1ra letra en mayuscula
            return $usuario_registrador;
        }

    }



}