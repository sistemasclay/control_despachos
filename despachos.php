<?
 session_start();
 
$fecha_filtro = time();

include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

	if($_POST["fechai"])
	{
		if($_POST["fechai"] > $_POST["fechaf"])
		{
			echo "La fecha de inicio debe ser menor al fecha final";
			$_POST["tipo"]=100;
			echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
		}
		$_POST["fechai"]=$_POST["fechai"]." 00:00:00";
		$_POST["fechaf"]=$_POST["fechaf"]." 23:59:59";
		
		$recordSet = $datos->listar_despachos_fechas($_POST["fechai"], $_POST["fechaf"]);
	}
	else{
		$recordSet=$datos->listar_despachos();
	}
	
$pagina = $pagina.'?seccion=despachos';
?>
			<div id="titulo">
				<h1>DESPACHOS</h1>
				<h2>Aquí podra ver la lista de despachos que han sido monitoreados por esta aplicación</h2>
				<br>
				<form class="forma" action="<?$pagina?>" method="post" name="busqueda">
					<table class="tforma">
						<tr>
							<td  class="etq">
								Filtro de Fechas
							</td>
							<td>
								<input class="ctxt" type="text" name="fechai" id="fechai" onclick="displayCalendar(document.forms[0].fechai,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha_filtro);?>"/>
							</td>
							<td>
								<input class="ctxt" type="text" name="fechaf" id="fechaf" onclick="displayCalendar(document.forms[0].fechaf,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha_filtro);?>"/>
							</td>
							<td>
								<input class="btn" type="submit" />
							</td>
							
						</tr>
					</table>
				</form>
			</div>
                <!--div principal-->
                <!--  overflow: scroll; -->
			<div id="contenido">
				<br>
				<div id="lista_despachos" class="scrollstyle">
					<table class="tinfo">
						<tr>
							<th><div class="tooltip">Despacho<span class="tooltiptext">Usuario quien hizo el despacho</span> </div></th>
							<th><div class="tooltip">Realizado Por <span class="tooltiptext">Usuario quien hizo el despacho</span> </div></th>
							<th><div class="tooltip">Fecha Despacho <span class="tooltiptext">Fecha del despacho</span></th>
							<th>Ver</th>
						</tr>
<?
		
		//echo $recordSet;
		$color=array('impar','par');
		$c_estilo=0;
		
		while (!$recordSet->EOF) {
			$usuario = $datos->detalle_usuario($recordSet->fields['despachador']);
							if($c_estilo%2!=0)
							echo '<tr class="'.$color[0].'">';
					else
							echo '<tr class="'.$color[1].'">';
		echo "
		<td>".$recordSet->fields['id_despacho']."</td>
		<td>".$usuario->fields['nombre_usuario']."</td>
		<td>".$recordSet->fields['fecha_despacho']."</td>
		<td><a href=principal?seccion=despacho&id_despacho="
				.$recordSet->fields['id_despacho']."><img src=\"imagenes/edit1.png\"> </a></td>
		</tr>
		";
		$c_estilo++;
		$recordSet->MoveNext();
		}
?>
					</table>
				</div>
			</div>
            <!-- fin div principal-->