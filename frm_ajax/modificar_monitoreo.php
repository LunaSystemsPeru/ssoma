<?php
session_start();
include ('../includes/conectar.php');
include ('../includes/varios.php');
$varios = new Varios();

$id = $_POST['id'];
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];
$empresa = $_SESSION['empresa'];

global $conn;
$consulta = "select * from programa_monitoreo where empresa = '" . $empresa . "' and id = '" . $id . "' and anio = '" . $anio . "'";
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $proveedor = $fila['proveedor'];
        $tipo = $fila['tipo'];
        $fecha = $varios->fecha_tabla($fila['fecha_programado']);
    }
}
$conn->close();
?>
<!--Modal header-->
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Modifcar Monitoreo</h4>
</div>
<form class="form-horizontal" id="frm_modifica_monitoreo" action="inserts/modificar_monitoreo.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Tipo</label>
            <div class="col-lg-7">
                <select id="tipo_monitoreo" name="tipo_monitoreo" class="selectpicker">
                    <option value="AGENTES FISICOS" <?php if ($tipo == "AGENTES FISCOS"){echo "selected='selected'";}?>>AGENTES FISCOS</option>
                    <option value="AGENTES QUIMICOS" <?php if ($tipo == "AGENTES QUIMICOS"){echo "selected='selected'";}?>>AGENTES QUIMICOS</option>
                    <option value="AGENTES BIOLOGICOS" <?php if ($tipo == "AGENTES BIOLOGICOS"){echo "selected='selected'";}?>>AGENTES BIOLOGICOS</option>
                    <option value="AGENTES PSICOSOCIALES" <?php if ($tipo == "AGENTES PSICOSOCIALES"){echo "selected='selected'";}?>>AGENTES PSICOSOCIALES</option>
                    <option value="RIESGOS DISERGONOMICOS" <?php if ($tipo == "AGENTES DISERGONOMICOS"){echo "selected='selected'";}?>>RIESGOS DISERGONOMICOS</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Empresa</label>
            <div class="col-lg-7">
                <input type="text" placeholder="Empresa" name="proveedor" value="<?php echo $proveedor?>" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Programacion</label>
            <div class="col-lg-3">
                <input type="text"class="form-control" id="fecha_registro" name="fecha_inicio" value="<?php echo $fecha?>" placeholder="dd/mm/aaaa" required >
            </div>
        </div>
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <input type="hidden" value="<?php echo $id ?>" name="id">
        <input type="hidden" value="<?php echo $anio ?>" name="anio">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
        <input type="submit" class="btn btn-primary" name="modificar_monitoreo">
    </div>
</form>
