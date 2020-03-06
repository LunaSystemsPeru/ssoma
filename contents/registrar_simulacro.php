<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("location:login.php");
}
include("includes/conectar.php");
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
		<title>Registrar Simulacro | Software Gestion de Seguridad Industrial</title>
		
		
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
		
		<!--Chosen [ OPTIONAL ]-->
		<link href="../public/plugins/chosen/chosen.min.css" rel="stylesheet">
		
		
		<!--SCRIPT-->
		<!--=================================================-->
		
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
		<script src="../public/plugins/pace/pace.min.js"></script>
		
		<script type="text/javascript">
			function regresar() {
				document.location.href="programa_simulacros.php";
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
			<?php include("../fixed/header.php"); ?>
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
								<h3 class="panel-title"><b>Registro de Simulacros</b></h3>
							</div>
							<!--Data Table-->
							<!--===================================================-->
							<div class="panel-body">
								<div class="table-responsive">
									<form class="form-horizontal" id="frm_registra_evento" action="../old_controller/add_simulacro.php" method="post">
								<!--Modal body-->
								<div class="modal-body">
									<div class="form-group">
										<label class="col-lg-3 control-label">Lugar</label>
										<div class="col-lg-7">
											<input type="text" placeholder="Lugar" name="lugar" class="form-control" required>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Observador</label>
										<div class="col-sm-7">
											<select data-placeholder="Buscar Observador" id="demo-chosen-select" name="observador" class="form-control">
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
										<label class="col-lg-3 control-label">Fecha Programa</label>
										<div class="col-lg-3">
											<input type="text" class="form-control" id="fecha_registro" name="fecha_inicio" placeholder="dd/mm/aaaa" required >
										</div>
										<label class="col-lg-2 control-label">Hora Inicio</label>
										<div class="col-lg-2">
											<input type="text" class="form-control" id="hora_registro" name="hora_inicio" placeholder="hh:mm:ss" required >
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="tipo">Tipo de Simulacro</label>
										<div class="col-lg-7">
											<!-- Default Bootstrap Select -->
											<!--===================================================-->
											<select id="tipo" name="tipo" class="selectpicker">
												<option value="SISMO">SISMO</option>
												<option value="INCENDIO">INCENDIO</option>
												<option value="TSUNAMI">TSUNAMI</option>
											</select>
											<!--===================================================-->
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="direccion">Simulacion Creada</label>
										<div class="col-lg-7">
											 <textarea class="form-control" cols="50" rows="5" name="simulacion" required></textarea> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="direccion">Magnitud del Simulacro</label>
										<div class="col-lg-7">
											 <textarea class="form-control" cols="50" rows="5" name="magnitud" required></textarea> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="direccion">Antes</label>
										<div class="col-lg-7">
											 <textarea class="form-control" cols="50" rows="5" name="antes" required></textarea> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="direccion">Durante</label>
										<div class="col-lg-7">
											 <textarea class="form-control" cols="50" rows="8"name="durante" required></textarea> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="direccion">Despues</label>
										<div class="col-lg-7">
											 <textarea class="form-control" cols="50" rows="5" name="despues" required></textarea> 
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-3 control-label" for="direccion">Ayuda Externa</label>
										<div class="col-lg-7">
											 <textarea class="form-control" cols="50" rows="5" name="ayuda_externa" required></textarea> 
										</div>
									</div>
								</div>
								
								<!--Modal footer-->
								<div class="modal-footer">
									<button onclick="regresar()" class="btn btn-default" type="button">Cerrar</button>
									<input type="submit" class="btn btn-primary" name="graba_simulacro">
								</div>
							</form>
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
				
				<!--===================================================-->
				<!--End Default Bootstrap Modal-->
				
				
				
				<!--MAIN NAVIGATION-->
				<!--===================================================-->
				<?php include("../fixed/main_navigation.php");?>
				<!--===================================================-->
				<!--END MAIN NAVIGATION-->
				
				<!-- TAB DE LA DERECHA -->
				<!--ASIDE-->
				<!--===================================================-->
				<?php include("../fixed/aside_rigth.php");?>
				<!--===================================================-->
				<!--END ASIDE-->
			</div>
			
			
			
			<!-- FOOTER -->
			<!--===================================================-->
			<?php include("../fixed/footer.php");?>
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
		<script src="../public/js/jquery-2.1.1.min.js"></script>
		
		
		<!--BootstrapJS [ RECOMMENDED ]-->
		<script src="../public/js/bootstrap.min.js"></script>
		
		
		<!--Fast Click [ OPTIONAL ]-->
		<script src="../public/plugins/fast-click/fastclick.min.js"></script>
		
		
		<!--Nifty Admin [ RECOMMENDED ]-->
		<script src="../public/js/nifty.min.js"></script>
		
		
		<!--Switchery [ OPTIONAL ]-->
		<script src="../public/plugins/switchery/switchery.min.js"></script>
		
		
		<!--Bootstrap Select [ OPTIONAL ]-->
		<script src="../public/plugins/bootstrap-select/bootstrap-select.min.js"></script>
		
		<!--Bootstrap Validator [ OPTIONAL ]-->
		<script src="../public/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
		
		
		<!--Demo script [ DEMONSTRATION ]-->
		<script src="../public/js/demo/nifty-demo.min.js"></script>
		
		
		<!--Masked Input [ OPTIONAL ]-->
		<script src="../public/plugins/masked-input/jquery.maskedinput.min.js"></script>
		
		
		<!--Form validation [ SAMPLE ]-->
		<script src="../public/js/demo/form-validation.js"></script>
			
		<!--Chosen [ OPTIONAL ]-->
		<script src="../public/plugins/chosen/chosen.jquery.min.js"></script>
		
		<!--Form Component [ SAMPLE ]-->
   		<script src="../public/js/demo/form-component.js"></script>
		
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
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

