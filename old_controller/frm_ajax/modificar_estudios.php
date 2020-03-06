<?php
    session_start();
	include('../includes/conectar.php');

	$empleado = $_POST['empleado'];
    $estudio = $_POST['estudio'];
	$empresa = $_SESSION['empresa'];
    global $conn;
	$consulta = "select * from estudios where empleado = '".$empleado ."' and id = '".$estudio."' and empresa = '".$empresa."'";
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$institucion = $fila['institucion'];
            $tipo = $fila['tipo'];
            $grado = $fila['grado'];
		}
	}
	//$resultado->close();
	
?>
<!--Modal header-->
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Modificacion de Estudios</h4>
</div>
<form class="form-horizontal" id="frm_graba_estudios" action="inserts/modificar_estudios.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Id</label>
            <div class="col-lg-7">
                <input type="text" name="id_estudios" id="id_estudios" class="form-control" value="<?php echo $estudio;?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Institucion</label>
            <div class="col-lg-7">
                <input type="text" placeholder="Institucion" name="institucion" id="institucion" class="form-control" value='<?php echo $institucion;?>' required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Tipo</label>
            <div class="col-sm-6">
                <!-- Default Bootstrap Select -->
                <!--===================================================-->
                <select id="tipo" name="tipo" class="selectpicker">
                    <option value="PRIMARIA" <?php if ($tipo=="PRIMARIA" ) { echo "selected='selected'"; }?>>PRIMARIA</option>
                    <option value="SECUNDARIA" <?php if ($tipo=="SECUNDARIA" ) { echo "selected='selected'"; }?>>SECUNDARIA</option>
                    <option value="TECNICO SUPERIOR" <?php if ($tipo=="TECNICO SUPERIOR" ) { echo "selected='selected'"; }?>>TECNICO SUPERIOR</option>
                    <option value="SUPERIOR" <?php if ($tipo=="SUPERIOR" ) { echo "selected='selected'"; }?>>SUPERIOR</option>
                </select>
                <!--===================================================-->
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Grado</label>
            <div class="col-sm-6">
                <!-- Default Bootstrap Select -->
                <!--===================================================-->
                <select id="grado" name="grado" class="selectpicker">
                    <option value="COMPLETO" <?php if ($grado=="COMPLETO" ) { echo "selected='selected'"; }?>>COMPLETO</option>
                    <option value="INCOMPLETO" <?php if ($grado=="INCOMPLETO" ) { echo "selected='selected'"; }?>>INCOMPLETO</option>
                    <option value="BACHILER" <?php if ($grado=="BACHILLER" ) { echo "selected='selected'"; }?>>BACHILER</option>
                    <option value="TITULADO" <?php if ($grado=="TITULADO" ) { echo "selected='selected'"; }?>>TITULADO</option>
                    <option value="EGRESADO" <?php if ($grado=="EGRESADO" ) { echo "selected='selected'"; }?>>EGRESADO</option>
                </select>
                <!--===================================================-->
            </div>
        </div>
        <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $empleado;?>">
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        <button class="btn btn-primary" name="modificar_estudios">Guardar</button>
    </div>
</form>
<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>