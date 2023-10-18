<? session_start(); ?>
<?
include("../clases/reportes.php");

$repor= new reportes();
$ordenes_produccion=$repor->listar_ops();
$personas = $repor->listar_personal();

if($_POST["id_proceso"])
{
    $i_proceso=$_POST["id_proceso"];
}
else
{
    $i_proceso=$_GET["id_proceso"];
}

if($_POST["turno"])
{
    $i_turno=$_POST["turno"];
}
else
{
    $i_turno=$_GET["turno"];
}

$sql="SELECT *
                FROM turnos as b INNER JOIN procesos as a ON (b.id_proceso= a.id_proceso) INNER JOIN productos as c ON (b.id_producto= c.id_producto)
                WHERE b.id_proceso='".$i_proceso."' AND id_turno='".$i_turno."'";
        $etiquetas=$repor->listar_etiquetas();
        include("../clases/conexion.php");
        $result=$conexion_pg->Execute($sql);
        if ($result === false)
        {
        echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
         $conexion_pg->Close();         
  $orden=  $repor->detalle_op($result->fields['orden_produccion']);
  $productos=$repor->listar_productos();
?>
<?
    $asistencia=$repor->listar_turno_asistencia($i_turno,$i_proceso);
    $n_empleados=0;
    while (!$asistencia->EOF) {
    $n_empleados=$n_empleados+1;
    $asistencia->MoveNext();
    }
	
	$producto_proceso=$repor->detalle_producto_proceso($result->fields["id_proceso"], $result->fields["id_producto"]);
	$estandar=$producto_proceso->fields["var1"];
	$unidades_pulso=$producto_proceso->fields["unidades_pulso"];
	
	
    $tiempo_hombre=$result->fields["tiempo_hombre"]/$n_empleados;
    $tiempo_eli_hombre=$result->fields["tiempo_hombre"]-$tiempo_hombre;
    $tiempo_agre_hombre=$result->fields["tiempo_hombre"]+$tiempo_hombre;
 $asistencia->MoveFirst();
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="estilos/myc_gral.css"/>
  <title>Monitoreo y Control</title>
</head>

<body>
<div id="contenedor">
  <?php require_once('..\includes\cabecera.php'); ?>
  <div id="contenido">
      <h1>Detalles de Batch</h1>
      <form action="formsubmit.php" method="post">
           <input type="hidden" value="actualiza_turno" name="seccion"/>
            <input type="hidden" value="<? echo $result->fields['id_tabla']; ?>" name="tabla_turno"/>
                  <input type="hidden" value="<? echo $n_empleados; ?>" name="n_empleados"/>
                       <input type="hidden" value="<? echo $i_proceso ?>" name="proceso"/>
           <input type="hidden" value="<? echo $i_turno ?>" name="turno"/>
      <table class="tinfo">
           <tr >
              <th colspan="2"><? echo "Detalles del Batch:  ".$i_turno."   ".$result->fields['nombre']; ?></th>
             
          </tr>
          <tr class="impar">
              <td colspan="2"><? echo "Producto: "; ?>

                                                 <select class="lista"  name="producto" id="producto">
                            <?
                             echo "<option class=\"oplista\" value=\" ".$result->fields['id_producto']." \">".$result->fields['nombre_producto']."</option>";
                            while (!$productos->EOF) {
      echo "<option class=\"oplista\" value=\" ".$productos->fields['id_producto']." \">".$productos->fields['nombre_producto']."</option>";
                           $productos->MoveNext();
                            }
                            ?>
                        </select>
              </td>
          </tr>
          <tr class="par">
              <td>            
                      <? echo $etiquetas[8]['etiqueta'];    ?> <input class="ctxt" type="text" name="dato_extra" id="dato_extra" value="<? echo $result->fields['dato_extra'];  ?>" /></td>
             <td><? echo "Orden Produccion: "; ?>
                                   <select class="lista"  name="op" id="op">
                            <?                            
                             echo "<option class=\"oplista\" value=\" ".$orden->fields['id_orden_produccion']." \">".$orden->fields['id_orden_produccion']."-".$orden->fields['nombre_producto']."</option>";
                            while (!$ordenes_produccion->EOF) {
      echo "<option class=\"oplista\" value=\" ".$ordenes_produccion->fields['id_orden_produccion']." \">".$ordenes_produccion->fields['id_orden_produccion']."-".$ordenes_produccion->fields['nombre_producto']."</option>";
                           $ordenes_produccion->MoveNext();
                            }
                            ?>
                        </select>
             </td>
          </tr>

                    <tr class="impar">
              <td><? echo "Fecha Inicio:  "; ?>
               <input class="ctxt" type="text" name="fecha_inicio" id="fecha_inicio" value="<? echo $result->fields['fecha_inicio'];  ?>" />
              </td>
             <td><? echo "Fecha Fin: "; ?>
              <input class="ctxt" type="text" name="fecha_fin" id="fecha_fin" value="<? echo $result->fields['fecha_fin'];  ?>" />
             </td>
          </tr>
          <tr class="par">
              <td colspan="1"><? echo "Terminado "; ?>
               <input type="Checkbox" name="terminado" id="terminado" <? if ($result->fields['terminado']=="1") echo "checked" ?>  />
              </td>
              <td colspan="1">
                  <? if ($result->fields['terminado']=="1") { ?>
            <a onclick='return confirm("¿Seguro que desea eliminar el turno=<? echo $i_turno  ?> del proceso =<?  echo $i_proceso; ?> ?")' href="borrar_turno.php?turno=<? echo $i_turno ?>&&id_proceso=<?  echo $i_proceso; ?>" class="link">Eliminar Turno</a>
            <? } else { echo "Eliminar Turno";  } ?>
              </td>
          </tr>
          <tr class="impar">
              <td colspan="2" >
                        <input class="btn"  type="submit" value="Guardar"/>
                    </td>
		</tr>
             <!--                 <tr class="par">
              <td><? //echo "Unidades:  ".$result->fields['unidades_conteo']; ?></td>
             <td><? //echo "Produccion Final: ".$result->fields['produccion_final']; ?></td>
          </tr> -->
      </table>


<br/>
<h1>Tiempos y Indicadores</h1>
      <table class="tinfo">
           <tr>
              <th>Tiempos</th>
             <th>Indicadores</th>
              <th>Produccion</th>
          </tr>

          <tr class="impar">
              <td><? echo "Tiempo Total Parada: ".$repor->tiempo_segundos($result->fields['tiempo_total_paro']);  ?></td>
             <td><? echo $etiquetas[0]['etiqueta'].": ".$result->fields['indicador_1']; ?></td>
             <td><? echo "Unidades:  ".$result->fields['unidades_conteo']; ?></td>
          </tr>

          <tr class="par">
              <td><? echo "Tiempo Parada Prog: ".$repor->tiempo_segundos($result->fields['tiempo_paro_prog']);  ?></td>
             <td><? echo $etiquetas[1]['etiqueta'].": ".$result->fields['indicador_2']; ?></td>
             <td><? echo "Produccion Final: "; ?>
             <input class="ctxt" type="text" name="pfinal" id="pfinal" value="<? echo $result->fields['produccion_final'];  ?>" />
             </td>
          </tr>

          <tr class="impar">
              <td><? echo "T. Paradas NO Prog: ".$repor->tiempo_segundos($result->fields['tiempo_paro_no_p']);  ?></td>
             <td><? echo $etiquetas[2]['etiqueta'].": ".$result->fields['indicador_3']; ?></td>
            <td><? echo $etiquetas[12]['etiqueta'].": "; ?>
            <input class="ctxt" type="text" name="d1" id="d1" value="<? echo $result->fields['desperdicio_1'];  ?>" />
            </td>
            
          </tr>

                    <tr class="par">
              <td><? echo "Parada Averias: ".$repor->tiempo_segundos($result->fields['tiempo_paro_g1']);  ?></td>
             <td><? echo $etiquetas[3]['etiqueta'].": ".$result->fields['indicador_4']; ?></td>
             <td><? echo $etiquetas[13]['etiqueta'].": "; ?>
            <input class="ctxt" type="text" name="d2" id="d2" value="<? echo $result->fields['desperdicio_2'];  ?>" />
             </td>
          </tr>
                    <tr class="impar">
              <td><? echo "P Cuadres y Ajustes: ".$repor->tiempo_segundos($result->fields['tiempo_paro_g2']);  ?></td>
             <td><? echo $etiquetas[4]['etiqueta'].": ".$result->fields['indicador_5']; ?></td>
                         <td><? echo $etiquetas[14]['etiqueta'].": "; ?>
            <input class="ctxt" type="text" name="d3" id="d3" value="<? echo $result->fields['desperdicio_3'];  ?>" />
             </td>
          </tr>
                    <tr class="par">
              <td><? echo "Pequenas Paradas: ".$repor->tiempo_segundos($result->fields['tiempo_paro_g3']);  ?></td>
             <td><? echo $etiquetas[5]['etiqueta'].": ".$result->fields['indicador_6']; ?></td>

              <td >
                        <input class="btn"  type="submit" value="Guardar"/>
                    </td>
          </tr>

            <tr class="impar">
              <td><? echo "Tiempo Estandar: ".$repor->tiempo_segundos($result->fields['tiempo_std_prog']);  ?></td>
             <td><? echo $etiquetas[6]['etiqueta'].": ".$result->fields['indicador_7']; ?></td>
             <td></td>
          </tr>

            <tr class="par">
              <td><? echo "Tiempo Hombre: ".$repor->tiempo_segundos($result->fields['tiempo_hombre']);  ?></td>
             <td><? echo "Estandar: ".$estandar; ?></td>
             <td> <a href="modificar_paradas.php?turno=<? echo $i_turno ?>&&id_proceso=<?  echo $i_proceso; ?>" target="_blank" class="link">Modificar Paradas</a></td>
          </tr>

            <tr class="impar">
				<td><? echo "Tiempo Maquina: ".$repor->tiempo_segundos($result->fields['tiempo_maquina']);  ?></td>
				<td><? echo "Unidades Pulso: ".$unidades_pulso?></td>
				<td></td>
          </tr>
		  <tr class="par">
			<td colspan="3">
				OBSERVACIONES</br>
				<textarea class="observaciones" rows="5" name="obs" id="obs"><?echo $result->fields['obsevaciones'];?></textarea>
				</br>
			</td>
		  </tr>

      </table>


</form>
      <br/>
      <table class="tforma">
          <form action="formsubmit.php" method="post">
           <input type="hidden" value="calcular" name="seccion"/>
           <input type="hidden" value="<? echo $i_proceso ?>" name="proceso"/>
           <input type="hidden" value="<? echo $i_turno ?>" name="turno"/>
             <input type="hidden" value="<? echo $result->fields['id_tabla']; ?>" name="tabla_turno"/>
             <input type="hidden" value="<? echo $n_empleados; ?>" name="n_empleados"/>
              <tr>
                  <td class="link">Calcular Indicadores</td>
                  <td>  <input class="btn"  type="submit" value="Calcular"/></td>
              </tr>
          </form>
      </table>
<br/>

<h1>Grupo De Trabajo</h1>

      <table class="tinfo">
           <tr>
              <th>Empleado</th>
             <th>Fecha Inicio</th>
             <th>Fecha Fin</th>
             <th>Tiempo</th>
              <th>Eliminar</th>
          </tr>
          <?
          $color=array('impar','par');
$c_estilo=0;
              while (!$asistencia->EOF) {
            if($c_estilo%2!=0)
                    echo '<tr class="'.$color[0].'">';
            else
                    echo '<tr class="'.$color[1].'">';
              
    echo "<td>".$asistencia->fields["id_empleado"]."-".$asistencia->fields["nombre_persona"]."</td>";
    echo "<td>".$result->fields["fecha_inicio"]."</td>";
    echo "<td>".$result->fields["fecha_fin"]."</td>";
    echo "<td>".$repor->tiempo_segundos(($tiempo_hombre))."</td>";
    echo "<td><a onclick='return confirm(\"¿Seguro que desea eliminar  ".$asistencia->fields['nombre_persona']."?\")' href='formsubmit.php?seccion=eliminar_empleado_turno&&turno_asistencia="
        .$asistencia->fields['id_turno_asistencia']."&&proceso=".$i_proceso."&&turno=".$i_turno."&&tiempo_at=".$tiempo_eli_hombre."'><img src=\"../imagenes/eliminar.JPG\"> </a></td>";
    // echo "<td><img src=\"../imagenes/eliminar.JPG\"> </td>";
    echo "</tr>";
    $c_estilo++;
    $asistencia->MoveNext();
    }
          ?>
      </table>
<br/>
      <h1>Agregar Operario</h1>
      <form action="formsubmit.php" method="post">
          <? //echo $_POST["id_proceso"]."-".$_POST["turno"].$result->fields['fecha_inicio'].$result->fields['fecha_fin']; ;  ?>
          <input type="hidden" value="agregar_operario" name="seccion"/>
           <input type="hidden" value="<? echo $i_proceso ?>" name="proceso"/>
           <input type="hidden" value="<? echo $i_turno ?>" name="turno"/>
           <input type="hidden" value="<? echo $result->fields['fecha_inicio'];  ?>" name="fini"/>
           <input type="hidden" value="<? echo $result->fields['fecha_fin'];  ?>" name="ffin"/>
            <input type="hidden" value="<? echo $tiempo_agre_hombre;  ?>" name="tiempo_at"/>
      
          <table class="tforma">
                <tr>
                    <td class="etq">
                   Personal
                    </td>
                    <td>
                        <select name="persona" id="persona">
                            <?
                            while (!$personas->EOF) {
      echo "<option class=\"oplista\" value=\" ".$personas->fields['id_persona']." \">".$personas->fields['nombre_persona']."</option>";
                           $personas->MoveNext();
                            }
                            ?>
                        </select>
                    </td>
                                      <td >
                        <input class="btn"  type="submit" value="Agregar"/>
                    </td>
                </tr>
          </table>
      </form>
  </div>
  <?php require_once('..\includes\piep.php'); ?>
</div>
</body>
</html>