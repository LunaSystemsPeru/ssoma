<?php
require_once 'Conectar.php';

class Compra
{
    private $id_compra;
    private $periodo;
    private $fecha;
    private $id_documento;
    private $serie;
    private $numero;
    private $id_proveedor;
    private $total;
    private $afecto;
    private $id_empresa;
    private $id_usuario;
    private $c_conectar;

    /**
     * Compra constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }


    /**
     * @return mixed
     */
    public function getIdCompra()
    {
        return $this->id_compra;
    }

    /**
     * @param mixed $id_compra
     */
    public function setIdCompra($id_compra)
    {
        $this->id_compra = $id_compra;
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
    public function getIdDocumento()
    {
        return $this->id_documento;
    }

    /**
     * @param mixed $id_documento
     */
    public function setIdDocumento($id_documento)
    {
        $this->id_documento = $id_documento;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
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
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getAfecto()
    {
        return $this->afecto;
    }

    /**
     * @param mixed $afecto
     */
    public function setAfecto($afecto)
    {
        $this->afecto = $afecto;
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

    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_compra) +1, 1) as codigo from compras";
        $this->id_compra = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    /**
     * @return mixed
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * @param mixed $periodo
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
    }

    public function obtenerDatos()
    {
        $sql = "select * from compras
        where id_compra = '$this->id_compra'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->fecha = $resultado['fecha'];
        $this->periodo = $resultado['periodo'];
        $this->id_proveedor = $resultado['id_proveedor'];
        $this->id_documento = $resultado['id_documento'];
        $this->numero = $resultado['numero'];
        $this->serie = $resultado['serie'];
        $this->total = $resultado['total'];
        $this->afecto = $resultado['afecto'];
        $this->id_empresa = $resultado['id_empresas'];
        $this->id_usuario = $resultado['id_usuario'];
    }

    public function insertar()
    {
        $sql = "insert into compras 
            values ('$this->id_compra',
                    '$this->periodo',  
                    '$this->fecha', 
                    '$this->id_documento', 
                    '$this->serie',
                    '$this->numero',
                    '$this->id_proveedor',
                    '$this->total',
                    '$this->afecto',
                    '$this->id_empresa',
                    '$this->id_usuario')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function modificar()
    {
        $sql = "update compras set 
                    fecha = '$this->fecha',
                    periodo = '$this->periodo',  
                    id_proveedor = '$this->id_proveedor', 
                    id_documento = '$this->id_documento', 
                    numero  = '$this->numero',
                    total = '$this->total',
                    afecto = '$this->afecto',
                    id_empresas = '$this->id_empresa'
                where id_compra = '$this->id_compra'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from compras 
            where id_compra = '$this->id_compra'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verTodas()
    {
        $sql = "select c.fecha, c.afecto, c.periodo, c.total, c.numero, c.serie, c.id_compra, e.razon_social as empresa, p.ruc, p.razon_social, u.username, c.id_documento, pd.nombre as documento
        from compras as c
        inner join empresas e on c.id_empresas = e.id_empresas
        inner join proveedores p on c.id_proveedor = p.id_proveedor
        inner join usuarios u on c.id_usuario = u.id_usuario
        inner join parametros_detalle as pd on pd.id_detalle = c.id_documento and pd.id_parametro = 12";
        return $this->c_conectar->get_Cursor($sql);
    }

}