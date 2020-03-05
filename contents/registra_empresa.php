
<!DOCTYPE html>
<html lang="es">
	
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Registrar | Zeus Transport.</title>
		
		
		<!--STYLESHEET-->
		<!--=================================================-->
		
		
		
		<!--Bootstrap Stylesheet [ REQUIRED ]-->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		
		
		<!--Nifty Stylesheet [ REQUIRED ]-->
		<link href="css/nifty.min.css" rel="stylesheet">
		
		
		<!--Font Awesome [ OPTIONAL ]-->
		<link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		
		
		<!--Demo [ DEMONSTRATION ]-->
		<link href="css/demo/nifty-demo.min.css" rel="stylesheet">
		
		
		
		
		<!--SCRIPT-->
		<!--=================================================-->
		
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="plugins/pace/pace.min.css" rel="stylesheet">
		<script src="plugins/pace/pace.min.js"></script>
		
		
		
		<!--
			
			REQUIRED
			You must include this in your project.
			
			RECOMMENDED
			This category must be included but you may modify which plugins or components which should be included in your project.
			
			OPTIONAL
			Optional plugins. You may choose whether to include it in your project or not.
			
			DEMONSTRATION
			This is to be removed, used for demonstration purposes only. This category must not be included in your project.
			
			SAMPLE
			Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
			
			
			Detailed information and more samples can be found in the document.
			
		-->
		
		
	</head>
	
	<!--TIPS-->
	<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
	
	<body>
		<div id="container" class="cls-container">
			
			
			<!-- BACKGROUND IMAGE -->
			<!--===================================================-->
			<div id="bg-overlay" class="bg-img img-balloon"></div>
			
			<!-- HEADER -->
			<!--===================================================-->
			<div class="cls-header cls-header-lg">
				<div class="cls-brand">
					<a class="box-inline" href="index.html">
						<!-- <img alt="Nifty Admin" src="img/logo.png" class="brand-icon"> -->
						<span class="brand-title">Zeus Transport <span class="text-thin">Admin</span></span>
					</a>
				</div>
			</div>
			
			<!-- REGISTRATION FORM -->
			<!--===================================================-->
			<div class="cls-content">
				<div class="cls-content-lg panel">
					<div class="panel-body">
						<p class="pad-btm">Registrar Empresa</p>
						<div class="row">
							<div class="col-lg-12">
								<div class="panel">
									
									<!-- Circular Form Wizard -->
									<!--===================================================-->
									<div id="demo-step-wz">
										<div class="wz-heading wz-w-label bg-success">
											
											<!--Progress bar-->
											<div class="progress progress-xs">
												<div style="width: 15%;" class="progress-bar progress-bar-dark"></div>
											</div>
											
											<!--Nav-->
											<ul class="wz-steps wz-icon-bw wz-nav-off text-lg">
												<li class="col-xs-4">
													<a data-toggle="tab" href="#demo-step-tab1">
														<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
															<span class="wz-icon icon-txt text-bold">1</span>
															<i class="wz-icon-done fa fa-check"></i>
														</span>
														<small class="wz-desc box-block">Empresa</small>
													</a>
												</li>
												<li class="col-xs-4">
													<a data-toggle="tab" href="#demo-step-tab2">
														<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
															<span class="wz-icon icon-txt text-bold">2</span>
															<i class="wz-icon-done fa fa-check"></i>
														</span>
														<small class="wz-desc box-block">Usuario</small>
													</a>
												</li>
												<li class="col-xs-4">
													<a data-toggle="tab" href="#demo-step-tab3">
														<span class="icon-wrap icon-wrap-xs icon-circle bg-dark">
															<span class="wz-icon icon-txt text-bold">3</span>
															<i class="wz-icon-done fa fa-check"></i>
														</span>
														<small class="wz-desc box-block">Listo</small>
													</a>
												</li>
											</ul>
										</div>
										
										<!--Form-->
										<form class="form-horizontal" id="registrar" action="inserts/add_empresa.php" method="post">
											<div class="panel-body">
												<div class="tab-content">
													
													<!--First tab-->
													<div id="demo-step-tab1" class="tab-pane">
														<div class="form-group">
															<label class="col-lg-3 control-label">Nro RUC</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" pattern=".{11,}" maxlength="11" name="ruc" placeholder="Nro RUC" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Razon Social</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" name="razon_social" placeholder="Razon Social" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Nombre Corto - Conocido</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" name="corto" placeholder="Nombre Corto" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Direccion</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" name="direccion" placeholder="Direccion" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Telefono</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" pattern=".{6,}" maxlength="9" name="telefono" placeholder="Telefono" >
															</div>
														</div>
													</div>
													
													<!--Second tab-->
													<div id="demo-step-tab2" class="tab-pane fade">
														<div class="form-group">
															<label class="col-lg-3 control-label">Apellido Paterno</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Apellido Paterno" name="ape_pat" class="form-control" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Apellido Materno</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Apellido Materno" name="ape_mat" class="form-control" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Nombres</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Nombres" name="nombres" class="form-control" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Usuario</label>
															<div class="col-lg-7">
																<input type="text" placeholder="Usuario" name="usuario" class="form-control" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Clave</label>
															<div class="col-lg-7">
																<input type="password" placeholder="Clave" name="contrasena" class="form-control" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Email</label>
															<div class="col-lg-7">
																<input type="email" placeholder="Correo Electronico" name="email" class="form-control" >
															</div>
														</div>
														<div class="form-group">
															<label class="col-lg-3 control-label">Telefono</label>
															<div class="col-lg-7">
																<input type="text" class="form-control" pattern=".{6,}" maxlength="9" name="user_telefono" placeholder="Telefono" >
															</div>
														</div>
													</div>
													
													<!--Fourth tab-->
													<div id="demo-step-tab3" class="tab-pane mar-btm text-center">
														<h4>Gracias por Registrarse</h4>
														<p class="text-muted">En breves momentos estara recibiendo un correo con los datos escritos aqui.</p>
														<p class="text-muted">haga clic en terminar para finalizar.</p>
													</div>
												</div>
											</div>
											
											<!--Footer button-->
											<div class="panel-footer text-right">
												<div class="box-inline">
													<button type="button" class="previous btn btn-mint">Atras</button>
													<button type="button" class="next btn btn-mint">Siguiente</button>
													<button type="button" onclick="document.forms[0].submit()" class="finish btn btn-mint" disabled>Terminar</button>
												</div>
											</div>
										</form>
									</div>
									<!--===================================================-->
									<!-- End Circular Form Wizard -->
									
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="pad-ver">
				Ya tiene una cuenta <a href="login.php" class="btn-link mar-rgt">Ingrese Aqui</a>
			</div>
		</div>
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
	
	
	<!--Bootstrap Wizard [ OPTIONAL ]-->
	<script src="plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
	
	
	<!--Bootstrap Validator [ OPTIONAL ]-->
	<script src="plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
	
	
	<!--Demo script [ DEMONSTRATION ]-->
	<script src="js/demo/nifty-demo.min.js"></script>
	

	<!--Form Wizard [ SAMPLE ]-->
	<script src="js/demo/form-wizard.js"></script>
	
	
	<!--
		
		REQUIRED
		You must include this in your project.
		
		RECOMMENDED
		This category must be included but you may modify which plugins or components which should be included in your project.
		
		OPTIONAL
		Optional plugins. You may choose whether to include it in your project or not.
		
		DEMONSTRATION
		This is to be removed, used for demonstration purposes only. This category must not be included in your project.
		
		SAMPLE
		Some script samples which explain how to initialize plugins or components. This category should not be included in your project.
		
		
		Detailed information and more samples can be found in the document.
		
	-->
	
	
</body>
</html>
