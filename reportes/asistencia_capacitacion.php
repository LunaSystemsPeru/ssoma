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
        $this->Ln(13);
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

$ver_datos = "select * from programa_capacitaciones where id='" . $id . "' and anio = '" . $anio . "' and empresa = '" . $empresa . "'";
$r_capacitaciones = $conn->query($ver_datos);
if ($r_capacitaciones->num_rows > 0) {
    while ($fila = $r_capacitaciones->fetch_assoc()) {
        $tema = $fila['tema'];
        $instructor = $fila['expositor'];
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true, 10);
$pdf->AddPage();

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "INSTRUCTOR:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, $instructor, 0, 0, 'L');
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
$pdf->Cell(20, 5, "CAPACITACION", 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 5, "TEMA:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 5, $tema, 0, 1, 'L');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(195, 10, "RELACION DE PARTICIPANTES", 0, 1, 'C');
$pdf->Cell(15, 6, "COD", 1, 0, 'C');
$pdf->Cell(20, 6, "DNI", 1, 0, 'C');
$pdf->Cell(120, 6, "APELLIDOS Y NOMBRES", 1, 0, 'C');
$pdf->Cell(40, 6, "FIRMA", 1, 1, 'C');
$pdf->SetFont('Arial', '', 9);
$ver_datos = "select e.nombres, e.ape_pat, e.ape_mat, e.dni, e.codigo, e.fecha_nacimiento, e.telefono, e.jornal, e.renta_5ta, ec.nombre as estado_civil, e.direccion from empleado as e inner join estado_civil as ec on e.estado_civil = ec.id where e.empresa = '" . $empresa . "' order by e.codigo asc ";
//echo $ver_datos;
$resultado = $conn->query($ver_datos);
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $codigo = $fila['codigo'];
        $nombre_completo = $fila['ape_pat'] . ' ' . $fila['ape_mat'] . ' ' . $fila['nombres'];
        $dni = $fila['dni'];
        $pdf->Cell(15, 8, $codigo, 1, 0, 'C');
        $pdf->Cell(20, 8, $dni, 1, 0, 'C');
        $pdf->Cell(120, 8, $nombre_completo, 1, 0, 'L');
        $pdf->Cell(40, 8, "", 1, 1, 'C');
    }
}

$pdf->Output();
ob_end_flush();
?>
