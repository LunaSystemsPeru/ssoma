<?php
$nombre_archivo = basename($_SERVER['PHP_SELF']);

//echo $nombre_archivo;
?>

<nav id="mainnav-container">
    <div id="mainnav">

        <!--Shortcut buttons-->
        <!--================================-->
        <div id="mainnav-shortcut">
            <ul class="list-unstyled">
                <li class="col-xs-4" data-content="Additional Sidebar">
                    <a id="demo-toggle-aside" class="shortcut-grid" href="#">
                        <i class="fa fa-magic"></i>
                    </a>
                </li>
                <li class="col-xs-4" data-content="Notification">
                    <a id="demo-alert" class="shortcut-grid" href="#">
                        <i class="fa fa-bullhorn"></i>
                    </a>
                </li>
                <li class="col-xs-4" data-content="Page Alerts">
                    <a id="demo-page-alert" class="shortcut-grid" href="#">
                        <i class="fa fa-bell"></i>
                    </a>
                </li>
            </ul>
        </div>
        <!--================================-->
        <!--End shortcut buttons-->


        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">

                        <!--Menu list item-->
                        <li class="<?php if ($nombre_archivo == "index.php") {
                            echo 'active-link';
                        } ?>">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
									<strong>Dashboard</strong>
                                    <!--<span class="label label-success pull-right">Top</span>-->
								</span>
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Eventos</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="<?php if ($nombre_archivo == "calendario.php") {
                                    echo 'active-link';
                                } ?>">
                                    <a href="calendario.php">
                                        <i class="fa fa-calendar"></i>
                                        <span class="menu-title">
									<strong>Ver Calendario</strong>
                                            <!--<span class="label label-success pull-right">Top</span>-->
								</span>
                                    </a>
                                </li>
                                <li class="<?php if ($nombre_archivo == "eventos.php") {
                                    echo 'active-link';
                                } ?>">
                                    <a href="eventos.php">
                                        <i class="fa fa-calendar"></i>
                                        <span class="menu-title">
									<strong>Ver Lista</strong>
                                            <!--<span class="label label-success pull-right">Top</span>-->
								</span>
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <!--Category name-->
                        <!--<li class="list-header">Unidades</li>-->

                        <!--Menu list item-->
                        <li class="<?php if ($nombre_archivo == "empleados.php") {
                            echo 'active-link';
                        } ?>">
                            <a href="empleados.php">
                                <i class="fa fa-check"></i>
                                <span class="menu-title">
									<strong>Colaboradores</strong>
                                    <!--<span class="label label-success pull-right">Top</span>-->
								</span>
                            </a>
                        </li>

                        <!--<li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Inspecciones</span>
                                <i class="arrow"></i>
                            </a>

                           Submenu-->
                        <!--
							<ul class="collapse">
								<li class="<?php if ($nombre_archivo == "inspeccion_extintor.php") {
                            echo 'active-link';
                        } ?>"><a href="epp.php">Insp. Extintores</a></li>
								<li class="<?php if ($nombre_archivo == "inspeccion_botiquin.php") {
                            echo 'active-link';
                        } ?>"><a href="epp.php">Insp. Botiquin</a></li>
								<li class="<?php if ($nombre_archivo == "inspeccion_epp.php") {
                            echo 'active-link';
                        } ?>"><a href="epp.php">Insp. EPP</a></li>
								<li class="<?php if ($nombre_archivo == "inspeccion_orden.php") {
                            echo 'active-link';
                        } ?>"><a href="epp.php">Insp. Orden y Limpieza</a></li>
								
							</ul>
						</li>-->

                        <li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Servicios - Ventas</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="<?php if ($nombre_archivo == "clientes.php") {
                                    echo 'active-link';
                                } ?>"><a href="clientes.php">Clientes</a></li>
                                <li class="<?php if ($nombre_archivo == "ventas.php") {
                                    echo 'active-link';
                                } ?>"><a href="ventas.php">Ventas</a></li>
                                <li class="<?php if ($nombre_archivo == "ordenes_internas.php") {
                                    echo 'active-link';
                                } ?>"><a href="ordenes_internas.php">Ordenes de Servicio Internas</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Compras - Pagos</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="<?php if ($nombre_archivo == "proveedores.php") {
                                    echo 'active-link';
                                } ?>"><a href="proveedores.php">Proveedores</a></li>
                                <li class="<?php if ($nombre_archivo == "compras.php") {
                                    echo 'active-link';
                                } ?>"><a href="compras.php">Compras</a></li>
                                <li class="<?php if ($nombre_archivo == "recordatorios_pagos.php") {
                                    echo 'active-link';
                                } ?>"><a href="recordatorios_pagos.php">Recordatorio Pagos</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Programas</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="<?php if ($nombre_archivo == "programa_inspecciones.php") {
                                    echo 'active-link';
                                } ?>"><a href="programa_inspecciones.php">Prog. Inspecciones</a></li>
                                <li class="<?php if ($nombre_archivo == "programa_capacitaciones.php") {
                                    echo 'active-link';
                                } ?>"><a href="programa_capacitaciones.php">Prog. Capacitaciones</a></li>
                                <li class="<?php if ($nombre_archivo == "programa_simulacros.php") {
                                    echo 'active-link';
                                } ?>"><a href="programa_simulacros.php">Prog. Simulacros</a></li>
                                <li class="<?php if ($nombre_archivo == "programa_monitoreo.php") {
                                    echo 'active-link';
                                } ?>"><a href="programa_monitoreo.php">Prog. Monitoreo</a></li>
                                <li class="<?php if ($nombre_archivo == "programa_auditoria.php") {
                                    echo 'active-link';
                                } ?>"><a href="programa_auditoria.php">Prog. Auditoria</a></li>

                            </ul>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Insumos de Seguridad</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="<?php if ($nombre_archivo == "epp.php") {
                                    echo 'active-link';
                                } ?>"><a href="epp.php">EPP</a></li>
                                <li class="<?php if ($nombre_archivo == "extintor.php") {
                                    echo 'active-link';
                                } ?>"><a href="extintor.php">Extintores</a></li>

                            </ul>
                        </li>

                        <li class="<?php if ($nombre_archivo == "documentos.php") {
                            echo 'active-link';
                        } ?>">
                            <a href="documentos.php">
                                <i class="fa fa-file-pdf-o"></i>
                                <span class="menu-title">
									<strong>Gestion Documentaria</strong>
                                    <!--<span class="label label-success pull-right">Top</span>-->
								</span>
                            </a>
                        </li>

                        <!--Menu list item-->
                        <li>
                            <a href="#">
                                <i class="fa fa-plus-square"></i>
                                <span class="menu-title">Seguridad</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class><a href="reportes/charla_seguridad.php">Charlas de Seguridad</a></li>
                                <li class="<?php if ($nombre_archivo == "preliminar_incidentes.php") {
                                    echo 'active-link';
                                } ?>"><a href="preliminar_incidentes.php">Preliminar Incidentes</a></li>
                                <li class="<?php if ($nombre_archivo == "incidentes.php") {
                                    echo 'active-link';
                                } ?>"><a href="incidentes.php">Reporte de Incidentes</a></li>
                                <li class="<?php if ($nombre_archivo == "acciones_correctivas.php") {
                                    echo 'active-link';
                                } ?>"><a href="acciones_correctivas.php">Acciones Correctivas</a></li>
                            </ul>
                        </li>

                        <!--Menu list item-->
                        <li>
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span class="menu-title">Configuracion</span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="<?php if ($nombre_archivo == "bancos.php") {
                                    echo 'active-link';
                                } ?>"><a href="bancos.php">Mis Bancos</a></li>
                                <li class="<?php if ($nombre_archivo == "parametros_generales.php") {
                                    echo 'active-link';
                                } ?>"><a href="parametros_generales.php">Parametros Generales</a></li>
                                <li class="<?php if ($nombre_archivo == "documentos_colaboradores.php") {
                                    echo 'active-link';
                                } ?>"><a href="documentos_colaboradores.php">Documentos Colaboradores</a></li>
                                <li class="<?php if ($nombre_archivo == "ubigeos.php") {
                                    echo 'active-link';
                                } ?>"><a href="ubigeos.php">Ubigeos</a></li>
                                <li class="<?php if ($nombre_archivo == "usuarios.php") {
                                    echo 'active-link';
                                } ?>"><a href="usuarios.php">Usuarios</a></li>
                                <li class="<?php if ($nombre_archivo == "empresas.php") {
                                    echo 'active-link';
                                } ?>"><a href="empresas.php">Mis Empresas</a></li>
                            </ul>
                        </li>

                    </ul>




                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
