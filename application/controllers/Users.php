<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    

    public function __construct()
    {
        parent::__construct();
        // Force SSL
        //$this->force_ssl();
        
        // Form and URL helpers always loaded (just for convenience)    
        $this->load->helper('form');  
		
		       
    }
    
   
    public function index()
    {
        
            
         // Method should not be directly accessible         
        $this->is_logged_in();
		//si no hay nadie logeado              
        if( ! empty( $this->auth_role ) )
        {            
       
        redirect(base_url() . 'comun/dashboard');  
		//redirect('welcome');  
          
        }else {
            
             if( $this->uri->uri_string() == 'users/login') //no permitir ingresar directamente a la funcion por la utl
                show_404();
    
            if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
                $this->require_min_level(1);
            
            $this->setup_login_form();            
            
            
            $html =  $this->load->view('comun/login', '',TRUE);
           
            echo $html;
        }        
       
       
    }
    
    public function login()
    {
                
         $this->is_logged_in();             
        if( ! empty( $this->auth_role ) )
        {            
       
         redirect(base_url() . 'comun/dashboard');      
          
        }else {
            
             if( $this->uri->uri_string() == 'examples/login')
                show_404();
    
            if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
                $this->require_min_level(1);
            
            $this->setup_login_form();
             
            
            $html =  $this->load->view('comun/login', '',TRUE);
           
            echo $html;
        }        
    }
    
        
    /**
     * Log out
     */
    public function logout()
    {
        $this->authentication->logout();

        // Set redirect protocol
        $redirect_protocol = USE_SSL ? 'https' : NULL;

        redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
    }
    
    // -----------------------------------------------------------------------

    /**
     * If you are using some other way to authenticate a created user, 
     * such as Facebook, Twitter, etc., you will simply call the user's 
     * record from the database, and pass it to the maintain_state method.
     *
     * So, you must know either the user's username or email address to 
     * log them in.
     *
     * How you would safely implement this in your application is your choice.
     * Please keep in mind that such functionality bypasses all of the 
     * checks that Community Auth does during a normal login.
     */
    public function social_login()
    {
        // Add the username or email address of the user you want logged in:
        //$_SESSION['correo_red_social'] = $userProfile['email'];
        
        //$username_or_email_address = '';
        
        $username_or_email_address = $_SESSION['correo_red_social'] ;

        if( ! empty( $username_or_email_address ) )
        {
            $auth_model = $this->authentication->auth_model;

            // Get normal authentication data using username or email address
            if( $auth_data = $this->{$auth_model}->get_auth_data( $username_or_email_address ) )
            {
                /**
                 * If redirect param exists, user redirected there.
                 * This is entirely optional, and can be removed if 
                 * no redirect is desired.
                 */
                $this->authentication->redirect_after_login();

                // Set auth related session / cookies
                $this->authentication->maintain_state( $auth_data );
            }
            else 
            {
            	//correo gmail válido, pero no está registrado en el sistema
            	 redirect('users/login'. '?error_email=1');
            }
        }
        else
        {
            echo 'Example requires that you set a username or email address.';
        }
    }


    //recuperar formulario
     public function recuperar()
    {
    	  //cargar archivo de idiomas
		 cargar_lenguaje(array('comun/recuperar'));
         
        // Load resources
        $this->load->model('examples/examples_model');

        /// If IP or posted email is on hold, display message
        if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
        {
            $view_data['disabled'] = 1;
        }
        else
        {
            // If the form post looks good
            if(  $this->input->post('email') )
            {
                if( $user_data = $this->examples_model->get_recovery_data( $this->input->post('email') ) )
                {
                    // Check if user is banned
                    if( $user_data->banned == '1' )
                    {
                        // Log an error if banned
                        $this->authentication->log_error( $this->input->post('email', TRUE ) );

                        // Show special message for banned user
                        $view_data['banned'] = 1;
                    }
                    else
                    {
                        /**
                         * Use the authentication libraries salt generator for a random string
                         * that will be hashed and stored as the password recovery key.
                         * Method is called 4 times for a 88 character string, and then
                         * trimmed to 72 characters
                         */
                        $recovery_code = substr( $this->authentication->random_salt() 
                            . $this->authentication->random_salt() 
                            . $this->authentication->random_salt() 
                            . $this->authentication->random_salt(), 0, 72 );

                        // Update user record with recovery code and time
                        $this->examples_model->update_user_raw_data(
                            $user_data->user_id,
                            [
                                'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
                                'passwd_recovery_date' => date('Y-m-d H:i:s')
                            ]
                        );
                        
                        

                        // Set the link protocol
                        $link_protocol = USE_SSL ? 'https' : NULL;

                        // Set URI of link
                        $link_uri = 'users/recovery_verification/' . $user_data->user_id . '/' . $recovery_code;

                        $view_data['special_link'] = anchor( 
                            site_url( $link_uri, $link_protocol ), 
                            site_url( $link_uri, $link_protocol ), 
                            'target ="_blank"' 
                        );
                        
                        //enlace al recuperar
                        $enlace_nuevo = base_url($link_uri );
                        
                        // =======  envio de email (IMPORTANTE) ===========
                        $this->load->library("phpmailer_library");
				       	$mail = $this->phpmailer_library->load();
						
						//desactivar certificados de google
						$mail->SMTPOptions = array(
						    'ssl' => array(
						        'verify_peer' => false,
						        'verify_peer_name' => false,
						        'allow_self_signed' => true
						    )
						);
						
						//Tell PHPMailer to use SMTP
						$mail->isSMTP();						
						$mail->SMTPDebug = 0;// 0 = off (for production use)
											// 1 = client messages
											// 2 = client and server messages						
					   //Set the hostname of the mail server
						//$mail->Host = 'smtp.gmail.com';					
						$mail->Host = gethostbyname('smtp.gmail.com');
					   
					   //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
						$mail->Port = 587;
						//Set the encryption system to use - ssl (deprecated) or tls
						$mail->SMTPSecure = 'tls';
						//Whether to use SMTP authentication
						$mail->SMTPAuth = true;
						//Username to use for SMTP authentication - use full email address for gmail
						//$mail->SMTPSecure = 'ssl';
						$mail->Username = 'sigecou@gmail.com';
						//Password to use for SMTP authentication
						$mail->Password = 'sigecou2017unap';
						//Set who the message is to be sent from
						$mail->setFrom('sigecou@gmail.com', 'Sigacou');
						
						$mail->addAddress($this->input->post('email'));
						//Set the subject line
						$mail->Subject = lang('email_titulo');
                        
						
						$ruta =  base_url('docs/plantilla_correo/');		
						$message = file_get_contents( $ruta . 'recuperar_cuenta.html');
						 
						// Replace the % with the actual information
						//agregar el enlace al mensaje
						$message = str_replace('%enlace%', $enlace_nuevo, $message);
						
						/* Cambiar el idioma del mensaje */
						$message = str_replace('%email_titulo%', lang('email_titulo'), $message);
						$message = str_replace('%email_mensaje%', lang('email_mensaje'), $message);
						$message = str_replace('%email_pie%', lang('email_pie'), $message);
						$message = str_replace('%email_enlace%', lang('email_enlace'), $message);
						
						//$this->email->message($enlace_nuevo);
						$mail->Body = $message;
						//Replace the plain text body with one created manually
						$mail->AltBody = 'Su servidor de correo no soporta HTML'; 
                   
                     if (!$mail->send()) {
						    echo "Mailer Error: " . $mail->ErrorInfo;
						  $view_data['correo_enviado'] = 0;
						 
						} else {
							//MENSAJE ENVIADO
							$view_data['correo_enviado'] = 1;
						    //echo "Message sent!";
						    //Section 2: IMAP
						    //Uncomment these to save your message in the 'Sent Mail' folder.
						    #if (save_mail($mail)) {
						    #    echo "Message saved!";
						    #
						}                         
                        
                        

                        $view_data['confirmation'] = 1;
                    }
                }

                // There was no match, log an error, and display a message
                else
                {
                    // Log the error
                    $this->authentication->log_error( $this->input->post('email', TRUE ) );

                    $view_data['no_match'] = 1;
                }
            }
        }

        //echo $this->load->view('examples/page_header', '', TRUE);
        
        
        echo $this->load->view('comun/vista_recuperar', ( isset( $view_data ) ) ? $view_data : '', TRUE );

        
    }


