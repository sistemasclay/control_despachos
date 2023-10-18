<?
 session_start();

/**
 **	ESTA ES LA SECCION EN LA QUE SE VEN TODAS LAS REMISIONES CARGADAS EN EL SISTEMA EN EL ARCHIVO DEL DIA
 **/
 
include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

$pagina = $pagina.'?seccion=despacho';


//echo $pagina;
    if($_GET["id_despacho"])
    {
		$despacho = $_GET["id_despacho"];
    }
	if($_GET["id_remision"]){
		$remision = $_GET["id_remision"];
		if(!$datos->comprobar_fin_remision($remision, $despacho)){
			$datos->asignar_fin_remision($remision, $despacho);
		}
	}
		
	$datos_despacho = $datos->consultar_remisiones_despacho_historico();
	
?>

			<div id="titulo">
				
			</div>
                <!--div principal-->
                <!--  overflow: scroll; -->
			<div id="contenido">
				<!--<div id="datos" class="scrollstyle">
					<IMG class="btn_guardar" SRC="imgs/terminar.png" ALT="Guardar" onmouseover="src='imgs/terminarA.png'" onMouseOut="src='imgs/terminar.png'" onclick="accion()">
					
				</div>-->
				<div id="lista_despacho" class="scrollstyle">
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
//$datos_despacho;
//echo $datos_despacho;
$color=array('impar','par');
$c_estilo=0;

//PRIMER CICLO PARA VERIFICAR LA INFORMACIÓN DE LAS REMISIONES DEL DESPACHO
while (!$datos_despacho->EOF) {
		$datos->verificar_remision($datos_despacho->fields['id_remision']);
		$datos_despacho->MoveNext();
}
//SE REINICIA EL ARRAY PARA IMPRIMIR EL LISTADO CORRECTAMENTE
$datos_despacho->MoveFirst();


while (!$datos_despacho->EOF) {

	//se define el color de la fila
	if($c_estilo%2!=0)
		$fila = $color[0];
	else
		$fila = $color[1];
	
	if($datos_despacho->fields['estado']==0)
		$celda = 'menor';//COLOR ROJO
	else
		$celda = 'correcto';//COLOR VERDE

	
		echo '<tr>';	
		echo "<td class=\"".$fila."\">".$datos_despacho->fields['id_remision']."</td>";
		echo "<td class=\"".$fila."\">".$datos_despacho->fields['nombre_cliente']."</td>";
		echo "<td class=\"".$celda."\">".$datos_despacho->fields['estado']."</td>";
		echo "<td class=\"".$fila."\">".$datos_despacho->fields['fecha_inicio']."</td>";
		echo "<td class=\"".$fila."\">".$datos_despacho->fields['fecha_fin']."</td>";
		echo "<td class=\"".$fila."\"><a href=principal?seccion=remision&id_despacho=$despacho&id_remision="
				.$datos_despacho->fields['id_remision']."><img src=\"imagenes/edit1.png\"> </a></td>";
		echo "</tr>";
		//<td><a onclick='return confirm(\"¿Seguro que desea eliminar  ".$datos_despacho->fields['nombre_persona']."?\")' href=formsubmit_config.php?seccion=eliminar_empleado&codigo_empleado="
		//		.$datos_despacho->fields['id_persona']."><img src=\"imagenes/delete3.png\"> </a></td>
		
		$c_estilo++;
		$datos_despacho->MoveNext();
}

?>
					</table>
				</div>
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