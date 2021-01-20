<?php 
	session_start();
	if (!isset($_SESSION["usuario"])){
		header("location:login.php");
	}
	include ("includes/conectar.php");

    $empresa = $_SESSION['empresa'];
?>
<!DOCTYPE html>
<html lang="es">
	
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
	<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Empleados | Software Gestion de Seguridad Industria</title>
		
		
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
		
		
		<script type="text/javascript">
			function add_empleado() {
				document.location.href="registra_empleado.php";
			}
			function ver_lista() {
				document.location.href="empleados.php";
			}
		</script>
		
		
		<!--SCRIPT-->
		<!--=================================================-->
		
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
		<script src="../public/plugins/pace/pace.min.js"></script>
		
		
		
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
					<div id="page-title">
						<h1 class="page-header text-overflow">Galeria de Empleados</h1>
						
						<div class="pad-btm form-inline">
							<div class="row">
								<div class="col-sm-6 table-toolbar-left">
									<button onclick="add_empleado()" id="demo-btn-addrow" class="btn btn-purple btn-labeled fa fa-plus">Agregar</button>
									<button onclick="ver_lista()" id="demo-btn-addrow" class="btn btn-info btn-labeled fa fa-check">Ver Lista</button>
									<button class="btn btn-default"><i class="fa fa-print"></i></button>
									<div class="btn-group">
										<button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
										<button class="btn btn-default"><i class="fa fa-trash"></i></button>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->
					
					<!--Page content-->
					<!--===================================================-->
					<div id="page-content">
						
						<div class="row">
							<?php 
								//buscar vehiculos en esta empresa
								$empleados = "select e.codigo, e.dni, e.nombres, e.ape_pat, e.ape_mat, e.fecha_nacimiento, ec.nombre as estado_civil, ca.nombre as cargo, sp.nombre as seguro_pension, gs.nombre as grupo_sanguineo, fs.nombre as factor_sanguineo, e.estado, e.imagen from empleado as e inner join estado_civil as ec on e.estado_civil = ec.id inner join cargo as ca on e.cargo = ca.id inner join seguro_pension as sp on e.seguro_pension = sp.id inner join grupo_sanguineo as gs on e.grupo_sanguineo = gs.id inner join factor_sanguineo as fs on e.factor_sanguineo = fs.id where e.empresa = '".$empresa."' order by e.ape_pat asc, e.ape_mat asc, e.nombres asc";
								$resultado = $conn->query($empleados); 
								if ($resultado->num_rows > 0) {
									while ($fila = $resultado->fetch_assoc()) {
										$estado = $fila['estado'];
										if ($estado == 1 ) {
											$v_estado = '<div class="label label-table label-success">Vigente</div>';
										}
										echo '<div class="col-md-4">
										<!--Profile Widget-->
										<!--===================================================-->
										<div class="panel text-center">
										<div class="panel-body">
										<img class="col-sm-12" src="upload/'.$empresa.'/perfil/'.$fila['imagen'].'">
										</div>
										<div class="pad-all">
										<p>
										'.$fila['codigo'].' - ' .$fila['dni'].'
										</p>
										<p>'.strtoupper($fila['ape_pat']).' '.strtoupper($fila['ape_mat']).' '.strtoupper($fila['nombres']).'</p>
										<div class="pad-btm">
										<div class="btn-group">
										<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" type="button">
										Ver Mas <i class="dropdown-caret fa fa-caret-down"></i>
										</button>
										<ul class="dropdown-menu dropdown-menu-right">
										<li class="dropdown-header">Otros Datos</li>
										<li><a href="resumen_empleado.php?id='.$fila['codigo'].'">Resumen</a>
										</li>
										<li><a href="familia_empleado.php?id='.$fila['codigo'].'">Familia / Contacto</a>
										</li>
										<li><a href="academico_empleado.php?id='.$fila['codigo'].'">Exp. Academica</a>
										</li>
										<li><a href="laboral_empleado.php?id='.$fila['codigo'].'">Exp. Laboral</a>
										</li>
										</ul>
										</div>
										<button class="btn btn-info btn-icon icon-lg fa fa-trash"></button>
										</div>
										</div>
										</div>
										<!--===================================================-->
										</div>';
									}
								} 
							?>
							
						</div>
					</div>
					<!--===================================================-->
					<!--End page content-->
					
					
				</div>
				<!--===================================================-->
				<!--END CONTENT CONTAINER-->
				
				
				
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
		
		
		<!--DataTables [ OPTIONAL ]-->
		<script src="../public/plugins/datatables/media/js/jquery.dataTables.js"></script>
		<script src="../public/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
		<script src="../public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
		
		
		<!--Demo script [ DEMONSTRATION ]-->
		<script src="../public/js/demo/nifty-demo.min.js"></script>
		
		
		<!--DataTables Sample [ SAMPLE ]-->
		<script src="../public/js/demo/tables-datatables.js"></script>
		
		
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

