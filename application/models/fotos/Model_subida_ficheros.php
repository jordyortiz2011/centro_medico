<?php
class Model_subida_ficheros extends CI_Model {
   
       public function __construct()
       {
            parent::__construct();
            $this->load->database();    
        }
     
     public function insertar_imagen($id_solicitud, $nom_fichero, $lat, $lon )
     {
         //fecha del registro
         $fecha=new DateTime();
         $fecha_registro=$fecha->format('Y-m-d H:i');

         //usuario que está realizando el registro
         $this->load->model('reutilizables/Model_usuarios');
         $usuario_registrador = $this->Model_usuarios->obtener_usuario_registrador_completo($this->auth_user_id);


         $datos = array(
             'id_solicitud_foto'    	=> $id_solicitud,
             'nombre_foto'        		=> $nom_fichero,
             'latitud_foto'  	        => $lat,
             'longitud_foto'  	        => $lon,

             //meta datos
             'fecha_registro_foto'   	=> $fecha_registro,
             'user_registro_foto'	    => $usuario_registrador,

         );


         $res = $this->db->insert('tbl_fotos' , $datos);
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
     
     
     public function listar_fotos($id_registro)
     {

         $query = $this
             ->db
             ->from('tbl_fotos')
             ->where('id_solicitud_foto =',  $id_registro)
             ->order_by('id_foto',  'asc');

         //ejectua la consulta
         $query = $this->db->get();

         if (!$query)
         {
             $error = $this->db->error(); // Has keys 'code' and 'message'
             echo "$error[message]";
         }else
         {
             return $query->result();
         }

     }
     
     public function eliminar_imagen($id_registro){
        
        $this->db->where('id_foto', $id_registro);
         
        $res = $this->db->delete('tbl_fotos');
        if (!$res)
        {
          $error = $this->db->error(); // Has keys 'code' and 'message'
          //echo "$error[message]";
          return false ;
        }else  {
            $res =  $this->db->affected_rows() == 1 ?  true : false;
            return $res;        
        }       
      
    }

    public function obtener_imagen_xID($id_registro)
    {
        $query = $this
            ->db
            ->from('tbl_fotos')
            ->where('id_foto =',  $id_registro);

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


      
      

    
    
    
   
        

    

}