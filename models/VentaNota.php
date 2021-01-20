<?php
require_once 'Conectar.php';

class VentaNota
{
private $id_venta;
private $id_nota;
private $c_conectar;

    /**
     * VentaNota constructor.
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
    public function getIdNota()
    {
        return $this->id_nota;
    }

    /**
     * @param mixed $id_nota
     */
    public function setIdNota($id_nota)
    {
        $this->id_nota = $id_nota;
    }

    public function obtenerDatos()
    {
        $sql = "select * from ventas_notas
        where id_nota = '$this->id_nota'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->id_venta = $resultado['id_venta'];
    }

    public function insertar()
    {
        $sql = "insert into ventas_notas 
            values ('$this->id_nota', 
                    '$this->id_venta')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from ventas_notas 
            where id_nota = '$this->id_nota'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verTodas()
    {
        $sql = "";
        return $this->c_conectar->get_Cursor($sql);
    }

}