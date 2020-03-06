<?php 
	session_start();
	if (!isset($_SESSION["usuario"])){
		header("location:login.php");
	}
	include("includes/conectar.php");
	require("includes/varios.php");
	
	$varios = new Varios();
	
	$mes_actual = date("m");
	$anio_actual = date("Y");
	
	$id = $_GET['id'];
	$anio = $_GET['anio'];	
	
	$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
	
	$empresa = $_SESSION['empresa'];
	
	$consulta = "select id, anio, tema, expositor, duracion, fecha_programado, date_add(fecha_programado, interval duracion hour) as fecha_termino, estado from programa_capacitaciones where empresa = '".$empresa."' and id = '".$id."' and anio = '".$anio."'";

	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			
			$tema = $fila['tema'];
			$expositor = $fila['expositor'];
			$duracion = $fila['duracion']; 
		    	$fecha_programacion = $varios->fecha_hora_tabla($fila['fecha_programado']);
		    	$fecha_fin = $varios->fecha_hora_tabla($fila['fecha_termino']);
		    if ($fila['estado'] == "0") {
		    	$activo = "";
			$inactivo = "disabled";
			$estado = '<div class="label label-table label-warning">Pendiente</div>';
		    } else {
			$activo = "disabled";
			$inactivo = "";
			$estado = '<div class="label label-table label-success">Realizado</div>';
														}                                   
		}
	} else {
		echo "0 resultados";
	}
	//$conn->close();

?>
<!DOCTYPE html>
<html lang="es">
	
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:49 GMT -->
	<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Detalle Capacitaciones | Software Gestion de Seguridad Industrial</title>
		
		
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
		
		<!--Dropzone [ OPTIONAL ]-->
		<link href="../public/plugins/dropzone/dropzone.css" rel="stylesheet">
		<!--SCRIPT-->
		<!--=================================================-->
		
		<!--Page Load Progress Bar [ OPTIONAL ]-->
		<link href="../public/plugins/pace/pace.min.css" rel="stylesheet">
		<script src="../public/plugins/pace/pace.min.js"></script>
		
		<style type="text/css"> 
                    #lightbox .modal-content {
                        display: inline-block;
                        text-align: center;   
                    }

                    #lightbox .close {
                        opacity: 1;
                        color: rgb(255, 255, 255);
                        background-color: rgb(25, 25, 25);
                        padding: 5px 8px;
                        border-radius: 30px;
                        border: 2px solid rgb(255, 255, 255);
                        position: absolute;
                        top: -15px;
                        right: -55px;

                        z-index:1032;
                    }
                </style>
		
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
								<h2 class="panel-title"><a href="programa_capacitaciones.php" class="btn-link">Programa Capacitaciones </a> / <b><?php echo $tema;?></b></h2>
							</div>
							<!--Data Table-->
							<!--===================================================-->
							<div class="panel-body">
								<div class="pad-btm form-inline">
									<div class="row">
										<div class="col-sm-6 table-toolbar-left">
											<button onclick="EditaCapacitacion(<?php echo $id?>, <?php echo $anio?>)" data-target="#editar_capacitacion" data-toggle="modal" class="btn btn-primary btn-m" <?php echo $activo?>>Editar</button>
											<button data-target="#finalizar_capacitacion" data-toggle="modal" class="btn btn-success btn-m" <?php echo $activo?>>Finalizar</button>
											<button class="btn btn-default"><i class="fa fa-print"></i></button>
											<div class="btn-group">
												<button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-8">
											
												<h4>Informacion General</h4>
												<div class="row">
													<div class="col-sm-12">
														<dl class="dl-horizontal">
															<dt>Fecha:</dt>
															<dd><?php echo $fecha_programacion.' - '.$fecha_fin; ?></dd>
															<dt>Expositor:</dt>
															<dd><?php echo $expositor; ?></a></dd>
															<dt>Lugar:</dt>
															<dd>xxxx</dd>
															<dt>Estado:</dt>
															<dd><?php echo $estado; ?></dd>
															
														</dl>
													</div>
												</div>
												<h4>Generar Asistencia</h4>
												<div>
													<a href="../reportes/asistencia_capacitacion.php?id=<?php echo $id?>&anio=<?php echo $anio?>">Ir a Pagina</a>
												</div>
											
										</div>
								
											<!-- RECENT FILES -->
											<div class="panel col-md-4">
												<div class="panel-heading">
													<h4><i class="fa fa-files-o"></i> Archivos del Evento</h4>
												</div>
												<div class="panel-content">
													<ul class="fa-ul recent-file-list bottom-30px">
													<?php 
													$archivos = "select nombre, tipo from archivos_capacitaciones where id = '".$id."' and anio = '".$anio."' and empresa = '".$empresa."'";
