<?php
session_start();
include('../includes/conectar.php');
require('../includes/varios.php');

$varios = new Varios();

$id = $_POST['codigo'];
$anio = $_POST['anio'];
$tipo = $_POST['tipo'];
$empleado = $_SESSION['usuario'];
$empresa = $_SESSION['empresa'];

//global $conn;
$consulta = "select * from programa_monitoreo where empresa = '" . $empresa . "' and id = '" . $id . "' and anio = '" . $anio . "'";

$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $tipo = $fila['tipo'];
        $proveedor = $fila['proveedor'];
        if ($fila['estado'] == "0") {
            $estado = '<div class="label label-table label-warning">Pendiente</div>';
            $fecha_programacion = $varios->fecha_tabla($fila['fecha_programado']);
            $fecha_fin = "-";
        } else {
            $estado = '<div class="label label-table label-success">Realizado</div>';
            $fecha_programacion = "-";
            $fecha_fin = $varios->fecha_tabla($fila['fecha_ejecutado']);
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
    <h4 class="modal-title">Detalles del Programa de Monitoreo</h4>
</div>
<!--Modal body-->
<div class="modal-body">
    <form class="form-horizontal">
        <div class="form-group">
            <label class="col-lg-3 control-label">Empresa:</label>
            <div class="col-lg-7">
                <label class="form-control"><?php echo $proveedor?></label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Tipo:</label>
            <div class="col-lg-7">
                <label class="form-control"><?php echo $tipo?></label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fec. Programacion:</label>
            <div class="col-lg-7">
                <label class="form-control"><?php echo $fecha_programacion?></label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fec. Ejecucion:</label>
            <div class="col-lg-7">
                <label class="form-control"><?php echo $fecha_fin?></label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Estado:</label>
            <div class="col-lg-7">
                <label class="form-control"><?php echo $estado?></label>
            </div>
        </div>
        <div class="form-group">
            <a href="detalle_monitoreo.php?id=<?php echo $id; ?>&anio=<?php echo $anio; ?>&tipo=<?php echo $tipo; ?>" class="col-lg-3 control-label">clic para ver Detalle</a>
        </div>
    </form>
</div>
<!--Modal footer-->
<div class="modal-footer">
    <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
</div>
