<? session_start();
include("../clases/reportes.php");

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

$repor= new reportes();

$paradas=$repor->listar_turno_paradas($i_turno,$i_proceso);
//print_r($paradas);
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
  	<h1>MODIFICAR PARADAS TURNO <? echo " ".$i_turno."  MAQUINA ".$i_proceso; ?></h1>
  <br/>
  <div id="lista_ordenes" style="overflow:scroll; height:350px; overflow-x:hidden;" >
  <table  class="tinfo">
<tr>
  <th>Codigo</th>
   <th>Nombre</th>
    <th>Inicio</th>
    <th>Fin</th>
    <th>Duracion</th>
    <th>Modificar</th>
</tr>
<?
$color=array('impar','par');
$c_estilo=0;

while (!$paradas ->EOF) {

                    if($c_estilo%2!=0)
                    echo '<tr class="'.$color[0].'">';
            else
                    echo '<tr class="'.$color[1].'">';
echo "
<td class=\"tabla_celda\">".$paradas ->fields['id_parada']."</td>
<td class=\"tabla_celda\">".$paradas ->fields['nombre_parada']."</td>
<td class=\"tabla_celda\">".$paradas ->fields['fecha_inicio']."</td>
<td class=\"tabla_celda\">".$paradas ->fields['fecha_fin']."</td>
<td class=\"tabla_celda\">".$repor->tiempo_segundos($paradas ->fields['horas'])."</td>

    <td class=\"tabla_celda\"><a href=\"modificar_paradas.php?codigo_parada="
        .$paradas ->fields['id_turno_parada']."&&turno=".$i_turno."&&id_proceso=".$i_proceso."&&nombre=".$paradas ->fields['nombre_parada']."\"><img src=\"../imagenes/editar.JPG\"> </a></td>
</tr>
";
  $c_estilo++;
$paradas->MoveNext();
}
    ?>
  </table>
       </div>
      <br/>
<form class="forma" id="fpersonal" name="fpersonal" method="post" action="formsubmit.php">
<input type="hidden" name="seccion" id="seccion" value="modificar_turno_parada"/>
<input type="hidden" value="<? echo $i_proceso ?>" name="proceso"/>
<input type="hidden" value="<? echo $i_turno ?>" name="turno"/>
<input type="hidden" name="id_turno_parada" id="id_turno_parada" value="<? echo $_GET["codigo_parada"]; ?>"/>

  <table class="tforma">
      <tr>
          <td colspan="2" class="etq">
              Modificar Parada:<? echo " ".$_GET["nombre"]; ?>
          </td>
      </tr>
      <tr>
  <td class="etq">
 Nueva Causa  </td>
  <td ><select class="lista" name="n_parada" id="n_parada">
<?
$paros=$repor->listar_paradas();
while(!$paros->EOF)
    {
echo "<option class=\"oplista\" value=\" ".$paros->fields['id_parada']." \">".$paros->fields['nombre_parada']."</option>"; 
$paros->MoveNext();
      }
      ?></select>
  </td>
  </tr>
  <tr>
  <td colspan="2">
   <input class="btn" <? if(!$_GET["codigo_parada"]){ echo "disabled='true'"; }  ?>type="submit" name="Submit" value="Enviar" />
  </td>
  </tr>
 </table>
                  </form>
  
  </div>
  <?php require_once('..\includes\piep.php'); ?>
</div>
</body>
</html>