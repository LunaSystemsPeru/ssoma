<?php

require_once 'Conectar.php';

class RecordatorioServicio
{
    private $id;
    private $fecha;
    private $dia;
    private $servicio;
    private $url;
    private $codcliente;
    private $idproveedor;
    private $monto;
    private $c_conectar;

    /**
     * RecordatorioServicio constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * @param mixed $dia
     */
    public function setDia($dia)
    {
        $this->dia = $dia;
    }

    /**
     * @return mixed
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * @param mixed $servicio
     */
    public function setServicio($servicio)
    {
        $this->servicio = $servicio;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getCodcliente()
    {
        return $this->codcliente;
    }

    /**
     * @param mixed $codcliente
     */
    public function setCodcliente($codcliente)
    {
        $this->codcliente = $codcliente;
    }

    /**
     * @return mixed
     */
    public function getIdproveedor()
    {
        return $this->idproveedor;
    }

    /**
     * @param mixed $idproveedor
     */
    public function setIdproveedor($idproveedor)
    {
        $this->idproveedor = $idproveedor;
    }

    /**
     * @return mixed
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param mixed $monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(idrecodatorio) +1, 1) as codigo from recordatorio_servicios";
        $this->id = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into recordatorio_servicios values (
                                  '$this->id', 
                                  '$this->fecha', 
                                  '$this->dia', 
                                  '$this->url',
                                  '$this->servicio',
                                  '$this->codcliente',
                                  '$this->idproveedor',
                                  '$this->monto')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from recordatorio_servicios 
        where id = '$this->id'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->fecha = $resultado['fecha'];
        $this->dia = $resultado['dia'];
        $this->url = $resultado['url'];
        $this->servicio = $resultado['servicio'];
        $this->codcliente = $resultado['codcliente'];
        $this->idproveedor = $resultado['id_proveedor'];
        $this->monto = $resultado['monto'];
    }

    public function actualizar()
    {
        $sql = "UPDATE recordatorio_servicios SET 
                dia = '$this->dia', 
                servicio = '$this->servicio', 
                url = '$this->url',
                codcliente = '$this->codcliente' , 
                monto = '$this->monto'
                WHERE id = '$this->id' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM recordatorio_servicios
                WHERE  id = '$this->id'  ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas()
    {
        $sql = "select rs.idrecodatorio as id, rs.fecha, rs.codcliente, rs.dia, rs.servicio, p.razon_social, rs.url, rs.monto 
                from recordatorio_servicios as rs
                         inner join proveedores as p  on p.id_proveedor = rs.id_proveedor
                order by dia asc;";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verPendientes()
    {
        $sql = "select rs.idrecodatorio as id, rs.fecha, rs.codcliente, rs.dia, rs.servicio, p.razon_social, rs.url, rs.monto
                from recordatorio_servicios as rs
                         inner join proveedores as p  on p.id_proveedor = rs.id_proveedor
                where (dia) > (day(current_date()) - 7) and dia <= day(current_date())";
        return $this->c_conectar->get_Cursor($sql);
    }
}