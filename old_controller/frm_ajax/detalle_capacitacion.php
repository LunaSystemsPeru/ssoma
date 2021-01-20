<?php 
    session_start();
    include('../includes/conectar.php');
    require('../includes/varios.php');
    
    $varios = new Varios();
	
	$id = $_POST['codigo'];
	$anio = $_POST['anio'];	
    $empleado = $_SESSION['usuario'];
    $empresa = $_SESSION['empresa'];
	
    //global $conn;
	$consulta = "select id, anio, tema, expositor, fecha_programado, date_add(fecha_programado, interval duracion hour) as fecha_termino, fecha_ejecutado, fecha_fin, estado from programa_capacitaciones where empresa = '".$empresa."' and id = '".$id."' and anio = '".$anio."'";

	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$tema = $fila['tema'];
			$expositor = $fila['expositor'];
		    if ($fila['estado'] == "0") {
			$estado = '<div class="label label-table label-warning">Pendiente</div>';
			$activo = "";
			$fecha_inicio = $varios->fecha_hora_tabla($fila['fecha_programado']);
			$fecha_fin = $varios->fecha_hora_tabla($fila['fecha_termino']);
			} else {
			$estado = '<div class="label label-table label-success">Realizado</div>';
			$activo = "disabled";
			$fecha_inicio = $varios->fecha_hora_tabla($fila['fecha_ejecutado']);
			$fecha_fin = $varios->fecha_hora_tabla($fila['fecha_fin']);
		}
		}
	} else {
		echo "0 resultados";
	}
	$conn->close();
	
?>
<!--Modal header-->
<div class="modal-header">
<button data-dismiss="modal" class="close" type="button">
    <span aria-hidden="true">&times;</span>
</button>
<h4 class="modal-title">Detalles de la Capacitacion</h4>
</div>
<!--Modal body-->
<div class="modal-body">
    <form class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-3 control-label">Expositor:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $expositor; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Tema:</label>
        <div class="col-lg-7">
            <label class="form-control"> <?php echo $tema; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fec. Programacion:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $fecha_inicio; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fec. Fin:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $fecha_fin; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Estado:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $estado; ?></label>
        </div>
    </div>
    <div class="form-group">
        <a href="detalle_capacitacion.php?id=<?php echo $id; ?>&anio=<?php echo $anio; ?>" class="col-lg-6 btn-link control-label">clic para ver mas detalles</a>
    </div>
    </form>
</div>
<!--Modal footer-->
<div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
</div>
