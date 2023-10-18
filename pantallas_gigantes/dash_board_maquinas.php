<?
		include("../clases/pantallas_gigantes.php");
		$pantallas_gigantes = new pantallas_gigantes();
/*
		$maquinai = $_REQUEST["maquinai"];
		$maquinaf = $_REQUEST["maquinaf"];
		
		$recordset = $pantallas_gigantes->listar_turnos_maquinas($maquinai,$maquinaf);
		$num_turnos = $pantallas_gigantes->contar_turnos_abiertos();
*/
		//ATRIBUTO QUE REPRESENTA LA "PANTALLA" DE 8 MAQUINAS QUE ACTUALMENTE SE ESTA MOSTRANDO
		$pantalla = $_REQUEST["pantalla"];
		
		//ATRIBUTO QUE REPRESENTA EL TIPO DE DATO QUE SE ESTA MOSTRANDO EN LA PARADA (OEE/UNIDADES) O (TIEMPO_PARADA)
		$dato = $_REQUEST["dato"];
		
		//ATRIBUTO QUE REPRESENTA EL COLOR DEL CUADRADO 0 PARA NORMAL 1 PARA ALTERNO
		$colour = $_REQUEST["colour"];
		
		$ids_maquinas = $pantallas_gigantes->listar_ids_maquinas(); //retorna una lista con todos los ID de las maquinas que en el momento se encuentran activas
		$maquinas_separadas = $pantallas_gigantes->separar_en_8($ids_maquinas); //retorna una lista que tiene la lista anterior dividida en secciones de 8
		$recordset = $pantallas_gigantes->listar_turnos_lista($maquinas_separadas[$pantalla-1]);
		$num_turnos = count($maquinas_separadas[$pantalla-1]);		
		if($num_turnos == 1){
			$clase = 'div1';
		}
		elseif($num_turnos == 2){
			$clase = 'div2';
		}
		elseif($num_turnos == 3){
			$clase = 'div3';
		}
		elseif($num_turnos == 4){
			$clase = 'div4';
		}
		elseif($num_turnos > 4 && $num_turnos <= 6){
			$clase = 'div6';
		}
		else{
			$clase = 'div8';
		}
?>	
<script>
	function Blink()
	{
		var ElemsBlink = document.getElementsByTagName('blink');
		for(var i=0;i<ElemsBlink.length;i++)
		ElemsBlink[i].style.visibility = ElemsBlink[i].style.visibility
		=='visible' ?'hidden':'visible';
	}

	function parpadear() {
		with (document.getElementById("parpadeo").style)
		visibility = (visibility == "visible") ? "hidden" : "visible";
	}
</script>
<?
		$i=0;
		while(!$recordset->EOF){
			
			$result = $pantallas_gigantes->traer_parametro_oee($recordset->fields['id']);
			
			$oee = round($recordset->fields['oee'],0);
			$unidades = round($recordset->fields['unid'],0);
			$tiempo = $recordset->fields['tiempo'];
			if($recordset->fields['tp'] == 0){
				$tiempo = $pantallas_gigantes->tiempo_segundos($tiempo);
			}			
			
			if($recordset->fields['tp'] == 1){
				if($result->fields['oee_minimo'] > $recordset->fields['oee'] && $colour == 1){
					$color = 'altverde';
				}
				else{
					$color = 'verde';
				}				
				$borde = 'unidverde';
			}
			else{
				if($result->fields['oee_minimo'] > $recordset->fields['oee'] && $colour == 1){
					$color = 'altrojo';
				}
				else{
					$color = 'rojo';
				}				
				$borde = 'unidrojo';
			}
			
?>
<?
								if($result->fields['oee_minimo'] > $recordset->fields['oee']){
									echo '<blink>';
								}
?>
				<div class="<?echo $clase.' '.$color;?>">
					<div id="titulo">
						<? echo $recordset->fields['maquina'];?>
					</div>
					<?
					
					if($recordset->fields['tp'] == 0 && $dato == 1){
					?>
						<div id="datos_tiempo">
							<div>
								<? echo $tiempo;?>
							</div>
						</div>
					<?	
					}
					
					else{
						?>
						<div id="datos">
							<div id="<?echo $id;?>">
								<? echo $oee.'%';?>
							</div>
							<div class="<?echo $borde?>">
								<? echo $unidades;?>
							</div>

						</div>
						<?
					}
					if($recordset->fields['tp'] == 1){
						if($color=='altverde')
						{
							echo '<div id="parada" class="noparoalt">';
						}
						else{
							echo '<div id="parada" class="noparo">';
						}
					}
					else{
						echo '<div id="parada">';
					}
					echo $recordset->fields['np'];
					echo '</div>';
					?>
				</div>
<?
								if($result->fields['oee_minimo'] > $recordset->fields['oee']){
									echo '</blink>';
								}
?>
<?
			$recordset->MoveNext();
			$i++;
		}
?>