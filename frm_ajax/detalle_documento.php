<?php 
    session_start();
	include ('../includes/conectar.php');
    require ('../includes/varios.php');
    
    $varios = new Varios();
	
	$id = $_POST['id'];
	$id_tipo = $_POST['id_tipo'];
	$id_clase = $_POST['id_clase'];		
    	$empleado = $_SESSION['usuario'];
    	$empresa = $_SESSION['empresa'];
	
	global $conn;
	$consulta = "select d.tipo, d.nombre, d.version, d.archivo, d.fecha_creacion, cd.nombre as clase_nombre from documentos as d inner join clase_documentos as cd on d.clase = cd.id where d.tipo = '".$id_tipo."' and d.clase = '".$id_clase."' and d.id = '".$id."' and d.empresa = '".$empresa."'";
	//echo $consulta;
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
	            $tipo = $fila['tipo'];
	            $clase = $fila['clase_nombre'];
	            $documento = $fila['nombre'];
	            $version = $fila['version'];
	            $fecha_creacion = $fila['fecha_creacion'];
	            $archivo = $fila['archivo'];
		    $estado = '<span class="label label-success">VIGENTE</span>';
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
<h4 class="modal-title">Detalles del Documento</h4>
</div>
<!--Modal body-->
<div class="modal-body">
    <form class="form-horizontal">
    <div class="form-group">
        <label class="col-lg-3 control-label">Tipo:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $tipo; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Clase:</label>
        <div class="col-lg-7">
            <label class="form-control"> <?php echo $clase; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Codigo:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $id; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Nombre:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $documento; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Fecha Creacion:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $fecha_creacion; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Version:</label>
        <div class="col-lg-7">
            <label class="form-control"><?php echo $version; ?></label>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-3 control-label">Documento:</label>
        <div class="col-lg-7">
            <label class="form-control"><a href="<?php echo 'upload/'.$empresa.'/documentos/'.$archivo; ?>" class="btn-link"><?php echo $archivo; ?></a></label>
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
