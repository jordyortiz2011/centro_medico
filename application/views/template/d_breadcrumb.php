 <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <center>
	              	<h2 class="no-margin-bottom"> 
	              		<i class="<?= $titulo_icono ?>" aria-hidden="true"></i> <?= $titulo ?>
	              	</h2>
              	</center>
              <?php    // Add any javascripts
		        if( isset($descripcion) && $descripcion != '' ) 
		        {
		           echo '<p style="margin-bottom: 0px;">'. $descripcion . '</p>' ;
		        }?>
              
            </div>
          </header>
          <!-- Breadcrumb-->
          <ul class="breadcrumb">
            <div class="container-fluid">            	 
              <!--<li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
              <li class="breadcrumb-item active">Charts</li>  -->
               <?php    // Add any javascripts
		        if( isset($navegacion ) )
		        {
		            foreach($navegacion as $nombre => $url)
		            {
		            	if($url !='' || $url !='')                
		                	echo "<li class='breadcrumb-item active'><a href=". $url .">" . $nombre."</a> </li>";
						else
							echo "<li class='breadcrumb-item active'>" . $nombre." </li>";
						
		            }
		        }?>
            </div>
          </ul>