<?php 
	session_start();
	if (!isset($_SESSION["usuario"])){
		header("location:login.php");
	}
	include ("includes/conectar.php");
	require("includes/varios.php");
	
	$varios = new Varios();
	
	$mes_actual = date("m");
	$anio_actual = date("Y");
	
	$empresa = $_SESSION['empresa'];
?>
<!DOCTYPE html>
<html lang="es">
	
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
	<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Programa de Monitoreo | Software Gestion de Seguridad Industrial</title>
		
		
		<!--STYLESHEET-->
		<!--=================================================-->
		
		
		
		<!--Bootstrap Stylesheet [ REQUIRED ]-->
		<link href="../public/css/bootstrap.min.css" rel="stylesheet">
		
		
		<!--Nifty Stylesheet [ REQUIRED ]-->
		<link href="../public/css/nifty.min.css" rel="stylesheet">
		
		
		<!--Font Awesome [ OPTIONAL ]-->
		<link href="../public/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		
		
		<!--Switchery [ OPTIONAL ]-->
		<link href="../public/plugins/switchery/switchery.min.css" rel="stylesheet">
		
		
		<!--Bootstrap Select [ OPTIONAL ]-->
		<link href="../public/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
		
		
		<!--Bootstrap Table [ OPTIONAL ]-->
		<link href="../public/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
		<link href="../public/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
		
		
		<!--Demo [ DEMONSTRATION ]-->
		<link href="../public/css/demo/nifty-demo.min.css" rel="stylesheet">
		
		
		<!--SCRIPT-->
		<!--=================================================-->
		
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
		<script src="plugins/pace/pace.min.js"></script>
		
        	<!--
			
			REQUIRED
			You must include this in your project.
			
			RECOMMENDED
			This category must be included but you may modify which plugins or components which should be included in your project.
			
			OPTIONAL
			Optional plugins. You may choose whether to include it in your project or not.
			
			DEMONSTRATION
			This is to be removed, used for�demonstration purposes only.�This category must not be included in your project.
			
			SAMPLE
			Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
			
			
			Detailed information and more samples can be found in the document.
			
		-->
		
		
	</head>
	
	<!--TIPS-->
	<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
	
	<body>
		<div id="container" class="effect mainnav-lg">
			
			<!--NAVBAR-->
			<!--===================================================-->
			<?php include("includes/header.php"); ?>
			<!--===================================================-->
			<!--END NAVBAR-->
			
			<div class="boxed">
				
				<!--CONTENT CONTAINER-->
				<!--===================================================-->
				<div id="content-container">
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--div id="page-title">
						<h1 class="page-header text-overflow">Empleados</h1>
					</div-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->
					
					<!--Page content-->
					<!--===================================================-->
					<div id="page-content">
						
						
						
						<!-- Basic Data Tables -->
						<!--===================================================-->
						<div class="panel">
							<div class="panel-heading">
								<h3 class="panel-title"><b>Programa de Monitoreo</b></h3>
							</div>
							<!--Data Table-->
							<!--===================================================-->
							<div class="panel-body">
								<div class="pad-btm form-inline">
									<div class="row">
										<div class="col-sm-6 table-toolbar-left">
											<button data-target="#add_monitoreo" data-toggle="modal" class="btn btn-primary btn-m">Agregar</button>
											<button class="btn btn-default"><i class="fa fa-print"></i></button>
											<div class="btn-group">
												<button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div class="table-responsdsdsive">
									<table id="demo-dt-basic" class="table table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th class="text-center">Cod.</th>
												<th class="text-center">A&ntilde;o</th>
												<th class="text-center">Tipo</th>
												<th class="text-center">Empresa</th>
												<th class="text-center">Fecha Programado</th>
												<th class="text-center">Fecha Ejecutado</th>
												<th class="text-center">Estado</th>
												<th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$monitoreo = "select id, anio, tipo, fecha_programado, fecha_ejecutado, proveedor, estado from programa_monitoreo where empresa = '".$empresa."'";
												//echo $capacitaciones;
												$r_monitoreo = $conn->query($monitoreo); 
												if ($r_monitoreo->num_rows > 0) {
													while ($fila = $r_monitoreo->fetch_assoc()) {
                                                                                                                $proveedor = $fila['proveedor'];
														if ($fila['estado'] == "0") {
															$estado = '<div class="label label-table label-warning">Pendiente</div>';
															$programado = $varios->fecha_tabla($fila['fecha_programado']);
															$ejecutado = '-';
                                                                                                                        $activo = "";
                                                                                                                        $inactivo = "disabled";
															} else {
															$estado = '<div class="label label-table label-success">Realizado</div>';
															$programado = '-';
															$ejecutado = $varios->fecha_tabla($fila['fecha_ejecutado']);
                                                                                                                        $activo = "disabled";
                                                                                                                        $inactivo = "";
														}
														echo '<tr>
														<td class="text-center">'.$fila['id'].'</td>
														<td class="text-center">'.$fila['anio'].'</td>
														<td><a href="" class="btn-link" onclick="VerDetalle(\''.$fila['id'].'\', \''.$fila['anio'].'\', \''.$fila['tipo'].'\')" data-target="#ver_detalle" data-toggle="modal">'.$fila['tipo'].'</a></td>
														<td class="text-center">'.$proveedor.'</td>
														<td class="text-center">'.$programado.'</td>
														<td class="text-center">'.$ejecutado.'</td>
														<td class="text-center">'.$estado.'</td>
														<td>
														<button onclick="EditarMonitoreo(\''.$fila['id'].'\', \''.$fila['anio'].'\', \''.$fila['tipo'].'\')" data-target="#editar_monitoreo" data-toggle="modal"class="btn btn-success btn-icon icon-lg fa fa-edit" '.$activo.'></button>
														<button class="btn btn-info btn-icon icon-lg fa fa-trash"></button>
														</td>
														</tr>';
													}
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<!--===================================================-->
							<!--End Data Table-->
						</div>
						<!--===================================================-->
						<!-- End Striped Table -->
						
					</div>
					<!--===================================================-->
					<!--End page content-->
					
					
				</div>
				<!--===================================================-->
				<!--END CONTENT CONTAINER-->
				
				<!--Default Bootstrap Modal-->
				<!--===================================================-->
				<div class="modal" id="add_monitoreo" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<!--Modal header-->
							<div class="modal-header">
								<button data-dismiss="modal" class="close" type="button">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title">Registro de Monitoreo</h4>
							</div>
							<form class="form-horizontal" id="frm_registra_monitoreo" action="inserts/add_monitoreo.php" method="post">
								<!--Modal body-->
								<div class="modal-body">
									<div class="form-group">
										<label class="col-lg-3 control-label">Tipo</label>
										<div class="col-lg-7">
											<select id="tipo" name="tipo" class="selectpicker">
												<option value="AGENTES FISICOS">AGENTES FISICOS</option>
												<option value="AGENTES QUIMICOS">AGENTES QUIMICOS</option>
												<option value="AGENTES BIOLOGICOS">AGENTES BIOLOGICOS</option>
												<option value="AGENTES PSICOSOCIALES">AGENTES PSICOSOCIALES</option>
												<option value="RIESGOS DISERGONOMICO">RIESGOS DISERGONOMICO</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Empresa</label>
										<div class="col-lg-7">
											<input type="text" placeholder="Empresa" name="proveedor" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Fecha Programacion</label>
										<div class="col-lg-3">
											<input type="text"class="form-control" id="fecha_registro" name="fecha_inicio" placeholder="dd/mm/aaaa" required >
										</div>
									</div>
								</div>
								
								<!--Modal footer-->
								<div class="modal-footer">
									<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
									<input type="submit" class="btn btn-primary" name="graba_monitoreo">
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="modal" id="ver_detalle" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div name="contenido_detalle" class="modal-content" id="contenido_detalle">
							
						</div>
					</div>
				</div>
                                
                                <div class="modal" id="editar_monitoreo" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div name="contenido_editar" class="modal-content" id="contenido_editar">
							
						</div>
					</div>
				</div>
				<!--===================================================-->
				<!--End Default Bootstrap Modal-->
				
				
				
				<!--MAIN NAVIGATION-->
				<!--===================================================-->
				<?php include("includes/main_navigation.php");?>
				<!--===================================================-->
				<!--END MAIN NAVIGATION-->
				
				<!-- TAB DE LA DERECHA -->
				<!--ASIDE-->
				<!--===================================================-->
				<?php include("includes/aside_rigth.php");?>
				<!--===================================================-->
				<!--END ASIDE-->
			</div>
			
			
			
			<!-- FOOTER -->
			<!--===================================================-->
			<?php include("includes/footer.php");?>
			<!--===================================================-->
			<!-- END FOOTER -->
			
			
			<!-- SCROLL TOP BUTTON -->
			<!--===================================================-->
			<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
			<!--===================================================-->
			
			
			
		</div>
		<!--===================================================-->
		<!-- END OF CONTAINER -->
		
		
		<!--JAVASCRIPT-->
		<!--=================================================-->
		
		<!--jQuery [ REQUIRED ]-->
		<script src="js/jquery-2.1.1.min.js"></script>
		
		
		<!--BootstrapJS [ RECOMMENDED ]-->
		<script src="js/bootstrap.min.js"></script>
		
		
		<!--Fast Click [ OPTIONAL ]-->
		<script src="plugins/fast-click/fastclick.min.js"></script>
		
		
		<!--Nifty Admin [ RECOMMENDED ]-->
		<script src="js/nifty.min.js"></script>
		
		
		<!--Switchery [ OPTIONAL ]-->
		<script src="plugins/switchery/switchery.min.js"></script>
		
		
		<!--Bootstrap Select [ OPTIONAL ]-->
		<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>
		
		<!--Bootstrap Validator [ OPTIONAL ]-->
		<script src="plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
		
		
		<!--DataTables [ OPTIONAL ]-->
		<script src="plugins/datatables/media/js/jquery.dataTables.js"></script>
		<script src="plugins/datatables/media/js/dataTables.bootstrap.js"></script>
		<script src="plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
		
		
		<!--Demo script [ DEMONSTRATION ]-->
		<script src="js/demo/nifty-demo.min.js"></script>
		
		
		<!--Masked Input [ OPTIONAL ]-->
		<script src="plugins/masked-input/jquery.maskedinput.min.js"></script>
		
		
		<!--Form validation [ SAMPLE ]-->
		<script src="js/demo/form-validation.js"></script>
		
		
		<!--DataTables Sample [ SAMPLE ]-->
		<script src="js/demo/tables-datatables.js"></script>
		
		<script type="text/javascript">
			function VerDetalle(id, anio, tipo) {
				var parametros = {
					"codigo" : id,
					"anio" : anio,
					"tipo" : tipo,
				};
				$.ajax({
					data:  parametros,
					url:   'frm_modificar/detalle_monitoreo.php',
					type:  'post',
					beforeSend: function () {
                        $("#contenido_detalle").html("Procesando, espere por favor...");
					},
					success:  function (response) {
                        $("#contenido_detalle").html(response);
					}
				});
			}
                        
                        function EditarMonitoreo(id, anio, tipo) {
				var parametros = {
					"id" : id,
					"anio" : anio,
					"tipo" : tipo,
				};
				$.ajax({
					data:  parametros,
					url:   'frm_modificar/modificar_monitoreo.php',
					type:  'post',
					beforeSend: function () {
                        $("#contenido_editar").html("Procesando, espere por favor...");
					},
					success:  function (response) {
                        $("#contenido_editar").html(response);
					}
				});
			}
		</script>
		
		<!--
			
			REQUIRED
			You must include this in your project.
			
			RECOMMENDED
			This category must be included but you may modify which plugins or components which should be included in your project.
			
			OPTIONAL
			Optional plugins. You may choose whether to include it in your project or not.
			
			DEMONSTRATION
			This is to be removed, used for�demonstration purposes only.�This category must not be included in your project.
			
			SAMPLE
			Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
			
			
			Detailed information and more samples can be found in the document.
			
		-->
		
		
	</body>
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

