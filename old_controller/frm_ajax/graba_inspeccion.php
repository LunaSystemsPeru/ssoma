<?php
session_start();
include("../includes/conectar.php");
require("../includes/varios.php");

$empresa = $_SESSION['empresa'];
$id = $_POST['id'];
$anio = $_POST['anio'];
$item = $_POST['item'];
$tipo = $_POST['tipo'];

switch ($tipo) {
    case "EPP":
        $tabla = "inspeccion_epp";
        $pagina = "inspeccion_epp";
        break;
    case "ALMACEN":
        $tabla = "inspeccion_almacen";
        $pagina = "inspeccion_almacen";
        break;
    case "BOTIQUIN":
        $tabla = "inspeccion_botiquin";
        $pagina = "inspeccion_botiquin";
        break;
    case "EXTINTORES":
        $tabla = "inspeccion_extintores";
        $pagina = "inspeccion_extintor";
        break;
    case "OFICINAS":
        $tabla = "inspeccion_oficina";
        $pagina = "inspeccion_oficina";
        break;
    case "ORDEN Y LIMPIEZA":
        $tabla = "inspeccion_limpieza";
        $pagina = "inspeccion_limpieza";
        break;
    case "TRABAJO":
        $tabla = "inspeccion_trabajo";
        $pagina = "inspeccion_trabajo";
        break;
    case "SSHH":
        $tabla = "inspeccion_sshh";
        $pagina = "inspeccion_sshh";
        break;
}

$ver_datos = "select ie.*, e.nombres, e.ape_pat, e.ape_mat from " . $tabla . " as ie inner join empleado as e on ie.empresa = e.empresa "
        . "and ie.inspector = e.codigo where ie.id = '" . $id . "' and ie.anio = '" . $anio . "' and ie.empresa = '" . $empresa . "' and item = '" . $item . "'";
//echo $ver_datos;
$resultado = $conn->query($ver_datos);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $area = $fila ['area'];
        $local = $fila ['local'];
    }
}
?>
<!--Modal header-->
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Grabar Inspeccion</h4>
</div>
<form class="form-horizontal" id="frm_grabar" action="inserts/graba_inspeccion.php" enctype="multipart/form-data" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="form-group">
            <label class="col-lg-3 control-label">Area</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="area" value="<?php echo $area ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Local</label>
            <div class="col-lg-7">
                <input type="text" class="form-control" name="local" value="<?php echo $local ?>" readonly="true">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Fecha de Ejecucion</label>
            <div class="col-lg-7">
                <input type="text" placeholder="dd/mm/aaaa" name="fecha" id="fecha_ejecucion" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label">Subir Archivo</label>
            <div class="col-lg-7">
                <input class="btn btn-default" type="file" name="file" id="file" required/>
                <div id="message"></div>
            </div>
        </div>
    </div>
    <!--Modal footer-->
    <div class="modal-footer">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="anio" value="<?php echo $anio; ?>">
        <input type="hidden" name="tipo" value="<?php echo $tipo; ?>">
        <input type="hidden" name="item" value="<?php echo $item; ?>">
        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
        <input type="submit" class="btn btn-primary" name="graba_inspeccion">
    </div>
</form>
