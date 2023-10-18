<?php

      include("adodb5/adodb-exceptions.inc.php");
      include("adodb5/adodb.inc.php");
      
class datos_persona {
        
    function credencial($login,$pass)
    {
		
		$sql ="SELECT * FROM usuarios WHERE id_usuario=$login AND pass_usuario='$pass'";
        include("conexion.php");
        $result = $conexion_pg->Execute($sql);
        if ($result === false) die("fallo consulta");
		$conexion_pg->Close();

        return $result;

    }

}

?>
