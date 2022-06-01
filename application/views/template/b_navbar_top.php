  <body>
    <div class="page charts-page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <!-- Search Box-->
          <div class="search-box">
            <button class="dismiss"><i class="fa fa-search"></i></button>
            <form id="searchForm" action="#" role="search">
              <input type="search" placeholder="Buscar Alumno" class="form-control">
            </form>
          </div>
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.html" class="navbar-brand">
                  <div class="brand-text brand-big hidden-lg-down"><span>Seguro Integral S. </span><strong> &nbsp;&nbsp;&nbsp;</strong></div>
                  <div class="brand-text brand-small"><strong>SIS</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Search-->
                <!-- <li class="nav-item d-flex align-items-center"><a id="search" href="#"><i class="fa fa-search"></i></a></li>-->
            	&nbsp;&nbsp;&nbsp;
            	
            	<!--<li class="nav-item d-flex align-items-center">
            		<a href="<?= config_item('base_url_home') ?>" target="_blank"  data-toggle="tooltip" title="Inicio" >
            	<i class="fa fa-home fa-lg"></i></a>
                </li> -->

                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none;">
                          <img class="rounded-circle" src="<?= base_url('public/img/fotos_usuarios/')?>avatar-hombre.jpg" width="25px" height="25px"  alt="">
                          <span class="hidden-xs"> <?= $auth_username ?> </span>
                      </a>
                      <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header" style="background-color: #0c7cbb;">
                              <div class="text-center">
                                  <img class="rounded-circle" src="<?= base_url('public/img/fotos_usuarios/')?>avatar-hombre.jpg"   width="70px" height="80px" alt="">

                                  <p class="text-white"> <b> <?= $auth_username ?> </b><br>
                                      <small><?= $auth_role ?></small>
                                  </p>
                              </div>
                          </li>
                          <!-- Menu Body -->
                          <li class="user-body">
                              <!--<div class="row">
                                  <div class="col-xs-4 text-center">
                                      <a href="#">Followers</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                      <a href="#">Sales</a>
                                  </div>
                                  <div class="col-xs-4 text-center">
                                      <a href="#">Friends</a>
                                  </div>
                              </div> -->
                              <!-- /.row -->
                          </li>
                          <!-- Menu Footer-->
                          <li class="user-footer">
                              <!-- <div class="pull-left">
                                  <a href="#" class="btn btn-default btn-flat">Principal</a>
                              </div> -->
                              <div class="text-center">
                                  <button type="button" class="btn btn-secondary" onclick='location.href="<?= base_url('users/logout')?>";' >Cerrar Sesión</button>
                                  <!-- <a href="<?= base_url('users/logout')?>" class="btn btn-default btn-flat">Cerrar Sesión</a> -->
                              </div>
                          </li>
                      </ul>
                  </li>
               
                <!-- Logout    -->
                <!-- <li class="nav-item"><a href="<?= base_url('users/logout')?>" class="nav-link logout">Salir<i class="fa fa-sign-out"></i></a></li> -->
              </ul>
            </div>
          </div>
        </nav>
      </header>