<?php 
	include('../includes/conectar.php');
	
	$id = $_POST['codigo'];
	global $conn;
	$consulta = "select * from especializacion where id =".$id;
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$nombres = $fila['descripcion'];
			$porcentaje = $fila['porcentaje'];
		}
	}
	//$resultado->close();
	
?>
<!--Modal header-->
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Modificar Especializacion</h4>
</div>
<form class="form-horizontal" id="frm_modifica_especializacion" action="inserts/modificar_especializacion.php" method="post">
	<!--Modal body-->
	<div class="modal-body">
		<div class="form-group">
			<label class="col-lg-3 control-label">Nombre</label>
			<div class="col-lg-7">
				<input type="text" placeholder="Nombre" name="nombre_db" id="nombre" value="<?php echo $nombres; ?>" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Porcentaje</label>
			<div class="col-lg-7">
				<input type="number" min="0"  class="form-control" name="porcentaje_db" placeholder="Porcentaje" value="<?php echo $porcentaje; ?>" required >
			</div>
		</div>
	</div>
	
	<!--Modal footer-->
	<div class="modal-footer">
	<input type="hidden" name="codigo" value="<?php echo $id; ?>">
		<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
		<input type="submit" class="btn btn-primary" name="modificar_especializacion">
	</div>
</form>