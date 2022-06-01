 // ------------------------------------------------------- //
    // Sidebar Functionality (plegar/desplegar sidebar)
    // ------------------------------------------------------ //
    $('#toggle-btn').on('click', function (e) {
        e.preventDefault();
        $(this).toggleClass('active');

        $('.side-navbar').toggleClass('shrinked');
        $('.content-inner').toggleClass('active');

        if ($(window).outerWidth() > 1183) {
            if ($('#toggle-btn').hasClass('active')) {
                $('.navbar-header .brand-small').hide();
                $('.navbar-header .brand-big').show();
            } else {
                $('.navbar-header .brand-small').show();
                $('.navbar-header .brand-big').hide();
            }
        }

        if ($(window).outerWidth() < 1183) {
            $('.navbar-header .brand-small').show();
        }
    });
    

$(document).ready(function() {
    let CURRENT_URL = window.location.href.split('?')[0];  
    console.log(CURRENT_URL) ; 
    let SIDEBAR = $('#side-menu');
    let target = SIDEBAR.find('a[href="' + CURRENT_URL + '"]').parent('li');
    target.addClass('active');
    
    //desplegar 
    let targetlu = target.parent('ul').eq(0);
    if(targetlu.attr('id')){

        //targetlu.parent('li').addClass('active open');
        //targetlu.toggleClass('show');
        targetlu.parent('li').toggleClass('active');
        //targetlu.parent('li').attr('aria-expanded' , 'true');
    }

    //Mostrar siempre barra lateral en dispositivo menores de 1200px de ancho
    var WIDTH_DISPOSITIVO = parseInt(window.innerWidth);
    console.log(WIDTH_DISPOSITIVO);
    if(WIDTH_DISPOSITIVO <= 1200 ){
        $('nav.side-navbar').addClass('shrinked');
    }


    
  
    
});
