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
        $imagen = "MEMBRETE_HORIZONTAL_FISHONE.png";
        $this->Image('../upload/' . $empresa . '/documentos/' . $imagen, 0, 0, 297, 35);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(250, 250, 250);
        $this->Cell(280, 5, "REGISTRO DE CHARLAS DE SEGURIDAD", 0, 1, 'R');
        $this->Cell(280, 5, "Pagina " . $this->PageNo() . " de {nb}", 0, 1, 'R');
        $this->Ln(13);
    }

    function Footer() {
        $this->SetFont('Arial', '', 8);
        $this->RotatedText(6, 170, "SST-REG-010     Vr. 01      Fec. Aprob.: 23/07/2016", 90);
    }
}

$varios = new Varios();

$empresa = $_SESSION['empresa'];

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(20, 8, "LUGAR:", 0, 0, 'L');
$pdf->Cell(220, 8, ":________________________________________________________________________", 0, 1, 'L');

$pdf->Cell(20, 8, "FECHA", 1, 0, 'C');
$pdf->Cell(100, 8, "TEMA", 1, 0, 'C');
$pdf->Cell(30, 8, "DURACION", 1, 0, 'C');
$pdf->Cell(95, 8, "EXPOSITOR", 1, 0, 'C');
$pdf->Cell(30, 8, "FIRMA", 1, 1, 'C');

$pdf->Cell(20, 8, "", 1, 0, 'C');
$pdf->Cell(100, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 0, 'C');
$pdf->Cell(95, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 1, 'C');

$pdf->Cell(20, 8, "", 1, 0, 'C');
$pdf->Cell(100, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 0, 'C');
$pdf->Cell(95, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 1, 'C');

$pdf->Cell(20, 8, "", 1, 0, 'C');
$pdf->Cell(100, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 0, 'C');
$pdf->Cell(95, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 1, 'C');

$pdf->Cell(20, 8, "", 1, 0, 'C');
$pdf->Cell(100, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 0, 'C');
$pdf->Cell(95, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 1, 'C');

$pdf->Cell(20, 8, "", 1, 0, 'C');
$pdf->Cell(100, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 0, 'C');
$pdf->Cell(95, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 1, 'C');

$pdf->Cell(20, 8, "", 1, 0, 'C');
$pdf->Cell(100, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 0, 'C');
$pdf->Cell(95, 8, "", 1, 0, 'C');
$pdf->Cell(30, 8, "", 1, 1, 'C');

$pdf->Ln(5);
//CARGAR EMPLEADOS

$pdf->Cell(15, 8, "CODIGO", 1, 0, 'C');
$pdf->Cell(110, 8, "APELLIDOS Y NOMBRES", 1, 0, 'C');
$pdf->Cell(25, 8, "___/___/______", 1, 0, 'C');
$pdf->Cell(25, 8, "___/___/_____", 1, 0, 'C');
$pdf->Cell(25, 8, "___/___/_____", 1, 0, 'C');
$pdf->Cell(25, 8, "___/___/_____", 1, 0, 'C');
$pdf->Cell(25, 8, "___/___/_____", 1, 0, 'C');
$pdf->Cell(25, 8, "___/___/_____", 1, 1, 'C');

$pdf->SetFont('Arial', '', 9);
$ver_datos = "select nombres, ape_pat, ape_mat, dni, codigo from empleado where empresa = '" . $_SESSION['empresa'] . "' order by codigo asc ";
//echo $ver_datos;
$resultado = $conn->query($ver_datos);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $codigo = $fila['codigo'];
        $nombre_completo = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
        $dni = $fila['dni'];
        $pdf->Cell(15, 8, $codigo, 1, 0, 'C');
        $pdf->Cell(110, 8, $nombre_completo, 1, 0, 'L');
        $pdf->Cell(25, 8, "", 1, 0, 'C');
        $pdf->Cell(25, 8, "", 1, 0, 'C');
        $pdf->Cell(25, 8, "", 1, 0, 'C');
        $pdf->Cell(25, 8, "", 1, 0, 'C');
        $pdf->Cell(25, 8, "", 1, 0, 'C');
        $pdf->Cell(25, 8, "", 1, 1, 'C');
    }
}

$pdf->Output();

ob_end_flush();
?>
