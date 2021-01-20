<?php


require_once 'Conectar.php';


class DocumentacionVersion
{

    private $idVersion;
    private $descripcion;
    private $fechaModificacion;
    private $version;
    private $idUsuario;
    private $idDocumento;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdVersion()
    {
        return $this->idVersion;
    }

    public function setIdVersion($idVersion)
    {
        $this->idVersion = $idVersion;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdDocumento()
    {
        return $this->idDocumento;
    }

    public function setIdDocumento($idDocumento)
    {
        $this->idDocumento = $idDocumento;
    }


    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_version) +1, 1) as codigo from documentacion_version";
        $this->idVersion = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into documentacion_version values ('$this->idVersion', '$this->descripcion', '$this->fechaModificacion', '$this->version', '$this->idUsuario', '$this->idDocumento')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from documentacion_version 
        where id_version = '$this->idVersion'" ;
        $resultado = $this->c_conectar->get_Row($sql);
         $this->descripcion = $resultado['descripcion'];
        $this->fechaModificacion = $resultado['fecha_modificacion'];
        $this->version = $resultado['version'];
        $this->idUsuario = $resultado['id_usuario'];
        $this->idDocumento = $resultado['id_documento'];
    }

    public function actualizar()
    {
        $sql = "UPDATE documentacion_version
                SET  id_documento = '$this->idDocumento' WHERE  id_version = '$this->idVersion' " ;
         return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM documentacion_version
                WHERE  id_version = '$this->idVersion'  " ; 
        return $this->c_conectar->ejecutar_idu($sql);
    }

}
