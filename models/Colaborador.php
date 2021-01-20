<?php


require_once 'Conectar.php';


class Colaborador
{

    private $idColaborador;
    private $documento;
    private $dato;
    private $domicilio;
    private $idUbigeo;
    private $fechaNacimiento;
    private $telefono;
    private $idCargo;
    private $foto;
    private $estado;
    private $ultimoIngreso;
    private $idEmpresa;
    private $nacionalidad;
    private $tipo_documento;
    private $profesion;
    private $idGrupoSanguineo;
    private $idFactorSanguineo;
    private $idEstadoCivil;
    private $fichaPersonalScan;

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

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }

    public function getDato()
    {
        return $this->dato;
    }

    public function setDato($dato)
    {
        $this->dato = $dato;
    }

    public function getDomicilio()
    {
        return $this->domicilio;
    }

    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;
    }

    public function getIdUbigeo()
    {
        return $this->idUbigeo;
    }

    public function setIdUbigeo($idUbigeo)
    {
        $this->idUbigeo = $idUbigeo;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getIdCargo()
    {
        return $this->idCargo;
    }

    public function setIdCargo($idCargo)
    {
        $this->idCargo = $idCargo;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getUltimoIngreso()
    {
        return $this->ultimoIngreso;
    }

    public function setUltimoIngreso($ultimoIngreso)
    {
        $this->ultimoIngreso = $ultimoIngreso;
    }

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function getNacionalidad()
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad($nacionalidad)
    {
        $this->nacionalidad = $nacionalidad;
    }

    public function getProfesion()
    {
        return $this->profesion;
    }

    public function setProfesion($profesion)
    {
        $this->profesion = $profesion;
    }

    public function getIdGrupoSanguineo()
    {
        return $this->idGrupoSanguineo;
    }

    public function setIdGrupoSanguineo($idGrupoSanguineo)
    {
        $this->idGrupoSanguineo = $idGrupoSanguineo;
    }

    public function getIdFactorSanguineo()
    {
        return $this->idFactorSanguineo;
    }

    public function setIdFactorSanguineo($idFactorSanguineo)
    {
        $this->idFactorSanguineo = $idFactorSanguineo;
    }

    public function getIdEstadoCivil()
    {
        return $this->idEstadoCivil;
    }

    public function setIdEstadoCivil($idEstadoCivil)
    {
        $this->idEstadoCivil = $idEstadoCivil;
    }

    public function getFichaPersonalScan()
    {
        return $this->fichaPersonalScan;
    }

    public function setFichaPersonalScan($fichaPersonalScan)
    {
        $this->fichaPersonalScan = $fichaPersonalScan;
    }

    /**
     * @return mixed
     */
    public function getTipoDocumento()
    {
        return $this->tipo_documento;
    }

    /**
     * @param mixed $tipo_documento
     */
    public function setTipoDocumento($tipo_documento)
    {
        $this->tipo_documento = $tipo_documento;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_colaborador) +1, 1) as codigo from colaboradores";
        $this->idColaborador = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into colaboradores values (
                                  '$this->idColaborador', 
                                  '$this->documento', 
                                  '$this->dato', 
                                  '$this->domicilio', 
                                  '$this->idUbigeo', 
                                  '$this->fechaNacimiento', 
                                  '$this->telefono', 
                                  '$this->idCargo', 
                                  '$this->foto', 
                                  '$this->estado', 
                                  '$this->ultimoIngreso', 
                                  '$this->idEmpresa', 
                                  '$this->nacionalidad',
                                  '$this->tipo_documento', 
                                  '$this->profesion', 
                                  '$this->idGrupoSanguineo', 
                                  '$this->idFactorSanguineo', 
                                  '$this->idEstadoCivil', 
                                  '$this->fichaPersonalScan')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from colaboradores 
        where id_colaborador = '$this->idColaborador'" ;
        $resultado = $this->c_conectar->get_Row($sql);
         $this->documento = $resultado['documento'];
        $this->dato = $resultado['datos'];
        $this->domicilio = $resultado['domicilio'];
        $this->idUbigeo = $resultado['id_ubigeo'];
        $this->fechaNacimiento = $resultado['fecha_nacimiento'];
        $this->telefono = $resultado['telefono'];
        $this->idCargo = $resultado['id_cargo'];
        $this->foto = $resultado['foto'];
        $this->estado = $resultado['estado'];
        $this->ultimoIngreso = $resultado['ultimo_ingreso'];
        $this->idEmpresa = $resultado['id_empresas'];
        $this->nacionalidad = $resultado['nacionalidad'];
        $this->tipo_documento = $resultado['tipo_documento'];
        $this->profesion = $resultado['profesion'];
        $this->idGrupoSanguineo = $resultado['id_grupo_sanguineo'];
        $this->idFactorSanguineo = $resultado['id_factor_sanguineo'];
        $this->idEstadoCivil = $resultado['id_estado_civil'];
        $this->fichaPersonalScan = $resultado['ficha_personal_scan'];
    }

    public function validarCarnet()
    {
        $sql = "select * from colaboradores 
        where documento = '$this->documento' and id_empresas = '$this->idEmpresa' and nacionalidad = '$this->nacionalidad'" ;
        $resultado = $this->c_conectar->get_Row($sql);
        if ($resultado) {
            $this->idColaborador = $resultado['id_colaborador'];
            return true;
        } else {
            return false;
        }
    }

    public function actualizar()
    {
        $sql = "UPDATE colaboradores
                SET  ficha_personal_scan = '$this->fichaPersonalScan', 
                documento = '$this->documento',
                datos = '$this->dato',
                domicilio = '$this->domicilio',
                id_ubigeo = '$this->idUbigeo',
                fecha_nacimiento = '$this->fechaNacimiento',
                telefono = '$this->telefono',
                id_cargo = '$this->idCargo',
                nacionalidad = '$this->nacionalidad',
                tipo_documento = '$this->tipo_documento',
                profesion = '$this->profesion',
                id_grupo_sanguineo = '$this->idGrupoSanguineo',
                id_factor_sanguineo = '$this->idFactorSanguineo',
                id_estado_civil = '$this->idEstadoCivil', 
                foto = '$this->foto'
                WHERE  id_colaborador = '$this->idColaborador' " ;
        //echo $sql;
         return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM colaboradores
                WHERE  id_colaborador = '$this->idColaborador'  " ; 
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verFilas () {
        $sql = "select * from colaboradores where id_empresas = '$this->idEmpresa'";
        return $this->c_conectar->get_Cursor($sql);
    }
    public function verFilasFotos () {
        $sql = "select * from colaboradores where id_empresas = '$this->idEmpresa' order by datos asc ";
        return $this->c_conectar->get_Cursor($sql);
    }

}
