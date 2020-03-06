<?php 
	session_start();
	if (!isset($_SESSION["usuario"])){
		header("location:login.php");
	}
	include("includes/conectar.php");
?>
<!DOCTYPE html>
<html lang="es">
	
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
	<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Empresas | Software Gestion de Seguridad Industrial</title>
		
		
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
		<script src="../public/plugins/pace/pace.min.js"></script>
		
		
		
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
		
		<script type="text/javascript">
			function add_empresa() {
				document.location.href="registrar_empresa.php";
			}
		</script>
		
		
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
								<h3 class="panel-title"><b>Listar Empresas</b></h3>
							</div>
							<!--Data Table-->
							<!--===================================================-->
							<div class="panel-body">
								<div class="pad-btm form-inline">
									<div class="row">
										<div class="col-sm-6 table-toolbar-left">
											<button onclick="add_empresa()" class="btn btn-primary btn-m">Agregar</button>
											<button class="btn btn-default"><i class="fa fa-print"></i></button>
											<div class="btn-group">
												<button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th class="text-center">RUC</th>
												<th class="text-center">Razon Social</th>
												<th class="text-center">Direccion</th>
												<th class="text-center">Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												$busca_epp = "select * from empresa";
												$resultado = $conn->query($busca_epp); 
												if ($resultado->num_rows > 0) {
													while ($fila = $resultado->fetch_assoc()) {
														echo '<tr>
														<td class="text-center">'.$fila['ruc'].'</a></td>
														<td>'.$fila['razon_social'].'</td>
														<td>'.$fila['direccion'].'</td>
														<td  class="text-center">
														<button onclick="EditaEmpresa(\''.$fila['ruc'].'\')" data-target="#edita_empresa" data-toggle="modal"class="btn btn-success btn-icon icon-lg fa fa-edit"></button>
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
				<div class="modal" id="edita_empresa" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div name="contenido_edita_empresa" class="modal-content" id="contenido_edita_empresa">
							
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
		
		
		<!--DataTables [ OPTIONAL ]-->
		<script src="../public/plugins/datatables/media/js/jquery.dataTables.js"></script>
		<script src="../public/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
		<script src="../public/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
		
		
		<!--Demo script [ DEMONSTRATION ]-->
		<script src="../public/js/demo/nifty-demo.min.js"></script>
		
		
		<!--Masked Input [ OPTIONAL ]-->
		<script src="../public/plugins/masked-input/jquery.maskedinput.min.js"></script>
		
		
		<!--Form validation [ SAMPLE ]-->
		<script src="../public/js/demo/form-validation.js"></script>
		
		
		<!--DataTables Sample [ SAMPLE ]-->
		<script src="../public/js/demo/tables-datatables.js"></script>
		
		<script type="text/javascript">
			function EditaEmpresa(ruc) {
				var parametros = {
					"codigo" : ruc,
				};
				$.ajax({
					data:  parametros,
					url:   'modificar_empresa.php',
					type:  'post',
					beforeSend: function () {
                        $("#contenido_edita_empresa").html("Procesando, espere por favor...");
					},
					success:  function (response) {
                        $("#contenido_edita_empresa").html(response);
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

