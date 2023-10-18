<? session_start();

$fecha = time();
include("../clases/progreso_op_clase.php");
$datos = new progreso_op();
$datos->reagrupar_ordenes();

$fechai;
$fechaf;

if($_POST["opcion"]=="fecha")
    {
            if($_POST["fechai"] > $_POST["fechaf"])
        {
           echo "La fecha de inicio debe ser menor al fecha final";
           $_POST["tipo"]=100;
           echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
        }
		$_POST["fechai"]=$_POST["fechai"]." 00:00:00";
		$_POST["fechaf"]=$_POST["fechaf"]." 23:59:59";
		
		$fechai = $_POST["fechai"];
		$fechaf = $_POST["fechaf"];

    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../estilos/myc_gral.css"/>
	<link rel="stylesheet" type="text/css" href="../tab/tabcontent.css"/>
	<script type="text/javascript" src="../tab/tabcontent.js"></script>
	<script type="text/javascript" src="../js/form-submit.js"></script>
	<script type="text/javascript" src="../js/ajax.js"></script>
	<script type="text/javascript" src="../js/livevalidation_standalone.compressed.js"></script>
	<link type="text/css" rel="stylesheet" href="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
	<script type="text/javascript" src="calendario/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
	<title>Pegasus PRO</title>
</head>

<body>
	<div id="contenedor">
		<?php require_once('../includes/cabecera.php'); ?>
		<div id="contenido">
			<h1>PROGRESO DE ORDENES DE PRODUCCION</h1>
			<table border=0 cellPadding=0 cellSpacing=0 width="100%">
				<tbody>
					<tr>
						<td align="center">
							<table border="0" align="center">
								<tr>
									</br>
										<ul id="progresstabs"  style="list-style:none" align="center">
											<li class="progresstabsli" align="center"><a href="#" rel="country1" class="selected"><img src="../img_progreso/2.png" WIDTH=180 HEIGHT=65 BORDER=0 onmouseover="src='../img_progreso/2A.png'"onMouseOut="src='../img_progreso/2.png'"/></a></li>
											<li class="progresstabsli" align="center"><a href="#" rel="country2"><img src="../img_progreso/1.png" WIDTH=180 HEIGHT=65 BORDER=0 onmouseover="src='../img_progreso/1A.png'"onMouseOut="src='../img_progreso/1.png'"/></a></li>
											<li class="progresstabsli" align="center"><a href="#" rel="country3"><img src="../img_progreso/3.png" WIDTH=180 HEIGHT=65 BORDER=0 onmouseover="src='../img_progreso/3A.png'"onMouseOut="src='../img_progreso/3.png'"/></a></li>
										</ul>
									</br>
									<td valign="top" align="center">
<!--div principal-->
										<div>
											<form class="tforma"  action="progreso_ops.php" method="POST" name="fechas">
												<table>
													<tr>
														<td class="etq"><input type="checkbox" name="opcion" value="fecha"/> Filtro<br/></td>
														<td>
	<input class="ctxt" type="text" name="fechai" id="fechai" onclick="displayCalendar(document.forms[0].fechai,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha);  ?>"/>
														</td>
														<td>
	<input class="ctxt" type="text" name="fechaf" id="fechaf" onclick="displayCalendar(document.forms[0].fechaf,'yyyy/mm/dd',this)" value="<? echo date("Y/m/d",$fecha);  ?>"/>															
														</td>
														<td>
															<input class="btn" type="submit" value="buscar"/>
														</td>
														<td>
	<?echo "<a href=\"formsubmit.php?fechai=$fechai&&fechaf=$fechaf&&tarea=1\" target=\"_blank\\\"><img src=\"../imgs/excel-xp.png\" WIDTH=40 HEIGHT=40 BORDER=0 />";?>
														</td>
													</tr>
												</table>
											</form>
											</br>
											<div id="country1" class="tabcontent">
<?
	//VALIDA SI HAY OPS INCONCLUSAS O NO
	if($_POST["opcion"]=="fecha")
	{
		$recordSet=$datos->listar_ops_historico_fecha($_POST["fechai"],$_POST["fechaf"]);// valida si hay info	
	}
	else
	{
		$recordSet=$datos->listar_ops_historico();// valida si hay info
	}
	            if ($recordSet->EOF)
                {
                echo  "<H1>NO HAY OPS</H1>" ;
                }
                else
                { //$cantidad=mysql_num_rows($recordSet);
					$cantidad_OPs=$datos->contar();   
					
					$numeroOPs=$cantidad_OPs;  	// cantidad de Ordenes de produccion activas traidas desde la BD
													// esto se hace con el fin de no utilizar el dato original y no correr riesgos de alteracion de informacion
													
					echo '<h1>HISTORICO DE ORDENES</h1>';
						
					echo '<table class="tinfo">';
					echo '<tr>';
					echo '<th>Orden</br>Producci&oacute;n</th>';
					echo '<th>Producto</th>';
					echo '<th>Progreso</th>';
					echo '<th>Unidades</br>Ordenadas</th>';
					echo '<th>Unidades</br>Terminadas</th>';
					echo '<th>Unidades</br>Restantes</th>';
					echo '<th>OEE</th>';
					echo '<th>Desperdicio</th>';
					echo '<th>Turnos</th>';
					echo '</tr>';
				
$color=array('impar','par');
$c_estilo=0;

					while(!$recordSet->EOF){ 
						$id_op			= $recordSet->fields['id_orden_produccion'];
						$id_proceso		= $recordSet->fields['id_orden_proceso'];
						$id_producto	= $recordSet->fields['id_producto'];
						$cantidad		= $recordSet->fields['cantidad'];
						$estado			= $recordSet->fields['estado'];
						$fecha_inicio	= $recordSet->fields['fecha_inicio'];
						$fecha_fin		= $recordSet->fields['fecha_fin'];
						$cantidad_ter	= $recordSet->fields['cant_terminada'];
						
						$progreso = round($datos->progreso_orden($id_op),2);
						$producto = $datos->producto_orden($id_op);
						$oee = $datos->OEE_orden($id_op);
						$desperdicio = $datos->desperdicio_orden($id_op);
						$barra = "";
						$barprog = "";
						if($progreso >= 100){
							$barra = "bar2";
							$barprog = 100;
							$progreso = 100;
						}
						else{
							$barra = "bar";
							$barprog = $progreso;
						}
						
						if($c_estilo%2!=0)
								echo '<tr class="'.$color[0].'">';
						else
								echo '<tr class="'.$color[1].'">';
						
						echo '<td align="center">'.$id_op.'</td>';
						echo '<td>'.$producto->fields["nombre_producto"].'</td>';
						echo '<td><div id="progress" class="graph"><div id="'.$barra.'" style="width:'.$barprog.'%"><p>'.$progreso.'% completada</p></div></div></td>';
						echo '<td align="center">'.$cantidad.'</td>';
						echo '<td align="center">'.$cantidad_ter.'</td>';
						echo '<td align="center">'.($cantidad-$cantidad_ter).'</td>';
						echo '<td align="center">'.$oee.'</td>';
						echo '<td align="center">'.$desperdicio.'</td>';
						echo '<td align="center"><a href=datos_turnos.php?id_orden_produccion="'.$id_op.'" TARGET=\"_blank\"><img src="../imagenes/turno icon.jpg"> </a></td>';
						echo '</tr>';
					
						$c_estilo++;
						$recordSet->MoveNext();
					}
					
					echo '</table>';
				}
?>
											</div>
											
											<div id="country2" class="tabcontent">
<?
	//VALIDA SI HAY OPS INCONCLUSAS O NO
	if($_POST["opcion"]=="fecha")
	{
		$recordSet=$datos->listar_ops_ejecutandose_fecha($_POST["fechai"],$_POST["fechaf"]);// valida si hay info	
	}
	else
	{
		$recordSet=$datos->listar_ops_ejecutandose();// valida si hay info
	}
	
                
               
                if ($recordSet->EOF)
                {
                echo  "<H1>NO HAY ORDENES DE PRODUCCION ACTIVAS</H1>" ;
                }
                else
                { //$cantidad=mysql_num_rows($recordSet);
					$cantidad_OPs=$datos->contar();   
				
					$numeroOPs=$cantidad_OPs;  	// cantidad de Ordenes de produccion activas traidas desde la BD
												// esto se hace con el fin de no utilizar el dato original y no correr riesgos de alteracion de informacion
												
					echo '<h1>ORDENES EN EJECUCION</h1>';
						
					echo '<table class="tinfo">';
					echo '<tr>';
					echo '<th>Orden</br>Producci&oacute;n</th>';
					echo '<th>Producto</th>';
					echo '<th>Progreso</th>';
					echo '<th>Unidades</br>Ordenadas</th>';
					echo '<th>Unidades</br>Terminadas</th>';
					echo '<th>Unidades</br>Restantes</th>';
					echo '<th>OEE</th>';
					echo '<th>Desperdicio</th>';
					echo '<th>Turnos</th>';
					echo '</tr>';
				
$color=array('impar','par');
$c_estilo=0;

					while(!$recordSet->EOF){ 
						$id_op			= $recordSet->fields['id_orden_produccion'];
						$id_proceso		= $recordSet->fields['id_orden_proceso'];
						$id_producto	= $recordSet->fields['id_producto'];
						$cantidad		= $recordSet->fields['cantidad'];
						$estado			= $recordSet->fields['estado'];
						$fecha_inicio	= $recordSet->fields['fecha_inicio'];
						$fecha_fin		= $recordSet->fields['fecha_fin'];
						$cantidad_ter	= $recordSet->fields['cant_terminada'];
						
						$progreso = round($datos->progreso_orden_ejecucion($id_op),2);
						$producto = $datos->producto_orden($id_op);
						$oee = $datos->OEE_orden($id_op);
						$desperdicio = $datos->desperdicio_orden($id_op);
						$barra = "";
						$barprog = "";
						if($progreso >= 100){
							$barra = "bar2";
							$barprog = 100;
							$progreso = 100;
						}
						else{
							$barra = "bar";
							$barprog = $progreso;
						}
						
						if($c_estilo%2!=0)
								echo '<tr class="'.$color[0].'">';
						else
								echo '<tr class="'.$color[1].'">';
						
						echo '<td align="center">'.$id_op.'</td>';
						echo '<td>'.$producto->fields["nombre_producto"].'</td>';
						echo '<td><div id="progress" class="graph"><div id="'.$barra.'" style="width:'.$barprog.'%"><p>'.$progreso.'% completada</p></div></div></td>';
						echo '<td align="center">'.$cantidad.'</td>';
						echo '<td align="center">'.$cantidad_ter.'</td>';
						echo '<td align="center">'.($cantidad-$cantidad_ter).'</td>';
						echo '<td align="center">'.$oee.'</td>';
						echo '<td align="center">'.$desperdicio.'</td>';
						echo '<td align="center"><a href=datos_turnos.php?id_orden_produccion="'.$id_op.'" TARGET=\"_blank\"><img src="../imagenes/turno icon.jpg"> </a></td>';
						echo '</tr>';
					
						$c_estilo++;
						$recordSet->MoveNext();
					}
					
					echo '</table>';
				}
?>
											</div>
											
											<div id="country3" class="tabcontent">
<?
	//VALIDA SI HAY OPS INCONCLUSAS O NO
	if($_POST["opcion"]=="fecha")
	{
		$recordSet=$datos->listar_ops_inconclusas_fecha($_POST["fechai"],$_POST["fechaf"]);// valida si hay info	
	}
	else
	{
		$recordSet=$datos->listar_ops_inconclusas();// valida si hay info
	}
	
                
               
                if ($recordSet->EOF)
                {
                echo  "<H1>NO HAY ORDENES DE PRODUCCION INCONCLUSAS</H1>" ;
                }
                else
                { //$cantidad=mysql_num_rows($recordSet);
					$cantidad_OPs=$datos->contar();   
				
					$numeroOPs=$cantidad_OPs;  	// cantidad de Ordenes de produccion activas traidas desde la BD
												// esto se hace con el fin de no utilizar el dato original y no correr riesgos de alteracion de informacion
												
				
					echo '<h1>ORDENES INCONCLUSAS</h1>';
						
					echo '<table class="tinfo">';
					echo '<tr>';
					echo '<th>Orden</br>Producci&oacute;n</th>';
					echo '<th>Producto</th>';
					echo '<th>Progreso</th>';
					echo '<th>Unidades</br>Ordenadas</th>';
					echo '<th>Unidades</br>Terminadas</th>';
					echo '<th>Unidades</br>Restantes</th>';
					echo '<th>OEE</th>';
					echo '<th>Desperdicio</th>';
					echo '<th>Turnos</th>';
					echo '<th>Cerrar</br>Orden</th>';
					echo '</tr>';
				
$color=array('impar','par');
$c_estilo=0;

					while(!$recordSet->EOF){ 
						$id_op			= $recordSet->fields['id_orden_produccion'];
						$id_proceso		= $recordSet->fields['id_orden_proceso'];
						$id_producto	= $recordSet->fields['id_producto'];
						$cantidad		= $recordSet->fields['cantidad'];
						$estado			= $recordSet->fields['estado'];
						$fecha_inicio	= $recordSet->fields['fecha_inicio'];
						$fecha_fin		= $recordSet->fields['fecha_fin'];
						$cantidad_ter	= $recordSet->fields['cant_terminada'];
						
						$progreso = round($datos->progreso_orden($id_op),2);
						$producto = $datos->producto_orden($id_op);
						$oee = $datos->OEE_orden($id_op);
						$desperdicio = $datos->desperdicio_orden($id_op);
						$barra = "";
						$barprog = "";
						if($progreso >= 100){
							$barra = "bar2";
							$barprog = 100;
							$progreso = 100;
						}
						else{
							$barra = "bar";
							$barprog = $progreso;
						}
						
						if($c_estilo%2!=0)
								echo '<tr class="'.$color[0].'">';
						else
								echo '<tr class="'.$color[1].'">';
						
						echo '<td align="center">'.$id_op.'</td>';
						echo '<td>'.$producto->fields["nombre_producto"].'</td>';
						echo '<td><div id="progress" class="graph"><div id="'.$barra.'" style="width:'.$barprog.'%"><p>'.$progreso.'% completada</p></div></div></td>';
						echo '<td align="center">'.$cantidad.'</td>';
						echo '<td align="center">'.$cantidad_ter.'</td>';
						echo '<td align="center">'.($cantidad-$cantidad_ter).'</td>';
						echo '<td align="center">'.$oee.'</td>';
						echo '<td align="center">'.$desperdicio.'</td>';
						echo '<td align="center"><a href=datos_turnos.php?id_orden_produccion="'.$id_op.'" TARGET=\"_blank\"><img src="../imagenes/turno icon.jpg"> </a></td>';
						echo '<td align="center"><a href=formsubmit.php?tarea=2&&orden='.$id_op.' TARGET=\"_blank\"><img src="../imagenes/CERRAR ORDEN.png"> </a></td>';
						echo '</tr>';
					
						$c_estilo++;
						$recordSet->MoveNext();
					}
					
					echo '</table>';
				}
?>
											</div>
<!-- fin div principal-->
										</div>
									</td>
								</tr>
							</table>

           	<script type="text/javascript">
           	var countries=new ddtabcontent("progresstabs")
           	countries.setpersist(true)
           	countries.setselectedClassTarget("link") //"link" or "linkparent"
           	countries.init()
			</script>

						</td>
					</tr>
				</tbody>
			</table>      
		</div>
	</div>
</body>
</html>