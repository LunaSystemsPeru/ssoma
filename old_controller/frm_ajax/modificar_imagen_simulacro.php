<?php
session_start();
include('../includes/conectar.php');
include('../includes/varios.php');
$varios = new Varios();

$id = $_POST['id'];
$cod = str_pad($id, 3, '0', STR_PAD_LEFT);
$anio = $_POST['anio'];
$imagen = $_POST['imagen'];
$empresa = $_SESSION['empresa'];

global $conn;
$consulta = "select correlativo, descripcion from imagenes_simulacro where empresa = '" . $empresa . "' and id ='" . $id . "' and anio = '" . $anio . "' and imagen = '".$imagen."'";
$resultado = $conn->query($consulta);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $correlativo = $fila['correlativo'];
        $descripcion = $fila['descripcion'];
    }
}
//$resultado->close();
?>

<!--Modal header-->
<div class="modal-header">
    <button data-dismiss="modal" class="close" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Editar Datos de Imagenes</h4>
</div>
<form class="form-horizontal" id="frm_registra_evento" action="inserts/modificar_imagen_simulacro.php" method="post">
    <!--Modal body-->
    <div class="modal-body">
        <div class="col-lg-4">
            <img class="group list-group-image" style="max-width:100%" src="<?php echo 'upload/' . $empresa . '/simulacros/' . $anio . $cod . '/imagenes/' . $imagen; ?>" />
        </div>
        <div class="col-lg-7">
            <div class="form-group">
                <label class="col-lg-3 control-label">Imagen</label>
                <div class="col-lg-9">
                    <input type="text" value="<?php echo $imagen ?>" name="imagen" class="form-control" readonly="true">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Correlativo</label>
                <div class="col-lg-9">
                    <input type="number" min-value="1" min="1" value="<?php echo $correlativo ?>" name="correlativo" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Descripcion</label>
                <div class="col-lg-9">
                    <textarea class="form-control" cols="50" name="descripcion" placeholder="Descripcion de la Imagen"><?php echo $descripcion ?></textarea> 
                </div>
            </div>
        </div>
    </div>

    <!--Modal footer-->
    <div class="modal-footer">
        <input type="hidden" value="<?php echo $id; ?>" name="id" />
        <input type="hidden" value="<?php echo $anio; ?>" name="anio" />
        <button data-dismiss="modal" class="btn btn-default" type="button">Cerrar</button>
        <input type="submit" class="btn btn-primary" name="modifica_imagen">
    </div>
</form>