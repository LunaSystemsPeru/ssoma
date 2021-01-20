<?php
require_once 'Conectar.php';

class Cliente
{
    private $id;
    private $ruc;
    private $razon;
    private $direccion;
    private $c_conectar;

    /**
     * Cliente constructor.
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
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * @param mixed $ruc
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    /**
     * @return mixed
     */
    public function getRazon()
    {
        return $this->razon;
    }

    /**
     * @param mixed $razon
     */
    public function setRazon($razon)
    {
        $this->razon = $razon;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_clientes) +1, 1) as codigo from clientes";
        $this->id = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into clientes values (
                                  '$this->id', 
                                  '$this->ruc', 
                                  '$this->razon', 
                                  '$this->direccion')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from clientes 
        where id_clientes = '$this->id'" ;
        $resultado = $this->c_conectar->get_Row($sql);
        $this->ruc = $resultado['ruc'];
        $this->razon = $resultado['razon_social'];
        $this->direccion = $resultado['direccion'];
    }

    public function actualizar()
    {
        $sql = "UPDATE clientes SET 
                ruc = '$this->ruc', 
                razon_social = '$this->razon', 
                direccion = '$this->direccion' 
                WHERE id_clientes = '$this->id' " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM clientes
                WHERE  id_clientes = '$this->id'  " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas () {
        $sql = "select * 
        from clientes order by razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }
}