<?php


require_once 'Conectar.php';


class Ubigeo
{

    private $idUbigeo;
    private $departamento;
    private $provincia;
    private $distrito;
    private $nombre;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdUbigeo()
    {
        return $this->idUbigeo;
    }

    public function setIdUbigeo($idUbigeo)
    {
        $this->idUbigeo = $idUbigeo;
    }

    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    public function getDistrito()
    {
        return $this->distrito;
    }

    public function setDistrito($distrito)
    {
        $this->distrito = $distrito;
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
        $sql = "select ifnull(max(id_ubigeo) +1, 1) as codigo from ubigeos";
        $this->idUbigeo = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into ubigeos values ('$this->idUbigeo', '$this->departamento', '$this->provincia', '$this->distrito', '$this->nombre')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from ubigeos 
        where id_ubigeo = '$this->idUbigeo'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->departamento = $resultado['departamento'];
        $this->provincia = $resultado['provincia'];
        $this->distrito = $resultado['distrito'];
        $this->nombre = $resultado['nombre'];
    }

    public function actualizar()
    {
        $sql = "UPDATE ubigeos
                SET  nombre = '$this->nombre' WHERE  id_ubigeo = '$this->idUbigeo' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM ubigeos
                WHERE  id_ubigeo = '$this->idUbigeo'  ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function verDepartamentos()
    {
        $sql = "select departamento, nombre 
        from ubigeos 
        where provincia = 00 and distrito = 00 
        order by nombre asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verProvincias()
    {
        $sql = "select provincia, nombre 
        from ubigeos 
        where departamento = '$this->departamento' and distrito = 00 
        order by nombre asc";
        //echo $sql;
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verDistritos()
    {
        $sql = "select distrito, id_ubigeo, nombre 
        from ubigeos 
        where departamento = '$this->departamento' and provincia = '$this->provincia' 
        order by nombre asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function verFilas()
    {
        $sql = "select * 
        from ubigeos 
        order by departamento asc, provincia asc, distrito asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function obtenerNombre($coddepartamento = '00', $codprovincia = '00', $coddistrito = '00')
    {
        $sql = "select nombre 
        from ubigeos 
        where departamento = '$coddepartamento' and provincia = '$codprovincia' and distrito = '$coddistrito'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->nombre = $resultado['nombre'];
    }

}
