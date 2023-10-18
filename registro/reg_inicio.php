<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();
$procesos_abiertos = $logicaTurno->listar_procesos_calidad_activos();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
		<meta http-equiv="refresh" content="5">
        <link rel="stylesheet" type="text/css" href="css/reset.css"/>
        <link rel="stylesheet" type="text/css" href="css/styles_reg_inicio.css"/>
        <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
        <title>Control de Calidad</title>
        <script>
<?php// echo "var proceso = " . $_REQUEST["proceso"] . ";"; ?>
<?php// echo "var numeroOperarios = " . $numeroOperarios . ";"; ?>
        </script>
    </head>
    <body data-estado="inicio" data-loading="off">
			<div class="logos">
				<div class="logo1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div><div class="logo2"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div>
			</div>
			<div class="linea_divisora">.</div>
			<div class="titulos">
				<table class="tabla_titulos">
					<tr>
						<td>
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
					<tr>
						<td class="espacio_blanco">.</td>
						<td class="boton">
							<a class="link" href="reg_abrir"><div class="text">ABRIR</div></a>
						</td>
						<td class="espacio_blanco">.</td>
					</tr>
					<tr>
						<td>
							<img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0>
						</td>
					</tr>
				</table>
			</div>
			
<script>
	function Blink()
	{
		var ElemsBlink = document.getElementsByTagName('blink');
		for(var i=0;i<ElemsBlink.length;i++)
		ElemsBlink[i].style.visibility = ElemsBlink[i].style.visibility
		=='visible' ?'hidden':'visible';
	}

	function parpadear() {
		with (document.getElementById("parpadeo").style)
		visibility = (visibility == "visible") ? "hidden" : "visible";
	}
</script>

			<div class="linea_divisora">.</div>
			<div class="info">
				<table class="tabla_info">
					<tr class="impar">
						<th class="producto">Producto</th>
						<th class="estado">Info</th>
						<th class="proceso">Proceso</th>
						<th class="cerrar">Cerrar</th>
						<th class="cambiar">Usuario</th>
					</tr>
<?
$color=array('impar','par');
$colordiv=array('divpar','divimpar');
$c_estilo=0;
if($procesos_abiertos){
	while (!$procesos_abiertos->EOF) {
		
		/* 0. reiniciar variables internas */
		$producto = "";
		$maquina = "";
		$estado = "";
		$proc_prov= "";
		$tipo= "";
		
		/*1. definir color de la fila*/
		
		if($c_estilo%2!=0){
			echo '<tr class="'.$color[0].'">';
			$divcolor = $colordiv[0];
		}
				
		else{
			echo '<tr class="'.$color[1].'">';
			$divcolor = $colordiv[1];
		}
		
		/* Fin 1. */
		
		/* 2. traer logicaTurno adicionales necesarios, nombres de producto y maquina de ser fabricado */
		
		$producto = $logicaTurno->traer_info_producto($procesos_abiertos->fields["id_producto"]);
		
		if($procesos_abiertos->fields["id_maquina"]){
			$maquina = $logicaTurno->traer_info_maquina($procesos_abiertos->fields["id_maquina"]);
		}
		
		/* Fin 2. */
		
		/* 3. indicar si el registro corresponde a una revision de importacion o fabricacion */
		
		if($maquina){
			$proc_prov= $maquina->fields["nombre"];
			$tipo = 1;
			$proceso= $procesos_abiertos->fields["id_maquina"];
		}
		else{
			$proc_prov= "IMPORTADO";
			$tipo = 2;
			$proceso= $procesos_abiertos->fields["id_proveedor"];
		}
		/* Fin 3. */
		
		/* 4. definir estado */
		if($procesos_abiertos->fields["estado"] == 1){
			$estado = "E1";
		}
		else if($procesos_abiertos->fields["estado"] == 2){
			$estado = "E2";
		}
		else if($procesos_abiertos->fields["estado"] == 3){
			$estado = "E3";
		}
		/* Fin 4. */
		//?tipo=".$tipo."&proceso=".$proceso."&producto=".$producto."&usuario=".$usuario.
		echo "<td class=\"producto\"><a class=\"link\" href= \"reg_parametros?tipo=".$tipo."&proceso=".$proceso."&producto=".$producto->fields['id_producto']."&usuario=".$procesos_abiertos->fields["id_usuario"]."&lote=".$procesos_abiertos->fields['lote']."&op=".$procesos_abiertos->fields['orden_produccion']."\">".$producto->fields['nombre_producto']."</a></td>";
		echo "<td class=\"estado\"><div><img src=\"css/imagenes/".$estado .".png\" WIDTH=50 HEIGHT=50 BORDER=0/></div></td>";
		echo "<td class=\"proceso\">".$proc_prov."</td>";
		//echo "<td class=\"cerrar\"><a href=\"formsubmit?seccion=cerrar_turno&turno_muestreo=".$procesos_abiertos->fields["id_turno_muestreo"]."\"> <img src=\"css/imagenes/salir5.png\" WIDTH=50 HEIGHT=50 BORDER=0/> </a> </td>";
		echo "<td class=\"cerrar\"><a onclick='return confirm(\"¿Seguro que desea cerrar el turno de muestreo?\")' href=formsubmit?seccion=cerrar_turno&turno_muestreo=".$procesos_abiertos->fields["id_turno_muestreo"]."><img src=\"css/imagenes/salir5.png\" WIDTH=50 HEIGHT=50 BORDER=0/> </a> </td>";
		echo "<td class=\"cambiar\"><a href=\"reg_cambio?registro=".$procesos_abiertos->fields["id_registro"]."\"><img src=\"css/imagenes/user.png\" WIDTH=50 HEIGHT=50 BORDER=0/> </a> </td>";
		echo "</tr>";
		$c_estilo++;
		$procesos_abiertos->MoveNext();
	}
}
?>
				</table>
			</div>
			<div class="linea_divisora">.</div>
			<div class="piep">
				<a href="http://172.16.96.55/mantenimiento/index.php"><div class="piep1"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div></a><a href="http://172.16.96.203:809/mic/mic_central/seleccion_proceso.php"><div class="piep2"><img src="css/imagenes/cuadro.png" WIDTH=1 HEIGHT=1 BORDER=0></div>
			</div>
    </body>
</html>