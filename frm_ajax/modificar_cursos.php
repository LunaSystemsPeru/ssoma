<?php
    session_start();
	include ('../includes/conectar.php');

	$empleado = $_POST['empleado'];
    $curso = $_POST['curso'];
	$empresa = $_SESSION['empresa'];
    global $conn;
	$consulta = "select * from cursos where empleado = '".$empleado ."' and id = '".$curso."' and empresa = '".$empresa."'";
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$institucion = $fila['institucion'];
            $descripcion = $fila['descripcion'];
            $duracion = $fila['duracion'];
            $tipo_duracion = $fila['tipo_duracion'];
		}
	}
	//$resultado->close();
	
?>
<!--Modal header-->
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Modificacion de Cursos</h4>
</div>
<form class="form-horizontal" id="frm_modifica_cursos" action="inserts/modificar_cursos.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Id</label>
            <div class="col-lg-7">
                <input type="text" name="id_curso" id="id_curso" class="form-control" value="<?php echo $curso;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Institucion</label>
            <div class="col-lg-7">
                <input type="text" placeholder="Institucion" name="institucion" id="institucion" class="form-control" value='<?php echo $institucion;?>' required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Descripcion</label>
            <div class="col-lg-7">
                <input type="text" placeholder="Descripcion" name="descripcion" id="descripcion" class="form-control" value='<?php echo $descripcion;?>' required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Duracion</label>
            <div class="col-lg-3">
                <input type="number" placeholder="Duracion" name="duracion" id="duracion" class="form-control" value="<?php echo $duracion;?>"  required>
            </div>
            <div class="col-sm-3">
                <!-- Default Bootstrap Select -->
                <!--===================================================-->
                <select id="tipo_duracion" name="tipo_duracion" class="selectpicker">
                    <option value="HORAS" <?php if ($tipo_duracion=="HORAS" ) { echo "selected='selected'"; }?>>HORAS</option>
                    <option value="DIAS" <?php if ($tipo_duracion=="DIAS" ) { echo "selected='selected'"; }?>>DIAS</option>
                    <option value="SEMANAS" <?php if ($tipo_duracion=="SEMANAS" ) { echo "selected='selected'"; }?>>SEMANAS</option>
                    <option value="MESES" <?php if ($tipo_duracion=="MESES" ) { echo "selected='selected'"; }?>>MESES</option>
                    <option value="AÑOS" <?php if ($tipo_duracion=="AÑOS" ) { echo "selected='selected'"; }?>>AÑOS</option>
                </select>
                <!--===================================================-->
            </div>
        </div>
        <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $empleado;?>">
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        <button class="btn btn-primary" name="modificar_cursos">Guardar</button>
    </div>
</form>