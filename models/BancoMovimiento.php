<?php
require_once 'Conectar.php';

class BancoMovimiento
{
    private $id_banco;
    private $id_movimiento;
    private $fecha;
    private $id_clasificacion;
    private $descripcion;
    private $ingresa;
    private $egresa;
    private $id_usuario;
    private $c_conectar;

    /**
     * BancoMovimiento constructor.
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
    public function getIdClasificacion()
    {
        return $this->id_clasificacion;
    }

    /**
     * @param mixed $id_clasificacion
     */
    public function setIdClasificacion($id_clasificacion)
    {
        $this->id_clasificacion = $id_clasificacion;
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
    public function getIngresa()
    {
        return $this->ingresa;
    }

    /**
     * @param mixed $ingresa
     */
    public function setIngresa($ingresa)
    {
        $this->ingresa = $ingresa;
    }

    /**
     * @return mixed
     */
    public function getEgresa()
    {
        return $this->egresa;
    }

    /**
     * @param mixed $egresa
     */
    public function setEgresa($egresa)
    {
        $this->egresa = $egresa;
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
        $sql = "select ifnull(max(id_movimiento) +1, 1) as codigo from bancos_movimientos";
        $this->id_movimiento = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function obtenerDatos()
    {
        $sql = "select * from bancos_movimientos
        where id_movimiento = '$this->id_movimiento'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->fecha = $resultado['fecha'];
        $this->id_clasificacion = $resultado['id_clientes'];
        $this->descripcion = $resultado['id_documento'];
        $this->ingresa = $resultado['numero'];
        $this->egresa = $resultado['serie'];
        $this->id_banco = $resultado['total'];
        $this->id_usuario = $resultado['pagado'];
    }

    public function insertar()
    {
        $sql = "insert into bancos_movimientos 
            values ('$this->id_movimiento', 
                    '$this->fecha', 
                    '$this->id_clasificacion', 
                    '$this->descripcion', 
                    '$this->ingresa',
                    '$this->egresa',
                    '$this->id_banco',
                    '$this->id_usuario')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "delete from bancos_movimientos 
            where id_movimiento = '$this->id_movimiento'";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verTodas()
    {
        $sql = "select bm.descripcion, bm.fecha, bm.ingresa, bm.sale, u.username
        from bancos_movimientos as bm
        inner join usuarios u on bm.id_usuario = u.id_usuario
        inner join parametros_detalle as pd on pd.id_detalle = bm.id_clasificacion and pd.id_parametro=11
        where bm.id_banco = '$this->id_banco'";
        return $this->c_conectar->get_Cursor($sql);
    }

}