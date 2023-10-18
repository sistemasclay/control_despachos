<?php

/**
 * Description of Contacto
 *
 * @author Usuario
 */
class TurnoRegistro {

    /**
     * 
     * @param string $nombre
     * @param string $apellido
     * @param string $telefono
     */
	private $nombre;
    private $apellido;
	private $telefono;
	
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
	
	public function getApellido() {
        return $this->apellido;
    }
    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }
	
	public function getTelefono() {
        return $this->telefono;
    }
	
    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
	
    public function __construct($nombre, $apellido, $telefono) {
        $this->setNombre($nombre);
		$this->setApellido($apellido);
		$this->setTelefono($telefono);
    }

    /**
     * Retorna array asociativo con los datos del contacto.
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'nombre' => $this->getNombre(),
            'apellido' => $this->getApellido(),
            'telefono' => $this->getTelefono()
        );
    }

}
?>
