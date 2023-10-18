<?php
session_start();
include("clases/acceso.php");
$datos= new datos_persona();


if($_GET["salir"]==1)
    {
    Session_destroy();
    echo "Sesion Finalizada<br>";
                $pagina="index.php";
               echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
    }
    else
    {

            $datos_r=$datos->credencial($_POST["usuario"],$_POST["pass"]);
                    $i=0;
        while (!$datos_r->EOF) {
            $i++;
            $datos_r->MoveNext();
        }
         $datos_r->MoveFirst();
             if($i==1)
            {
				$_SESSION[id_usuario]=$datos_r->fields["id_usuario"];
				$_SESSION[nombre]=$datos_r->fields["nombre_usuario"];
				$_SESSION[nivel]=$datos_r->fields["nivel"];
				echo "Bienvenido ".$datos_r->fields["nombre_usuario"];
				if($datos_r->fields["nivel"]>1){
					$pagina="principal";
				}
				else{
					$pagina="principal?seccion=plantilla";	
				}				
				
				echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
            }
            else
                {
                $pagina="index.php";
                echo "Datos Inconsistentes. Revise los Datos Ingresados";
                echo "<meta http-equiv=\"refresh\" content=\"2;URL=".$pagina."\">";
                }
}
//print_r($datos);
?>