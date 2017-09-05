$(document).ready(function() {

    getLocalizaciones();
    $.backstretch(["../assets/global/images/gallery/login4.jpg", "../assets/global/images/gallery/login3.jpg", "../assets/global/images/gallery/login2.jpg", "../assets/global/images/gallery/login.jpg"], {
        fade: 600,
        duration: 4000
    });
    copyrightPos();
    var form = $(".form-signin");
    var formNew = $("#frmNew");
    $('#registeru').click(function(e) {
        $('#modalNew').modal();
    });
    /////

    $('#saveNew').click(function(e) {
        formNew.validate({
            rules: {
                nickname: {
                    required: true,
                    minlength: 4,
                },
                correo: {
                    required: true,
                    email: true,
                },
                ubicacion: {
                    required: true
                },
                psw: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
                },
                rpsw: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
                }
            },
            messages: {
                nickname: {
                    required: 'Escriba su Nickname',
                    minlength: 'Minimo de 4 caracteres'
                },
                correo: {
                    required: 'Ingrese su correo'
                },
                ubicacion: {
                    required: 'Seleccione una ubicacion'
                },
                psw: {
                    required: 'Escriba su Contraseña',
                    minlength: 'Minimo de 6 caracteres'
                },
                rpsw: {
                    required: 'Repita su Contraseña',
                    minlength: 'Minimo de 6 caracteres'
                }
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
        e.preventDefault();
        if (formNew.valid()) {
            $(this).addClass('ladda-button');
            var l = Ladda.create(this);
            l.start();
            var sendObj = {
                nick: $("#nickname").val(),
                cor: $("#correo").val(),
                psw: $("#psw").val(),
                loc: $('#ubicacion').val()
            };
            $.post('main.php', { dt: sendObj, action: "new" },
                function(e) {
                    if (e.data == true) {
                        window.location.replace("../admin/inicio");
                    } else {
                        showNotification('Usuario y/o Contraseña', 'incorrectos', 'danger');
                    }
                    l.stop();
                });
        } else {
            $('body').addClass('boxed');
        }
    });

    ////
    $('#submit-form').click(function(e) {
        form.validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3,
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 16
                }
            },
            messages: {
                username: {
                    required: 'Escriba su Correo'
                },
                password: {
                    required: 'Escriba su Contraseña'
                }
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
        e.preventDefault();
        if (form.valid()) {
            $(this).addClass('ladda-button');
            var l = Ladda.create(this);
            l.start();
            var sendObj = {
                usr: $("#username").val(),
                psw: $("#password").val()
            };
            $.post('main.php', { dt: sendObj, action: "login" },
                function(e) {
                    if (e.data == true) {
                        window.location.replace("../admin/inicio");
                    } else {
                        showNotification('Usuario y/o Contraseña', 'incorrectos', 'danger');
                    }
                    l.stop();
                });
        } else {
            $('body').addClass('boxed');
        }
    });
});

function copyrightPos() {
    var windowHeight = $(window).height();
    if (windowHeight < 700) {
        $('.account-copyright').css('position', 'relative').css('margin-top', 40);
    } else {
        $('.account-copyright').css('position', '').css('margin-top', '');
    }
}

$(window).resize(function() {
    copyrightPos();
});

function getLocalizaciones() {
    $.post('main.php', { action: "getLocalizaciones" },
        function(e) {
            if (e.data == true) {
                $("#ubicacion").html(e.r);
                // $("#ubicacion").select2();
            } else {
                showNotification('Error!', e.r, 'danger');
            }
        });
}

function showNotification(textS, textN, typez) {
    var n = noty({
        text: '<div class="alert alert-' + typez + ' media fade in"><p><strong>' + textS + '</strong> ' + textN + '</p></div>',
        progressBar: true,
        type: typez,
        dismissQueue: true,
        layout: 'topRight',
        closeWith: ['click'],
        theme: 'made',
        maxVisible: 10,
        animation: {
            open: 'animated bounceIn',
            close: 'animated bounceOut',
            easing: 'swing',
            speed: 100
        },
        timeout: 3000,
        buttons: ''
    });
}