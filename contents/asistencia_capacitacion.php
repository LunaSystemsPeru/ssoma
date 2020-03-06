<?php 
	session_start();
	if (!isset($_SESSION["usuario"])){
		header("location:login.php");
	}
	$empresa = $_SESSION['empresa'];
	$id = $_GET['id'];
	$anio = $_GET['anio'];	
	
	include ('includes/conectar.php');
?>
<!DOCTYPE html>
<html lang="es">
	
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
	<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Asistencia a la Capacitacion | Software Gestion de Seguridad Industrial</title>
		
		
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
		
		
		<!--Bootstrap Validator [ OPTIONAL ]-->
		<link href="../public/plugins/bootstrap-validator/bootstrapValidator.min.css" rel="stylesheet">
		
		
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
					
					<!--Page Title-->
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<div id="page-title">
						<h1 class="page-header text-overflow">Grabar Asistencia</h1>
					</div>
					<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
					<!--End page title-->
					
					<!--Page content-->
					<!--===================================================-->
					<div id="page-content">
						
						<div class="row">
							<form class="form-horizontal" enctype="multipart/form-data" id="graba_epp_empleado" action="inserts/entrega_epp.php" method="post">
								<div class="col-lg-9">
									<div class="panel">
										<div class="panel-body">
											<!-- GENERAL -->
											<!--===================================================-->
											<div id="demo-gen-faq" class="panel-group accordion">
												<div class="panel-body">
													<div class="form-group">
														<label class="col-sm-3 control-label" for="fecha_entrega">Fecha Ejecucion</label>
														<div class="col-sm-6">
															<input type="text" placeholder="dd/mm/aaaa" name="fecha_entrega" id="fecha_entrega" class="form-control" required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="tipo_seguro">EPP</label>
														<div class="col-sm-5">
															<!-- Default Bootstrap Select -->
															<!--===================================================-->
															<select id="lista_empleado" name="lista_epp" class="selectpicker">
																<?php 
																	global $conn;
																	$consulta = "select * from empleado where empresa = '".$empresa."' order by nombres asc";
																	$resultado = $conn->query($consulta); 
																	if ($resultado->num_rows > 0) {
																		while ($fila = $resultado->fetch_assoc()) {
																			echo '<option value='.$fila['codigo'].'>'.strtoupper($fila['nombres']).'</option>';
																		}
																	}
																?>
															</select>
															<!--===================================================-->
														</div>
														<div class="col-sm-3">
															<button class="btn btn-info" type="button" id="add_fila">Agregar</button>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label" for="tipo_seguro"></label>
														<div class="col-sm-6">
															<table class="table table-striped" name="detalle" id="detalle">
																<thead>
																	<tr>
																		<th class="text-center">Cod.</th>
																		<th class="text-center">Nombre</th>
																		<th>Acciones</th>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</div>
													</div>
												</div>
												<div class="panel-footer text-right">
													<input name="array_idepp" id="array_idepp" type="hidden" />
													<input name="id_empleado" id="id_empleado" value="<?php echo $id_empleado; ?>" type="hidden" />
													<input type="submit" id="enviar" name="enviar" onclick="setValores()" class="btn btn-info" />
												</div>
											</div>
											<!--===================================================-->
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
		
		
		<!--Demo script [ DEMONSTRATION ]-->
		<script src="js/demo/nifty-demo.min.js"></script>
		
		
		<!--Masked Input [ OPTIONAL ]-->
		<script src="plugins/masked-input/jquery.maskedinput.min.js"></script>
		
		
		<!--Form validation [ SAMPLE ]-->
		<script src="js/demo/form-validation.js"></script>
		
		<script type="text/javascript">
			var nro_fila = 0;
			var id_epp =  new Array();
			
			$("#add_fila").click(function() {
				id_epp[nro_fila] = $("#lista_epp").val();
				var tds = '<tr>';
				tds += '<td class="text-center">' + $("#lista_epp").val() + '</td>';
				tds += '<td>' +$("#lista_epp option:selected").text() +'</td>';
				tds += '<td><button onclick ="delete_row($(this),'+nro_fila+')" id="'+nro_fila+'" class="btn btn-info btn-icon icon-lg fa fa-trash"></button></td>';
				tds += '</tr>';
				
				$("#detalle").append(tds);
				
				nro_fila ++;
			});
			
			function delete_row(row, idarray)
			{
				row.closest('tr').remove();
				delete id_epp [idarray];
			}
			
			function setValores () {
				//Lo convierto a objeto
				var jepp={};
				for(i in id_epp)
				{
					jepp[i] = id_epp[i];
				}
				
				var jeppjson = JSON.stringify(jepp);
				//alert (jeppjson.toString());
				document.getElementById("array_idepp").value=jeppjson;
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
		
		
	</body>
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/pages-faq.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:42:25 GMT -->
</html>

