<?php
include("../clases/pantallas_gigantes.php");
$pantallas_gigantes = new pantallas_gigantes();
$recordset = $pantallas_gigantes->ranking();

$clase = '';
?>
			<?
				$i = 1;
			?>
				<table class="rank">
				<tr>
					<th class="pos">
						POSICI&Oacute;N
					</th>
					<th class="maquina">
						M&Aacute;QUINA
					</th>
					<th class="oee">
						OEE
					</th>
				</tr>
				<?
					while(!$recordset->EOF){
						if($i%2==0){
							$clase = 'par';
						}
						else{
							$clase = 'impar';
						}
						echo'<tr class='.$clase.'>';									
						echo'<td class="pos">';
							echo $i.'.';
						echo'</td>';
						
						echo'<td class="maquina">';
							echo $recordset->fields['maquina'];
						echo'</td>';
						
						$result = $pantallas_gigantes->traer_parametro_oee($recordset->fields['id']);
						//echo 'esperado: '.$result->fields['oee_minimo'].' actual '.$recordset->fields['oee'];
						if($result->fields['oee_minimo'] > $recordset->fields['oee']){
							$color = "#FF0000";
						}
						else{
							$color = "#FFFFFF";
						}
						echo'<td class="oee" style="color:'.$color.';"">';
							echo $recordset->fields['oee'];
						echo'</td>';
						
						echo'</tr>';
						echo'<tr>';
						$recordset->MoveNext();
						if($i == 8){
							break;
						}
						$i++;
					}
				?>
				</table>