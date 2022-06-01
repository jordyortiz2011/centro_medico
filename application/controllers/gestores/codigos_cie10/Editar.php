<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editar extends MY_Controller {
    
    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form');
        $this->is_logged_in();
        $this->require_min_level(1);
    }
  
    public function index()
    {        
       redirect()  ;      
    }
	
	 
 // --------------------------------------------------------------
    /**
     * Muestar el formulario para editar 
	 * para realizar la edición
     * @param  $id_registro (al final de la url) 
	 * @return (vista) , formulario
     */   	 
	 
	  public function form_editar($id_registro = null){
        
        if(  $this->auth_role == 'admin' )
        {
         	 //si no se pasa ni un parametro en la url redireccionar
        	 if($id_registro == null )
			  redirect('gestores/codigos_cie10/listar/listar_codigos');
         
         	 //cargar librería de formulario
         	 $this->load->helper('form');
			
         	 //obtener los datos del registro
         	 $this->load->model('gestores/codigos_cie10/Model_editar');
             $codigo  = $this->Model_editar->obtener_codigo($id_registro);
			 
			 //si no existe ningún paquete con el id seleccionado, redireccionar al listar
			 if($codigo == NULL)
                 redirect('gestores/codigos_cie10/listar/listar_codigos');


			 $id_categoria = $codigo->id_categoria_cie10;

            $codigo_tres    =  substr($codigo->codigo_cie10, 0, 3);
            $ultimo_caracter = substr($codigo->codigo_cie10, -1);

            // =============================================================================
            $this->load->helper('MY_form');

            //CREAR SELECT de categoria
            $this->load->model('reutilizables/Model_cie10_categorias');
            $lst_categorias = $this->Model_cie10_categorias->listado_cie10_cat();

            //para que cree el array de id y nombre del select = unidades de medida
            $lista_categorias = array();
            foreach ($lst_categorias as $cat) {
                $lista_categorias[$cat->id_codigo_ciecat] =  $cat->codigo_ciecat . " " .  $cat->descripcion_ciecat ;
            }

            //para que cree el array de metadatos
            $lista_categorias_meta = array();
            foreach ($lst_categorias as $cat) {
                $lista_categorias_meta[$cat->id_codigo_ciecat] =   'data-codigo="' . $cat->codigo_ciecat . '"' ;
            }

            $extra = array(
                'id'    => 'select_categoria',
                'class' => "select2 form-control form-control-lg"
            );

            //string del select customizado
            $dropdown_categorias = form_dropdown('select_categoria', $lista_categorias, set_value('select_categoria',$id_categoria) , $extra,  $lista_categorias_meta  );



            $data = array (
			 				 'codigo'				=> $codigo,
                             'codigo_tres'          =>  $codigo_tres,
                             'ultimo_caracter'      => $ultimo_caracter,
                            'select_categorias'    => $dropdown_categorias
			 				); 
                      
             $this->load->view('gestores/codigos_cie10/vista_editar', $data)  ;
                            
              
        }
        
    }
	
	   // --------------------------------------------------------------
    /**
     * procesa el formulario de la edicion de paquetes 
     * @param  (post) valores del formulario
	 * @return  (vista) si la actualización es correcta , retorna al listado de paquetes
     */     
    public function procesa_editar()
    {
		        
        if(  $this->auth_role == 'admin' )
        {
             $post =  $this->input->post(); 		
			//print_r($post);  exit;
			
                   
             $this->mi_validacion_editar($post);
			
			//comprobar si el formulario es valido
			if( $this->form_validation->run() == FALSE )
            {
                //echo "error validacion";
               //regresa al formulario de actualizar
               $this->form_editar($post['hidden_id_codigo']);
                   
            }else {
            	
            	//datos correctos , actualizar  en la BD
            	//echo "entré para actualizar";exit;
            	$id_codigo	= $post['hidden_id_codigo'];

                $post['text_codigo_nuevo'] = $post['text_codigo_tres'] . $post['text_codigo'];
            	
            	$this->load->model('gestores/codigos_cie10/Model_editar');
				$res  = $this->Model_editar->editar_codigo($id_codigo, $post);
                //exit;
                //comprobar si se guardó exitosamente el registro
                if ( $res == TRUE  )	{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'actualizado');


                    //redirección de acuerdo al boton
                    if($post['btn_subir'] == 'listar')
                        redirect('gestores/codigos_cie10/listar/listar_codigos', 'refresh');

                }
                else{
                    //datos guardados correctamente
                    $this->session->set_flashdata('estado_registro', 'sin_actualizar');
                    redirect('gestores/codigos_cie10/listar/listar_codigos', 'refresh');
                }






            }			                            
              
        }        
    }
	
	private function mi_validacion_editar ($post) 
	{
		 //carga la libreria para validar formulario               
        $this->load->library('form_validation');	
		$this->config->set_item('language', 'spanish');
		
		//para no realizar comprobación del nombre del colegio si no se cambió el nombre del colegio
		$id_registro	= $post['hidden_id_codigo'];
        $this->load->model('gestores/codigos_cie10/Model_editar');
		$codigo  = $this->Model_editar->obtener_codigo($id_registro);

        $_POST['text_codigo_nuevo'] = $post['text_codigo_tres'] . $post['text_codigo'];

		
		//Para el codigo
		if($codigo->codigo_cie10 != $_POST['text_codigo_nuevo'] )
		{
		  //para el código
          $this->form_validation->set_rules('text_codigo_nuevo', 'Código ','required|trim|min_length[1]|max_length[4]|is_unique[tbl_codigos_cie10.codigo_cie10]' ,
										 //mensajes personalizados de cada regla de validación
										 array(									               
									                'is_unique'     => 'Esta <b> %s </b> ya existe.'
									           )
										);
		}else 
		{
			$this->form_validation->set_rules('text_codigo', 'Código', 'required|trim|min_length[1]|max_length[3]' );
		}

        //Para la descripcion
        if($codigo->descripcion_cie10 != $post['text_descripcion'])
        {

            //para el código
            $this->form_validation->set_rules('text_descripcion', 'Categoria','required|trim|min_length[1]|max_length[60]|is_unique[tbl_codigos_cie10.descripcion_cie10]' ,
                //mensajes personalizados de cada regla de validación
                array(
                    'is_unique'     => 'Esta <b> %s </b> ya existe.',
                    'max_length'  => 'No debería exceder de 60 caracteres'
                )
            );
        }else
        {
            $this->form_validation->set_rules('text_descripcion', 'Categoria', 'required|trim|min_length[1]|max_length[60]' );
        }
		
	}
	
	

    
    
}
