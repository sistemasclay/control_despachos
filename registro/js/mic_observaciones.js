var estado = 0;//para iniciar turno
var turno = {};
turno.observaciones = "";

//modulos.titulos = new Array();
//modulos.titulos.rss = "Lector RSS";

//proceso,numeroOperarios
$(function () {
    // validarReponer();
    $(".number").each(function (index) {
        $(this).click(function () {
            var digIn = $(this).data("val");
            switch (digIn) {
                case "ok":
                    procesarInformacion(document.getElementById("dataIn").value );
                    break;
                case "cancel":
                    if(document.getElementById("dataIn").value  == ""){
						window.location.replace("mic_cerrar_turno.php?proceso="+proceso);
					}
					/*else{
						$("#dataIn").text("Digite")
					}*/
                    break;
                default:
                    /*var dataInput = $("#dataIn").text() + digIn;
                    $("#dataIn").text(dataInput);*/
            }
        });

        $(this).on({"touchstart mousedown": function onInteraction(e) {
                $(this).css("background-color", "gray");
            }, "mouseup": function onInteractionEnd(e) {
                $(this).css("background-color", "black");
            }});

        $(this).mouseup(function () {
            $(this).css("background-color", "black");
        })
                .mousedown(function () {
                    $(this).css("background-color", "gray");
                });

    });
});

var procesarInformacion = function (entrada) {
    switch (estado) {
        case 0:
			turno.maquina = proceso;
			turno.observaciones = entrada;
			estado = 9;
			guardarObservaciones(turno)
            break;
        default:
    }
}

var guardarObservaciones = function (turno) {

    var jsTurno = JSON.stringify(turno);
    $.ajax({
        url: "turno.php",
        type: "post",
        datatype: 'json',
        data: {estado: estado,
            turno: jsTurno},
        success: function (data) {
            res = JSON.parse(data);
            if (res.resultado) {
               window.location.replace("seleccion_proceso.php");
            } else {
                //window.location.replace("mic_observaciones.php?proceso="+proceso);
                window.location.replace("seleccion_proceso.php");
            }
        },
        error: function () {
            //alert('error al validar!');
        }
    });
};