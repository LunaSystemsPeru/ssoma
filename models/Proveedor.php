<?php

require_once 'Conectar.php';

class Proveedor
{
private $id_proveedor;
private $ruc;
private $razon;
private $direccion;
private $c_conectar;

    /**
     * Proveedor constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdProveedor()
    {
        return $this->id_proveedor;
    }

    /**
     * @param mixed $id_proveedor
     */
    public function setIdProveedor($id_proveedor)
    {
        $this->id_proveedor = $id_proveedor;
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
        $sql = "select ifnull(max(id_proveedor) +1, 1) as codigo from proveedores";
        $this->id_proveedor = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into proveedores values (
                                  '$this->id_proveedor', 
                                  '$this->ruc', 
                                  '$this->razon', 
                                  '$this->direccion')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from proveedores 
        where id_proveedor = '$this->id_proveedor'" ;
        $resultado = $this->c_conectar->get_Row($sql);
        $this->ruc = $resultado['ruc'];
        $this->razon = $resultado['razon_social'];
        $this->direccion = $resultado['direccion'];
    }

    public function actualizar()
    {
        $sql = "UPDATE proveedores SET 
                ruc = '$this->ruc', 
                razon_social = '$this->razon', 
                direccion = '$this->direccion' 
                WHERE id_proveedor = '$this->id_proveedor' " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM proveedores
                WHERE  id_proveedor = '$this->id_proveedor'  " ;
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas () {
        $sql = "select * 
        from proveedores order by razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verJson () {
        $sql = "select * 
        from proveedores order by razon_social asc";
        return $this->c_conectar->get_json_rows($sql);
    }

    public function validarRuc()
    {
        $sql = "select id_proveedor from proveedores
        where ruc = '$this->ruc'";
        $resultado = $this->c_conectar->get_Row($sql);
        if ($resultado) {
            $this->id_proveedor = $resultado['id_proveedor'];
            return true;
        } else {
            return false;
        }
    }
}