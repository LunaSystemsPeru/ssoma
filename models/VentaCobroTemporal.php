<?php
require_once 'Conectar.php';

class VentaCobroTemporal
{
private $idventa;
private $fecha;
private $idbanco;
private $monto;
private $nota;
private $c_conectar;

    /**
     * VentaCobroTemporal constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdventa()
    {
        return $this->idventa;
    }

    /**
     * @param mixed $idventa
     */
    public function setIdventa($idventa)
    {
        $this->idventa = $idventa;
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
    public function getIdbanco()
    {
        return $this->idbanco;
    }

    /**
     * @param mixed $idbanco
     */
    public function setIdbanco($idbanco)
    {
        $this->idbanco = $idbanco;
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
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * @param mixed $nota
     */
    public function setNota($nota)
    {
        $this->nota = $nota;
    }

    public function obtenerDatos()
    {
        $sql = "select * from ventas_cobros_temporales
        where id_venta = '$this->idventa'";
        $resultado = $this->c_conectar->get_Row($sql);
        if (count($resultado) > 0) {
        $this->fecha = $resultado['fecha'];
        $this->monto = $resultado['monto'];
        $this->idbanco = $resultado['id_banco'];
        $this->nota = $resultado['nota'];}
    }

    public function insertar()
    {
        $sql = "insert into ventas_cobros_temporales 
            values ('$this->idventa', 
                    '$this->fecha',
                    '$this->monto',
                    '$this->idbanco',
                    '$this->nota')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from ventas_cobros_temporales 
            where id_venta = '$this->idventa'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verPagos()
    {
        $sql = "select vct.fecha, vct.monto, vct.nota, b.nombre, vct.id_venta
        from ventas_cobros_temporales as vct
                 inner join bancos as b on b.id_banco = vct.id_banco
        where id_venta = '$this->idventa'";
        return $this->c_conectar->get_Cursor($sql);
    }

}