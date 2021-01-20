<?php

require_once 'Conectar.php';

class Empresa
{

    private $id_empresa;
    private $ruc;
    private $razon;
    private $direccion;
    private $logo;
    private $fregistro;
    private $usuariosunat;
    private $clavesunat;
    private $c_conectar;

    /**
     * Empresa constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
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
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * @param mixed $ruc
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    /**
     * @return mixed
     */
    public function getRazon()
    {
        return $this->razon;
    }

    /**
     * @param mixed $razon
     */
    public function setRazon($razon)
    {
        $this->razon = $razon;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getFregistro()
    {
        return $this->fregistro;
    }

    /**
     * @param mixed $fregistro
     */
    public function setFregistro($fregistro)
    {
        $this->fregistro = $fregistro;
    }

    /**
     * @return mixed
     */
    public function getUsuariosunat()
    {
        return $this->usuariosunat;
    }

    /**
     * @param mixed $usuariosunat
     */
    public function setUsuariosunat($usuariosunat)
    {
        $this->usuariosunat = $usuariosunat;
    }

    /**
     * @return mixed
     */
    public function getClavesunat()
    {
        return $this->clavesunat;
    }

    /**
     * @param mixed $clavesunat
     */
    public function setClavesunat($clavesunat)
    {
        $this->clavesunat = $clavesunat;
    }

    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_empresas) +1, 1) as codigo from empresas";
        $this->id_empresa = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function obtenerDatos()
    {
        $sql = "select * from empresas
        where id_empresas = '$this->id_empresa'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->ruc = $resultado['ruc'];
        $this->razon = $resultado['razon_social'];
        $this->direccion = $resultado['direccion'];
        $this->logo = $resultado['logo'];
        $this->fregistro = $resultado['fecha_registro'];
        $this->usuariosunat = $resultado['usunat'];
        $this->clavesunat = $resultado['csunat'];
    }

    public function insertar()
    {
        $sql = "insert into empresas 
            values ('$this->id_empresa', 
                    '$this->ruc', 
                    '$this->razon', 
                    '$this->direccion', 
                    '$this->logo', 
                    now(),
                    '$this->usuariosunat',
                    '$this->clavesunat')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function validarRuc()
    {
        $sql = "select id_empresas from empresas
        where ruc = '$this->ruc'";
        $resultado = $this->c_conectar->get_Row($sql);
        if ($resultado) {
            $this->id_empresa = $resultado['id_empresas'];
            return true;
        } else {
            return false;
        }
    }

    public function verTodas()
    {
        $sql = "select * from empresas order by razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }
}