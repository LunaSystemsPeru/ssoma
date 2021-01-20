<?php

require_once 'Conectar.php';

class ArchivoColaborador
{
    private $id_empresa;
    private $id_empleado;
    private $id_archivo;
    private $nombre;
    private $archivo;
    private $c_conectar;

    /**
     * ArchivoColaborador constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }

    /**
     * @param mixed $id_empresa
     */
    public function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    /**
     * @return mixed
     */
    public function getIdEmpleado()
    {
        return $this->id_empleado;
    }

    /**
     * @param mixed $id_empleado
     */
    public function setIdEmpleado($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }

    /**
     * @return mixed
     */
    public function getIdArchivo()
    {
        return $this->id_archivo;
    }

    /**
     * @param mixed $id_archivo
     */
    public function setIdArchivo($id_archivo)
    {
        $this->id_archivo = $id_archivo;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getArchivo()
    {
        return $this->archivo;
    }

    /**
     * @param mixed $archivo
     */
    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;
    }

    public function  ver_archivos() {
        $query = "select * 
        from colaboradores_adjuntos  
        where id_colaborador = '$this->id_empleado'";
    }


}