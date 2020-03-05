<?php

require 'conectar.php';

class cl_archivos_empleados {

    private $id_empresa;
    private $id_empleado;
    private $id_archivo;
    private $nombre;
    private $archivo;

    function __construct() {
        
    }

    function getId_empresa() {
        return $this->id_empresa;
    }

    function getId_empleado() {
        return $this->id_empleado;
    }

    function getId_archivo() {
        return $this->id_archivo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function setId_empresa($id_empresa) {
        $this->id_empresa = $id_empresa;
    }

    function setId_empleado($id_empleado) {
        $this->id_empleado = $id_empleado;
    }

    function setId_archivo($id_archivo) {
        $this->id_archivo = $id_archivo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    function obtener_id() {
        $id = 1;
        global $conn;
        $query = "select ifnull(max(id_archivo) + 1, 1) as codigo "
                . "from archivos_empleados "
                . "where id_empresa = '" . $this->id_empresa . "' and id_empleado = '" . $this->id_empleado . "'";
        $resultado = $conn->query($query);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $id = $fila ['codigo'];
            }
        }
        return $id;
    }

    function insertar() {
        $grabado = false;
        global $conn;
        $query = "insert into archivos_empleados "
                . "values ('" . $this->id_empresa . "', '" . $this->id_empleado . "', '" . $this->id_archivo . "', '" . $this->nombre . "', '" . $this->archivo . "')";
        $resultado = $conn->query($query);
        if (!$resultado) {
            die('Could not enter data in archivos_empleados: ' . mysqli_error($conn));
        } else {
            //echo "Entered data successfully";
            $grabado = true;
        }
        return $grabado;
    }

    function ver_archivos() {
        global $conn;
        $query = "select * "
                . "from archivos_empleados "
                . "where id_empresa = '" . $this->id_empresa . "' and id_empleado = '" . $this->id_empleado . "'";
        $resultado = $conn->query($query);
        $fila = $resultado->fetch_all(MYSQLI_ASSOC);
        return $fila;
    }

}
