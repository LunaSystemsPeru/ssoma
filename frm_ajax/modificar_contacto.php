<?php
    session_start();
	include ('../includes/conectar.php');

	$empleado = $_POST['empleado'];
    $contacto = $_POST['contacto'];
	$empresa = $_SESSION['empresa'];
    global $conn;
	$consulta = "select * from contacto_emergencia where empleado = '".$empleado ."' and id = '".$contacto."' and empresa = '".$empresa."'";
	$resultado = $conn->query($consulta); 
	if ($resultado->num_rows > 0) 
	{
		while ($fila = $resultado->fetch_assoc()) 
		{
			$nombres = $fila['nombre_completo'];
            $direccion = $fila['direccion'];
            $telefono = $fila['telefono'];
            $sexo = $fila['sexo'];
            $parentesco = $fila['parentesco'];
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
	<h4 class="modal-title">Modificacion de Contacto de Emergencia</h4>
</div>
<form class="form-horizontal" id="frm_modificar_contacto" action="inserts/modifica_contacto.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Codigo</label>
            <div class="col-lg-7">
                <input type="text" placeholder="Codigo" name="contacto" id="contacto" value="<?php echo $contacto; ?>" class="form-control" readonly="true">
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
        <input type="hidden" id="empleado" name="empleado" class="form-control" value="<?php echo $empleado;?>">
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
        <button class="btn btn-primary" name="modificar_contacto">Guardar</button>
    </div>
</form>
<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>