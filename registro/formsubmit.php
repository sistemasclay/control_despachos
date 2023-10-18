<?php
require 'modelo/LogicaTurno.php';
$logicaTurno = new LogicaTurno();


if($_POST["seccion"])
{
    $opcion=$_POST["seccion"];
}
else
{
    $opcion=$_GET["seccion"];
}

echo '<body bgcolor="#000">';
switch ($opcion)
{
	case "reg_abrir":
		if($_POST["tipo"]){$tipo=$_POST["tipo"];}else{$tipo=$_GET["tipo"];}
		
		if($_POST["proceso"]){$proceso=$_POST["proceso"];}else{$proceso=$_GET["proceso"];}
		
		if($_POST["producto"]){$producto=$_POST["producto"];}else{$producto=$_GET["producto"];}
		
		if($_POST["usuario"]){$usuario=$_POST["usuario"];}else{$usuario=$_GET["usuario"];}
		
		if(!$logicaTurno->comprobar_turno_muestreo($producto,$proceso)){
			$logicaTurno->iniciar_turno_muestreo($producto,$proceso);
		}
		$pagina="reg_parametros.php";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."?tipo=".$tipo."&proceso=".$proceso."&producto=".$producto."&usuario=".$usuario."&lote=".$lote."&op=".$op." \">";
	break;
	
	case "reg_cambio":
		if($_POST["tipo"]){$tipo=$_POST["tipo"];}else{$tipo=$_GET["tipo"];}
		
		if($_POST["proceso"]){$proceso=$_POST["proceso"];}else{$proceso=$_GET["proceso"];}
		
		if($_POST["producto"]){$producto=$_POST["producto"];}else{$producto=$_GET["producto"];}
		
		if($_POST["usuario"]){$usuario=$_POST["usuario"];}else{$usuario=$_GET["usuario"];}
		
		if(!$logicaTurno->comprobar_turno_muestreo($producto,$proceso)){
			$logicaTurno->iniciar_turno_muestreo($producto,$proceso);
		}
		$pagina="reg_parametros.php";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."?tipo=".$tipo."&proceso=".$proceso."&producto=".$producto."&usuario=".$usuario."&lote=".$lote."&op=".$op." \">";
	break;
	
	case "reg_parametros":
		$fechaactual = date('Y-m-d hh:ii:ss');
		$pagina="reg_parametros.php";
		$error = 0;
		$params = "";//variable que almacenará todos las parametros que se almacenaro en la pantalla anterior
				if(!empty($_POST['params'])) { 
				
					// Ciclo guardar y comprobar cada parametro almacenado (no debe haber ninguno en 0)
					foreach($_POST['params'] as $selected) {
						if($selected){
							$params = $params.$selected.",";
						}
						else{
							echo '<script> alert("ERROR\nFalta un dato: por favor revise los datos ingresados "); </script>';
							$error = 1;
							break;
						}
						//echo "<p>".$selected ."</p>";				
					}
					if($error){
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."?tipo=".$_POST["tipo"]."&proceso=".$_POST["proceso"]."&producto=".$_POST["producto"]."&usuario=".$_POST["usuario"]."&lote=".$_POST["lote"]."&op=".$_POST["op"]." \">";
					}
					else{
						// aqui se elimina el ultimo caracter de la cadena de texto el cual es una ,
						$params = substr ($params, 0, -1); 
						
						//obtiene los datos del turno de muerstreo
						try{
							$turno_muestreo = $logicaTurno->traer_turno_muestreo($producto,$proceso);
						}
						catch (Exception $e) {
							$fichero = 'log_errores.txt';
							// Abre el fichero para obtener el contenido existente
							$actual = file_get_contents($fichero);
							// Añade una nueva persona al fichero
							$actual .= "FECHA: ".$fechaactual.". ERROR AL TRAER TURNO MUESTREO: ".$e->getMessage()."\n";
							// Escribe el contenido al fichero
							file_put_contents($fichero, $actual);
							//echo 'Excepción capturada al traer el turno muestreo: ',  $e->getMessage(), "\n";
						}
						//cierra todos los muestreos del turno, esto se hace para que solo haya un muestreo activo por turno
						try{
							$logicaTurno->cerrar_muestreo($turno_muestreo->fields["id_t_muestreo"]);
						}
						catch (Exception $e) {
							$fichero = 'log_errores.txt';
							// Abre el fichero para obtener el contenido existente
							$actual = file_get_contents($fichero);
							// Añade una nueva persona al fichero
							$actual .= "FECHA: ".$fechaactual.". ERROR AL CERRAR MUESTREO: ".$e->getMessage()."\n";
							// Escribe el contenido al fichero
							file_put_contents($fichero, $actual);
							//echo 'Excepción capturada al cerrar muestreo: ',  $e->getMessage(), "\n";
						}
						//inicia un nuevo muestreo
						try{
							$logicaTurno->iniciar_muestreo($_POST['producto'],$_POST['proceso'],$_POST['tipo'],$_POST['usuario'],$turno_muestreo->fields["id_t_muestreo"],$_POST['lote'],$_POST['op']);
						}
						catch (Exception $e) {
							$fichero = 'log_errores.txt';
							// Abre el fichero para obtener el contenido existente
							$actual = file_get_contents($fichero);
							// Añade una nueva persona al fichero
							$actual .= "FECHA: ".$fechaactual.". ERROR AL INICIAR MUESTREO: ".$e->getMessage()."\n";
							// Escribe el contenido al fichero
							file_put_contents($fichero, $actual);
							//echo 'Excepción capturada al iniciar muestreo: ',  $e->getMessage(), "\n";
						}
						
						$datos = explode(",", $params);
						$i = 0;
						$mensaje = "";
						$estandares = $logicaTurno->traer_parametros_producto($_POST['producto']);
						while(!$estandares->EOF){
							
							$mensaje = $mensaje.'Para el dato '.$estandares->fields["nombre_parametro"].' usted ingreso '.$datos[$i].'\n';
							$logicaTurno->agregar_parametro_registro($_POST['producto'],$estandares->fields["id_parametro"],$_POST['proceso'],$_POST['tipo'],$datos[$i]);
							$valorOK = $logicaTurno->comprobar_valor_parametro_producto($_POST['producto'], $estandares->fields["id_parametro"], $datos[$i]);
							$fallo = $logicaTurno->traer_fallo_producto_parametro($_POST['producto'],$estandares->fields["id_parametro"],$valorOK);
							if($fallo){
								$logicaTurno->agregar_fallo_registro($_POST['proceso'],$_POST['producto'],$_POST['tipo'],$fallo);
								$logicaTurno->parar_proceso($_POST['producto'],$_POST['proceso'],$_POST['tipo']);
							}
							
							$i++;
							$estandares->MoveNext();
						}
						//echo '<script> alert("Se han guardado los parametros del muestreo \n'.$mensaje.'\n se va aregresar al Inicio"); </script>';
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_fallos?tipo=".$_POST["tipo"]."&proceso=".$_POST["proceso"]."&producto=".$_POST["producto"]."&usuario=".$_POST["usuario"]." \">";
					}
					
				}
				/*
				else{
					echo "<b>No selecciono ninguna parada.</b>";
					echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."?id_proceso=".$_POST["proceso"]."&&turno=".$_POST["turno"]." \">";
				}*/
	break;
	
	case "reg_fallos":
		if(!empty($_POST['fallos'])) {
			
		// Ciclo para almacenar el valor de cada checkbox seleccionada.
			$fallos = "";
			foreach($_POST['fallos'] as $selected) {
				$fallos = $fallos.$selected.",";	
			}
			$mensaje="";
			$fallos = substr ($fallos, 0, -1); // aqui se elimina el ultimo caracter de la cadena de texto el cual es una ,
			$datos = explode(',', $fallos);
			$i=0;
			$errores=0;
			$length = count($datos);
			while($i<$length){
				//$mensaje = $mensaje.'Los datos seleccionados fueron los siguientes:\n'.$datos[$i].'\n';
				$logicaTurno->agregar_fallo_registro($_POST['proceso'],$_POST['producto'],$_POST['tipo'],$datos[$i]);
				$errores = 1;
				$i++;
			}
			if($errores){
				$logicaTurno->parar_proceso($_POST['producto'],$_POST['proceso'],$_POST['tipo']);
			}
			echo "fallos registrados";
			//echo '<script> alert("Se han guardado los parametros del muestreo \n'.$fallos.'\n se va aregresar al Inicio"); </script>';
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_observaciones?tipo=".$_POST["tipo"]."&proceso=".$_POST["proceso"]."&producto=".$_POST["producto"]."\">";
			//echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_fallos?tipo=".$_POST["tipo"]."&proceso=".$_POST["proceso"]."&producto=".$_POST["producto"]."\">";
		}
		else{
			
		}
		echo "fallos registrados";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_observaciones?tipo=".$_POST["tipo"]."&proceso=".$_POST["proceso"]."&producto=".$_POST["producto"]."\">";
	break;
	
	case "reg_observaciones":
		$logicaTurno->guardar_observaciones_registro($_GET['tipo'],$_GET['proceso'],$_GET['producto'],$_GET['observaciones']);
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_salir?proceso=".$_GET["proceso"]."&producto=".$_GET["producto"]."\">";
	break;
	
	case "cerrar_turno":
		$turno_muestreo = $_GET['turno_muestreo'];
		$logicaTurno->cerrar_turno_muestreo($turno_muestreo);
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_inicio\">";
	break;
	
	case "reg_salir":
		$turno_muestreo = $logicaTurno->traer_turno_muestreo($_GET['producto'],$_GET['proceso']);
		$logicaTurno->cerrar_turno_muestreo($turno_muestreo);
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=reg_inicio\">";
	break;
}
  echo'</body>';
?>

