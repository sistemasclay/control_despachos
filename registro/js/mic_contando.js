$(function () {
    //traerDatos();
    var tid = setInterval(traerDatos, 500);
    function traerDatos() {
        validarInformacion();
    }
    function abortTimer() { // to be called when you want to stop the timer
        clearInterval(tid);
    }

    var validarInformacion = function () {

        $.ajax({
            url: "turno.php",
            type: "post",
            data: {estado: 5,
                maquina: proceso},
            datatype: 'json',
            success: function (data) {
                res = JSON.parse(data);
                if (res.resultado) {
					$('body').attr('data-loading', 'off');
                    var datosTurno = res.resultado;
					if (datosTurno.estadoTurno == 0) {
						window.location.replace("mic_inicio.php?proceso=" + datosTurno.maquina);
					}
                    else if(datosTurno.enParo == 1){
                         window.location.replace("mic_parada_regis.php?proceso="+datosTurno.maquina);
                    }
                    $("#maquina").text(datosTurno.nom_maquina);
                    $("#turno").text("Turno " + datosTurno.turno);
                    $("#disponibilidad").text(datosTurno.disponibilidad+"%");
                    $("#velocidad").text(datosTurno.velocidad+"%");
                    $("#unidades").text(datosTurno.unidades);
                    $("#estimado").text(datosTurno.estimado+"%");
                } else {

                }
            },
            error: function () {
                //alert('Error en datos turno!');
            }
        });
    };
});


