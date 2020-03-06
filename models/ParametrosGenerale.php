<?php


require_once 'Conectar.php';


class ParametrosGenerale
{

    private $idParametro;
    private $nombre;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdParametro()
    {
        return $this->idParametro;
    }

    public function setIdParametro($idParametro)
    {
        $this->idParametro = $idParametro;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_parametro) +1, 1) as codigo from parametros_generales";
        $this->idParametro = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into parametros_generales values ('$this->idParametro', '$this->nombre')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from parametros_generales 
        where id_parametro = '$this->idParametro'" ;
        $resultado = $this->c_conectar->get_Row($sql);
         $this->nombre = $resultado['nombre'];
    }

    public function actualizar()
    {
        $sql = "UPDATE parametros_generales
                SET  nombre = '$this->nombre' WHERE  id_parametro = '$this->idParametro' " ;
         return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM parametros_generales
                WHERE  id_parametro = '$this->idParametro'  " ; 
        return $this->c_conectar->ejecutar_idu($sql);
    }

}
