<?php
require_once 'Conectar.php';

class PrestamoColaborador
{
    private $idprestamo;
    private $fecha;
    private $idcolaborador;
    private $monto;
    private $estado;
    private $nrocuotas;
    private $ultimopago;
    private $montopagado;
    private $c_conectar;

    /**
     * PrestamoColaborador constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdprestamo()
    {
        return $this->idprestamo;
    }

    /**
     * @param mixed $idprestamo
     */
    public function setIdprestamo($idprestamo)
    {
        $this->idprestamo = $idprestamo;
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
    public function getIdcolaborador()
    {
        return $this->idcolaborador;
    }

    /**
     * @param mixed $idcolaborador
     */
    public function setIdcolaborador($idcolaborador)
    {
        $this->idcolaborador = $idcolaborador;
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
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getNrocuotas()
    {
        return $this->nrocuotas;
    }

    /**
     * @param mixed $nrocuotas
     */
    public function setNrocuotas($nrocuotas)
    {
        $this->nrocuotas = $nrocuotas;
    }

    /**
     * @return mixed
     */
    public function getUltimopago()
    {
        return $this->ultimopago;
    }

    /**
     * @param mixed $ultimopago
     */
    public function setUltimopago($ultimopago)
    {
        $this->ultimopago = $ultimopago;
    }

    /**
     * @return mixed
     */
    public function getMontopagado()
    {
        return $this->montopagado;
    }

    /**
     * @param mixed $montopagado
     */
    public function setMontopagado($montopagado)
    {
        $this->montopagado = $montopagado;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(idprestamo) +1, 1) as codigo from prestamos_colaborador";
        $this->idprestamo = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into prestamos_colaborador 
                values ('$this->idprestamo', 
                        '$this->idcolaborador',
                        '$this->monto',
                        '$this->fecha',
                        '$this->nrocuotas',
                        '0',
                        '$this->montopagado',
                        '$this->ultimopago')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from prestamos_colaborador 
        where idprestamo = '$this->idprestamo'" ;
        $resultado = $this->c_conectar->get_Row($sql);
        $this->idcolaborador = $resultado['id_colaborador'];
        $this->monto = $resultado['monto_total'];
        $this->fecha = $resultado['fecha_prestamos'];
        $this->nrocuotas = $resultado['nro_cuotas'];
        $this->ultimopago = $resultado['ultimo_pago'];
        $this->montopagado = $resultado['monto_pagado'];
        $this->estado = $resultado['estado'];
    }

    public function actualizar()
    {
        $sql = "UPDATE prestamos_colaborador
                SET  monto_total = '$this->monto',
                 fecha_prestamos = '$this->fecha'
                  WHERE  idprestamo = '$this->idprestamo' " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM prestamos_colaborador
                WHERE  idprestamo = '$this->idprestamo' " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas () {
        $sql = "select pc.monto_total, pc.fecha_prestamos, pc.nro_cuotas, pc.estado, c.datos, pc.monto_pagado, pc.ultimo_pago
                from prestamos_colaborador as pc
                inner join colaboradores c on pc.id_colaborador = c.id_colaborador ";
        return $this->c_conectar->get_Cursor($sql);
    }

}