//													echo dirname(__FILE__) . "/uploads";
													$resultado = $conn->query($archivos); 
													if ($resultado->num_rows > 0) {
														while ($fila = $resultado->fetch_assoc()) 															{
														echo '<li><b>'.$fila['tipo'].'</b> <i class="fa-li fa fa-file-pdf-o"></i><a class="btn-link" href="upload/'.$empresa.'/capacitaciones/'.$anio.$cod.'/archivos/'.$fila['nombre'].'">'.$fila['nombre'].'</a></li>';
														}
													}
													?>
													</ul>
												</div>
												<div class="panel-footer">
													<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_subir_archivos" <?php echo $activo?>><i class="fa fa-upload"></i> Cargar Archivos</button> 
													<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_subir_fotos" <?php echo $activo?>><i class="fa fa-upload"></i> Subir Fotos</button>
	
												</div>
											</div>
											<!-- END RECENT FILES -->
								
							</div>
							<!--===================================================-->
							<!--End Data Table-->
						</div>
						<!--===================================================-->
						<!-- End Striped Table -->
						
						
						<div class="list-group panel">
						<div class="panel-heading">
								<h3 class="panel-title"><b>Imagenes de la Capacitacion</b></h>
							</div>
							<!--Data Table-->
							<!--===================================================-->
							<div class="panel-body">
									<?php 
										global $conn;
										$img_capacitacion = "select id, imagen,fecha_subida from imagenes_capacitacion where id = '".$id."' and anio = '".$anio."' and empresa = '".$empresa."'";
