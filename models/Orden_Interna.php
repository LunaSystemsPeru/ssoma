<?php

require_once 'Conectar.php';

class Orden_Interna
{
private $id;
private $codigo;
private $fecha_generado;
private $fecha_inicio;
private $duracion;
private $monto;
private $detalle;
private $observaciones;
private $solicitante;
private $responsable;
private $insumos;
private $sede_servicio;
private $id_tipo_servicio;
private $id_cliente;
private $id_usuario;
private $id_empresa;
private $c_conectar;

    /**
     * Orden_Interna constructor.
     */
    public function __construct()
    {
        $this->c_conectar= Conectar::getInstancia();
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
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getFechaGenerado()
    {
        return $this->fecha_generado;
    }

    /**
     * @param mixed $fecha_generado
     */
    public function setFechaGenerado($fecha_generado)
    {
        $this->fecha_generado = $fecha_generado;
    }

    /**
     * @return mixed
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    /**
     * @param mixed $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @return mixed
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * @param mixed $duracion
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
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

    /**
     * @return mixed
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * @param mixed $detalle
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    /**
     * @return mixed
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return mixed
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * @param mixed $solicitante
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;
    }

    /**
     * @return mixed
     */
    public function getSedeServicio()
    {
        return $this->sede_servicio;
    }

    /**
     * @param mixed $sede_servicio
     */
    public function setSedeServicio($sede_servicio)
    {
        $this->sede_servicio = $sede_servicio;
    }

    /**
     * @return mixed
     */
    public function getIdTipoServicio()
    {
        return $this->id_tipo_servicio;
    }

    /**
     * @param mixed $id_tipo_servicio
     */
    public function setIdTipoServicio($id_tipo_servicio)
    {
        $this->id_tipo_servicio = $id_tipo_servicio;
    }

    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * @param mixed $id_cliente
     */
    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
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
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * @param mixed $responsable
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;
    }

    /**
     * @return mixed
     */
    public function getInsumos()
    {
        return $this->insumos;
    }

    /**
     * @param mixed $insumos
     */
    public function setInsumos($insumos)
    {
        $this->insumos = $insumos;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(idorden_interna) +1, 1) as codigo from orden_interna";
        $this->id = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function generarNroOrden()
    {
        $sql = "select ifnull(max(codigo) +1, CONCAT(YEAR(CURRENT_DATE()), '001')) as codigo 
        from orden_interna 
        where codigo like concat(YEAR(CURRENT_DATE()), '%') ";
        $this->codigo = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into orden_interna values (
                                  '$this->id', 
                                  '$this->fecha_generado', 
                                  '$this->fecha_inicio', 
                                  '$this->duracion', 
                                  '$this->monto', 
                                  '$this->detalle', 
                                  '$this->observaciones', 
                                  '$this->solicitante', 
                                  '$this->codigo', 
                                  '$this->sede_servicio', 
                                  '$this->id_tipo_servicio', 
                                  '$this->id_cliente', 
                                  '$this->id_usuario', 
                                  '$this->id_empresa',
                                  '$this->responsable',
                                  '$this->insumos'
                                  )";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from orden_interna 
        where idorden_interna = '$this->id'" ;
        $resultado = $this->c_conectar->get_Row($sql);
        $this->fecha_generado = $resultado['fecha_generado'];
        $this->fecha_inicio = $resultado['fecha_inicio'];
        $this->duracion = $resultado['duracion'];
        $this->monto = $resultado['monto'];
        $this->detalle = $resultado['detalle'];
        $this->observaciones = $resultado['observaciones'];
        $this->solicitante = $resultado['solicita'];
        $this->codigo = $resultado['codigo'];
        $this->sede_servicio = $resultado['sede_servicio'];
        $this->id_tipo_servicio= $resultado['id_tipo_servicio'];
        $this->id_cliente = $resultado['id_clientes'];
        $this->id_usuario = $resultado['id_usuario'];
        $this->id_empresa = $resultado['id_empresas'];
        $this->responsable = $resultado['responsable'];
        $this->insumos = $resultado['insumos'];
    }

    public function actualizar()
    {
        $sql = "UPDATE orden_interna SET 
                fecha_generado = '$this->fecha_generado', 
                fecha_inicio = '$this->fecha_inicio',
                duracion = '$this->duracion',
                monto = '$this->monto',
                detalle = '$this->detalle',
                observaciones = '$this->observaciones',
                solicita = '$this->solicitante',
                sede_servicio = '$this->sede_servicio',
                id_tipo_servicio = '$this->id_tipo_servicio', 
                WHERE idorden_interna = '$this->id' " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM orden_interna
                WHERE  idorden_interna = '$this->id'  " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas () {
        $sql = "select oi.idorden_interna, oi.codigo, c.razon_social as raz_cliente, oi.sede_servicio, e.razon_social as raz_empresa, oi.observaciones as servicio, oi.detalle, oi.monto, oi.fecha_generado, oi.fecha_inicio, oi.duracion
        from orden_interna as oi
        inner join clientes as c on c.id_clientes = oi.id_clientes
        inner join empresas e on oi.id_empresas = e.id_empresas";
        return $this->c_conectar->get_Cursor($sql);
    }
}