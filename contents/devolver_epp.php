<?php 
	include('includes/conectar.php');
	require('includes/varios.php');
	
	$varios = new Varios();
	
	$entrega = $_POST['id_entrega'];
	$epp = $_POST['id_epp'];
	$empleado = $_POST['id_empleado'];
	$empresa = $_POST['id_empresa'];
	
	global $conn;
	$historial= "select he.id as id_entrega, e.nombre, e.id, e.duracion, he.fecha_entrega, ADDDATE(he.fecha_entrega, INTERVAL e.duracion DAY) as fecha_retorno, dhe.fecha_devolucion, dhe.estado from detalle_historial_epp as dhe inner join historial_epp as he on dhe.id = he.id and dhe.empresa = he.empresa and dhe.empleado = he.empleado inner join epp as e on dhe.epp = e.id where dhe.empleado = '".$empleado."' and dhe.empresa = '".$empresa."' and dhe.epp = '".$epp."' and dhe.id = '".$entrega."'";
	
	$resultado = $conn->query($historial); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$nombre_epp = $fila['nombre'];
			$fecha_entrega = $varios->fecha_tabla($fila['fecha_entrega']);
			$fecha_retorno = $varios->fecha_tabla($fila['fecha_retorno']);
		}
	}
	//$resultado->close();
	
?>
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Devolucion de EPPs</h4>
</div>
<form class="form-horizontal" id="frm_epp" action="../old_controller/devolver_epp.php" method="post">
	<div class="modal-body">
		<div class="form-group">
			<label class="col-lg-3 control-label">Id</label>
			<div class="col-lg-7">
				<input type="text" name="id_epp" id="id_epp" class="form-control" value="<?php echo $epp?>" readonly="true">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Nombre</label>
			<div class="col-lg-7">
				<input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre_epp?>" readonly="true">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Fecha Entrega</label>
			<div class="col-lg-7">
				<input type="text" class="form-control" name="fecha_entrega" value="<?php echo $fecha_entrega?>" readonly="true">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Fecha Devolucion Aprox.</label>
			<div class="col-lg-7">
				<input type="text" class="form-control" name="fecha_devolucion_aprox" value="<?php echo $fecha_retorno?>" readonly="true">
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Fecha Devolucion</label>
			<div class="col-lg-7">
				<input type="text"class="form-control" name="fecha_devolucion" id="fecha_devolucion" placeholder="dd/mm/aaaa" required >
			</div>
		</div>
		<input type="hidden" name="id_entrega" value="<?php echo $entrega?>">
		<input type="hidden" name="id_empresa" value="<?php echo $empresa?>">
		<input type="hidden" name="id_empleado" value="<?php echo $empleado?>">
	</div>
	<div class="modal-footer">
		<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
		<input type="submit" class="btn btn-primary" name="devolver_epp">
	</div>
</form>