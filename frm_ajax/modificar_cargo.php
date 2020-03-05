<?php 
	include ('../includes/conectar.php');
	
	$id = $_POST['codigo'];
	global $conn;
	$consulta = "select * from cargo where id =".$id;
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$nombres = $fila['nombre'];
			$jornal = $fila['jornal'];
		}
	}
	//$resultado->close();
	
?>
<!--Modal header-->
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Modificar Cargo</h4>
</div>
<form class="form-horizontal" id="frm_modifica_cargo" action="inserts/modificar_cargo.php" method="post">
	<!--Modal body-->
	<div class="modal-body">
		<div class="form-group">
			<label class="col-lg-3 control-label">Nombre</label>
			<div class="col-lg-7">
				<input type="text" placeholder="Nombre" name="nombre_db" id="nombre" value="<?php echo $nombres; ?>" class="form-control" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-3 control-label">Jornal</label>
			<div class="col-lg-7">
				<input type="number" min="1"  class="form-control" name="jornal_db" placeholder="Jornal" value="<?php echo $jornal; ?>" required >
			</div>
		</div>
	</div>
	
	<!--Modal footer-->
	<div class="modal-footer">
		<input type="hidden" name="codigo" value="<?php echo $id; ?>">
		<button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
		<input type="submit" class="btn btn-primary" name="modificar_cargo">
	</div>
</form>