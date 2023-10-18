<?
 session_start();
 
$fecha_filtro = time();
$fecha_inicial ="";
$fecha_final ="";

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
		
		$recordSet = $datos->listar_despachos_fechas_nuevo($_POST["fechai"], $_POST["fechaf"]);
		$fecha_inicial = $_POST["fechai"];
		$fecha_final = $_POST["fechaf"];
	}else{
		$fecha_final = $fecha_filtro;
				$fecha_final = $fecha_filtro;

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
				                <?php if($recordSet !=null) {?>

				<br>
				<div id="lista_despachos" class="scrollstyle">
					<table class="tinfo" id="example">
						<thead>
							<th><div class="tooltip">#</br>REMISION<span class="tooltiptext">Numero de remisión</span> </div></th>
							<th><div class="tooltip">CLIENTE<span class="tooltiptext">Cliente al cual se le está enviando la remisión</span></th>
							<th><div class="tooltip">ESTADO<span class="tooltiptext">Cambia dependiendo del estado de la remisión, ROJO: Pendiente. VERDE: Terminado.</span></th>
							<th><div class="tooltip">INICIO<span class="tooltiptext">Fecha y hora exacta de cuando se comenzó a remisionar la orden</span></th>
							<th><div class="tooltip">FIN<span class="tooltiptext">Fecha y hora exacta de cuando se terminó a remisionar la orden</span></th>
							<th><div class="tooltip">REMISIONAR<span class="tooltiptext">Se inicia el proceso de para remisionar</span></th>
							<!--<th>Eliminar</th>-->
						</thead>
<?
		
		//echo $recordSet;
		$color=array('impar','par');
		$c_estilo=0;
		
		while (!$recordSet->EOF) {
		//se define el color de la fila
	if($c_estilo%2!=0)
		$fila = $color[0];
	else
		$fila = $color[1];
	
	if($recordSet->fields['estado']==0)
		$celda = 'menor';//COLOR ROJO
	else
		$celda = 'correcto';//COLOR VERDE}
echo '<tr>';	
		echo "<td class=\"".$fila."\">".$recordSet->fields['id_remision']."</td>";
		echo "<td class=\"".$fila."\">".$recordSet->fields['nombre_cliente']."</td>";
		echo "<td class=\"".$celda."\">".$recordSet->fields['estado']."</td>";
		echo "<td class=\"".$fila."\">".$recordSet->fields['fecha_inicio']."</td>";
		echo "<td class=\"".$fila."\">".$recordSet->fields['fecha_fin']."</td>";
		echo "<td class=\"".$fila."\"><a href=principal?seccion=remision&id_despacho=".$recordSet->fields['id_despacho']."&id_remision="
				.$recordSet->fields['id_remision']."><img src=\"imagenes/edit1.png\"> </a></td>";
		echo "</tr>";

		$c_estilo++;
		$recordSet->MoveNext();
		}
?>
					</table>
				</div>
						<?php }?>

			</div>
            <!-- fin div principal-->
            <script>
   $(document).ready(function() {
        $('#example').DataTable({
            "bStateSave": true,
            "orderClasses": false,
            "fnStateSave": function(oSettings, oData) {
                localStorage.setItem('DataTables_' + window.location.pathname, JSON.stringify(oData));
            },
            "fnStateLoad": function(oSettings) {
                return JSON.parse(localStorage.getItem('DataTables_' + window.location.pathname));
            }
        });

    });
</script>