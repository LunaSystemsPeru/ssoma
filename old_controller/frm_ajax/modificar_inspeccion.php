<?php
session_start();
include('../includes/conectar.php');
include('../includes/varios.php');
$varios = new Varios();

$id = $_POST['id'];
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];
$empresa = $_SESSION['empresa'];

global $conn;
$consulta = "select * from programa_inspecciones where empresa = '" . $empresa . "' and id = '" . $id . "' "
        . "and anio = '" . $anio . "' and tipo = '" . $tipo . "'";
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $fecha = $varios->fecha_tabla($fila['fecha_programa']);
        $frecuencia = $fila['frecuencia'];
    }
}
$conn->close();
?>
<!--Modal header-->
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Modificar Inspeccion </h4>
</div>
<form class="form-horizontal" id="frm_modifica_inspeccion" action="inserts/modificar_inspeccion.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Tipo</label>
            <div class="col-lg-7">
                <input type="text" name="tipo" class="form-control" value="<?php echo $tipo ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha Programacion</label>
            <div class="col-lg-7">
                <input type="text" placeholder="dd/mm/aaa" name="fecha" value="<?php echo $fecha?>" id="fecha_registro" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Frecuencia</label>
            <div class="col-lg-7">
                <select class="selectpicker" name="frecuencia">
                    <option value="SEMANAL" <?php if ($frecuencia=="SEMANAL" ) { echo "selected='selected'"; }?>>SEMANAL</option>
                    <option value="QUINCENAL" <?php if ($frecuencia=="QUINCENAL" ) { echo "selected='selected'"; }?>>QUINCENAL</option>
                    <option value="MENSUAL" <?php if ($frecuencia=="MENSUAL" ) { echo "selected='selected'"; }?>>MENSUAL</option>
                    <option value="TRIMESTRAL" <?php if ($frecuencia=="TRIMESTRAL" ) { echo "selected='selected'"; }?>>TRIMESTRAL</option>
                    <option value="SEMESTRAL" <?php if ($frecuencia=="SEMESTRAL" ) { echo "selected='selected'"; }?>>SEMESTRAL</option>
                    <option value="ANUAL" <?php if ($frecuencia=="ANUAL" ) { echo "selected='selected'"; }?>>ANUAL</option>
                </select>
            </div>
        </div>
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <input type="hidden" value="<?php echo $id ?>" name="id">
        <input type="hidden" value="<?php echo $anio ?>" name="anio">
        <input type="hidden" value="<?php echo $tipo ?>" name="tipo">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
        <input type="submit" class="btn btn-primary" name="modificar_inspeccion">
    </div>
</form>
