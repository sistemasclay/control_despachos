var estado = 7;

$(function () {
   // validarReponer();
    $("#title").text("Causal de Parada");
    $(".number").each(function (index) {
        $(this).click(function () {
            var digIn = $(this).data("val");
            if ($("#dataIn").text() == "Digite" || $("#dataIn").text() == "Invalido!") {
                $("#dataIn").text("")
            }
            switch (digIn) {
                case "ok":
                    validarInformacion($("#dataIn").text());
                    break;
                case "cancel":
                    if($("#dataIn").text() == ""){
						window.location.replace("mic_paro.php?proceso="+proceso);
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


var validarInformacion = function (codigo) {
    $.ajax({
        url: "turno.php",
        type: "post",
        data: {estado: estado,
            maquina: proceso,
            codigo: codigo},
        datatype: 'json',
        success: function (data) {
            res = JSON.parse(data);
            if (res.resultado) {
                window.location.replace("seleccion_proceso.php");
            } else {
                $("#dataIn").text("Invalido!");
            }
        },
        error: function () {
            //alert('error al validar!');
        }
    });
};