$(document).ready(function() {
    Template.setTitle({ title: "Buscar", "subtitle": "Subtítulo" });
    $('#iniciardiv').hide();
});

$("#frm").validate({
    submitHandler: function(form) {
        getBuscar();
    }
});
var pp;

function getBuscar() {
    var data = {
        bu: '%' + $("#busqueda").val() + '%'
    };
    $.post('main.php', { dt: data, action: "getBuscar" },
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
                    $('#' + cuentap).html(e.r[i][1]);
                }

            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
    return false;
}

function initExp() {
    for (var i = 6; i >= 0; i--) {
        pp = "pp" + i;
        $('#' + pp).hide();
    }
}