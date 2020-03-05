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
						<li class="<?php if ($nombre_archivo == "index.php") {echo 'active-link';}?>">
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
								<li class="<?php if ($nombre_archivo == "calendario.php") {echo 'active-link';}?>">
							<a href="calendario.php">
								<i class="fa fa-calendar"></i>
								<span class="menu-title">
									<strong>Ver Calendario</strong>
									<!--<span class="label label-success pull-right">Top</span>-->
								</span>
							</a>
						</li>
						<li class="<?php if ($nombre_archivo == "eventos.php") {echo 'active-link';}?>">
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
						<!--<li class="list-header">Unidades</li>--
							
						<!--Menu list item-->
						<li class="<?php if ($nombre_archivo == "empleados.php") {echo 'active-link';}?>">
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
							
							<!--Submenu-->
							<!--
							<ul class="collapse">
								<li class="<?php if ($nombre_archivo == "inspeccion_extintor.php") {echo 'active-link';}?>"><a href="epp.php">Insp. Extintores</a></li>
								<li class="<?php if ($nombre_archivo == "inspeccion_botiquin.php") {echo 'active-link';}?>"><a href="epp.php">Insp. Botiquin</a></li>
								<li class="<?php if ($nombre_archivo == "inspeccion_epp.php") {echo 'active-link';}?>"><a href="epp.php">Insp. EPP</a></li>
								<li class="<?php if ($nombre_archivo == "inspeccion_orden.php") {echo 'active-link';}?>"><a href="epp.php">Insp. Orden y Limpieza</a></li>
								
							</ul>
						</li>-->
						
						<li>
							<a href="#">
								<i class="fa fa-plus-square"></i>
								<span class="menu-title">Programas</span>
								<i class="arrow"></i>
							</a>
							
							<!--Submenu-->
							<ul class="collapse">
								<li class="<?php if ($nombre_archivo == "programa_inspecciones.php") {echo 'active-link';}?>"><a href="programa_inspecciones.php">Prog. Inspecciones</a></li>
								<li class="<?php if ($nombre_archivo == "programa_capacitaciones.php") {echo 'active-link';}?>"><a href="programa_capacitaciones.php">Prog. Capacitaciones</a></li>
								<li class="<?php if ($nombre_archivo == "programa_simulacros.php") {echo 'active-link';}?>"><a href="programa_simulacros.php">Prog. Simulacros</a></li>
								<li class="<?php if ($nombre_archivo == "programa_monitoreo.php") {echo 'active-link';}?>"><a href="programa_monitoreo.php">Prog. Monitoreo</a></li>
								<li class="<?php if ($nombre_archivo == "programa_auditoria.php") {echo 'active-link';}?>"><a href="programa_auditoria.php">Prog. Auditoria</a></li>
								
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
								<li class="<?php if ($nombre_archivo == "epp.php") {echo 'active-link';}?>"><a href="epp.php">EPP</a></li>
								<li class="<?php if ($nombre_archivo == "extintor.php") {echo 'active-link';}?>"><a href="extintor.php">Extintores</a></li>
								
							</ul>
						</li>
						
						<!--Menu list item-->
						<li>
							<a href="#">
								<i class="fa fa-plus-square"></i>
								<span class="menu-title">Tablas</span>
								<i class="arrow"></i>
							</a>
							
							<!--Submenu-->
							<ul class="collapse">
								<li class="<?php if ($nombre_archivo == "cargo.php") {echo 'active-link';}?>"><a href="cargo.php">Cargo</a></li>
								<li class="<?php if ($nombre_archivo == "especializacion.php") {echo 'active-link';}?>"><a href="especializacion.php">Especializacion</a></li>
								<li class="<?php if ($nombre_archivo == "categoria.php") {echo 'active-link';}?>"><a href="categoria.php">Categoria</a></li>
								<li class="<?php if ($nombre_archivo == "estado_civil.php") {echo 'active-link';}?>"><a href="estado_civil.php">Estado Civil</a></li>
								<li class="<?php if ($nombre_archivo == "seguro_pension.php") {echo 'active-link';}?>"><a href="seguro_pension.php">Seguro Pension</a></li>
								<li class="<?php if ($nombre_archivo == "tipo_seguro.php") {echo 'active-link';}?>"><a href="tipo_seguro.php">Tipo Seguro Pension</a></li>
								<li class="<?php if ($nombre_archivo == "tipo_evento.php") {echo 'active-link';}?>"><a href="tipo_evento.php">Tipo Evento</a></li>
								<li class="<?php if ($nombre_archivo == "tipo_documento.php") {echo 'active-link';}?>"><a href="tipo_documento.php">Tipo Documento</a></li>
								<li class="<?php if ($nombre_archivo == "usuarios.php") {echo 'active-link';}?>"><a href="usuarios.php">Usuarios</a></li>
								<li class="<?php if ($nombre_archivo == "empresas.php") {echo 'active-link';}?>"><a href="empresas.php">Empresas</a></li>
							</ul>
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
								<li class="<?php if ($nombre_archivo == "documentos.php") {echo 'active-link';}?>"><a href="documentos.php">Gestion Documentaria</a></li>
								<li class="<?php if ($nombre_archivo == "preliminar_incidentes.php") {echo 'active-link';}?>"><a href="preliminar_incidentes.php">Preliminar Incidentes</a></li>
								<li class="<?php if ($nombre_archivo == "incidentes.php") {echo 'active-link';}?>"><a href="incidentes.php">Reporte de Incidentes</a></li>
								<li class="<?php if ($nombre_archivo == "acciones_correctivas.php") {echo 'active-link';}?>"><a href="acciones_correctivas.php">Acciones Correctivas</a></li>
							</ul>
						</li>
						
					</ul>
					
					
					<!--Widget-->
					<!--================================-->
					<div class="mainnav-widget">
						
						<!-- Show the button on collapsed navigation -->
						<div class="show-small">
							<a href="#" data-toggle="menu-widget" data-target="#demo-wg-server">
								<i class="fa fa-desktop"></i>
							</a>
						</div>
						
						<!-- Hide the content on collapsed navigation -->
						<div id="demo-wg-server" class="hide-small mainnav-widget-content">
							<ul class="list-group">
								<li class="list-header pad-no pad-ver">Server Status</li>
								<li class="mar-btm">
									<span class="label label-primary pull-right">15%</span>
									<p>CPU Usage</p>
									<div class="progress progress-sm">
										<div class="progress-bar progress-bar-primary" style="width: 15%;">
											<span class="sr-only">15%</span>
										</div>
									</div>
								</li>
								<li class="mar-btm">
									<span class="label label-purple pull-right">75%</span>
									<p>Bandwidth</p>
									<div class="progress progress-sm">
										<div class="progress-bar progress-bar-purple" style="width: 75%;">
											<span class="sr-only">75%</span>
										</div>
									</div>
								</li>
								<li class="pad-ver"><a href="#" class="btn btn-success btn-bock">View Details</a></li>
							</ul>
						</div>
					</div>
					<!--================================-->
					<!--End widget-->
					
				</div>
			</div>
		</div>
		<!--================================-->
		<!--End menu-->
		
	</div>
</nav>
