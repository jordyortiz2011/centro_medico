<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_nuevo extends CI_Model {
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();    
    }       
  

    // --------------------------------------------------------------
    /**
     * Guarda matricula nueva  en en la BD
     * @param  $post(array)         : datos POST del formulario,
     * @return (boole)  TRUE: correcto | FALSE: error
     *  */
    public function registrar_pago( $post )
    {
        //fecha del registro
        $fecha=new DateTime();
        $fecha_registro=$fecha->format('Y-m-d H:i');


        $datos = array(
            'id_matricula_pago'    	=> $post['hidden_id_matricula'],
            'numero_recibo_pago'   	=> $post['text_num_recibo'],
            'fecha_recibo_pago'  	=> $post['text_fecha_recibo'],
            'monto_recibo_pago'  	=> $post['text_monto_recibo'],

            //meta datos
            'fecha_registro_pago' 	     => $fecha_registro,
            'id_user_registro_pago'	    => $this->auth_user_id,

        );


        $res = $this->db->insert('tbl_pagos' , $datos);
        if (!$res)
        {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo "$error[message]";
        }else
        {
           $res =  $this->db->affected_rows() == 1 ?  TRUE : FALSE;
           return $res;
        }

        return false;
    }


}