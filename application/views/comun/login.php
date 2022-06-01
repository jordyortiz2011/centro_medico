<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIS </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url('public/assets/')?>css/bootstrap.min.css">
    <!-- Google fonts - Roboto -->
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">-->
    <link rel="stylesheet" href="<?= base_url('public/assets/')?>fuentes/google/roboto.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url('public/assets/')?>css/style.green.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?= base_url('public/assets/')?>css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <!--<script src="https://use.fontawesome.com/99347ac47f.js"></script>-->
      <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Font Icons CSS-->
    <link rel="stylesheet" href="<?= base_url('public/assets/')?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page" style="background-color: green;">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center" style="">
                <div class="content" style="width: 100%;">
                  <div class="logo">
                    <h1>MINISTERIO DE SALUD </h1>
                  </div>
                  <p>Seguro Integral de Salud</p>
                    <!--<div class="row align-items-center" style="background-color: #fff; color:#000;">
                        <div class="col-md-12">
                            <img src="<?= base_url('public/assets/img/logo_nuevo_prisma.jpg')?>"  width="100%">
                        </div>

                    </div>-->
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white" >
             <?php if ( ! isset( $on_hold_message )) { ?>
              <!-- Formulario de inicio de sesion-->    
              <div class="form d-flex ">                  	         
                <div class="content">
                  <center>	                
	                  <h2>Iniciar Sesión</h2>
                  </center>
                  
                   <?php if ( $this->input->get('logout') ) { ?>
                   	<!-- Mensaje de cierre de sesión exitoso -->
                  <center><span class="badge badge-success">Cierre de Sesión exitoso</span></center>
                   <?php }  ?>
                    <?php if ( $this->input->get('error_email') ) { ?>
                   	<!-- Mensaje de correo no registrado en el sistema (autentificación de  terceros)-->
                  <center><span class="badge badge-danger">Correo no registrado en el sistema</span></center>
                   <?php }  ?>
                  
                  <?php if (isset( $login_error_mesg )) { ?>
                  	<!--  mensaje de ERROR al iniciar sessión -->
                  	<div class="alert alert-danger alert-dismissible fade show" role="alert">
					  Error de Inicio de Sesión # <strong> <?php echo  $this->authentication->login_errors_count . ' / ' . config_item('max_allowed_attempts')?>. </strong>  
					  Nombre de usuario, correo o contraseña incorrecto
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>                  	
                  <?php }  ?>
                  	
                  <!--<form id="login-form" method="post">-->
                   <br>
                  <?= form_open( $login_url, ['class' => 'std-form' , 'id' => 'form_login'] ) ?>
                    <div class="form-group">
                      <input id="login_string" type="text" name="login_string" required="" class="input-material">
                      <label for="login_string" class="label-material">Usuario o Correo</label>
                    </div>
                    <div class="form-group">
                      <input id="login_pass" type="password" name="login_pass" required="" class="input-material">
                      <label for="login_pass" class="label-material">Contraseña</label>
                    </div>
                     <?php if ( config_item('allow_remember_me') ) { ?>
                     	<!-- si está activado recordar sessión -->
                     	<div class="">		                  
							&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="remember_me" name="remember_me" value="yes" />
							&nbsp;<label for="remember_me" class="form_label">Recordar </label>
	                    </div>	
                     <?php }  ?>
                    	
                    	<!--<a id="login" href="index.html" class="btn btn-primary form-save">Entrar</a>-->
                    	<input type="submit" class="btn btn-primary" value="Entrar" />
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                    	<br>
                    	<!--<center>O entrar con: </p></center><p>
                    	      <div class="social-login ">        
								<center>
	                                <a href="<?= base_url('comun/autentificacion/google/glogin') ?>" class="btn btn-danger">
	                                    <i class="ace-icon fa fa-google-plus"></i>
	                                </a>
                                </center>
                            </div> -->
                    	
                    	
                  </form>
                  <br>
                   <!--<a href="#" class="forgot-pass">¿Olvidaste tu contraseña?</a> -->
                </div>
              </div> <!-- FIN Formulario de inicio de sesion-->
             <?php } else { ?>
             	<div class="info d-flex align-items-center" style="background-color: white;">
             		<div class="alert alert-danger" role="alert">
					  <h4 class="alert-heading">Inicio de Sesión Bloqueado</h4>
					  <p> Has excedido el número máximo de intentos de Inicio de Sesión que el sistema permite
					  </p>
					  <hr>
					  <p class="mb-0">
					    El Inicio de Sesión ha sido bloqueado por:  <?= ( (int) config_item('seconds_on_hold') / 60 ) ?>  minutos.
					  </p>					  
					   <p class="mb-1">
					    Por favor use <a href="/examples/recover">Recuperar Cuenta</a> 
					    luego de  <?= ( (int) config_item('seconds_on_hold') / 60 ) ?>  minutos.
					    O contacte con el administrador si tiene problemas al iniciar sesión.
					  </p>
					</div> 
             	</div>             	
             <?php }?>	
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Ministerio de Salud - Perú </p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
      </div>
    </div>
    <!-- Javascript files-->
    <!-- Descomentar en entorno de producción -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
    <script src="<?= base_url('public/assets/')?>js/jquery-1.11.0.min.js"></script> 
    <script src="<?= base_url('public/assets/')?>js/tether.min.js"></script>  
    <script src="<?= base_url('public/assets/')?>js/bootstrap.min.js"></script>
      <script src="<?= base_url('public/assets/')?>js/jquery.validate.min.js"></script>
 	<script>
 		$(document).ready(function () {
 			 // ------------------------------------------------------- //
		    // Login  form validation
		    // ------------------------------------------------------ //
		    $('#form_login').validate({
		        messages: {
		            login_string: 'Por favor ingrese su usuario o correo',
		            login_pass: 'Por favor ingrese su contraseñas'
		        }		         
		    });
		
		    // ------------------------------------------------------- //
		    // Transition Placeholders
		    // ------------------------------------------------------ //
		    $('input.input-material').on('focus', function () {
		        $(this).siblings('.label-material').addClass('active');
		    });
		
		    $('input.input-material').on('blur', function () {
		        $(this).siblings('.label-material').removeClass('active');
		
		        if ($(this).val() !== '') {
		            $(this).siblings('.label-material').addClass('active');
		        } else {
		            $(this).siblings('.label-material').removeClass('active');
		        }
		    });
 			
 		});
 	</script>
   

  
  </body>
</html>