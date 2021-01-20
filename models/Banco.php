<?php
require_once 'Conectar.php';

class Banco
{
    private $id_banco;
    private $nombre;
    private $cuenta;
    private $monto;
    private $id_empresa;
    private $c_conectar;

    /**
     * Banco constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    /**
     * @return mixed
     */
    public function getIdBanco()
    {
        return $this->id_banco;
    }

    /**
     * @param mixed $id_banco
     */
    public function setIdBanco($id_banco)
    {
        $this->id_banco = $id_banco;
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
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @param mixed $cuenta
     */
    public function setCuenta($cuenta)
    {
        $this->cuenta = $cuenta;
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


    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_banco) +1, 1) as codigo from bancos";
        $this->id_banco = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function obtenerDatos()
    {
        $sql = "select * from bancos
        where id_banco = '$this->id_banco'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->nombre = $resultado['nombre'];
        $this->cuenta = $resultado['cuenta'];
        $this->monto = $resultado['monto'];
        $this->id_empresa = $resultado['id_empresa'];
    }

    public function insertar()
    {
        $sql = "insert into bancos 
            values ('$this->id_banco', 
                    '$this->nombre', 
                    '$this->cuenta', 
                    '0', 
                    '$this->id_empresa')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function actualizar()
    {
        $sql = "insert into bancos 
           set nombre = '$this->nombre', 
           cuenta = '$this->cuenta', 
           id_empresas = '$this->id_empresa' 
           where id_banco = '$this->id_banco'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from bancos 
            where id_banco = '$this->id_banco'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verTodas()
    {
        $sql = "select b.monto, b.cuenta, b.id_banco, b.nombre, e.razon_social
        from bancos as b
                 inner join empresas e on b.id_empresas = e.id_empresas
        order by b.nombre asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verMisBancos()
    {
        $sql = "select b.monto, b.cuenta, b.id_banco, b.nombre, e.razon_social
        from bancos as b
                 inner join empresas e on b.id_empresas = e.id_empresas
                 where b.id_empresas = '$this->id_empresa'
        order by b.nombre asc";
        return $this->c_conectar->get_Cursor($sql);
    }
}