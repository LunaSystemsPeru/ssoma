<?php


require_once 'Conectar.php';


class ColaboradoresAdjunto
{

    private $idColaborador;
    private $fechaFirma;
    private $idAdjunto;
    private $archivo;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
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
        $sql = "select ifnull(max(id_colaborador) +1, 1) as codigo from colaboradores_adjuntos";
        $this->idColaborador = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into colaboradores_adjuntos values ('$this->idColaborador', '$this->fechaFirma', '$this->idAdjunto', '$this->archivo')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from colaboradores_adjuntos 
        where id_colaborador = '$this->idColaborador'" ;
        $resultado = $this->c_conectar->get_Row($sql);
         $this->fechaFirma = $resultado['fecha_firma'];
        $this->idAdjunto = $resultado['id_adjunto'];
        $this->archivo = $resultado['archivo'];
    }

    public function actualizar()
    {
        $sql = "UPDATE colaboradores_adjuntos
                SET  archivo = '$this->archivo' WHERE  id_colaborador = '$this->idColaborador' " ;
         return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM colaboradores_adjuntos
                WHERE  id_colaborador = '$this->idColaborador'  " ; 
        return $this->c_conectar->ejecutar_idu($sql);
    }

}
