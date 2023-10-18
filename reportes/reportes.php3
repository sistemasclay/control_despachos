<?
 session_start();
include("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();
$fecha = time();
$pagina = $pagina.'?seccion=reportes';
?>
			<div id="titulo">
				<h1>REPORTES</h1>
			</div>
                <!--div principal-->
			<div id="contenido">
				<form class="forma" action="formsubmit.php" target="_blank" method="POST" name="parametros">
					<table class="tforma">
						<tr>
							<td class="etq">
								Seleccione un Producto
							</td>
							<td>
								<datalist name="prodd" id="productos" >
<?	
								$productos = $datos->listar_productos();
								while(!$productos->EOF){
									echo '<option value="'.$productos->fields['id_producto'].'" label="'.$productos->fields['nombre_producto'].'"></option>';
									$productos->MoveNext();
								}
?>
								</datalist>
								<input list="productos" name="id_producto" id="id_producto" class="caja_texto">
							</td>
						</tr>
						<tr>
							<td class="etq">
							DESDE
							</td>
							<td class="etq">
							HASTA
							</td>
						</tr>
						<tr>
							<td>
								<input class="ctxt" type="text" name="fechai" id="fechai" onclick="displayCalendar(document.forms[0].fechai,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha);  ?>"/>
							</td>
							<td>
								<input class="ctxt" type="text" name="fechaf" id="fechaf" onclick="displayCalendar(document.forms[0].fechaf,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha);  ?>"  />
							</td>
						</tr>
						<tr>
							<td class="etq">
								Seleccione un reporte
							</td>
							<td colspan="2">
								<select class="lista" size="1" name="tipo" id="tipo">
								<option value="1" >Bitacora de Registros</option>
								<option value="2" >Grafica de Rangos</option>
								<option value="3" >Reporte Defectos</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input class="btn"  type="submit" value="Ver Reporte"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
            <!-- fin div principal-->