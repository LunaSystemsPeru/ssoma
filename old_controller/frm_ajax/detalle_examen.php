<?php 
    session_start();
	include('../includes/conectar.php');
    require('../includes/varios.php');
    
    $varios = new Varios();
	
	$id = $_POST['id_examen'];
    $empleado = $_POST['id_empleado'];
    $empresa = $_SESSION['empresa'];
	
    //global $conn;
	$consulta = "select archivo, current_date as fecha_actual, observaciones, fecha_evaluacion, date_add(fecha_evaluacion, INTERVAL 2 YEAR) as fecha_renovacion, resultado, evaluador from examen_medico where id = '".$id."' and empleado = '".$empleado."' and empresa = '".$empresa."'";

	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
            $archivo = $fila['archivo'];
			$evaluador = $fila['evaluador'];
            $res_examen = $fila['resultado'];
            $fecha_evaluacion = $varios->fecha_tabla($fila['fecha_evaluacion']);
            $fecha_renovacion = $varios->fecha_tabla($fila['fecha_renovacion']);
            $observaciones = $fila['observaciones'];
            $fecha_renovacion_larga = strtotime($varios->fecha_larga($fila['fecha_renovacion'])); 
            $fecha_actual_larga = strtotime($varios->fecha_larga($fila['fecha_actual']));
            if ($fecha_renovacion_larga > $fecha_actual_larga) {
                $estado = '<span class="label label-success">VIGENTE</span>';
            } else {
                $estado = '<span class="label label-danger">POR RENOVAR</span>';
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
<h4 class="modal-title">Detalles del Examen Medico</h4>
</div>
<!--Modal body-->
<div class="modal-body">
    <form class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-3 control-label">Evaluadora:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $evaluador; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Resultado:</label>
        <div class="col-lg-7">
            <label class="form-control"> <?php echo $res_examen; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fec. Evaluacion:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $fecha_evaluacion; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fec. Renovacion:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $fecha_renovacion; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Observaciones:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $observaciones; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Documento:</label>
        <div class="col-lg-7">
            <label class="form-control"><a href="<?php echo 'upload/'.$empresa.'/examen/'.$archivo; ?>" class="btn-link"><?php echo $archivo; ?></a></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Estado:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $estado; ?></label>
        </div>
    </div>
    </form>
</div>
<!--Modal footer-->
<div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
</div>