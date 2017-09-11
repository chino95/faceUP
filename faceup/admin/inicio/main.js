$(document).ready(function() {
    Template.setTitle({ title: "Inicio", "subtitle": "Subtítulo" });
    //showNotification('Soy la Verga', 'e we la neta si', 'success');
    // getLocalizaciones();
    getExpresiones();
    initExp();

    //ubica = $("#ubicacion").value;
    //console.log(ubica)
});

$("#frm").validate({
    submitHandler: function(form) {
        guardarexpresion();
    }
});
var pp;

function initExp() {
    $('#expresion').val('');
    for (var i = 6; i >= 0; i--) {
        pp = "pp" + i;
        $('#' + pp).hide();
    }
}
$('#ubicacion').change(function() {
    initExp();
    getExpresiones();

    return false;
});

function guardarexpresion() {
    var data = {
        id: 0,
        ex: $("#expresion").val(),
        fec: 0
    };
    $.post('main.php', { dt: data, action: "newExpresion" },
        function(e) {
            if (e.data == true) {
                showNotification('Aviso!', 'Expresion enviada', 'success');
                initExp();
                getExpresiones();
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
    return false;
}

var cuentap;
var cuentaa;
var aux;
var ubica;

function getExpresiones() {

    if (ubica == "")
        aux = 1;
    else
        aux = $('#ubicacion').val();
    $.post('main.php', { dt: aux, action: "getExpresiones" },
        function(e) {
            if (e.data == true) {
                for (var i = e.r.length - 1; i >= 0; i--) {
                    cuentap = "p" + i;
                    cuentaa = "a" + i;
                    pp = "pp" + i;
                    $('#' + pp).show();
                    $('#' + cuentaa).text(e.r[i][0]);
                    $('#' + cuentap).text(e.r[i][1]);
                }
            } else {
                if (e.error == false) {
                    showNotification('Atencion', 'No hay expresiones', 'warning');
                } else {
                    showNotification('Error!', e.r, 'danger');
                }
            }
        });
}

function getLocalizaciones() {
    $.post('main.php', { action: "getLocalizaciones" },
        function(e) {
            if (e.data == true) {
                console.log(e.r)
                $("#ubicacion").html(e.r);
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
}