/**
     * Verification of a user by email for recovery
     * 
     * @param  int     the user ID
     * @param  string  the passwd recovery code
     */
    public function recovery_verification( $user_id = '', $recovery_code = '' )
    {
    	 //cargar archivo de idiomas
		 cargar_lenguaje(array('comun/recuperar_verificacion'));
		
        /// If IP is on hold, display message
        if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
        {
            $view_data['disabled'] = 1;
        }
        else
        {
            // Load resources
            $this->load->model('examples/examples_model');

            if( 
                /**
                 * Make sure that $user_id is a number and less 
                 * than or equal to 10 characters long
                 */
                is_numeric( $user_id ) && strlen( $user_id ) <= 10 &&

                /**
                 * Make sure that $recovery code is exactly 72 characters long
                 */
                strlen( $recovery_code ) == 72 &&

                /**
                 * Try to get a hashed password recovery 
                 * code and user salt for the user.
                 */
                $recovery_data = $this->examples_model->get_recovery_verification_data( $user_id ) )
            {
                /**
                 * Check that the recovery code from the 
                 * email matches the hashed recovery code.
                 */
                if( $recovery_data->passwd_recovery_code == $this->authentication->check_passwd( $recovery_data->passwd_recovery_code, $recovery_code ) )
                {
                    $view_data['user_id']       = $user_id;
                    $view_data['username']     = $recovery_data->username;
                    $view_data['recovery_code'] = $recovery_data->passwd_recovery_code;
                }

                // Link is bad so show message
                else
                {
                    $view_data['recovery_error'] = 1;

                    // Log an error
                    $this->authentication->log_error('');
                }
            }

            // Link is bad so show message
            else
            {
                $view_data['recovery_error'] = 1;

                // Log an error
                $this->authentication->log_error('');
            }

            /**
             * If form submission is attempting to change password 
             */
            if( $this->tokens->match )
            {
                $this->examples_model->recovery_password_change();
            }
        }

        /*echo $this->load->view('examples/page_header', '', TRUE);
        echo $this->load->view( 'examples/choose_password_form', $view_data, TRUE );
        echo $this->load->view('examples/page_footer', '', TRUE); */
		
		echo $this->load->view('comun/vista_recuperar_verificacion', ( isset( $view_data ) ) ? $view_data : '', TRUE );
    }
    
    
}
