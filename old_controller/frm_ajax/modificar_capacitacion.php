<?php 
	session_start();
	include('../includes/conectar.php');
	include('../includes/varios.php');
	$varios = new Varios();
	
	$id = $_POST['id'];
	$anio = $_POST['anio'];	
	$empresa = $_SESSION['empresa'];
	
	global $conn;
	$consulta = "select tema, expositor, fecha_programado, duracion from programa_capacitaciones where empresa = '".$empresa."' and id ='".$id."' and anio = '".$anio."'";
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$tema = $fila['tema'];
			$expositor = $fila['expositor'];
			$duracion = $fila['duracion'];
			$fecha_programa = $varios->fecha_hora_tabla($fila['fecha_programado']);
		}
	}
	//$resultado->close();
	
?>
<!--Modal header-->
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Modificar Capacitacion</h4>
</div>
<form class="form-horizontal" id="frm_modifica_capacitacion" action="inserts/modificar_capacitacion.php" method="post">
	<!--Modal body-->
	<div class="modal-body">
		<div class="form-group">
			<label class="col-lg-3 control-label">Tema</label>
			<div class="col-lg-7">
				<input type="text" placeholder="Tema" name="tema" class="form-control" value="<?php echo $tema?>" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Expositor</label>
			<div class="col-lg-7">
				<input type="text" placeholder="Expositor" name="expositor" value="<?php echo $expositor?>" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Fecha Programado</label>
			<div class="col-lg-7">
				<input type="text"class="form-control" id="fecha_evento" name="fecha_evento" placeholder="dd/mm/aaaa hh:mm" value="<?php echo $fecha_programa?>" required >
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Duracion</label>
			<div class="col-lg-3">
				<input type="text" class="form-control" name="duracion" value="<?php echo $duracion?>" required >
			</div>
			<label class="col-lg-3 control-label">Horas</label>
		</div>
	</div>

	<!--Modal footer-->
	<div class="modal-footer">
		<input type="hidden" value="<?php echo $id?>" name="id">
		<input type="hidden" value="<?php echo $anio?>" name="anio">
		<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
		<input type="submit" class="btn btn-primary" name="graba_modificacion">
	</div>
</form>
