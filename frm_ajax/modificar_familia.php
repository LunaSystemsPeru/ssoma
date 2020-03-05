<?php
    session_start();
	include ('../includes/conectar.php');
	require ('../includes/varios.php');
    
    $varios = new Varios();
	$empleado = $_POST['empleado'];
    $familiar = $_POST['familiar'];
	$empresa = $_SESSION['empresa'];
    global $conn;
	$consulta = "select * from datos_familiares where empleado = '".$empleado ."' and dni = '".$familiar."' and empresa = '".$empresa."'";
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$nombres = $fila['nombre_completo'];
			$dni = $fila['dni'];
            $direccion = $fila['direccion'];
            $telefono = $fila['telefono'];
            $sexo = $fila['sexo'];
            $parentesco = $fila['parentesco'];
            $fecha_nacimiento = $varios->fecha_tabla($fila['fecha_nacimiento']);
		}
	}
	//$resultado->close();
	
?>
<!--Modal header-->
<!--Modal header-->
<div class="modal-header">
	<button data-dismiss="modal" class="close" type="button">
		<span aria-hidden="true">&times;</span>
	</button>
	<h4 class="modal-title">Modificacion de Datos Familiares</h4>
</div>
<form class="form-horizontal" id="frm_modificar_familiar" action="inserts/modifica_familiar.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Nro DNI</label>
            <div class="col-lg-7">
                <input type="text" placeholder="Nro DNI" name="nro_dni" id="nro_dni" value="<?php echo $dni; ?>" class="form-control" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Nombres</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="nombres" value="<?php echo $nombres; ?>" placeholder="Nombres" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Direccion</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>" placeholder="Direccion" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Telefono / Celular</label>
            <div class="col-lg-7">
                <input type="text" id="celular" name="celular" class="form-control" value="<?php echo $telefono; ?>" placeholder="Nro Celular" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Sexo</label>
            <div class="col-sm-6">
                <!-- Default Bootstrap Select -->
                <!--===================================================-->
                <select id="sexo" name="sexo" class="selectpicker">
                    <option value="F" <?php if ($sexo=="F") { echo "selected='selected'"; }?>>FEMENINO</option>
                    <option value="M" <?php if ($sexo=="M") { echo "selected='selected'"; }?>>MASCULINO</option>
                </select>
                <!--===================================================-->
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Parentesco</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="parentesco" value="<?php echo $parentesco; ?>" placeholder="Parentesco" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Nacimiento</label>
            <div class="col-sm-6">
                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" class="form-control" placeholder="dd/mm/aaaa" required>
            </div>
        </div>
        <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $empleado;?>">
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        <button class="btn btn-primary" name="modificar_familiar">Guardar</button>
    </div>
</form>
<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>