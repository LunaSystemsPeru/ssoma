<?php

include ("../includes/conectar.php");

class Eventos {

    var $descripcion;
    var $fecha_inicio;
    var $fecha_final;
    var $empresa;
    var $id;
    var $anio;
    var $tipo_evento;
    var $estado;

    function __construct() {
        
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getFecha_inicio() {
        return $this->fecha_inicio;
    }

    function getFecha_final() {
        return $this->fecha_final;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getId() {
        return $this->id;
    }

    function getAnio() {
        return $this->anio;
    }

    function getTipo_evento() {
        return $this->tipo_evento;
    }

    function getEstado() {
        return $this->estado;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setFecha_inicio($fecha_inicio) {
        $this->fecha_inicio = $fecha_inicio;
    }

    function setFecha_final($fecha_final) {
        $this->fecha_final = $fecha_final;
    }

    function setEmpresa($empresa) {
        $this->empresa = $empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setAnio($anio) {
        $this->anio = $anio;
    }

    function setTipo_evento($tipo_evento) {
        $this->tipo_evento = $tipo_evento;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function obtener_id($anio, $empresa) {
        $id = 1;
        global $conn;
        $ver_datos = "select id from evento where anio = '" . $anio . "' and empresa = '" . $empresa . "' order by id desc limit 1";
        echo $ver_datos;
        $r_datos = $conn->query($ver_datos);
        if ($r_datos->num_rows > 0) {
            while ($fila = $r_datos->fetch_assoc()) {
                $id = $fila ['id'] + 1;
            }
        }
        return $id;
    }

    function grabar_evento() {
        $grabado = false;
        global $conn;
        $registrar = "insert into evento values ('" . $this->id . "', '" . $this->anio . "', '" . $this->empresa . "', '" . $this->descripcion . "', '" . $this->tipo_evento . "', '" . $this->fecha_inicio . "', '" . $this->fecha_final . "', '" . $this->estado . "')";
        $resultado = $conn->query($registrar);
        if (!$resultado) {
            die('Could not enter data: ' . mysqli_error($conn));
        } else {
            echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

}
