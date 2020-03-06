<?php


require_once 'Conectar.php';


class ColaboradorDocumentacion
{

    private $idAdjunto;
    private $nroOrden;
    private $nombre;
    private $idDocumento;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdAdjunto()
    {
        return $this->idAdjunto;
    }

    public function setIdAdjunto($idAdjunto)
    {
        $this->idAdjunto = $idAdjunto;
    }

    public function getNroOrden()
    {
        return $this->nroOrden;
    }

    public function setNroOrden($nroOrden)
    {
        $this->nroOrden = $nroOrden;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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
        $sql = "select ifnull(max(id_adjunto) +1, 1) as codigo from colaborador_documentacion";
        $this->idAdjunto = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into colaborador_documentacion values ('$this->idAdjunto', '$this->nroOrden', '$this->nombre', '$this->idDocumento')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from colaborador_documentacion 
        where id_adjunto = '$this->idAdjunto'" ;
        $resultado = $this->c_conectar->get_Row($sql);
         $this->nroOrden = $resultado['nro_orden'];
        $this->nombre = $resultado['nombre'];
        $this->idDocumento = $resultado['id_documento'];
    }

    public function actualizar()
    {
        $sql = "UPDATE colaborador_documentacion
                SET  id_documento = '$this->idDocumento' WHERE  id_adjunto = '$this->idAdjunto' " ;
         return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM colaborador_documentacion
                WHERE  id_adjunto = '$this->idAdjunto'  " ; 
        return $this->c_conectar->ejecutar_idu($sql);
    }

}
