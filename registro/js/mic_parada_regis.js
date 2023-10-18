$(function () {
   // validarInformacion();
    var tid = setInterval(traerDatos, 500);
    function traerDatos() {
        validarInformacion();

    }
    function abortTimer() { // to be called when you want to stop the timer
        clearInterval(tid);
    }

    var validarInformacion = function (codigo) {

        $.ajax({
            url: "turno.php",
            type: "post",
            data: {estado: 6,
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
                    else if(datosTurno.enParo==0){
                        window.location.replace("mic_contando.php?proceso="+datosTurno.maquina);
                    }
					else if(datosTurno.registrada==1){
						window.location.replace("mic_paro.php?proceso=" + datosTurno.maquina);
					}
                    $("#maquina").text(datosTurno.nom_maquina);
                    $("#turno").text("Turno " + datosTurno.turno);
                    $("#time").text(datosTurno.tiempo);
                } else {

                }
            },
            error: function () {
                //alert('Error en datos turno!');
            }
        });
    };
});



