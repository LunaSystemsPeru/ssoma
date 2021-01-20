<?php
require_once 'Conectar.php';

class Inicio
{
    private $c_conectar;

    /**
     * Inicio constructor.
     */
    public function __construct()
    {
        $this->c_conectar = Conectar::getInstancia();
    }

    public function totalDeudas()
    {
        $sql = "select e.razon_social, sum(v.total - v.pagado) as deuda, count(v.serie) as nrodocumentos, max(DATEDIFF(current_date,v.fecha)) as nrodias
                from ventas as v
                inner join empresas e on v.id_empresas = e.id_empresas 
                where v.estado = 0
                group by v.id_empresas 
                order by e.razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function totalIGVPasado()
    {
        $sql = "select e.razon_social, sum(v.total) as total_venta,
                (select ifnull(sum(c.total),0)
                from compras as c
                where year(current_date) = year(c.fecha) and month(c.fecha) = (month(current_date) - 1) and c.id_empresas = e.id_empresas) as total_compra
                from ventas as v
                         inner join empresas e on v.id_empresas = e.id_empresas
                where year(current_date) = year(v.fecha) and month(v.fecha) = (month(current_date) - 1)
                group by v.id_empresas
                order by e.razon_social asc;";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function totalCobroCliente()
    {
        $sql = "select e.razon_social as empresa, c.razon_social as cliente, sum(v.total) as total, sum(v.total - v.pagado) as deuda, count(v.serie) as nrodocumentos, max(DATEDIFF(current_date,v.fecha)) as nrodias
                from ventas as v
                         inner join empresas e on v.id_empresas = e.id_empresas
                         inner join clientes c on v.id_clientes = c.id_clientes
                where v.estado = 0
                group by v.id_empresas, v.id_clientes
                order by e.razon_social, c.razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function porCobrarporDias()
    {
        $sql = "select e.razon_social as empresa, c.razon_social as cliente, DATEDIFF(current_date,v.fecha) as diferencia, sum(v.total) as total, sum(v.total - v.pagado) as deuda
                from ventas as v
                         inner join empresas e on v.id_empresas = e.id_empresas
                         inner join clientes c on v.id_clientes = c.id_clientes
                where v.estado = 0
                group by v.id_empresas, v.id_clientes, v.fecha
                order by e.razon_social, c.razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }

    public function trabajadoresPorEmpresa()
    {
        $sql = "select e.razon_social as empresa, ifnull(count(c.id_colaborador),0) as ctrabajadores
                from empresas as e
                left join colaboradores c on e.id_empresas = c.id_empresas
                group by e.id_empresas
                order by e.razon_social asc";
        return $this->c_conectar->get_Cursor($sql);
    }
}