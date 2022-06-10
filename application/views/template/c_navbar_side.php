<div class="page-content d-flex align-items-stretch">
        <!-- Side Navbar -->

        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <!--<div class="sidebar-header d-flex align-items-center">
            <div class="avatar"><img src="<?= base_url('public/img/fotos_usuarios/')?>avatar_defecto.png" alt="..." class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4"><?= $auth_username ?></h1>
              <p> <?= $auth_role ?> </p>
            </div>
          </div> -->
          <!-- Sidebar Navidation Menus-->
          <div id="side-menu">
	          <span class="heading"> <strong>Principal</strong> </span>
	          <ul class="list-unstyled">
	            <li class=""> <a href="<?= base_url('comun/dashboard') ?>"><i class="fa fa-tachometer"></i>Panel de Control</a></li>


                  <!-- Citas -->
                  <?php if ($auth_level ==  9 || $auth_level ==  5  ) { ?>
                  <li><a href="#citas" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-hospital-o "></i>Admisión (Citas)
                      </a>
                      <ul id="citas" class="collapse list-unstyled">

                              <li><a href="<?= base_url('citas/nueva/form_nueva') ?>">Nueva</a></li>

                          <li><a href="<?= base_url('citas/listar/listar_citas') ?>">Listar</a></li>
                      </ul>
                  </li>
                  <?php } ?>

                  <!-- Triaje -->
                  <?php if ($auth_level ==  9 ) { ?>
                  <li><a href="#triaje" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-stethoscope "></i>Triaje
                      </a>
                      <ul id="triaje" class="collapse list-unstyled">

                              <li><a href="#">Nueva</a></li>
                             <li><a href="#">Listar</a></li>
                      </ul>
                  </li>
                  <?php } ?>

                  <!-- Enfermeria -->
                  <?php if ($auth_level ==  9 ) { ?>
                  <li><a href="#enfermeria" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-stethoscope "></i>Enfermería
                      </a>
                      <ul id="enfermeria" class="collapse list-unstyled">

                              <li><a href="#">Nueva</a></li>

                          <li><a href="#">Listar</a></li>
                      </ul>
                  </li>
                  <?php } ?>

                  <?php if ($auth_level ==  9 ) { ?>
                  <!-- Obstetricia -->
                  <li><a href="#obstetricia" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-stethoscope "></i>Obstetricia
                      </a>
                      <ul id="obstetricia" class="collapse list-unstyled">
                              <li><a href="#">Nueva</a></li>
                              <li><a href="#">Listar</a></li>
                      </ul>
                  </li>
                 <?php } ?>

                  <?php if ($auth_level ==  9 ) { ?>
                  <!-- Medicia -->
                  <li><a href="#medicina" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-stethoscope "></i>Medicina
                      </a>
                      <ul id="medicina" class="collapse list-unstyled">
                              <li><a href="#">Nueva</a></li>
                          <li><a href="#">Listar</a></li>
                      </ul>
                  </li>
                  <?php } ?>

                  <?php if ($auth_level ==  9 ) { ?>
                  <!-- Odontologia -->
                  <li><a href="#odonto" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-stethoscope "></i>Odontologia
                      </a>
                      <ul id="odonto" class="collapse list-unstyled">
                              <li><a href="#">Nueva</a></li>
                              <li><a href="#">Listar</a></li>
                      </ul>
                  </li>
                <?php } ?>

                  <?php if ($auth_level ==  9 ) { ?>
                  <!-- FUA -->
                  <li><a href="#fua" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-file-text-o"></i>FUA
                      </a>
                      <ul id="fua" class="collapse list-unstyled">
                          <li><a href="<?= base_url('fua/nueva/form_nueva') ?>#">Nueva</a></li>
                          <li><a href="#">Listar</a></li>
                      </ul>
                  </li>
                  <?php } ?>

                  <!-- HIS -->
                  <?php if ($auth_level ==  9 ) { ?>
                  <li><a href="#his" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-file-text-o"></i>HIS
                      </a>
                      <ul id="his" class="collapse list-unstyled">

                          <li><a href="<?= base_url('his/nueva/form_nueva') ?>#">Nueva</a></li>

                          <li><a href="#">Listar</a></li>

                          <li class=""> <a href="<?= base_url('citas/trabajo/form_nueva') ?>"><i class="fa fa-user-md""></i>Profesionales</a></li>
                      </ul>
                  </li>
                  <?php } ?>

	            
	          </ul>

              <?php if ($auth_level ==  9 || $auth_level ==  5 ) { ?>
	          <span class="heading">Gestores</span>
	          <ul class="list-unstyled">

                  <!--Horarios  -->
                  <li class=""> <a href="<?= base_url('gestores/horarios/registrar/form_registrar') ?>"><i class="fa fa-table"></i>Horarios</a></li>


                  <?php if ($auth_level ==  9  ) { ?>
                  <!--Profesionales de la salud  -->
                  <li class=""> <a href="<?= base_url('gestores/profesionales/listar/listar_profesionales') ?>"><i class="fa fa-user-md""></i>Profesionales</a></li>

                  <!--Código Especialidades -->
                  <li class=""> <a href="<?= base_url('gestores/especialidades/listar/listar_especialidades') ?>"><i class="fa fa-graduation-cap"></i>Cartera de Servicios</a></li>

                  <!--Código consultorios -->
                  <li class=""> <a href="<?= base_url('gestores/consultorios/listar/listar_consultorios') ?>"><i class="fa fa-th-large"></i>Consultorios</a></li>


                  <?php } ?>

                  <!-- Pacientes -->
                  <?php if ($auth_level ==  9 || $auth_level ==  5 ) { ?>
                  <li><a href="#pacientes" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-user-o"></i>Pacientes
                      </a>
                      <ul id="pacientes" class="collapse list-unstyled">
                          <li><a href="<?= base_url('gestores/pacientes/registrar/form_registrar') ?>">Nuevo</a></li>
                          <li><a href="<?= base_url('gestores/pacientes/importar/form_importar') ?>">Cargar archivo Excel</a></li>
                          <li><a href="<?= base_url('gestores/pacientes/listar/listar_pacientes') ?>">Listar</a></li>
                      </ul>
                  </li>
                  <?php } ?>


                  <?php if ($auth_level ==  9  ) { ?>
                  <!--Código RENAES -->
                   <li class=""> <a href="<?= base_url('gestores/codigos_renaes/listar/listar_codigos') ?>"><i class="fa fa-barcode"></i>Códigos RENAES</a></li>

                  <!--Código Etnias -->
                  <li class=""> <a href="<?= base_url('gestores/codigos_etnias/listar/listar_codigos') ?>"><i class="fa fa-barcode"></i>Códigos Etnias</a></li>

                  <!--Código PRESTACIONALES -->
                  <li class=""> <a href="<?= base_url('gestores/codigos_prestacionales/listar/listar_codigos') ?>"><i class="fa fa-barcode"></i>Códigos Prestacionales</a></li>

                  <!-- Codigos CIE10 -->
                  <li><a href="#cie10" aria-expanded="false" data-toggle="collapse">
                          <i class="fa fa-barcode"></i>Codigos CIE-10
                      </a>
                      <ul id="cie10" class="collapse list-unstyled">
                          <li><a href="<?= base_url('gestores/codigos_cie10_cat/listar/listar_codigos') ?>">Categoria</a></li>
                          <li><a href="<?= base_url('gestores/codigos_cie10/listar/listar_codigos') ?>">Descripcion</a></li>
                      </ul>
                  </li>
                  <?php } ?>



              </ul>




              <?php } ?>


              <?php if ($auth_level ==  9) { ?>
	          <span class="heading">Sistema</span>      
	          
	          <ul class="list-unstyled">
	          	
	             <!--Página de Inicio -->
	            <!--<li class=""><a href="#pag_inicio" aria-expanded="false" data-toggle="collapse">
	            	<i class="fa fa-home"></i>Página Inicio
	            	</a>
	              <ul id="pag_inicio" class="collapse list-unstyled ">
	                <li><a href="<?= base_url('sistema/pag_inicio/portada/listar/listar_portadas') ?>">Portada</a></li>
	                <li><a href="<?= base_url('sistema/pag_inicio/contacto/editar/form_editar') ?>">Contacto</a></li>                
	              </ul>
	            </li> -->


                  <!--Usuarios -->
	            <li> <a href="<?= base_url('sistema/usuarios/listar/listar_usuarios') ?>"> <i class="fa fa-users"></i>Usuarios </a></li>
	         
	          </ul>
              <?php } ?>
          </div>
        </nav>