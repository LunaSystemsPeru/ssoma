<?php


require_once 'Conectar.php';


class Usuario
{

    private $idUsuario;
    private $idEmpresa;
    private $username;
    private $password;
    private $dato;
    private $celular;
    private $email;
    private $fechaRegistro;
    private $ultimoLogin;
    private $estado;

    private $c_conectar;


    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getDato()
    {
        return $this->dato;
    }

    public function setDato($dato)
    {
        $this->dato = $dato;
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getUltimoLogin()
    {
        return $this->ultimoLogin;
    }

    public function setUltimoLogin($ultimoLogin)
    {
        $this->ultimoLogin = $ultimoLogin;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }


    public function generarCodigo()
    {
        $sql = "select ifnull(max(id_usuario) +1, 1) as codigo from usuarios";
        $this->idUsuario = $this->c_conectar->get_valor_query($sql, "codigo");
    }

    public function insertar()
    {
        $sql = "insert into usuarios 
        values ('$this->idUsuario', 
                '$this->idEmpresa', 
                '$this->username', 
                '$this->password', 
                '$this->dato', 
                '$this->celular', 
                '$this->email', 
                now(), 
                now(), 
                '1')";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function obtenerDatos()
    {
        $sql = "select * from usuarios 
        where id_usuario = '$this->idUsuario'";
        $resultado = $this->c_conectar->get_Row($sql);
        $this->idEmpresa = $resultado['id_empresas'];
        $this->username = $resultado['username'];
        $this->password = $resultado['password'];
        $this->dato = $resultado['datos'];
        $this->celular = $resultado['celular'];
        $this->email = $resultado['email'];
        $this->fechaRegistro = $resultado['fecha_registro'];
        $this->ultimoLogin = $resultado['ultimo_login'];
        $this->estado = $resultado['estado'];
    }

    public function actualizar()
    {
        $sql = "UPDATE usuarios
                SET  estado = '$this->estado' WHERE  id_usuario = '$this->idUsuario' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM usuarios
                WHERE  id_usuario = '$this->idUsuario'  ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function actualizarLogin()
    {
        $sql = "UPDATE usuarios
                SET  ultimo_login = now() WHERE  id_usuario = '$this->idUsuario' ";
        return $this->c_conectar->ejecutar_idu($sql);
    }

    public function validarUsuario()
    {
        $sql = "select id_usuario, password from usuarios 
        where id_empresas = '$this->idEmpresa' and username = '$this->username'";
        $resultado = $this->c_conectar->get_Row($sql);
       if ($resultado) {
           $this->idUsuario = $resultado['id_usuario'];
           $this->password = $resultado['password'];
           return true;
       } else {
           return false;
       }
    }

}
