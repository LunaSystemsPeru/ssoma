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
	$consulta = "select ps.*, e.nombres, e.ape_pat, e.ape_mat from programa_simulacros as ps inner join empleado as e on ps.observador = e.codigo and ps.empresa = e.empresa where ps.empresa = '".$empresa."' and ps.id = '".$id."' and ps.anio = '".$anio."'";

	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$tipo = $fila['tipo'];
			$observador = $fila['nombres'] . ' ' . $fila['ape_pat'] . ' ' . $fila['ape_mat'];
		   	$fecha_programacion = $varios->fecha_hora_tabla($fila['fecha_programado']);
		   	$fecha_inicio = $varios->fecha_hora_tabla($fila['fecha_ejecutado']);
		   	$lugar = $fila['lugar'];
		   	$simulacion = $fila['simulacion_creada'];
		   	if ($fila['estado'] == "0") {
				$estado = '<div class="label label-table label-warning">Pendiente</div>';
				$fecha_fin = '-';
			} else {
				$estado = '<div class="label label-table label-success">Realizado</div>';
				$fecha_fin = $varios->fecha_hora_tabla($fila['fecha_fin_ejecutado']);
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
<h4 class="modal-title">Detalles del Simulacro</h4>
</div>
<!--Modal body-->
<div class="modal-body">
    <form class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-3 control-label">Observador:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $observador; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Lugar:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $lugar; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fec. Programacion:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $fecha_programacion; ?></label>
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
            <label class="form-control"><?php echo $estado?></label>
        </div>
    </div>
    <div class="form-group">
        <a href="detalle_simulacro.php?id=<?php echo $id; ?>&anio=<?php echo $anio; ?>" class="col-lg-6 btn_link control-label">clic para ver mas detalles</a>
    </div>
    </form>
</div>
<!--Modal footer-->
<div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
</div>
