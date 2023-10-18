<?
 session_start();
 
include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

$pagina = $pagina.'?seccion=remision';


    if($_GET["id_remision"] )
    {
		$remision = $_GET["id_remision"];
		$datos_remision = $datos->detalle_remision_solicitud($_GET["id_remision"]);
		if($_GET["id_despacho"]){	
			$despacho = $_GET["id_despacho"];
			if(!$datos->comprobar_inicio_remision($remision, $despacho)){
				$datos->asignar_inicio_remision($remision, $despacho);
			}
			if($_GET["id_lote"]){
				$lote = $_GET["id_lote"];
			}
		}		
    }
		
	if($_POST["barras_producto"])
	{
			$resultado = 1; // ESTA VARIABLE SERÁ 1 SI TODO ESTA EN ORDEN, 0 SI ENCUENTRA UN ERROR
			$pagina="principal?seccion=remision&id_remision=$remision&id_despacho=$despacho"; // REPRESENTA LA PÁGINA A LA QUE SE REDIRECCIONARÁ AL FINAL
			
			//PRIMERA PARTE.
			//Verificación del codigo de barras
			///Se quiere saber la información del producto al que pertenece este codigo de barras
			$despacho = $_POST['id_despacho'];
			$producto_r = $datos->detalle_producto_barras($_POST["barras_producto"],$remision);
			
			//SEGUNDA PARTE.
			//Verificación del lote
			//Se quiere saber lo siguiente: 
			//		1. Si hay información en el campo "lote"
			
			//este primer "IF" es para saber si el campo "lote" NO fue diligenciado
			/*if(!$_POST["lote"]){
				$resultado = 0;//se encontró un error debido a que no se diligenció el campo lote y el valor del resultado cambia a 0 (ERROR)
			}*/
			
			$cantidad = 1;
			if($datos->comprobar_remision_solicitud($remision, $producto_r->fields["id_producto"]) && $resultado==1){
				
				
				//SE AJUSTAN LAS CANTIDADES
				if($producto_r->fields["tipo_codigo"] == 2){
					//SI EL CODIGO QUE SE INGRESÓ ES EL DE LA CORRUGADA, ENTONCES SE MULTIPLICA POR LA CANTIDAD QUE SE EMPACA EN LA CORRUGADA
					$cantidad = $cantidad * $producto_r->fields["cant_empaque_final"];
				}
		echo'<script>
			var correct = document.getElementById("correct");
			correct.loop = false;
			correct.play(); 
		</script>';
				
				if($datos->comprobar_producto_remision_salida($remision, $producto_r->fields["id_producto"])){
					
					if($_POST["eliminar"]){
						$datos->restar_a_producto_remision($remision, $producto_r->fields["id_producto"],$cantidad);
					}
					else{
						$datos->sumar_a_producto_remision($remision, $producto_r->fields["id_producto"],$cantidad);
					}
				}
				else{
					if($_POST["eliminar"]){
						
					}
					else{
						$datos->registro_producto_remision($remision,$producto_r->fields["id_producto"],$cantidad);
					}
				}
				//CORRECTO
				$pagina = $pagina."&mensaje=1";
				
				//SE VERIFICA SI LA REMISION TERMINÓ, SI ESTA YA TERMINO, SE CIERRA AUTOMATICAMENTE
				/*if(!$datos->verificar_remision($remision)){
					echo '<script>location.href="principal?seccion=despacho&id_despacho='.$despacho.'&id_remision='.$remision.'";</script>';
				}*/
			}
			else{
				//ERROR
				$pagina = $pagina."&mensaje=2";				
			}
			//ECHO $producto_r;
			
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
	}

	if($_GET["mensaje"]==1){
?>
		<script>
			var correct = document.getElementById("correct");
			correct.loop = false;
			correct.play(); 
		</script>
<?
	}
	
	if($_GET["mensaje"]==2){
?>
		<script>
			var error = document.getElementById("error");
			error.loop = false;
			error.play(); 
		</script>
<?
	}
	
?>
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #13283f;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
			<div id="titulo">
				<h1>
				<img class="btn_guardar" src="imgs/3.png" alt="Guardar" onmouseover="src='imgs/3A.png'" onmouseout="src='imgs/3.png'" onclick="accion()" style="
    width: 120px;
    height: 40px;
">
				<?

				