//													echo dirname(__FILE__) . "/uploads";
										$resultado = $conn->query($img_capacitacion); 
										if ($resultado->num_rows > 0) {
											while ($fila = $resultado->fetch_assoc()) {
											$cod = str_pad($fila['id'], 3, '0', STR_PAD_LEFT);
											$tiempo = $varios->fecha_hora_segundos_tabla($fila['fecha_subida']);
												echo '
												<div class="item col-md-3 col-sm-6">
													<div class="thumbnail">
                                                                                                            <a href="#" class="thumbnail" data-toggle="modal" data-target="#lightbox">
														<img style="max-height:10em; max-width:100%" class="group list-group-image" src="upload/'.$empresa.'/capacitaciones/'.$anio.$cod.'/imagenes/'.$fila['imagen'].'" alt="" />
                                                                                                            </a>
														<div class="caption">
															<h3 class="inner list-group-item-heading">'.$fila['imagen'].'</h3>
															<ul class="list-unstyled">
																<li><strong>Path:</strong> <em>upload/'.$empresa.'/capacitaciones/'.$anio.$cod.'/imagenes/'.$fila['imagen'].'</em></li>
																<li><strong>Fecha y Hora:</strong> <em>'.$tiempo.'</em></li>
															</ul>
															<div class="action-buttons">
																<a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Eliminar</a>
															</div>
														</div>
													</div>
												</div>';
											}
										} else {
echo " 0 resultados";
}
									?>
								</div>
								</div>
						
						
					</div>
					<!--===================================================-->
					<!--End page content-->
					
					
				</div>
				<!--===================================================-->
				<!--END CONTENT CONTAINER-->
				
				<!--Default Bootstrap Modal-->
				<!--===================================================-->
				<div class="modal" id="editar_capacitacion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div name="contenido_edita_capacitacion" class="modal-content" id="contenido_edita_capacitacion">
							
						</div>
					</div>
				</div>
				
				<div class="modal" id="finalizar_capacitacion" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<!--Modal header-->
							<div class="modal-header">
								<button data-dismiss="modal" class="close" type="button">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title">Finalizar Capacitacion</h4>
							</div>
							<form class="form-horizontal" id="frm_registra_evento" action="../old_controller/finalizar_capacitaciones.php" method="post">
								<!--Modal body-->
								<div class="modal-body">
									<div class="form-group">
										<label class="col-lg-3 control-label">Tema</label>
										<div class="col-lg-7">
											<input type="text" placeholder="Tema" name="tema" value="<?php echo $tema; ?>" class="form-control" readonly="true">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Expositor</label>
										<div class="col-lg-7">
											<input type="text" placeholder="Expositor" name="expositor" id="nombre" value="<?php echo $expositor; ?>" class="form-control" readonly="true">
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Fecha Realizacion</label>
										<div class="col-lg-3">
											<input type="text"class="form-control" id="fecha_ejecucion" name="fecha_capacitacion" placeholder="dd/mm/aaaa" required >
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Hora Inicio</label>
										<div class="col-lg-2">
											<input type="text" class="form-control" id="hora_inicio" name="hora_inicio" placeholder="hh:mm:ss" required >
										</div>
										<label class="col-lg-2 control-label">Hora Fin</label>
										<div class="col-lg-2">
											<input type="text" class="form-control" id="hora_fin" name="hora_fin" placeholder="hh:mm:ss" required >
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Cantidad Asistentes</label>
										<div class="col-lg-2">
											<input type="number" name="cantidad" min-value="1" value="1" class="form-control" required>
										</div>
									</div>
								</div>
								
								<!--Modal footer-->
								<div class="modal-footer">
									<input type="hidden" name="id" value="<?php echo $id ?>" >
									<input type="hidden" name="anio" value="<?php echo $anio ?>">
									<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
									<input type="submit" class="btn btn-primary" name="graba_fin">
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="modal" id="modal_subir_archivos" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<!--Modal header-->
							<div class="modal-header">
								<button data-dismiss="modal" class="close" type="button">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title">Subir Archivos</h4>
							</div>
							<form class="form-horizontal" id="frm_registro_archivo" action="../old_controller/archivos_capacitacion.php" enctype="multipart/form-data" method="post">
								<!--Modal body-->
								<div class="modal-body">
									<div class="form-group">
										<label class="col-lg-3 control-label">Tipo</label>
										<div class="col-lg-7">
											<select id="tipo_archivo" name="tipo_archivo" class="selectpicker">
												<option value="DIAPOSITIVA">DIAPOSITIVA</option>
												<option value="ENCUESTA">ENCUESTA</option>
												<option value="CUESTIONARIO">CUESTIONARIO</option>
												<option value="ASISTENCIA">ASISTENCIA</option>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-lg-3 control-label">Archivo</label>
										<div class="col-lg-7">
											<input type="file" class="form-control" name="file" id="file" required >
											<div id="message"></div>
										</div>								
									</div>
								</div>
								
								<!--Modal footer-->
								<div class="modal-footer">
									<input type="hidden" value="<?php echo $id?>" name="id">
									<input type="hidden" value="<?php echo $anio?>" name="anio">
									<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
									<input type="submit" class="btn btn-primary" name="graba_archivo">
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="modal fade" id="modal_subir_fotos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
					<div class="modal-content">
					    <form id="demo-dropzone" action="../old_controller/imagenes_capacitacion.php" enctype="multipart/form-data" drop-zone="" method="POST">
						<div class="modal-header">
						    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						    <h4 class="modal-title" id="myModalLabel">Subir Imagenes a la Capacitacion </h4>
						</div>

						<div class="modal-body">
						    <!--  aqui va el file upload para imagenes -->

						    <!-- FILE UPLOAD -->
						    <div class="dz-default dz-message">
							<div class="dz-icon icon-wrap icon-circle icon-wrap-md" method="POST">
							    <i class="fa fa-cloud-upload fa-3x"></i>
							</div>
							<div>
							    <p class="dz-text">Arrastra las imagenes para subir</p>
							    <p class="text-muted">o clic para cargarlos manualmente</p>
							</div>
						    </div>
						    <div class="fallback">
							<input name="archivo[]" type="file" multiple />
							<input type="hidden" value="<?php echo $id;?>" name="id" />
							<input type="hidden" value="<?php echo $anio;?>" name="anio" />
						    </div>
						    <!-- END FILE UPLOAD -->

						</div>
						<div class="modal-footer">
						    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="recargar_pagina()"><i class="fa fa-times-circle"></i> Cerrar</button>
						    <input type="submit" class="btn btn-primary" />
						</div>
					    </form>
					</div>
				    </div>
				</div>
                                
                                <div id="lightbox" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img src="" alt="" />
                                            </div>
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
		
		<!--Dropzone [ OPTIONAL ]-->
		<script src="../public/plugins/dropzone/dropzone.min.js"></script>
		
		<script type="text/javascript">
			function EditaCapacitacion(id, anio) {
				var parametros = {
					"id" : id,
					"anio" : anio,
				};
				$.ajax({
					data:  parametros,
					url:   'frm_modificar/modificar_capacitacion.php',
					type:  'post',
					beforeSend: function () {
                        $("#contenido_edita_capacitacion").html("Procesando, espere por favor...");
					},
					success:  function (response) {
                        $("#contenido_edita_capacitacion").html(response);
					}
				});
			}
			
			function VerDetalle(id, anio) {
				var parametros = {
					"codigo" : id,
					"anio" : anio,
				};
				$.ajax({
					data:  parametros,
					url:   'frm_modificar/detalle_capacitacion.php',
					type:  'post',
					beforeSend: function () {
                        $("#contenido_detalle").html("Procesando, espere por favor...");
					},
					success:  function (response) {
                        $("#contenido_detalle").html(response);
					}
				});
			}
			
			function recargar_pagina() 
			{
				location.reload();
			}
			
			$(document).ready(function (e) {
				// Function to preview image after validation
				$(function() {
					$("#file").change(function() {
						$("#message").empty(); // To remove the previous error message
						var ext = $("#file").val().split('.').pop().toLowerCase();
						if($.inArray(ext, ['pdf','doc','docx', 'ppt', 'pptx']) == -1) 
						{
							$("#message").html("<p id='error'>Por Favor Seleccione un archivo valido</p>"+"<h4>Nota</h4>"+"<span id='error_message'>Solamente *.pdf, *.doc, *.docx, *.ppt, *.pptx esta permitidos</span>");
							$("#file")
							return false;
						} 
						else
						{
							var reader = new FileReader();
							reader.onload = imageIsLoaded;
							reader.readAsDataURL(this.files[0]);
						}
					});
				});
				function imageIsLoaded(e) {
					$("#file").css("color","green");
					//$('#previewing').attr('height', '300px');
				};
			});
                        
                        $(document).ready(function () {
                            var $lightbox = $('#lightbox');

                            $('[data-target="#lightbox"]').on('click', function (event) {
                                var $img = $(this).find('img'),
                                        src = $img.attr('src'),
                                        alt = $img.attr('alt'),
                                        css = {
                                            'maxWidth': $(window).width() - 100,
                                            'maxHeight': $(window).height() - 100
                                        };

                                $lightbox.find('.close').addClass('hidden');
                                $lightbox.find('img').attr('src', src);
                                $lightbox.find('img').attr('alt', alt);
                                $lightbox.find('img').css(css);
                            });

                            $lightbox.on('shown.bs.modal', function (e) {
                                var $img = $lightbox.find('img');

                                $lightbox.find('.modal-dialog').css({'width': $img.width()});
                                $lightbox.find('.close').removeClass('hidden');
                            });
                        });
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
	
	<!-- Mirrored from www.themeon.net/nifty/v2.3/tables-datatable.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 09 Mar 2016 14:41:57 GMT -->
</html>

