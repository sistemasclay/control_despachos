<?
include("modelo/DatosTurno.php");
$datos = new DatosTurno();
$recordset = $datos->listar_procesos();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!--  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
	<meta http-equiv="refresh" content="3">
	<link rel="stylesheet" type="text/css"  href="css/styles_selector.css"/>
	<title>Registro Maquinas M&C </title>
</head>
<body>
	<div class="title">
		<div id="title" class="textTitle">SELECCION DE</br>PROCESO</div>
	</div>
	<div>
	</div>
	<div class="main">
<?
$i=0;
$lenght=$recordset->RecordCount();
while($i < $lenght)
{
	echo "<div class=\"spacev\"></div>";
	echo "<div class=\"processCtn\">";
	while(!$recordset->EOF)
	{
		$maquina = $recordset->fields['id_proceso'];
		$nom_maquina = $recordset->fields['nombre'];
		$turno = $recordset->fields['t_terminado'];
		$parada = $recordset->fields['tp_terminado'];
		
		if($turno == 0){
			//$datos->verificarCierre($maquina);
			if($parada == 0){
				$clase = "leftParada";
			}
			else{
				$clase = "leftActivo";
			}
		}
		else{
			$clase = "left";
		}
		
		if($i%2 == 1){
			echo "<div class=\"spaceh\"></div>";
		}
		echo "<div class=\"".$clase."\">";
			echo "<a class=\"textSelector\"href=\"mic_inicio.php?proceso=".$maquina."\"><div class=\"number\">";
				echo "<div class=\"text\">".$maquina."<br>".$nom_maquina."</div>";
			echo "</div></a>";
		echo "</div>";
		
		$recordset->MoveNext();
		$i=$i+1;
		if($i%2 == 0){
			break;
		}
	}
	echo "</div>";
}
?>		

	</div>
	<div class="footer" id="footer">
		<table class="tabFooter">
			<tr>
				<td>
					<div class="textFotter">
						PEGASUS PRO <span class="textFotter2"> by </span> <span class="textFotter3"> M&C </span>
					</div>
				</td>
				<td>
					<a class="link" href="http://172.16.96.55/mantenimiento/index.php"><div class="mantenimiento">_</div></a>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>