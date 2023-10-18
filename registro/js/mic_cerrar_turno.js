var estado = 0;//para iniciar turno
var nMaterial = 0;
var numeroMaterial = 3;
var desperdicios = {};
var etiq = "";
var turno = {};
turno.materiales = {};
turno.pruduccionFinal = "";

//modulos.titulos = new Array();
//modulos.titulos.rss = "Lector RSS";

//proceso,numeroOperarios
$(function () {
    // validarReponer();
	traerEtiquetas();
    $("#title").text(desperdicios[nMaterial]);
    $(".number").each(function (index) {
        $(this).click(function () {
            var digIn = $(this).data("val");
            if ($("#dataIn").text() == "Digite" || $("#dataIn").text() == "Invalido!") {
                $("#dataIn").text("")
            }
            switch (digIn) {
                case "ok":
                    procesarInformacion($("#dataIn").text());
                    break;
                case "cancel":
                    if($("#dataIn").text() == ""){
						window.location.replace("mic_contando.php?proceso="+proceso);
					}
					else{
						$("#dataIn").text("Digite")
					}
                    break;
                default:
                    var dataInput = $("#dataIn").text() + digIn;
                    $("#dataIn").text(dataInput);
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
            evolucionar(entrada);
            break;
        case 1:
            turno.maquina = proceso;
            turno.pruduccionFinal = entrada;
            estado = 8;
            cerrarTurno(turno);
            break;
        default:
    }
}

var evolucionar = function (dato) {
    switch (estado) {
        case 0:
            turno.materiales[nMaterial] = dato;
            nMaterial++;
            if (nMaterial < numeroMaterial) {
                $("#title").text(desperdicios[nMaterial]);
                $("#dataIn").text("Digite");
            } else {
                $("#title").text(etiq);
                $("#dataIn").text("Digite");
                estado = 1;
            }
            break;

        default:
    }

}

	var traerEtiquetas = function () {
        $.ajax({
            url: "turno.php",
            type: "post",
            data: {estado: 10,
                maquina: proceso},
            datatype: 'json',
            success: function (data) {
                res = JSON.parse(data);
                if (res.resultado) {
                    var datosTurno = res.resultado;
					desperdicios[0] = datosTurno.desp1;
					desperdicios[1] = datosTurno.desp2;
					desperdicios[2] = datosTurno.desp3;
					etiq = datosTurno.prod;
					
                } else {

                }
            },
            error: function () {
                //alert('Error en datos turno!');
            }
        });
    };

var cerrarTurno = function (turno) {

    var jsTurno = JSON.stringify(turno);
    $.ajax({
        url: "turno.php",
        type: "post",
        datatype: 'json',
        data:{estado: estado,
            turno: jsTurno},
        success: function (data) {
            res = JSON.parse(data);
            if (res.resultado) {
               window.location.replace("seleccion_proceso.php");
            } else {
                window.location.replace("mic_cerrar_turno.php?proceso="+proceso);
            }
        },
        error: function () {
            //alert('error al validar!');
        }
    });
};