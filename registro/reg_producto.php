<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();

if($_GET["parametro"])
{
	$datos = $logicaTurno->detalleMaquina($_GET["parametro"]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_reg_producto.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="js/mic_inicio.js"></script>
        <title>Monitoreo y Control</title>
        <script>
<?php// echo "var proceso = " . $_REQUEST["proceso"] . ";"; ?>
<?php// echo "var numeroOperarios = " . $numeroOperarios . ";"; ?>
        </script>
    </head>
    <body data-estado="inicio" data-loading="off">
		<div class="container main" id="main">
			<div class="info">
				<form class="forma" id="registro" name="registro" method="post" action="formsubmit_config.php">
						<div>
							MAQUINA
						</div>
						<div>
							<datalist id="maquinas" >
								<?
									$maquinas = $logicaTurno->getMaquinas();
									while(!$maquinas->EOF){
										echo '<option value="'.$maquinas->fields['id_proceso'].'" label="'.$maquinas->fields['nombre'].'"></option>';
										$maquinas->MoveNext();
									}
								?>
							</datalist>
							<input <?if($_GET["parametro"]){?>value="<?echo $_GET["parametro"];?>"<?}?>list="maquinas" name="maquinas" id="id_maquina" onchange="cargarDatosPorID()">
						</div>
						<?
						if($_GET["parametro"]){
						?>
						<div>
							PRODUCTO
						</div>
						<div>
							<datalist id="productos" >
								<?
								$productos = $logicaTurno->getProductosMaquina($_GET["parametro"]);
								while(!$productos->EOF){
									echo '<option value="'.$productos->fields['id_producto'].'" label="'.$productos->fields['nombre_producto'].'"></option>';
									$productos->MoveNext();
								
								}
								?>
							</datalist>
							<input list="productos" name="productos" id="id_producto">
						</div>
						<?
						}
						?>
				</form>
			</div>
        </div>
        <div class="container footer" id="footer">
            <div class="textFotter">PEGASUS PRO <span class="textFotter2"> by </span> <span class="textFotter3"> M&C </span> </div>
        </div>
<script>
function cargarDatosPorID() {
    var por_id = document.getElementById("id_maquina").value;
	var page = "reg_producto?parametro=";
	var page = page.concat(por_id);
	window.location.replace(page);
}
</script>
    </body>
</html>