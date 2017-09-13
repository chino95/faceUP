$(document).ready(function() {
    Template.setTitle({ title: "Expresiones", "subtitle": "Subtítulo" });
    getExpresiones();
    initExp();
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


var cuentap;
var cuentaa;
var aux;
var ubica;

function getExpresiones() {
    $.post('main.php', { action: "getExpresionesU" },
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