<!-- Page Footer-->
          <footer class="main-footer">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p>Seguro Integral de Salud &copy; 2020</p>
                </div>
                <div class="col-sm-6 text-right">
                  <p>Desarrollado en Php con : <a href="https://codeigniter.com/" class="external">Codeigniter</a></p>
                  <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
              </div>
            </div>
          </footer>
        </div>
      </div>
    </div>
    <!-- Javascript files-->
<?php $version = config_item('version_archivos'); ?>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
    <script src="<?= base_url('public/assets/') ?>js/jquery-1.11.0.min.js"></script>
    <script src="<?= base_url('public/assets/') ?>js/sidebar.js?<?=     $version ?> "></script>
    <script src="<?= base_url('public/assets/') ?>js/tether.min.js"></script>
    <script src="<?= base_url('public/assets/') ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url('public/assets/') ?>js/jquery.cookie.js"> </script>   
    <script src="<?= base_url('public/assets/') ?>js/front_personalizado.js"></script>
    
    <script >
            var BASE_URL = '<?= base_url()?>';       
    </script>
        
       
        <?php
             // Agregar javascript dinamicamente
            if( isset( $javascripts ) )
            {
                foreach( $javascripts as $js )
                {
                    echo '<script src="'. base_url('public/').$js . '"></script>' . "\n";
                }
            }
		?>
    
    
   
  </body>
</html>