echo '<a href="principal?seccion=despacho&id_despacho='.$despacho.'"><IMG class="btn_guardar" SRC="imgs/4.png" ALT="Guardar" onmouseover="src=\'imgs/4A.png\'" onMouseOut="src=\'imgs/4.png\'" width="120" height="40"></a>';
				?>
				</h1>
				<br>

			<form class="forma" action="<?$pagina?>" method="post" name="busqueda">
					<input type="hidden" name="id_remisionb" id="id_remisionb" value="<?echo $remision?>"/>
					<input type="hidden" name="id_despacho" id="id_despacho" value="<?echo $despacho?>"/>
					<table class="tforma">
						<tr>
							<!--  <td  class="etq">
								Lote
							</td>
							<td>
								<input class="ctxt" name="lote" type="text" id="lote" value = "<?echo $lote?>"/>
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
					<table class="tinfo2">
						<tr>
							<th><div class="tooltip">Producto<span class="tooltiptext">Nombre del producto a despachar</span> </div></th>
							<th><div class="tooltip">Cantidad<br>a despachar<span class="tooltiptext">Cantidad total que se debe despachar del producto</span></th>
							<th><div class="tooltip">Cantidad<br>despachando<span class="tooltiptext">Cantidad total de producto que se ha registrado para despachar</span></th>
							<th>Codigo Producto</th>								
							<th>Lote Producto</th>

						</tr>
<?
		
		//$datos_remision;
		//echo $datos_remision;
		$color=array('impar','par');
		$c_estilo=0;
		
		while (!$datos_remision->EOF) {
			$producto = $datos->detalle_producto_id($datos_remision->fields['p_pedido']);
			//se define el color de la fila
			if($c_estilo%2!=0)
				$fila = $color[0];
			else
				$fila = $color[1];
			//se define el color de la celda cantidad_despachada
			if($datos_remision->fields['cantidad_despachar']>$datos_remision->fields['cantidad_despachada'])
				$celda = 'menor';
			else if($datos_remision->fields['cantidad_despachar']<$datos_remision->fields['cantidad_despachada'])
				$celda = 'mayor';
			else
				$celda = 'correcto';
			
		echo '<tr>';	
		echo "<td class=\"".$fila."\">".$producto->fields['nombre_producto']."</td>";
		echo "<td class=\"".$fila."\">".$datos_remision->fields['cantidad_despachar']."</td>";
		echo "<td class=\"".$celda."\">".$datos_remision->fields['cantidad_despachada']."</td>";
		echo "<td class=\"".$fila."\">".$datos_remision->fields['id_producto']."</td>";
		echo "<td class=\"".$fila."\">".$datos_remision->fields['lote_producto']."</td>";
		echo "<td class=\"".$fila."\">"."<button id='myBtn' onclick=document.getElementById('myModal".$datos_remision->fields['id_producto']."').style.display='block' >Cambio Lote</button>"."</td>";
		echo "</tr>";
		//<td><a onclick='return confirm(\"¿Seguro que desea eliminar  ".$datos_remision->fields['nombre_persona']."?\")' href=formsubmit_config.php?seccion=eliminar_empleado&codigo_empleado="
		//		.$datos_remision->fields['id_persona']."><img src=\"imagenes/delete3.png\"> </a></td>
		
		echo "<div id='myModal".$datos_remision->fields['id_producto']."' class='modal'>


				  <div class='modal-content'>
				    <span class='close' id='myBtn' onclick=document.getElementById('myModal".$datos_remision->fields['id_producto']."').style.display='none' >x</span>
				    <h1 style='color: white;'>Cambiar lote producto ".$datos_remision->fields['id_producto']."</h1>
				    <h2 style='color: white;'>Nuevo Lote </h2>
				    <form class='forma' action='formsubmit_config.php' method='post' name='cambioLote'>
						<input type=hidden name=id_despacho id=id_despacho value='".$_GET["id_despacho"]."'/>
						<input type=hidden name=cambioLote id=cambioLote value='".$_GET["id_despacho"]."'/>
						<input type=hidden name=id_producto id=id_producto value='".$datos_remision->fields['id_producto']."'/>
						
						
						<input type=hidden name=id_remision id=id_remision value='".$_GET["id_remision"]."'/>

						
								<input style='font-size: 24px;
											padding: 7px;
											text-align: center;
											width: -webkit-fill-available;' class='ctxt' name='lote_producto' type='text' id='lote' placeholder='Lote Nuevo' autofocus autocomplete='off'/>

								<input style=' width: 87px;height: 57px;'class='btn' type='submit' />

							
				</form>
				  </div>

				</div>";


			;
		$c_estilo++;
		$datos_remision->MoveNext();
		}

?>
					</table>
				</div>
			</div>

            <!-- fin div principal-->

            <!-- Modal Cambio lote -->
           
				

<script>
	function accion() {
		var resultado = <?echo $datos->verificar_remision($remision);?>;
		//alert("<?echo $datos->verificar_remision($remision);?>");
		if(resultado == 1){
			alert("*OJO* NO SE PUEDE DESPACHAR POR QUE SE HAN REGISTRADO MENOS UNIDADES DE LO SOLICITADO");
		}
		else if(resultado == 2){
			alert("*OJO* NO SE PUEDE DESPACHAR POR QUE SE HAN REGISTRADO MÁS UNIDADES DE LO SOLICITADO");
		}
		else{
			alert("LA REMISION SE A FINALIZADO CON EXITO");
			location.href="principal?seccion=despacho&id_despacho=<?echo $despacho;?>&id_remision=<?echo $remision?>";
		}
	}
	


</script>