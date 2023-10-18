<?
 session_start();
 
include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

$pagina = $pagina.'?seccion=productos';
//echo $pagina;
    if($_GET["codigo_producto"])
    {
		$datos_producto = $datos->detalle_producto_id($_GET["codigo_producto"]);
   // echo $datos_proceso->fields["nombre"]."-".$datos_proceso->fields["id_proceso"];
    }
	else
	{
		if($_POST["codigo_productob"])
		{
			$datos_producto = $datos->detalle_producto_id($_POST["codigo_productob"]);
		}
	}
?>
			<div id="titulo">
				<h1>PRODUCTOS</h1>
				<h2>Aquí podra consultar la información de un producto usando el codigo de barras</h2>
				<br>
				<form class="forma" action="<?$pagina?>" method="post" name="busqueda">
						<table class="tforma">
							<tr>
								<td  class="etq">
									Busqueda Rapida
								</td>
								<td>
									<input class="ctxt" name="codigo_productob" type="text" id="codigo_productob" />
								</td>
								<td colspan="2">
									<input class="btn" type="submit" />
								</td>
							</tr>
						</table>
					</form>
			</div>
                <!--div principal-->
                <!--  overflow: scroll; -->
				<br>
			<div id="contenido">
				<div id="datos" class="scrollstyle">
					
					<form class="forma" id="fproductos" name="fproductos" method="post" action="formsubmit_config.php">
						<input type="hidden" name="seccion" id="seccion" value="productos"/>
						<table class="tforma" >
							<tr>
								<td class="etq">
									Codigo:
								</td>
								<td>
									<input class="ctxt" type="text" <? if($datos_producto->fields["id_producto"]!=""){ echo "readonly='readOnly'";  } ?> name="codigo_producto" id="codigo_producto" value ="<? echo $datos_producto->fields["id_producto"];   ?>"/>
								</td>
							</tr>
							<tr>
								<td class="etq">
									Nombre:
								</td>
								<td>
									<input class="ctxt" type="text" name="nombre_producto" id="nombre_producto" value ="<? echo $datos_producto->fields["nombre_producto"];?>" />
								</td>
							</tr>
							<tr>
								<td class="etq">
									Codigo Barras
								</td>
								<td>
									<input class="ctxt" type="text" name="cod_barras" id="cod_barras" value ="<? echo $datos_producto->fields["codigo_barras"];?>" />
								</td>
							</tr>
							<tr>
								<td class="etq">
									Codigo Final
								</td>
								<td>
									<input class="ctxt" type="text" name="cod_final" id="cod_final" value ="<? echo $datos_producto->fields["codigo_final"];?>" />
								</td>
							</tr>
							<tr>
								<td class="etq">
									Cant Empaque Final
								</td>
								<td>
									<input class="ctxt" type="text" name="cant_empaque_final" id="cant_empaque_final" value ="<? echo $datos_producto->fields["cant_empaque_final"];?>" />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input class="btn" type="submit" name="Submit" value="Guardar" />
								</td>
							</tr>
						</table>
					</form>
				</div>
				<div id="lista" class="scrollstyle">
					<table class="tinfo">
						<tr>
							<th><div class="tooltip">Codigo </div></th>
							<th><div class="tooltip">Nombre </div></th>
							<th><div class="tooltip">Codigo <br>Empaque <br>Primario </div></th>
							<th><div class="tooltip">Codigo <br>Empaque <br>Final </div></th>
							<th><div class="tooltip">Cantidad<br>Empaque Final</div></th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
<?
		$recordSet=$datos->listar_productos();
		//echo $recordSet;
		$color=array('impar','par');
		$c_estilo=0;
		
		while (!$recordSet->EOF) {
		
							if($c_estilo%2!=0)
							echo '<tr class="'.$color[0].'">';
					else
							echo '<tr class="'.$color[1].'">';
		echo "
		<td>".$recordSet->fields['id_producto']."</td>
		<td>".$recordSet->fields['nombre_producto']."</td>
		<td>".$recordSet->fields['codigo_barras']."</td>
		<td>".$recordSet->fields['codigo_final']."</td>
		<td>".$recordSet->fields['cant_empaque_final']."</td>
		<td><a href=$pagina&&codigo_producto="
				.$recordSet->fields['id_producto']."><img src=\"imagenes/edit1.png\"> </a></td>
			<td><a onclick='return confirm(\"¿Seguro que desea eliminar  ".$recordSet->fields['nombre_producto']."?\")' href=formsubmit_config.php?seccion=eliminar_producto&codigo_producto="
				.$recordSet->fields['id_producto']."><img src=\"imagenes/delete3.png\"> </a></td>
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