<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
      <?php
        if(  (isset( $titulo_header )) && $titulo_header != '' )
         {
           echo "<title>$titulo_header</title>";
         }
        else 
         {
           echo "<title>CPAGRONEGOCIO</title>";
         }
     ?>        
    <meta name="author" content="CEPRE">
    <meta name="description" content="CPAGRONEGOCIO">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?= base_url('public/assets/') ?>css/bootstrap.min.css">
    <!-- Google fonts - Roboto -->
    <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">-->
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?= base_url('public/assets/') ?>css/style.green.css?1.0" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <!--<link rel="stylesheet" href="css/custom.css"> -->
    <!-- Favicon-->
    <!-- <link rel="shortcut icon" href="<?= base_url('public/assets/') ?>img/favi_unap.png"> -->
    <!-- Font Awesome CDN-->
    <!-- you can replace it by local Font Awesome-->
    <link rel="stylesheet" href="<?= base_url('public/assets/') ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css"> 
    <!-- <script src="https://use.fontawesome.com/99347ac47f.js"></script>-->
    <!-- Font Icons CSS-->
    <!-- <link rel="stylesheet" href="https://file.myfontastic.com/da58YPMQ7U5HY8Rb6UxkNf/icons.css">-->
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    
    <!-- hojas de estilos para página especifica-->        
    <?php
        if( isset( $css ) )
        {
            foreach( $css as $hoja )
            {
                echo '<link rel="stylesheet" href="' . base_url('public/') . $hoja . "\" /> \n " ;
            }
        }
     ?>     
        
  </head>