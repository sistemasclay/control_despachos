<?php

include("../clases/adodb5/adodb-exceptions.inc.php");
include("../clases/adodb5/adodb.inc.php");
date_default_timezone_set('America/Lima');

class DatosTurno {

    public function DatosTurno() {
        // Tratado como constructor en PHP 5.3.0 - 5.3.2
        // Tratado como método regular a partir de PHP 5.3.3
    }
/*****************/
/*SECCION INICIAL*/
/*****************/
	public function listar_procesos_calidad_activos(){
		include("../clases/conexion.php");
		$sql = "SELECT *
				FROM cal_turno_muestreo ctm
				INNER JOIN cal_registros cr ON ctm.id_t_muestreo = cr.id_turno_muestreo AND activo = 1
				WHERE ctm.estado=1
				ORDER BY ctm.id_t_muestreo";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_info_producto($producto){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM productos WHERE id_producto=$producto ORDER BY id_producto";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_info_maquina($maquina){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_procesos WHERE id_proceso=$maquina ORDER BY id_proceso";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_info_proveedor($proveedor){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_proveedores WHERE id_proveedor=$proveedor ORDER BY id_proveedor";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_maquinas(){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_procesos WHERE estado=1 ORDER BY id_proceso";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_proveedores(){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_proveedores WHERE estado=1 ORDER BY id_proveedor";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_productos_maquina($codigo_maquina){
		include("../clases/conexion.php");
		$sql =	"SELECT prod.* 
				FROM productos prod 
					INNER JOIN cal_asignar_tipo_producto c ON c.id_proceso = $codigo_maquina AND c.id_producto = prod.id_producto
				WHERE prod.estado=1 
				ORDER BY prod.id_producto";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_productos_proveedor($codigo_proveedor){
		include("../clases/conexion.php");
		$sql =	"SELECT prod.* 
				FROM productos prod 
					INNER JOIN cal_asignar_tipo_producto c ON c.id_proveedor = $codigo_proveedor AND c.id_producto = prod.id_producto
				WHERE prod.estado=1 
				ORDER BY prod.id_producto";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_usuarios(){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM personal WHERE estado_persona=1 AND nivel != 4 ORDER BY id_persona";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	public function traer_parametros_producto($producto){
		include("../clases/conexion.php");
		$sql ="	SELECT * 
				FROM cal_estandar_producto cep
				INNER JOIN cal_parametros cp ON cep.id_parametro = cp.id_parametro
				WHERE id_producto=$producto AND cep.estado = 1 ORDER BY id_estandar_producto";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}
	public function traer_fallos_producto($producto){
		include("../clases/conexion.php");
		$sql ="	SELECT * 
				FROM cal_estandar_fallos cef
				INNER JOIN cal_fallos cf ON cef.id_fallo = cf.id_fallo and cuantificable = 0
				WHERE id_producto=$producto AND cef.estado = 1 ORDER BY id_estandar_fallo";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}
	public function comprobar_valor_parametro_producto($producto, $parametro, $valor){
		include("../clases/conexion.php");
		$sql ="	SELECT * 
				FROM cal_estandar_producto cep
				INNER JOIN cal_parametros cp ON cep.id_parametro = cp.id_parametro
				WHERE cep.id_producto=$producto AND cep.id_parametro=$parametro AND cep.estado = 1 ORDER BY cep.id_estandar_producto";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}		
		$lie = $result->fields["limite_inf_espec"];
		$lic = $result->fields["limite_inf_control"];
		$lsc = $result->fields["limite_sup_control"];
		$lse = $result->fields["limite_sup_espec"];		
		$conexion_pg->Close();
		
		//el unumero que retorna corresponde a los codigos de tipo_desfase en la base de datos
		if($valor >= $lic && $valor <= $lsc){
			return 0;
		}
		else if($valor >= $lie && $valor < $lic){
			return 2;
		}
		else if($valor > $lsc && $valor <= $lse){
			return 3;
		}
		else if($valor < $lie){
			return 1;
		}
		else{
			return 4;
		}
	}
	
/************************/
/*SECCION TURNO MUESTREO*/
/************************/

	//trae el fallo que corresponde a la relación producto-parametro, trae unicamente el indicado por el tipo (por encima o por debajo de los limites)
	public function traer_fallo_producto_parametro($producto,$parametro,$tipo){
		include("../clases/conexion.php");
		$sql ="	SELECT * 
				FROM cal_estandar_fallos cep
				WHERE id_producto=$producto AND id_parametro=$parametro AND tipo_desfase=$tipo AND cep.estado = 1";
		$result=$conexion_pg->Execute($sql);
		if($result === false)
		{
			echo 'error al listar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result->fields["id_fallo"];
	}
	//inicia un turno de muestreo
	public function iniciar_turno_muestreo($producto,$proceso){
		include("../clases/conexion.php");
		$fechaactual= date("Y-m-d H:i:s");
		$sql = "INSERT INTO cal_turno_muestreo (id_producto,fecha_inicio,estado,id_proceso) values ($producto,'$fechaactual',1,$proceso)";
		try{
			$conexion_pg->Execute($sql);
			$conexion_pg->Close();
			return 1;
		}
		catch (Exception $e){
			echo "error al crear un nuevo turno: ".$e->getMessage();
			$conexion_pg->Close();
			return 0;
		}
	}
	/*
		Comprueba que la existencia de un turno abierto con datos iguales a los enviados esto se hace al momento de iniciar
		-	En caso de encontrar un turno abierto con esos parametros retorna true (no se puede iniciar)
		-	Retorna false (si se puede iniciar) en caso contrario
	*/
	public function comprobar_turno_muestreo($producto,$proceso){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_turno_muestreo WHERE id_producto=$producto AND id_proceso=$proceso AND estado=1";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		$resultado=$result->fields["id_t_muestreo"];
		$result->MoveNext();
		$result->Close();
		if ($resultado)
		{				// Es que  existe
			return true;
		}
		else
		{				// Es que no existe
			return false;
		}
	}
	//traer el dato identificador del turno_muestreo activo que corresponde al producto y proceso dado por parametro
	public function traer_turno_muestreo($producto,$proceso){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_turno_muestreo WHERE id_producto=$producto AND id_proceso=$proceso AND estado = 1";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}	
	//crea un registro de muestreo para indicar los parametros y fallos de este
	public function iniciar_muestreo($producto,$proceso,$tipo,$usuario,$turno_muestreo,$lote,$op){
		include("../clases/conexion.php");
		$fechaactual= date("Y-m-d H:i:s");
		$tipo_proceso = "";
		if($tipo == 1){
			$tipo_proceso = "id_maquina";
		}
		else{
			$tipo_proceso = "id_proveedor";
		}
		$sql = "INSERT INTO cal_registros (id_producto,".$tipo_proceso.",ts_registro,id_usuario,id_turno_muestreo,lote,orden_produccion) values (".$producto.",".$proceso.",'".$fechaactual."',".$usuario.",".$turno_muestreo.",".$lote.",".$op.")";
		try{
			$conexion_pg->Execute($sql);
			$conexion_pg->Close();
			return 1;
		}
		catch (Exception $e){
			$fichero = 'log_errores.txt';
			// Abre el fichero para obtener el contenido existente
			$actual = file_get_contents($fichero);
			// Añade una nueva persona al fichero
			$actual .= "FECHA: ".$fechaactual.". ERROR AL INICIAR MUESTREO: ".$e->getMessage()."\n";
			// Escribe el contenido al fichero
			file_put_contents($fichero, $actual);
			//echo 'Excepción capturada al iniciar muestreo: ',  $e->getMessage(), "\n";
			echo "error al crear un nuevo turno: ".$e->getMessage();
			$conexion_pg->Close();
			return 0;
		}
	}
	//cerrar turno_muestreo
	public function cerrar_turno_muestreo($turno_muestreo){
		include("../clases/conexion.php");
		$fechaactual= date("Y-m-d H:i:s");
        $sql="UPDATE cal_turno_muestreo SET estado=0, fecha_fin='$fechaactual'  WHERE id_t_muestreo=$turno_muestreo";
        if ($conexion_pg->Execute($sql) === false) {
			echo 'error al borrar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
        $conexion_pg->Close();
		$this->cerrar_muestreo($turno_muestreo);
	}
/*******************/
/*SECCION REGISTROS*/
/*******************/
	public function traer_info_registro($registro){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_registros WHERE id_registro=$registro";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result->fields["id_registro"];
	}
	//trae el dato identificador del registro de muestreo dado el producto, el tipo de registro(importado/fabricado) y el id del proceso(o proveedor)
	public function traer_registro($producto,$proceso,$tipo){
		include("../clases/conexion.php");
		$tipo_proceso = "";
		if($tipo == 1){
			$tipo_proceso = "id_maquina";
		}
		else{
			$tipo_proceso = "id_proveedor";
		}
		$sql =	"SELECT * FROM cal_registros WHERE id_producto=$producto AND $tipo_proceso=$proceso AND activo = 1";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result->fields["id_registro"];
	}
	//cerrar muestreo
	public function cerrar_muestreo($turno_muestreo){
		include("../clases/conexion.php");
        $sql="UPDATE cal_registros SET activo=0 WHERE id_turno_muestreo=$turno_muestreo";
        if ($conexion_pg->Execute($sql) === false) {
        echo 'error al borrar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
        $conexion_pg->Close();		
	}
	//Este metodo se ejecuta unicamente cuando se presenta algun error
	public function parar_proceso($producto,$proceso,$tipo){
		include("../clases/conexion.php");
		$tipo_proceso = "";
		if($tipo == 1){
			$tipo_proceso = "id_maquina";
		}	
		else{
			$tipo_proceso = "id_proveedor";
		}
        $sql="UPDATE cal_registros SET estado=2 WHERE id_producto=$producto AND $tipo_proceso = $proceso";
        if ($conexion_pg->Execute($sql) === false) {
        echo 'error al borrar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
        $conexion_pg->Close();
	}
	//guarda los datos registrados de peso, ancho, peso o cualquier parametro que se digite
	public function agregar_parametro_registro($producto,$parametro,$proceso,$tipo,$medida){
		include("../clases/conexion.php");
		$registro = $this->traer_registro($producto,$proceso,$tipo);		
		$sql = "INSERT INTO cal_registro_parametros (id_registro,id_producto,id_parametro,medida) values ($registro,$producto,$parametro,$medida)";
		try{
			$conexion_pg->Execute($sql);
			$conexion_pg->Close();
			return 1;
		}
		catch (Exception $e){
			echo "error al crear un registro de parametro: ".$e->getMessage();
			$conexion_pg->Close();
			return 0;
		}
	}
	//guarda fallos atribuidos a parametros (cuantificables) como por ejemplo muy alto o muy bajo
	public function agregar_fallo_registro($proceso,$producto,$tipo,$fallo){
		include("../clases/conexion.php");
		$fechaactual= date("Y-m-d H:i:s");
		$tipo_proceso = "";
		$registro = $this->traer_registro($producto,$proceso,$tipo);
		
		$sql = "INSERT INTO cal_registro_fallos (id_registro,id_producto,id_proceso,id_fallo) values ($registro,$producto,$proceso,$fallo)";
		try{
			$conexion_pg->Execute($sql);
			$conexion_pg->Close();
			return 1;
		}
		catch (Exception $e){
			echo "error al crear un nuevo turno: ".$e->getMessage();
			$conexion_pg->Close();
			return 0;
		}
	}
	
	public function traer_registro_con_id($registro){
		include("../clases/conexion.php");
		$sql =	"SELECT * FROM cal_registros WHERE id_registro=$registro";
		$result=$conexion_pg->Execute($sql);
		if ($result === false)
		{
			echo 'error al comprobar: '.$conexion_pg->ErrorMsg().'<BR>';
		}
		$conexion_pg->Close();
		return $result;
	}
	
	public function cambiar_usuario_registro($registro,$usuario){
		include("../clases/conexion.php");
        $sql="UPDATE cal_registros SET id_usuario=$usuario WHERE id_registro=$registro";
        if ($conexion_pg->Execute($sql) === false) {
        echo 'error al borrar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
        $conexion_pg->Close();
	}
	
	public function guardar_observaciones_registro($tipo,$proceso,$producto,$observaciones){
		$registro = $this->traer_registro($producto,$proceso,$tipo);
		include("../clases/conexion.php");
        $sql="UPDATE cal_registros SET observaciones='$observaciones' WHERE id_registro=$registro";
        if ($conexion_pg->Execute($sql) === false) {
        echo 'error al borrar: '.$conexion_pg->ErrorMsg().'<BR>';
        }
        $conexion_pg->Close();
	}
}

?>
