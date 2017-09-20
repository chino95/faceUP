$(document).ready(function() {    
    Template.setTitle({ title: "Mensajes", "subtitle": "Subtítulo" });
    $('#iniciardiv').hide();
    getBuscar();
});

$("#frm").validate({
    submitHandler: function(form) {
        getBuscar();
    }
});
var pp;

function getBuscar() {
    var data = {
        bu:'0'
    };
    $.post('main.php', { dt: data, action: "Mensaje" },
        function(e) {
            if (e.data == true) {
                $('#iniciardiv').show();
                initExp();

                for (var i = e.r.length - 1; i >= 0; i--) {
                    console.log(e.r)
                    cuentap = "p" + i;
                    cuentaa = "a" + i;
                    pp = "pp" + i;
                    $('#' + pp).show();
                    $('#' + cuentaa).text(e.r[i][0]);
                    $('#' + cuentap).html(e.r[i][2]);
                    //$('#' + cuentap).html(e.r[i][2]);
                    $('#' + cuentap).append(e.r[i][1]);
                }

            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
    return false;
}


function mensaje(numer){
    var uno=$( "textarea[name*='mensaje']" ).val();
    
    $("#modalNew").modal('hide');

    var sendObj = {
        men: uno,
        usu: numer
    };
    $.post('main.php', { dt: sendObj, action: "enviar" },
        function(e) {
            if (e.data == true) {
                showNotification('Mensaje enviado', 'correctos', 'success');
                $( "textarea[name*='mensaje']" ).val(' ');
            } else {
                showNotification('No se puede enviar', 'incorrectos', 'danger');
            }
            l.stop();
        });

    return false;

}

function initExp() {
    for (var i = 6; i >= 0; i--) {
        pp = "pp" + i;
        $('#' + pp).hide();
    }
}

function MostrarModal(a) {
    $("#modalNew").modal();
    //onclick="mensaje(-1)"
    $("#saveNew").attr('onclick','mensaje('+a+')');
}


function mensaje(numer){
    var uno=$( "textarea[name*='mensaje']" ).val();
    
    $("#modalNew").modal('hide');

    var sendObj = {
        men: uno,
        usu: numer
    };
    $.post('main.php', { dt: sendObj, action: "enviar" },
        function(e) {
            if (e.data == true) {
                showNotification('Mensaje enviado', 'correctos', 'success');
                $( "textarea[name*='mensaje']" ).val(' ');
            } else {
                showNotification('No se puede enviar', 'incorrectos', 'danger');
            }
            l.stop();
        });

    return false;

}