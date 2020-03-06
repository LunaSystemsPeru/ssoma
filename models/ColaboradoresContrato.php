<?php


require_once 'Conectar.php';


class ColaboradoresContrato
{

    private $idContrato;
    private $fechaInicio;
    private $fechaFin;
    private $tipoContrato;
    private $idColaborador;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdContrato()
    {
        return $this->idContrato;
    }

    public function setIdContrato($idContrato)
    {
        $this->idContrato = $idContrato;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    public function getTipoContrato()
    {
        return $this->tipoContrato;
    }

    public function setTipoContrato($tipoContrato)
    {
        $this->tipoContrato = $tipoContrato;
    }

    public function getIdColaborador()
    {
        return $this->idColaborador;
    }

    public function setIdColaborador($idColaborador)
    {
        $this->idColaborador = $idColaborador;
    }


    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_contrato) +1, 1) as codigo from colaboradores_contratos";
        $this->idContrato = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into colaboradores_contratos values ('$this->idContrato', '$this->fechaInicio', '$this->fechaFin', '$this->tipoContrato', '$this->idColaborador')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from colaboradores_contratos 
        where id_contrato = '$this->idContrato'" ;
        $resultado = $this->c_conectar->get_Row($sql);
         $this->fechaInicio = $resultado['fecha_inicio'];
        $this->fechaFin = $resultado['fecha_fin'];
        $this->tipoContrato = $resultado['tipo_contrato'];
        $this->idColaborador = $resultado['id_colaborador'];
    }

    public function actualizar()
    {
        $sql = "UPDATE colaboradores_contratos
                SET  id_colaborador = '$this->idColaborador' WHERE  id_contrato = '$this->idContrato' " ;
         return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM colaboradores_contratos
                WHERE  id_contrato = '$this->idContrato'  " ; 
        return $this->c_conectar->ejecutar_idu($sql);
    }

}
