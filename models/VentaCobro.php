<?php
require_once 'Conectar.php';

class VentaCobro
{
    private $id_venta;
    private $id_movimiento;
    private $monto;
    private $c_conectar;

    /**
     * VentaCobro constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdVenta()
    {
        return $this->id_venta;
    }

    /**
     * @param mixed $id_venta
     */
    public function setIdVenta($id_venta)
    {
        $this->id_venta = $id_venta;
    }

    /**
     * @return mixed
     */
    public function getIdMovimiento()
    {
        return $this->id_movimiento;
    }

    /**
     * @param mixed $id_movimiento
     */
    public function setIdMovimiento($id_movimiento)
    {
        $this->id_movimiento = $id_movimiento;
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

    public function insertar()
    {
        $sql = "insert into ventas_cobros 
            values ('$this->id_venta', 
                    '$this->id_movimiento', 
                    '$this->monto')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from ventas_cobros 
            where id_venta = '$this->id_venta' and id_movimiento = '$this->id_movimiento'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verTodas()
    {
        $sql = "select vc.id_movimiento, bm.fecha, vc.monto, b.nombre, b.cuenta
        from ventas_cobros as vc
        inner join bancos_movimientos bm on vc.id_movimiento = bm.id_movimiento
        inner join bancos b on bm.id_banco = b.id_banco
        where vc.id_venta = '$this->id_venta' 
        order by bm.fecha asc";
        return $this->c_conectar->get_Cursor($sql);
    }

}