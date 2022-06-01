$(document).ready(function () {
    
    if(typeof FOTO_EMPLEADO === 'undefined' ){
        FOTO_EMPLEADO = 'empleado_defecto.png';
    }
  
    // the file input
   var $el4 = $('#foto_empleado'), initPlugin = function() {
        $el4.fileinput({
            
            language: 'es',     
            overwriteInitial: true,
             maxFileSize: 2048,
            showClose: false,
            showCaption: false, //NO MOSTRAR BOTON POR DEFECTO DE SUBIDA
             browseLabel: '', //ETIQUETA DE BUSCAR 
             removeLabel: '',//ETIQUETA DE REMOVER
             uploadLabel: '',//ETIQUETA DE Subir
             browseIcon: '<i class="fa fa-folder-open-o"></i>', //ICONO BUSCAR
             removeIcon: '<i class="fa fa-trash-o"></i>', //ICONO REMOVER
             uploadIcon: '<i class="glyphicon glyphicon-ok" id="btn_subir_avatar"></i>', //ICONO Subir
            removeTitle: 'Cancel or reset changes',
             defaultPreviewContent: '<img id="preview_foto_empleado" src="'  + BASE_URL + '/public/img/fotos_empleados/'+ FOTO_EMPLEADO +'" alt="Foto">',
            layoutTemplates: {main2: '{preview} '  + '  {remove} {browse} ' , footer: ''},
            allowedFileExtensions: ["jpg", "png"],
             browseOnZoneClick: true , //al darle click en la imagen, poder subir una nueva
            //AJAX
           // uploadAsync: true,
           // uploadUrl:  BASE_URL + "comensal/perfil_editar/foto", // your upload server url
            //para enviar datos extrar 
            //uploadExtraData: function() {
            //    return {
             //       userid: $("#userid").val(),
             //       username: $("#username").val()
             //   };
            //}
        })
        .on('fileuploaded ', function(event, numFiles, label) {
        console.log("fileupoad");
        //console.log(event);       
       
        $('.fileinput-upload-button').remove(); //ocultar boton de subida
        $('.fileinput-remove-button').remove(); //ocultar boton de remover , reset
        $('.btn-file').remove();
       
    }); 
                      
    };
 
    // initialize plugin
    initPlugin();

// cambiar color por defecto de icono de subida
var btn_padre = $('#btn_subir_avatar').parent();
    btn_padre.removeClass('btn-default btn-secondary');
    btn_padre.addClass('btn-primary');  
   

/*   var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' +
    'onclick="alert(\'Call your custom code here.\')">' +
    '<i class="glyphicon glyphicon-tag"></i>' +
    '</button>';
$("#foto_empleado").fileinput({
    overwriteInitial: true,
    maxFileSize: 1500,
    showClose: false,
    showCaption: false,
    browseLabel: '',
    removeLabel: '',
    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    removeTitle: 'Cancel or reset changes',
    elErrorContainer: '#kv-avatar-errors-1',
    msgErrorClass: 'alert alert-block alert-danger',
    defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
    layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
    allowedFileExtensions: ["jpg", "png", "gif"]
}); */


   
   
   

});//fin document


    

