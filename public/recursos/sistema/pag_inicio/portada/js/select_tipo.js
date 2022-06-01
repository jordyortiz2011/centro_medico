 $(document).ready(function () {  
   
   $('#select_tipo_portada').on('change', function (evt) {
       
       id_select = this.value;
       ///console.log(this.value);
       
       if(id_select == 1 ) {
           
           $('#conten_imagen').removeClass('d-none');
           $('#conten_imagen').show();
           
           
           $('.conten_color').addClass('d-none');
           $('.conten_color').hide();
           
           
           
       }else if (id_select ==2 ) {
           $('#conten_imagen').addClass('d-none');
           $('#conten_imagen').hide();
           
           $('.conten_color').removeClass('d-none');
           $('.conten_color').show();
           
       }
       
   });
       
});//fin document