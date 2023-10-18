<?php

require 'TurnoRegistro.php';
require 'DatosTurno.php';

class LogicaTurno {

    private $datos = null;

    public function LogicaTurno() {
        $this->datos = new DatosTurno();
    }
	/*FUNCIONES PARA LISTAR INFORMACION*/
	public function listar_procesos_calidad_activos(){
		return $this->datos->listar_procesos_calidad_activos();
	}
	
	public function traer_maquinas(){
		return $this->datos->traer_maquinas();
	}
	
	public function traer_proveedores(){
		return $this->datos->traer_proveedores();
	}
	
	public function traer_usuarios(){
		return $this->datos->traer_usuarios();
	}
	
	public function traer_productos_maquina($codigo_maquina){
		return $this->datos->traer_productos_maquina($codigo_maquina);
	}
	
	public function traer_productos_proveedor($codigo_proveedor){
		return $this->datos->traer_productos_proveedor($codigo_proveedor);
	}
	
	/*FUNCIONES PARA TRAER INFORMACION DE ALGO*/
	public function comprobar_turno_muestreo($producto,$proceso){
		return $this->datos->comprobar_turno_muestreo($producto,$proceso);
	}
	
	public function traer_info_producto($producto){
		return $this->datos->traer_info_producto($producto);
	}
	
	public function traer_info_maquina($maquina){
		return $this->datos->traer_info_maquina($maquina);
	}
	
	public function traer_info_proveedor($proveedor){
		return $this->datos->traer_info_proveedor($proveedor);
	}
	
	public function traer_datos_parametro($parametro){
		return $this->datos->traer_datos_parametro($parametro);
	}
	
	public function traer_datos_fallo($fallo){
		return $this->datos->traer_datos_fallo($fallo);
	}
	
	public function traer_parametros_producto($producto){
		return $this->datos->traer_parametros_producto($producto);
	}
	
	public function traer_fallos_producto($producto){
		return $this->datos->traer_fallos_producto($producto);
	}
	
	public function iniciar_turno_muestreo($producto,$proceso){
		return $this->datos->iniciar_turno_muestreo($producto,$proceso);
	}
	
	public function iniciar_muestreo($producto,$proceso,$tipo,$usuario,$turno_muestreo,$lote,$op){
		return $this->datos->iniciar_muestreo($producto,$proceso,$tipo,$usuario,$turno_muestreo,$lote,$op);
	}
	
	public function parar_proceso($producto,$proceso,$tipo){
		return $this->datos->parar_proceso($producto,$proceso,$tipo);
	}
	
	public function comprobar_parametros_producto($producto){
		return $this->datos->comprobar_parametros_producto($producto);
	}
	
	public function comprobar_fallos_producto($producto){
		return $this->datos->comprobar_fallos_producto($producto);
	}
	
	public function comprobar_valor_parametro_producto($producto, $parametro, $valor){
		return $this->datos->comprobar_valor_parametro_producto($producto, $parametro, $valor);
	}
	
	public function agregar_parametro_registro($producto,$parametro,$proceso,$tipo,$medida){
		return $this->datos->agregar_parametro_registro($producto,$parametro,$proceso,$tipo,$medida);
	}
	
	public function traer_fallo_producto_parametro($producto,$parametro,$tipo){
		return $this->datos->traer_fallo_producto_parametro($producto,$parametro,$tipo);
	}
	
	public function agregar_fallo_registro($proceso,$producto,$tipo,$fallo){
		return $this->datos->agregar_fallo_registro($proceso,$producto,$tipo,$fallo);
	}
	
	public function cerrar_muestreo($turno_muestreo){
		return $this->datos->cerrar_muestreo($turno_muestreo);
	}
	
	public function cerrar_turno_muestreo($turno_muestreo){
		return $this->datos->cerrar_turno_muestreo($turno_muestreo);
	}
	
	public function traer_registro_con_id($registro){
		return $this->datos->traer_registro_con_id($registro);
	}
	
	public function traer_turno_muestreo($producto,$proceso){
		return $this->datos->traer_turno_muestreo($producto,$proceso);
	}

	public function guardar_observaciones_registro($tipo,$proceso,$producto,$observaciones){
		return $this->datos->guardar_observaciones_registro($tipo,$proceso,$producto,$observaciones);
	}

}
?>