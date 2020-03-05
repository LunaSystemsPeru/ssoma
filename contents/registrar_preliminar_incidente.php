<?php 
	session_start();
	if (!isset($_SESSION["usuario"])){
		header("location:login.php");
	}
	
	$empresa = $_SESSION['empresa'];
	
	include('includes/conectar.php');
?>
<!DOCTYPE html>
<html lang="es">
	
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
	<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Registrar Investigacion Preliminar de Incidente | Software Gestion de Seguridad Industrial</title>
		
		
		<!--STYLESHEET-->
		<!--=================================================-->
		
		
		
		<!--Bootstrap Stylesheet [ REQUIRED ]-->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		
		
		<!--Nifty Stylesheet [ REQUIRED ]-->
		<link href="../css/nifty.min.css" rel="stylesheet">
		
		
		<!--Font Awesome [ OPTIONAL ]-->
		<link href="../plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		
		
		<!--Switchery [ OPTIONAL ]-->
		<link href="../plugins/switchery/switchery.min.css" rel="stylesheet">
		
		
		<!--Bootstrap Select [ OPTIONAL ]-->
		<link href="../plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
		
		
		<!--Bootstrap Validator [ OPTIONAL ]-->
		<link href="../plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
		
		
		<!--Demo [ DEMONSTRATION ]-->
		<link href="../css/demo/nifty-demo.min.css" rel="stylesheet">
		
		<!--Chosen [ OPTIONAL ]-->
		<link href="../plugins/chosen/chosen.min.css" rel="stylesheet">
		
		
		
		
		<!--SCRIPT-->
		<!--=================================================-->
		
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="../plugins/pace/pace.min.css" rel="stylesheet">
		<script src="../plugins/pace/pace.min.js"></script>
		
		
		<!--
			
			REQUIRED
			You must include this in your project.
			
			RECOMMENDED
			This category must be included but you may modify which plugins or components which should be included in your project.
			
			OPTIONAL
			Optional plugins. You may choose whether to include it in your project or not.
			
			DEMONSTRATION
			This is to be removed, used for demonstration purposes only. This category must not be included in your project.
			
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
					
					
					<!--Page content-->
					<!--===================================================-->
					<div id="page-content">
						
						<div class="row">
							<form class="form-horizontal" enctype="multipart/form-data" id="graba_incidente" action="../inserts/add_investigacion_preliminar.php" method="post">
								<div class="col-lg-12">
									<div class="panel">
										<div class="panel-body">
											<!-- GENERAL -->
											<!--===================================================-->
											<h3 class="pad-all bord-btm text-thin">Registrar Investigacion Preliminar de Incidentes</h3>
											<div id="demo-gen-faq" class="panel-group accordion">
												<div class="panel-body">
													<div class="form-group">
														<label class="col-sm-3 control-label" for="codigo">Probable Consecuencia</label>
														<div class="col-sm-6">
															<!-- Default Bootstrap Select -->
															<!--===================================================-->
															<select id="tipo_seguro" name="consecuencia" class="selectpicker">
																<option value="MENOR">MENOR</option>
																<option value="MODERADA">MODERADA</option>
																<option value="MAYOR">MAYOR</option>
															</select>
															<!--===================================================-->
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="nro_placa">Tipo de Accidente</label>
														<div class="col-sm-6">
															<!-- Default Bootstrap Select -->
															<!--===================================================-->
															<select id="tipo_seguro" name="tipo_accidente" class="selectpicker">
																<option value="CASI ACCIDENTE">CASI ACCIDENTE</option>
																<option value="INCIDENTE">INCIDENTE</option>
															</select>
															<!--===================================================-->
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="nombres">Fecha</label>
														<div class="col-sm-6">
															<input type="text" placeholder="dd/mm/aaaa" name="fecha" id="fecha_registro" class="form-control" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="ape_pat">Hora</label>
														<div class="col-sm-6">
															<input type="text" placeholder="Hora:Minutos:Segundo" name="hora" id="hora_registro" class="form-control" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="ape_mat">Ubicacion</label>
														<div class="col-sm-6">
															<input type="text" placeholder="Ubicacion del Accidente" name="ubicacion" id="ubicacion" class="form-control" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="ape_mat">Area</label>
														<div class="col-sm-6">
															<input type="text" placeholder="Area del Accidente" name="area" id="area" class="form-control" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="direccion">Agraviado</label>
														<div class="col-sm-9">
															<select data-placeholder="Buscar Agraviado" id="demo-chosen-select" name="involucrado" class="col-sm-6">
															<?php 
																global $conn;
																$consulta = "select * from empleado where empresa = '".$empresa."' order by nombres asc";
																$resultado = $conn->query($consulta); 
																if ($resultado->num_rows > 0) {
																	while ($fila = $resultado->fetch_assoc()) {
																		echo '<option value='.$fila['codigo'].'>'.strtoupper($fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat']).'</option>';
																	}
																}
															?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="direccion">Descripcion del Evento</label>
														<div class="col-sm-6">
															<textarea class="form-control" cols="50" name="evento" placeholder="Descripcion del Evento"></textarea> 
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="direccion">Descripcion de la Perdida</label>
														<div class="col-sm-6">
															 <textarea class="form-control" cols="50" name="perdida" required></textarea> 
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="direccion">Probables Causas Inmediatas</label>
														<div class="col-sm-6">
															 <textarea class="form-control" cols="50" name="causas_inmediatas" required></textarea> 
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="direccion">Probables Causas Basicas</label>
														<div class="col-sm-6">
															 <textarea class="form-control" cols="50" name="causas_basicas" required></textarea> 
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="direccion">Acciones Correctivas Inmediatas</label>
														<div class="col-sm-6">
															 <textarea class="form-control" cols="50" name="acciones_inmediatas" required></textarea> 
														</div>
													</div>
												</div>
												<div class="panel-footer text-right">
													<button class="btn btn-info" type="submit">Aceptar</button>
												</div>
												
												
											</div>
											
											<!--===================================================-->
											
											<hr class="bord-no pad-all">
											
										</div>
									</div>
								</div>
							</form>
						</div>
						
						
					</div>
					<!--===================================================-->
					<!--End page content-->
					
					
				</div>
				<!--===================================================-->
				<!--END CONTENT CONTAINER-->
				
				
				
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
		<script src="../js/jquery-2.1.1.min.js"></script>
		
		
		<!--BootstrapJS [ RECOMMENDED ]-->
		<script src="../js/bootstrap.min.js"></script>
		
		
		<!--Fast Click [ OPTIONAL ]-->
		<script src="../plugins/fast-click/fastclick.min.js"></script>
		
		
		<!--Nifty Admin [ RECOMMENDED ]-->
		<script src="../js/nifty.min.js"></script>
		
		<!--Chosen [ OPTIONAL ]-->
		<script src="../plugins/chosen/chosen.jquery.min.js"></script>
		
		
		<!--Switchery [ OPTIONAL ]-->
		<script src="../plugins/switchery/switchery.min.js"></script>
		
		
		<!--Bootstrap Select [ OPTIONAL ]-->
		<script src="../plugins/bootstrap-select/bootstrap-select.min.js"></script>
		
		
		<!--Bootstrap Validator [ OPTIONAL ]-->
		<script src="../plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
		
		
		<!--Demo script [ DEMONSTRATION ]-->
		<script src="../js/demo/nifty-demo.min.js"></script>
		
		
		<!--Masked Input [ OPTIONAL ]-->
		<script src="../plugins/masked-input/jquery.maskedinput.min.js"></script>
		
		
		<!--Form validation [ SAMPLE ]-->
		<script src="../js/demo/form-validation.js"></script>
		
		<!--Form Component [ SAMPLE ]-->
   		<script src="../js/demo/form-component.js"></script>
		
		
		<!--
			
			REQUIRED
			You must include this in your project.
			
			RECOMMENDED
			This category must be included but you may modify which plugins or components which should be included in your project.
			
			OPTIONAL
			Optional plugins. You may choose whether to include it in your project or not.
			
			DEMONSTRATION
			This is to be removed, used for demonstration purposes only. This category must not be included in your project.
			
			SAMPLE
			Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
			
			
			Detailed information and more samples can be found in the document.
			
		-->
		
		
	</body>
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
</html>

