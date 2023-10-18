var estado = 0;//para iniciar turno
var nOperario = 0;
var usuario;

var turno = {};
turno.operario = {};
turno.op = "";
turno.producto = "";
turno.lote = "";
//modulos.titulos = new Array();
//modulos.titulos.rss = "Lector RSS";

//proceso,numeroOperarios
$(function () {
    $("#title").text("Código Operario "+ (nOperario+1) );
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
                    $("#dataIn").text("Digite")
                    break;
                default:
                    var dataInput = $("#dataIn").text() + digIn;
                    $("#dataIn").text(dataInput);
            }
        });

        $(this).on({"touchstart mousedown": function onInteraction(e) {
                $(this).css("background-color", "#303030");
            }, "mouseup": function onInteractionEnd(e) {
                $(this).css("background-color", "black");
            }});

        $(this).mouseup(function () {
                    $(this).css("background-color", "black");
                })
                .mousedown(function () {
                    $(this).css("background-color", "#303030");
                });

    });
});

var procesarInformacion = function (entrada) {
    switch (estado) {
        case 0:
            validarInformacion(entrada);
            break;
        case 1:
            validarInformacion(entrada);
            break;
        case 2:
            validarInformacion(entrada);
            break;
        case 3:
            turno.maquina = proceso;
            turno.lote = entrada;
            estado = 4;
            abrirTurno(turno);
            break;
        default:
    }
}

var evolucionar = function (dato) {
    switch (estado) {
        case 0:
			usuario = dato;
			if (opcion == 0){
				estado = 11; //sacar usuario del turno
			}
			else{
				estado = 12; //ingresar usuario al turno
			}
			
			ejecutar(usuario);
			
			break;
        default:
    }

}
var validarInformacion = function (codigo) {
    $.ajax({
        url: "turno.php",
        type: "post",
        data: {estado: estado,
            codigo: codigo},
        datatype: 'json',
        success: function (data) {
            res = JSON.parse(data);
            if (res.resultado) {
                evolucionar(res.dato);
            } else {
                $("#dataIn").text("Invalido!");
            }
        },
        error: function () {
            //alert('error al validar!');
        }
    });
};

var ejecutar = function (usuario) {
    $.ajax({
        url: "turno.php",
        type: "post",
        datatype: 'json',
        data: {estado: estado,
            usuario: usuario,
			maquina: proceso},
        success: function (data) {
            res = JSON.parse(data);
            if (res.resultado) {
                window.location.replace("seleccion_proceso.php");
            }else{
                $("#dataIn").text("Invalido!");
                window.location.replace("mic_teclado.php?proceso="+proceso+"&&opcion="+opcion);
            }
        },
        error: function () {
            //alert('error al validar!');
        }
    });
};