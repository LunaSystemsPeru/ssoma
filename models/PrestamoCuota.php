<?php
require_once 'Conectar.php';

class PrestamoCuota
{
    private $idcuota;
    private $idprestamo;
    private $fecha_cuota;
    private $fecha_pago;
    private $monto_cuota;
    private $monto_pago;
    private $c_conectar;

    /**
     * PrestamoCuota constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdcuota()
    {
        return $this->idcuota;
    }

    /**
     * @param mixed $idcuota
     */
    public function setIdcuota($idcuota)
    {
        $this->idcuota = $idcuota;
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
    public function getFechaCuota()
    {
        return $this->fecha_cuota;
    }

    /**
     * @param mixed $fecha_cuota
     */
    public function setFechaCuota($fecha_cuota)
    {
        $this->fecha_cuota = $fecha_cuota;
    }

    /**
     * @return mixed
     */
    public function getFechaPago()
    {
        return $this->fecha_pago;
    }

    /**
     * @param mixed $fecha_pago
     */
    public function setFechaPago($fecha_pago)
    {
        $this->fecha_pago = $fecha_pago;
    }

    /**
     * @return mixed
     */
    public function getMontoCuota()
    {
        return $this->monto_cuota;
    }

    /**
     * @param mixed $monto_cuota
     */
    public function setMontoCuota($monto_cuota)
    {
        $this->monto_cuota = $monto_cuota;
    }

    /**
     * @return mixed
     */
    public function getMontoPago()
    {
        return $this->monto_pago;
    }

    /**
     * @param mixed $monto_pago
     */
    public function setMontoPago($monto_pago)
    {
        $this->monto_pago = $monto_pago;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_cuota) +1, 1) as codigo from prestamos_cuotas";
        $this->idcuota = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into prestamos_cuotas 
                values ('$this->idcuota', 
                        '$this->idprestamo',
                        '$this->fecha_cuota',
                        '1000-01-01',
                        '$this->monto_cuota',
                        '0')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function actualizar()
    {
        $sql = "UPDATE prestamos_cuotas
                SET  fecha_pago = '$this->fecha_pago',
                    monto_pagado = '$this->monto_pago'
                WHERE id_cuota = '$this->idcuota' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM prestamos_cuotas
                WHERE  id_cuota= '$this->idcuota'  ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas()
    {
        $sql = "select id_cuota, fecha_cuota, fecha_pago, monto_cuota, monto_pagado 
                from prestamos_cuotas 
                where idprestamo = '$this->idprestamo'
                order by fecha_cuota desc";
        return $this->c_conectar->get_Cursor($sql);
    }


}