<?
 session_start();
 
include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

$pagina = $pagina.'?seccion=lote';
 

//echo $pagina;
    if($_GET["id_lote"] )
    {
		$lote = $_GET["id_lote"];
		$datos_lote = $datos->detalle_lote_solicitud($_GET["id_lote"]);
		
    }
	
?>
			<div id="titulo">
				<br>
				<form class="forma" action="<?$pagina?>" method="post" name="busqueda">
					<input type="hidden" name="id_loteb" id="id_loteb" value="<?echo $lote?>"/>
					<input type="hidden" name="id_despacho" id="id_despacho" value="<?echo $despacho?>"/>
					<table class="tforma">
						<tr>
							<!--<td class="etq">
								<input type="Checkbox" name="multplicar" id="multplicar"/> Unidades Contadas <input class="ctxt" name="cantidad" type="text" id="cantidad"/>
							</td>-->
							<td  class="etq">
								Producto
							</td>
							<td>
								<input class="ctxt" name="barras_producto" type="text" id="barras_producto" autofocus/>
							</td>
							<td class="etq">
								Eliminar<input type="Checkbox" name="eliminar" id="eliminar"/>
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
				<div id="lista_despacho" class="scrollstyle">
					<!--<IMG class="btn_guardar" SRC="imgs/3.png" ALT="Guardar" onmouseover="src='imgs/3A.png'" onMouseOut="src='imgs/3.png'" onclick="accion()" align="center">-->
					<table class="tinfo">
						<tr>
							<th><div class="tooltip">LOTE<span class="tooltiptext">Codigo del lote</span> </div></th>
							<th><div class="tooltip">Producto<span class="tooltiptext">Nombre del producto a despachar</span> </div></th>
							<th><div class="tooltip">Fecha<br>Fabricación<span class="tooltiptext">Fecha de fabricación del lote</span></th>
							<th><div class="tooltip">Fecha<br>Vencimiento<span class="tooltiptext">Fecha de vencimiento del lote</span></th>
							<th><div class="tooltip">Cantidad<span class="tooltiptext">Cantidad total de producto que se tiene registrada en el lote</span></th>
							<!--<th>Eliminar</th>-->
						</tr>
<?
		
		//$datos_lote;
		//echo $datos_lote;
		$color=array('impar','par');
		$c_estilo=0;
		
		$lotes = $datos->listar_lotes();
		
		while (!$lotes->EOF) {
			
			$producto = $datos->detalle_producto_id($lotes->fields['id_producto']);
			
			//se define el color de la fila
			if($c_estilo%2!=0)
				$fila = $color[0];
			else
				$fila = $color[1];
						
			echo '<tr>';	
			echo "<td class=\"".$fila."\">".$lotes->fields['id_lote']."</td>";
			echo "<td class=\"".$fila."\">".$producto->fields['nombre_producto']."</td>";
			echo "<td class=\"".$fila."\">".$lotes->fields['fecha_fabricado']."</td>";
			echo "<td class=\"".$fila."\">".$lotes->fields['fecha_vence']."</td>";
			echo "<td class=\"".$fila."\">".$lotes->fields['cantidad']."</td>";
			echo "</tr>";
			//<td><a onclick='return confirm(\"¿Seguro que desea eliminar  ".$datos_lote->fields['nombre_persona']."?\")' href=formsubmit_config.php?seccion=eliminar_empleado&codigo_empleado="
			//		.$datos_lote->fields['id_persona']."><img src=\"imagenes/delete3.png\"> </a></td>
			
			$c_estilo++;
			$lotes->MoveNext();
		}

?>
					</table>
				</div>
			</div>
            <!-- fin div principal-->
