<?
 session_start();
 
include_once("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();

$pagina = $pagina.'?seccion=usuarios';
//echo $pagina;
    if($_GET["codigo_empleado"])
    {
    $datos_empleado = $datos->detalle_usuario($_GET["codigo_empleado"]);
   // echo $datos_proceso->fields["nombre"]."-".$datos_proceso->fields["id_proceso"];
    }
	else
	{
		if($_POST["codigo_empleadob"])
		{
			$datos_empleado = $datos->detalle_usuario($_POST["codigo_empleadob"]);
		}
	}
?>
			<div id="titulo">
				<h1>USUARIOS</h1>
				<h2>Aquí podra ingresar al personal y los permisos que estos tengan en la aplicación</h2>
				<br>
				<form class="forma" action="<?$pagina?>" method="post" name="busqueda">
						<table class="tforma">
							<tr>
								<td  class="etq">
									Busqueda Rapida
								</td>
								<td>
									<input class="ctxt" name="codigo_empleadob" type="text" id="codigo_empleadob" />
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
			<div id="contenido">
				<div id="datos" class="scrollstyle">
					
					<form class="forma" id="fpersonal" name="fpersonal" method="post" action="formsubmit_config.php">
						<input type="hidden" name="seccion" id="seccion" value="usuarios"/>
						<table class="tforma" >
							<tr>
								<td class="etq">
									Codigo:
								</td>
								<td>
									<input class="ctxt" type="text" <? if($datos_empleado->fields["id_persona"]!=""){ echo "readonly=\"readonly\""; } ?> name="codigo_empleado" id="codigo_empleado" value ="<? echo $datos_empleado->fields["id_persona"];   ?>"/>
								</td>
							</tr>
							<tr>
								<td class="etq">
									Nombre:
								</td>
								<td>
									<input class="ctxt" type="text" name="user_name" id="user_name" value ="<? echo $datos_empleado->fields["nombre_persona"];?>" />
								</td>
							</tr>
							<tr>
								<td class="etq">
									Contrasena:
								</td>
								<td>
									<input class="ctxt"  type="password" name="contra_empleado" id="contra_empleado" value ="<? echo $datos_empleado->fields["clave"];   ?>" />
								</td>
							</tr>
							<tr>
								<td class="etq">
									Activo:
								</td>
								<td>
									<input type="Checkbox" name="estado_empleado" id="estado_empleado" <? if ($datos_empleado->fields["estado_persona"]=="1") echo "checked" ?>  />
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
							<th><div class="tooltip">Codigo <span class="tooltiptext">Codigo de Identificación del usuario, debe ser un numero mayor a 0</span> </div></th>
							<th><div class="tooltip">Nombre <span class="tooltiptext">Nombre del usuario</span></th>
							<th><div class="tooltip">Nivel <span class="tooltiptext">Nivel de acceso del usuario</span></th>
							<th>Editar</th>
							<th>Eliminar</th>
						</tr>
<?
		$recordSet=$datos->listar_usuarios();
		//echo $recordSet;
		$color=array('impar','par');
		$c_estilo=0;
		
		while (!$recordSet->EOF) {
		
							if($c_estilo%2!=0)
							echo '<tr class="'.$color[0].'">';
					else
							echo '<tr class="'.$color[1].'">';
		echo "
		<td>".$recordSet->fields['id_usuario']."</td>
		<td>".$recordSet->fields['nombre_usuario']."</td>
		<td>".$recordSet->fields['nivel']."</td>
		<td><a href=$pagina&&codigo_empleado="
				.$recordSet->fields['id_usuario']."><img src=\"imagenes/edit1.png\"> </a></td>
			<td><a onclick='return confirm(\"¿Seguro que desea eliminar  ".$recordSet->fields['nombre_usuario']."?\")' href=formsubmit_config.php?seccion=eliminar_empleado&codigo_empleado="
				.$recordSet->fields['id_usuario']."><img src=\"imagenes/delete3.png\"> </a></td>
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