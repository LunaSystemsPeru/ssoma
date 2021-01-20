<?php
session_start();
include('../includes/conectar.php');
require('../includes/varios.php');
require('../includes/rotations.php');
define('FPDF_FONTPATH', '../includes/font/');

class PDF extends PDF_Rotate {

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

}

$varios = new Varios();
$empresa = $_SESSION['empresa'];
$empleado = $_GET['empleado'];

$ver_datos = "select he.id, he.empresa, e.razon_social, he.fecha_entrega, t.dni, t.nombres, car.nombre as cargo "
        . "from historial_epp as he "
        . "inner join empresa as e on he.empresa = e.ruc "
        . "inner join empleado as t on he.empleado = t.codigo and he.empresa = t.empresa "
        . "inner join cargo as car on t.cargo = car.id "
        . "where he.empresa = '" . $empresa . "' and he.empleado = '" . $empleado . "'";
$resultado = $conn->query($ver_datos);
if ($resultado->num_rows > 0) {
    if ($fila = $resultado->fetch_assoc()) {
        $codigo = $fila['id'];
        $ruc = $fila['empresa'];
        $razon_social = $fila['razon_social'];
        $fecha_entrega = $varios->fecha_tabla($fila['fecha_entrega']);
        $dni = $fila['dni'];
        $trabajador = $fila['nombres'];
        $cargo = $fila['cargo'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$imagen = "MEMBRETE_SUPERIOR_FISHONE.jpg";
$pdf->Image('../upload/' . $empresa . '/documentos/' . $imagen, 0, 0, 230, 35);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(250, 250, 250);
$pdf->Cell(195, 5, "NOTA DE SALIDA - ENTREGA DE EPP", 0, 1, 'R');
$pdf->Cell(195, 5, "Pagina 1 de 1", 0, 1, 'R');

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, "NRO DNI:", 0, 0, 'L');
$pdf->Cell(80, 5, $dni, 0, 0, 'L');
$pdf->Cell(20, 5, "FECHA:", 0, 0, 'R');
$pdf->Cell(20, 5, date('d/m/Y'), 0, 1, 'L');
$pdf->Cell(40, 5, "NOMBRES Y APELLIDOS:", 0, 0, 'L');
$pdf->Cell(80, 5, $trabajador, 0, 0, 'L');
$pdf->Cell(20, 5, "CODIGO:", 0, 0, 'R');
$pdf->Cell(20, 5, $codigo, 0, 1, 'L');
$pdf->Cell(40, 5, "CARGO:", 0, 0, 'L');
$pdf->Cell(80, 5, $cargo, 0, 1, 'L');

$pdf->Ln(5);
$pdf->Cell(40, 5, "Detalle de Entrega:", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "Id EPP", 0, 0, 'C');
$pdf->Cell(60, 5, "Descripcion", 0, 0, 'C');
$pdf->Cell(40, 5, "F. Entrega", 0, 0, 'C');
$pdf->Cell(40, 5, "F. Devolucion", 0, 1, 'C');
$pdf->SetFont('Arial', '', 9);

$ver_epps = "select dhe.epp as codigo_epp, e.nombre as epp, e.duracion, he.fecha_entrega, adddate(he.fecha_entrega, interval e.duracion day) as fecha_devolucion "
        . "from detalle_historial_epp as dhe "
        . "inner join epp as e on dhe.epp = e.id "
        . "inner join historial_epp as he on dhe.id = he.id and dhe.empresa = he.empresa and dhe.empleado = he.empleado "
        . "where he.empresa = '" . $empresa . "' and he.empleado = '" . $empleado . "' "
        . "order by fecha_devolucion desc";
$resultado = $conn->query($ver_epps);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $codigo_epp = $fila['codigo_epp'];
        $nombre_epp = $fila['epp'];
        $devolucion = $fila['fecha_devolucion'];
        $entrega = $fila['fecha_entrega'];
        $pdf->Cell(30, 5, $codigo_epp, 0, 0, 'C');
        $pdf->Cell(60, 5, $nombre_epp, 0, 0, 'L');
        $pdf->Cell(40, 5, $varios->fecha_tabla($entrega), 0, 0, 'C');
        $pdf->Cell(40, 5, $varios->fecha_tabla($devolucion), 0, 1, 'C');
    }
}
$pdf->SetFont('Arial', '', 8);
$pdf->RotatedText(10, 240, "SST-REG-150     Vr. 01      Fec. Aprob.: 03/10/2016", 90);
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(-25);
$pdf->Cell(190, 5, "______________", 0, 1, 'C');
$pdf->Cell(190, 5, "Firma y Huella", 0, 1, 'C');
$pdf->Cell(190, 5, "DNI: " . $dni, 0, 1, 'C');
$pdf->Output();
?>
