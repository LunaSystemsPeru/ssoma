<?php

ob_start();
session_start();
include('../includes/conectar.php');
require('../includes/varios.php');
require('../includes/rotations.php');
define('FPDF_FONTPATH', '../includes/font/');

class PDF extends PDF_Rotate {

    //Cabecera de página
    function Header() {
        $empresa = $_SESSION['empresa'];
        $imagen = "MEMBRETE_SUPERIOR_FISHONE.jpg";
        $this->Image('../upload/' . $empresa . '/documentos/' . $imagen, 0, 0, 230, 35);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(250, 250, 250);
        $this->SetX(65);
        $this->MultiCell(140, 5, "REGISTRO DE ASISTENCIA - CAPACITACION / INDUCCION / ENTRENAMIENTO / SIMULAGROS Y EMERGENCIA", 0, 'R');
        $this->Cell(195, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(8, 270, "SST-REG-010     Vr. 01      Fec. Aprob.: 03/10/2016", 90);
    }

}

$varios = new Varios();
$id = $_GET['id'];
$empresa = $_SESSION['empresa'];
$anio = $_GET['anio'];

$ver_datos = "select ps.*, e.nombres, e.ape_pat, e.ape_mat from programa_simulacros as ps inner join empleado as e on ps.observador = e.codigo and ps.empresa = e.empresa "
        . "where ps.id='" . $id . "' and ps.anio = '" . $anio . "' and ps.empresa = '" . $empresa . "'";
$r_capacitaciones = $conn->query($ver_datos);
if ($r_capacitaciones->num_rows > 0) {
    while ($fila = $r_capacitaciones->fetch_assoc()) {
        $tipo = $fila['tipo'];
        $lugar = $fila['lugar'];
        $observador = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->Ln(13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "OBSERVADOR:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $observador, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "FECHA:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, "___ / ___ / ______", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "DURACION:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, "_______  horas", 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "TIPO:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, "SIMULACRO", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "LUGAR:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $lugar, 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 5, "TIPO:", 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 5, $tipo, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(195, 6, "RELACION DE COLABORADORES", 0, 1, 'C');
$pdf->Cell(15, 6, "Item", 1, 0, 'C');
$pdf->Cell(15, 6, "COD", 1, 0, 'C');
$pdf->Cell(125, 6, "APELLIDOS Y NOMBRES", 1, 0, 'C');
$pdf->Cell(40, 6, "FIRMA", 1, 1, 'C');
$pdf->SetFont('Arial', '', 9);
for ($index_fila = 0; $index_fila < 25; $index_fila++) {
    $pdf->Cell(15, 8,$index_fila + 1 , 1, 0, 'C');
    $pdf->Cell(15, 8,"", 1, 0, 'C');
    $pdf->Cell(125, 8,"", 1, 0, 'L');
    $pdf->Cell(40, 8, "", 1, 1, 'C');
}

$pdf->Output();
ob_end_flush();
?>
