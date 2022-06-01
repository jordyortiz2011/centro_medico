$(document).ready(function(){

    /*if(position == 'right') {
        var btn = $("<button id='printScheduleBtnId' "+
            'class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-left" '+
            'onclick="printPreview();" ' +
            "type='submit'><span class='ui-button-icon-left ui-icon ui-c ui-icon-print'></span>" +
            "<span class='ui-button-text ui-c'>Print Schedule</span>         </button>").appendTo(e);
        prevButton = btn;
    } */

    $('#btn_imprimir').on('click' , '' , function (e) {
        printPreview();
    });


    function printPreview() {
        var headerElements = document.getElementsByClassName('fc-header');//.style.display = 'none';
        for(var i = 0, length = headerElements.length; i < length; i++) {
            headerElements[i].style.display = 'none';
            console.log(headerElements[i]);

        }
        var toPrint = document.getElementById('printScheduleArea').cloneNode(true);

        for(var i = 0, length = headerElements.length; i < length; i++) {
            headerElements[i].style.display = '';
        }

        var linkElements = document.getElementsByTagName('link');
        var link = '';
        for(var i = 0, length = linkElements.length; i < length; i++) {
            link = link + linkElements[i].outerHTML;
        }

        var styleElements = document.getElementsByTagName('style');
        var styles = '';
        for(var i = 0, length = styleElements.length; i < length; i++) {
            styles = styles + styleElements[i].innerHTML;
        }



        var popupWin = window.open('', '_blank');
        popupWin.document.open();
        popupWin.document.write('<html><head><title>Horario</title>'+link
            +'<style>'+styles+'</style></head><body">')
        popupWin.document.write(toPrint.innerHTML);
        //popupWin.document.write('<script type="text/javascript">window.print();<'+'/script>');
        popupWin.document.write('</body></html>');
        popupWin.document.close();

         setTimeout(popupWin.print(), 30000);

    }




});


