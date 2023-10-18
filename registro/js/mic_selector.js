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
                $(this).css("background-color", "green");
            }, "mouseup": function onInteractionEnd(e) {
                $(this).css("background-color", "black");
            }});

        $(this).mouseup(function () {
                    $(this).css("background-color", "black");
                })
                .mousedown(function () {
                    $(this).css("background-color", "green");
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
            turno.operario[nOperario] = dato;
            nOperario++;
            if (nOperario < numeroOperarios) {
                $("#title").text("Código Operario "+ (nOperario+1) );
                $("#dataIn").text("Digite");
            } else {
                $("#title").text("Orden de Producción");
                $("#dataIn").text("Digite");
                estado = 1;
            }
            break;
        case 1:
            $("#title").text("Código de Producto");
            $("#dataIn").text("Digite");
            turno.op = dato;
            estado = 2;
            break;
        case 2:
            $("#title").text("Lote");
            $("#dataIn").text("Digite");
            turno.producto = dato;
            estado = 3;
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

    var validarReponer = function () {
        $.ajax({
            url: "turno.php",
            type: "post",
            data: {estado: 5,
                maquina: proceso},
            datatype: 'json',
            success: function (data) {
                res = JSON.parse(data);
                if (res.resultado) {
                    var datosTurno = res.resultado;
                    if(datosTurno.estadoTurno==1){
                         window.location.replace("mic_contando.php?proceso="+proceso);
                    }
                } else {

                }
            },
            error: function () {
                //alert('Error en datos turno!');
            }
        });
    };

var abrirTurno = function (turno) {

    var jsTurno = JSON.stringify(turno);
    $.ajax({
        url: "turno.php",
        type: "post",
        datatype: 'json',
        data: {estado: estado,
            turno: jsTurno},
        success: function (data) {
            res = JSON.parse(data);
            var datosTurno = res.resultado;
            if (datosTurno.estadoTurno == 1) {
//                window.location.replace("mic_contando.php?proceso="+proceso);
                window.location.replace("seleccion_proceso.php");
            }else{
                $("#dataIn").text("Invalido!");
                window.location.replace("mic_inicio.php?proceso="+proceso);
            }
        },
        error: function () {
            //alert('error al validar!');
        }
    });
};