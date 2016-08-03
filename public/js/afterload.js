/**
 * Created by dmunioz on 14/06/2016.
 */
$(window).bind("load", function () {
    setTimeout(
        function()
        {
            $("a.youtube").YouTubeModal({autoplay: 1, width:100});
            $( ".youtube" ).trigger( "click" );
        }, 2000);

    var myVar = setInterval(function () {
        controlarEstadoTurnos();

    }, 10000);

    function controlarEstadoTurnos() {
        //===== Se ejecuta una vez que la pagina se haya cargado completamente =====
        $.ajax({
            type: 'POST',
            url: '/impsweb/index/controlarEstadoTurnosAjax',
            dataType: 'json',
            encode: true
        })
            .done(function (data) {
                var  btn_turno = $('#btn_turno');
                btn_turno.empty();
                if (!data.success) {
                    // $('#btn_turno').attr('class', 'list-group-item borde-3-verde');
                    btn_turno.attr('class', 'list-group-item  borde-3-rojo fondo-rojo');
                    btn_turno.append( data.boton);

                }
                else {
                    btn_turno.attr('class', 'list-group-item');
                    btn_turno.append( data.boton );
                }
            })
            .fail(function (data) {
                console.log(data);
            });
    }

})
;