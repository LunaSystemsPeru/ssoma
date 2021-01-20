<?php

require_once 'Conectar.php';

class Venta
{
    private $id_venta;
    private $fecha;
    private $id_cliente;
    private $id_documento;
    private $numero;
    private $serie;
    private $total;
    private $pagado;
    private $afecto;
    private $adjunto;
    private $estado;
    private $id_empresa;
    private $id_usuario;
    private $descripcion;
    private $anexo;
    private $detraccion;
    private $c_conectar;

    /**
     * Venta constructor.
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
    public function getPagado()
    {
        return $this->pagado;
    }

    /**
     * @param mixed $pagado
     */
    public function setPagado($pagado)
    {
        $this->pagado = $pagado;
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
    public function getAdjunto()
    {
        return $this->adjunto;
    }

    /**
     * @param mixed $adjunto
     */
    public function setAdjunto($adjunto)
    {
        $this->adjunto = $adjunto;
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

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * @param mixed $anexo
     */
    public function setAnexo($anexo)
    {
        $this->anexo = $anexo;
    }

    /**
     * @return mixed
     */
    public function getDetraccion()
    {
        return $this->detraccion;
    }

    /**
     * @param mixed $detraccion
     */
    public function setDetraccion($detraccion)
    {
        $this->detraccion = $detraccion;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_venta) +1, 1) as codigo from ventas";
        $this->id_venta = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function obtenerDatos()
    {
        $sql = "select * from ventas
        where id_venta = '$this->id_venta'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->fecha = $resultado['fecha'];
        $this->id_cliente = $resultado['id_clientes'];
        $this->id_documento = $resultado['id_documento'];
        $this->numero = $resultado['numero'];
        $this->serie = $resultado['serie'];
        $this->total = $resultado['total'];
        $this->pagado = $resultado['pagado'];
        $this->afecto = $resultado['afecto'];
        $this->adjunto = $resultado['adjunto'];
        $this->estado = $resultado['estado'];
        $this->id_empresa = $resultado['id_empresas'];
        $this->id_usuario = $resultado['id_usuario'];
        $this->anexo = $resultado['anexo'];
        $this->descripcion = $resultado['descripcion'];
        $this->detraccion = $resultado['detraccion'];
    }

    public function insertar()
    {
        $sql = "insert into ventas 
            values ('$this->id_venta', 
                    '$this->fecha', 
                    '$this->id_cliente',
                    '$this->id_documento',
                    '$this->numero',
                    '$this->serie',
                    '$this->total',
                    '0',
                    '$this->afecto',
                    '$this->adjunto',
                    '0',
                    '$this->id_empresa',
                    '$this->id_usuario',
                    '$this->descripcion',
                    '$this->anexo',
                    '$this->detraccion')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function modificar()
    {
        $sql = "update ventas set 
                    fecha = '$this->fecha', 
                    id_clientes = '$this->id_cliente', 
                    id_documento = '$this->id_documento', 
                    numero  = '$this->numero',
                    total = '$this->total',
                    afecto = '$this->afecto',
                    id_empresas = '$this->id_empresa',
                    descripcion = '$this->descripcion',
                    anexo = '$this->anexo',
                    detraccion = '$this->detraccion'
                where id_venta = '$this->id_venta'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from ventas 
            where id_venta = '$this->id_venta'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function cerrarPago()
    {
        $sql = "update ventas 
            set estado = 1, pagado = total  
            where id_venta = '$this->id_venta'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verTodas()
    {
        $sql = "select v.id_venta, e.razon_social as empresa, v.fecha, v.id_documento, v.serie, v.numero, c.razon_social as cliente, v.descripcion, v.adjunto, v.total, v.pagado, v.afecto, v.estado, v.detraccion, v.anexo 
        from ventas as v
        inner join empresas e on v.id_empresas = e.id_empresas
        inner join clientes c on v.id_clientes = c.id_clientes 
        where v.estado = 0 ";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verMisClientes()
    {
        $sql = "select c.id_clientes, c.razon_social  
                from ventas as v 
                inner join clientes c on v.id_clientes = c.id_clientes
                where id_empresas = '$this->id_empresa' 
                group by v.id_clientes ";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verMisPendientes()
    {
        $sql = "select v.serie, v.numero, v.id_venta, v.fecha, v.total, v.pagado
                from ventas as v 
                where id_empresas = '$this->id_empresa' and v.id_clientes = '$this->id_cliente' and v.total != v.pagado and v.estado != 2
                order by v.numero asc ";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verAnioEmpresa () {
        $sql = "select distinct(year(v.fecha)) as anio from ventas as v where v.id_empresas = '$this->id_empresa'";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verPeriodosEmpresa () {
        $sql = "select distinct(DATE_FORMAT(v.fecha, '%Y%m')) as periodo from ventas as v ";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verPorEmpresa($periodo)
    {
        $sql = "select v.id_venta, e.razon_social as empresa, v.fecha, v.id_documento, v.serie, v.numero, c.ruc as ruc_cliente, c.razon_social as cliente, v.descripcion, v.adjunto, v.total, v.pagado, v.afecto, v.estado, v.detraccion, v.anexo 
        from ventas as v
        inner join empresas e on v.id_empresas = e.id_empresas
        inner join clientes c on v.id_clientes = c.id_clientes 
        where v.id_empresas = '$this->id_empresa'  and DATE_FORMAT(v.fecha, '%Y%m') = '$periodo' 
        order by v.numero asc , v.id_documento asc";
        return $this->c_conectar->get_Cursor($sql);

    }

}