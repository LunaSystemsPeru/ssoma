<?php


require_once 'Conectar.php';


class ColaboradoresAdjunto
{

    private $id;
    private $idColaborador;
    private $fechaFirma;
    private $idAdjunto;
    private $archivo;

    private $c_conectar;


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

    public function getIdColaborador()
    {
        return $this->idColaborador;
    }

    public function setIdColaborador($idColaborador)
    {
        $this->idColaborador = $idColaborador;
    }

    public function getFechaFirma()
    {
        return $this->fechaFirma;
    }

    public function setFechaFirma($fechaFirma)
    {
        $this->fechaFirma = $fechaFirma;
    }

    public function getIdAdjunto()
    {
        return $this->idAdjunto;
    }

    public function setIdAdjunto($idAdjunto)
    {
        $this->idAdjunto = $idAdjunto;
    }

    public function getArchivo()
    {
        return $this->archivo;
    }

    public function setArchivo($archivo)
    {
        $this->archivo = $archivo;
    }


    public function generarCodigo()
    {
        $sql = "select ifnull(max(idcolaboradoradjunto) +1, 1) as codigo from colaboradores_adjuntos";
        $this->id = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into colaboradores_adjuntos values ('$this->id', '$this->idColaborador', '$this->fechaFirma', '$this->idAdjunto', '$this->archivo')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from colaboradores_adjuntos 
        where idcolaboradoradjunto = '$this->id'";
        $resultado = $this->c_conectar->get_Row($sql);
        if ($resultado) {
            $this->idColaborador = $resultado['id_colaborador'];
            $this->fechaFirma = $resultado['fecha_firma'];
            $this->idAdjunto = $resultado['id_adjunto'];
            $this->archivo = $resultado['archivo'];
        }
    }

    public function actualizar()
    {
        $sql = "UPDATE colaboradores_adjuntos
                SET  archivo = '$this->archivo' WHERE  idcolaboradoradjunto = '$this->id' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM colaboradores_adjuntos
                WHERE  idcolaboradoradjunto = '$this->id' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function ver_archivos()
    {
        $query = "select cd.nro_orden, cd.nombre, ca.fecha_firma, ca.archivo, ca.idcolaboradoradjunto as id 
        from colaboradores_adjuntos as ca 
        inner join colaborador_documentacion as cd on cd.id_adjunto = ca.id_adjunto 
        where id_colaborador = '$this->idColaborador'";
        return $this->c_conectar->get_Cursor($query);
    }
}
