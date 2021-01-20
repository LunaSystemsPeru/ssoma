<?php


require_once 'Conectar.php';


class Documentacion
{

    private $idDocumento;
    private $areaDocumento;
    private $tipoDocumento;
    private $nroDocumento;
    private $nombre;
    private $fechaCreacion;
    private $fechaModificacion;
    private $idUsuario;
    private $extension;
    private $version;
    private $estado;
    private $idEmpresa;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdDocumento()
    {
        return $this->idDocumento;
    }

    public function setIdDocumento($idDocumento)
    {
        $this->idDocumento = $idDocumento;
    }

    public function getAreaDocumento()
    {
        return $this->areaDocumento;
    }

    public function setAreaDocumento($areaDocumento)
    {
        $this->areaDocumento = $areaDocumento;
    }

    public function getTipoDocumento()
    {
        return $this->tipoDocumento;
    }

    public function setTipoDocumento($tipoDocumento)
    {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }


    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_documento) +1, 1) as codigo from documentacion";
        $this->idDocumento = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into documentacion values ('$this->idDocumento', '$this->areaDocumento', '$this->tipoDocumento', '$this->nroDocumento', '$this->nombre', '$this->fechaCreacion', '$this->fechaModificacion', '$this->idUsuario', '$this->extension', '$this->version', '$this->estado', '$this->idEmpresa')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from documentacion 
        where id_documento = '$this->idDocumento'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->areaDocumento = $resultado['area_documento'];
        $this->tipoDocumento = $resultado['tipo_documento'];
        $this->nroDocumento = $resultado['nro_documento'];
        $this->nombre = $resultado['nombre'];
        $this->fechaCreacion = $resultado['fecha_creacion'];
        $this->fechaModificacion = $resultado['fecha_modificacion'];
        $this->idUsuario = $resultado['id_usuario'];
        $this->extension = $resultado['extension'];
        $this->version = $resultado['version'];
        $this->estado = $resultado['estado'];
        $this->idEmpresa = $resultado['id_empresas'];
    }

    public function actualizar()
    {
        $sql = "UPDATE documentacion
                SET  id_empresas = '$this->idEmpresa' WHERE  id_documento = '$this->idDocumento' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM documentacion
                WHERE  id_documento = '$this->idDocumento'  ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas()
    {
        $sql = "select d.area_documento, d.tipo_documento, pda.valor as area, pdt.valor as tipo, d.nro_documento, d.id_documento, d.nombre, d.fecha_creacion, 
        d.fecha_modificacion, d.version, d.extension, d.estado
        from documentacion as d 
        inner join parametros_detalle as pda on pda.id_detalle = d.area_documento
        inner join parametros_detalle as pdt on pdt.id_detalle = d.tipo_documento
        where d.id_empresas = '$this->idEmpresa'";
        return $this->c_conectar->get_Cursor($sql);
    }

}
