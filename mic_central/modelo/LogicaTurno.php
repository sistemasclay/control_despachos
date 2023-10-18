<?php

require 'TurnoRegistro.php';
require 'DatosTurno.php';

class LogicaTurno {

    private $datos = null;

    public function LogicaTurno() {
        $this->datos = new DatosTurno();
    }

    public function getNumeroDeOperarios($numeroProceso) {
        return $this->datos->getNumeroOperarios($numeroProceso);
    }

    public function validarOperario($codigo) {
        return $this->datos->validarOperario($codigo);
    }

    public function validarOP($codigo) {
        return $this->datos->validarOP($codigo);
    }

    public function validarProducto($codigo) {
        return $this->datos->validarProducto($codigo);
    }

    public function traerDatosTurno($maquina) {
        return $this->datos->traerDatosTurno($maquina);
    }

    public function traerDatosParada($maquina) {
        return $this->datos->traerDatosParada($maquina);
    }

    public function iniciarTurno($turno) {
        return $this->datos->iniciarTurno($turno);
    }

    public function registrarParada($maquina,$codigo) {
        return $this->datos->registrarParada($maquina,$codigo);
    }
	public function cerrarTurno($turno) {
        return $this->datos->cerrarTurno($turno);
    }
	public function guardarObservaciones($turno){
		return $this->datos->guardar_observaciones($turno);
	}
	public function traerDatosDesperdicios(){
		return $this->datos->traerDatosDesperdicios();
	}
	public function sacarUsuario($usuario, $maquina){
		return $this->datos->sacarUsuario($usuario, $maquina);
	}
	public function ingresarUsuario($usuario, $maquina){
		return $this->datos->ingresarUsuario($usuario, $maquina);
	}
	public function traerDatoExtraTurno(){
		return $this->datos->traerDatoExtraTurno();
	}
	public function validarSalida($maquina){
		return $this->datos->validarSalida($maquina);
	}
	public function llamado($maquina, $codigo){
		$this->datos->llamado($maquina,$codigo);
	}
	public function esta_llamando($maquina){
		return $this->datos->esta_llamando($maquina);
	}
}
