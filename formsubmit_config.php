<? session_start(); ?>
<body>
<?php

include("clases/configuracion_aplicacion.php");
$datos = new configuracion_aplicacion();
$pagina="principal?seccion=".$seccion;


if (isset($_POST["cambioLote"])) {
	$id_despacho = $_POST["id_despacho"];
	$id_remision = $_POST["id_remision"];
	$producto = $_POST["id_producto"];
			$nuevo_lote = $_POST["lote_producto"];
			$datos->cambiar_lote($id_remision,$nuevo_lote,$producto);

			$pagina="principal?seccion=remision&id_despacho=".$id_despacho."&id_remision=".$id_remision;
			echo "Cambiando Lote..";
			
			echo "<meta http-equiv=\"refresh\" content=\"3;URL=".$pagina."\">";
}
switch ($seccion)
{
        case "maquinas":

                    if($datos->comprobar_proceso($_POST["codigo_maquina"]))
                    {
						echo "Actualizando...";
						$datos->actualizar_proceso($_POST["codigo_maquina"], $_POST["nombre_maquina"], $_POST["descripcion_maquina"], $_POST["estado_maquina"]);
						echo "Proceso ".$_POST["nombre_maquina"]." Actualizado";
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                    }
                    else
                    {
						echo "Registrando...";						
						$datos->registro_proceso($_POST["codigo_maquina"], $_POST["nombre_maquina"], $_POST["descripcion_maquina"], $_POST["estado_maquina"]);
						echo "Proceso ".$_POST["nombre_maquina"]." Registrado";
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                    }
		break;

		case "eliminar_proceso":
					$pagina="configuracion?seccion=maquinas";
                    echo "Eliminando..";
					$datos->borrar_proceso($_GET["codigo_maquina"]);
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
					 
		break;
//-----------------------------
		case "proveedores":

                    if($datos->comprobar_proveedor($_POST["codigo_proveedor"]))
                    {
						echo "Actualizando...";
						$datos->actualizar_proveedor($_POST["codigo_proveedor"], $_POST["nombre_proveedor"], $_POST["descripcion_proveedor"], $_POST["estado_proveedor"]);
						echo "Proceso ".$_POST["nombre_proveedor"]." Actualizado";
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                    }
                    else
                    {
						echo "Registrando...";						
						$datos->registro_proveedor($_POST["codigo_proveedor"], $_POST["nombre_proveedor"], $_POST["descripcion_proveedor"], $_POST["estado_proveedor"]);
						echo "Proceso ".$_POST["nombre_proveedor"]." Registrado";
						echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                    }
		break;

		case "eliminar_proveedor":
					$pagina="configuracion?seccion=maquinas";
                    echo "Eliminando..";
					$datos->borrar_proveedor($_GET["codigo_proveedor"]);
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
					 
		break;
//----------------------------
		case "usuarios":
                    if($datos->comprobar_usuario($_POST["codigo_empleado"]))
                     {
                         echo "actualizando...";
                         $datos->actualizar_usuario($_POST["codigo_empleado"], $_POST["user_name"], $_POST["contra_empleado"], $_POST["nivel_empleado"], $_POST["estado_empleado"]);
                          echo "Informacion del usuario :".$_POST["user_name"]." Actualizada";
                          echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                     }
                     else
                     {
                         echo "registrando...";
                         $datos->registro_usuario($_POST["codigo_empleado"], $_POST["user_name"], $_POST["contra_empleado"], $_POST["nivel_empleado"], $_POST["estado_empleado"]);
                         echo "Usuario ".$_POST["user_name"]." Registrado";
                       echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
                     }
		break;

		case "eliminar_empleado":
			$pagina="configuracion?seccion=usuarios";
			echo "Eliminando..";
			$datos->borrar_usuario($_GET["codigo_empleado"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
		break;
//----------------------------
		case "productos":
			if($datos->comprobar_producto($_POST["codigo_producto"]))
			{
				echo "actualizando...";
				$datos->actualizar_producto($_POST["codigo_producto"],$_POST["nombre_producto"],$_POST["cod_barras"],$_POST["cod_final"],$_POST["cant_empaque_final"]);
				echo "Producto ".$_POST["nombre_producto"]." Actualizado";
				echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
			}
			else
			{
				echo "registrando ..";
				$datos->registro_producto($_POST["codigo_producto"],$_POST["nombre_producto"],$_POST["cod_barras"],$_POST["cod_final"],$_POST["cant_empaque_final"]);
				echo "Producto".$_POST["nombre_producto"]." Registrado";
				echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
			}
		break;

		case "eliminar_producto":

                    echo "Eliminando..".$_GET["codigo_producto"];
                     $datos->borrar_producto($_GET["codigo_producto"]);
                     echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
			break;
//----------------------------
		case "parametros":
				if($datos->comprobar_parametro($_POST["codigo_parametro"]))
				{
					echo "actualizando...";
					$datos->actualizar_parametro($_POST["codigo_parametro"], $_POST["nombre_parametro"], $_POST["descripcion_parametro"], $_POST["estado"]);
					echo "Informacion del sub-sistema :".$_POST["nombre_parametro"]." Actualizada";
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
				else
				{
					echo "registrando...";
					$datos->registro_parametro($_POST["codigo_parametro"], $_POST["nombre_parametro"], $_POST["descripcion_parametro"], $_POST["estado"]);
					echo "Sub-sistema ".$_POST["nombre_parametro"]." Registrado";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
		break;
	
		case "eliminar_parametro":
			$pagina="configuracion?seccion=parametros";
			echo "Eliminando..";
			$datos->borrar_parametro($_GET["codigo_parametro"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
		break;
//----------------------------
		case "fallos":
				if($datos->comprobar_fallo($_POST["codigo_fallo"]))
				{
					echo "actualizando...";
					$datos->actualizar_fallo($_POST["codigo_fallo"], $_POST["nombre_fallo"], $_POST["descripcion_fallo"], $_POST["estado"], $_POST["cuantificable"]);
					echo "Informacion de la fallo :".$_POST["nombre_fallo"]." Actualizada";
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
				else
				{
					echo "registrando...";
					$datos->registro_fallo($_POST["codigo_fallo"], $_POST["nombre_fallo"], $_POST["descripcion_fallo"], $_POST["estado"], $_POST["cuantificable"]);
					echo "fallo ".$_POST["nombre_fallo"]." Registrado";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
		break;
	
		case "eliminar_fallo":
			$pagina="configuracion?seccion=fallo";
			echo "Eliminando..";
			$datos->borrar_fallo($_GET["codigo_fallo"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
		break;
//-----------------------
		case "std_producto":
			echo $_POST["unidad_medida"].",";
				if($datos->comprobar_estandar_producto($_POST["codigo_producto"],$_POST["codigo_parametro"]))
				{
					echo "actualizando...";
					$datos->actualizar_estandar_producto($_POST["codigo_producto"], $_POST["codigo_parametro"], $_POST["lie"],$_POST["lic"], $_POST["lsc"],$_POST["lse"], $_POST["estado"],$_POST["unidad_medida"]);
					//echo "Informacion del insumo :".$_POST["nombre_insumo"]." Actualizada";
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
				else
				{
					echo "registrando...";
					$datos->registro_estandar_producto($_POST["codigo_producto"], $_POST["codigo_parametro"], $_POST["lie"],$_POST["lic"], $_POST["lsc"],$_POST["lse"], $_POST["estado"],$_POST["unidad_medida"]);
					//echo "Insumo ".$_POST["nombre_insumo"]." Registrado";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
		break;
	
		case "eliminar_std_producto":
			$pagina="configuracion?seccion=std_producto";
			echo "Eliminando..";
			$datos->borrar_estandar_producto($_GET["codigo_std_producto"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
		break;
//-----------------------
		case "std_fallo":
				if($_POST["codigo_parametro"]){
					$parametro = $_POST["codigo_parametro"];
				}
				else{
					$parametro = 0;
				}
				if($_POST["tipo_desfase"]){
					$tipo_desfase = $_POST["tipo_desfase"];
				}
				else{
					$tipo_desfase = 0;
				}
				if($datos->comprobar_estandar_fallo($_POST["codigo_producto"],$parametro,$_POST["codigo_fallo"]))
				{
					echo "actualizando...";
					$datos->actualizar_estandar_fallo($_POST["codigo_producto"], $parametro, $_POST["codigo_fallo"],$tipo_desfase, $_POST["estado"], $_POST["criticidad"]);
					//echo "Producto ".$_POST["codigo_producto"]."<br>Parametro ".$parametro."<br> Fallo ".$_POST["codigo_fallo"]."<br> Tipo desfase ".$tipo_desfase."<br> estado ".$_POST["estado"]."<br> Criticidad ".$_POST["criticidad"];
					echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
				}
				else
				{
					echo "registrando...";
					$datos->registro_estandar_fallo($_POST["codigo_producto"], $parametro, $_POST["codigo_fallo"],$tipo_desfase, $_POST["estado"], $_POST["criticidad"]);
					//echo "Producto ".$_POST["codigo_producto"]."<br>Parametro ".$parametro."<br> Fallo ".$_POST["codigo_fallo"]."<br> Tipo desfase ".$tipo_desfase."<br> estado ".$_POST["estado"]."<br> Criticidad ".$_POST["criticidad"];
				echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
				}
		break;
	
		case "eliminar_std_fallo":
			$pagina="configuracion?seccion=std_fallo";
			echo "Eliminando..";
			$datos->borrar_estandar_fallo($_GET["codigo_std_fallo"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
		break;
//-----------------------
	case "asignar":
				if($datos->comprobar_asignacion($_POST["codigo_producto"],$_POST["tipo_producto"],$_POST["codigo_proc_prov"]))
				{
					echo "actualizando...";
					$datos->actualizar_asignacion($_POST["codigo_producto"],$_POST["tipo_producto"],$_POST["codigo_proc_prov"],$_POST["estado"]);
					//echo "Informacion del insumo :".$_POST["nombre_insumo"]." Actualizada";
					echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
				else
				{
					echo "registrando...";
					$datos->registro_asignacion($_POST["codigo_producto"],$_POST["tipo_producto"],$_POST["codigo_proc_prov"],$_POST["estado"]);
					//echo "Insumo ".$_POST["nombre_insumo"]." Registrado";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
				}
		break;

	
		/*case "eliminar_asignacion":
			$pagina="configuracion?seccion=asignar";
			echo "Eliminando..";
			$datos->borrar_estandar_fallo($_GET["codigo_std_fallo"]);
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$pagina."\">";
		break;*/
//-----------------------

}
?>
</body>